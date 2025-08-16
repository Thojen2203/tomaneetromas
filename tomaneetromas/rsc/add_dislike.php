<?php
session_start();

header('Content-Type: application/json');

include 'database.php';
global $db;

if(isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['userid']; // Assurez-vous que l'utilisateur est connecté et que son ID est stocké en session.

    // Vérifiez si l'utilisateur a déjà aimé ce post
    $sql = "SELECT * FROM dislikes WHERE post_id = ? AND user_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $post_id, PDO::PARAM_INT);
    $stmt->bindParam(2, $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();

    $sql = "SELECT count(created) FROM dislikes WHERE post_id = ?";
    $q = $db -> prepare($sql);
    $q -> bindParam(1, $post_id, PDO::PARAM_INT);
    $q -> execute();
    $likes_nb = (int) $q -> fetch()[0];

    if($result == false) {
        // Si l'utilisateur n'a pas encore aimé ce post, ajoutez un like
        $sql = "INSERT INTO dislikes (post_id, user_id) VALUES (?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $post_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $user_id, PDO::PARAM_INT);
        if($stmt->execute()) {
            $likes_nb = $likes_nb + 1;
            $sql = "UPDATE recipes SET dislikes=? WHERE recipe_id = ?";
            $c = $db -> prepare($sql);
            $c -> bindParam(1, $likes_nb, PDO::PARAM_INT);
            $c -> bindParam(2, $post_id, PDO::PARAM_INT);
            $c -> execute();
            echo json_encode(['status' => 'success', 'action' => 'liked', "dislikes" => $likes_nb]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to dislike the post']);
        }
    } else {
        // Sinon, supprimez le like
        $sql = "DELETE FROM dislikes WHERE post_id = ? AND user_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $post_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $user_id, PDO::PARAM_INT);
        if($stmt->execute()) {
            $likes_nb = $likes_nb - 1;
            $sql = "UPDATE recipes SET dislikes=? WHERE recipe_id = ?";
            $c = $db -> prepare($sql);
            $c -> bindParam(1, $likes_nb, PDO::PARAM_INT);
            $c -> bindParam(2, $post_id, PDO::PARAM_INT);
            $c -> execute();
            echo json_encode(['status' => 'success', 'action' => 'unliked', "dislikes" => $likes_nb]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to undislike the post']);
        }
    }
}

?>