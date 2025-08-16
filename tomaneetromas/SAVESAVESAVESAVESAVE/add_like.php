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

    var_dump($result);

    if($result == false) {
        // Si l'utilisateur n'a pas encore aimé ce post, ajoutez un like
        $sql = "INSERT INTO likes (post_id, user_id) VALUES (?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $post_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $user_id, PDO::PARAM_INT);
        if($stmt->execute()) {
            echo json_encode(['status' => 'success', 'action' => 'liked']);
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
            echo json_encode(['status' => 'success', 'action' => 'unliked']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to unlike the post']);
        }
    }
}

?>