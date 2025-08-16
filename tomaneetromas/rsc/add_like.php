<?php
session_start();

header('Content-Type: application/json');

include 'database.php';
global $db;

if(isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['userid']; // Assurez-vous que l'utilisateur est connecté et que son ID est stocké en session.

    // Vérifiez si l'utilisateur a déjà aimé ce post
    $sql = "SELECT * FROM likes WHERE post_id = ? AND user_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $post_id, PDO::PARAM_INT);
    $stmt->bindParam(2, $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();

    $sql = "SELECT count(created) FROM likes WHERE post_id = ?";
    $q = $db -> prepare($sql);
    $q -> bindParam(1, $post_id, PDO::PARAM_INT);
    $q -> execute();
    $likes_nb = (int) $q -> fetch()[0];

    $sql = "SELECT userid FROM recipes WHERE recipe_id = ?";
    $q = $db -> prepare($sql);
    $q -> bindParam(1, $post_id, PDO::PARAM_INT);
    $q -> execute();
    $recipe_user_id = (string) $q -> fetch()[0];

    if($result == false) {
        $sql = "INSERT INTO notifications(icon,type,sender_id, recipient_id, title, content) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $db -> prepare($sql);
        $a = "thumb_up";
        $b = "like";
        $c = "Nouveau J\'aime";
        $d = $recipe_user_id . 'a mis un "J\'aime" à votre recette.';
        $stmt -> bindValue(1, $a, PDO::PARAM_STR);
        $stmt -> bindValue(2, $b, PDO::PARAM_STR);
        $stmt -> bindParam(3, $_SESSION['userid'], PDO::PARAM_INT);
        $stmt -> bindParam(4, $recipe_user_id, PDO::PARAM_INT);
        $stmt -> bindValue(5, $c , PDO::PARAM_STR);
        $stmt -> bindValue(6, $d , PDO::PARAM_STR);
        $stmt -> execute();
        // Si l'utilisateur n'a pas encore aimé ce post, ajoutez un like
        $sql = "INSERT INTO likes (post_id, user_id) VALUES (?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $post_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $user_id, PDO::PARAM_INT);
        if($stmt->execute()) {
            $likes_nb = $likes_nb + 1;
            $sql = "UPDATE recipes SET likes=? WHERE recipe_id = ?";
            $c = $db -> prepare($sql);
            $c -> bindParam(1, $likes_nb, PDO::PARAM_INT);
            $c -> bindParam(2, $post_id, PDO::PARAM_INT);
            $c -> execute();
            echo json_encode(['status' => 'success', 'action' => 'liked', "likes" => $likes_nb]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to like the post']);
        }
    } else {
        // Sinon, supprimez le like
        $sql = "DELETE FROM likes WHERE post_id = ? AND user_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $post_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $user_id, PDO::PARAM_INT);
        if($stmt->execute()) {
            $likes_nb = $likes_nb - 1;
            $sql = "UPDATE recipes SET likes=? WHERE recipe_id = ?";
            $c = $db -> prepare($sql);
            $c -> bindParam(1, $likes_nb, PDO::PARAM_INT);
            $c -> bindParam(2, $post_id, PDO::PARAM_INT);
            $c -> execute();
            echo json_encode(['status' => 'success', 'action' => 'unliked', "likes" => $likes_nb]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to unlike the post']);
        }
    }
}

?>