<?php
// add_bookmark.php
header('Content-Type: application/json');

include 'database.php';
global $db;

// Vérifiez si la requête est une requête POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données envoyées dans le corps de la requête
    $data = json_decode(file_get_contents('php://input'), true);

    $recipeid = $data['recipeid'];
    $userid = $data['userid'];
    $action = $data['action'];

    if ($mysqli->connect_error) {
        die('Erreur de connexion (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // Exécutez l'action en fonction de l'option choisie (ajout ou suppression)
    if ($action === 'add') {
        $stmt = $mysqli->prepare("INSERT INTO favorites (recipe_id, user_id) VALUES (?, ?)");
        $stmt->bind_param('ii', $recipeid, $userid);
    } else {
        $stmt = $mysqli->prepare("DELETE FROM favorites WHERE recipe_id = ? AND user_id = ?");
        $stmt->bind_param('ii', $recipeid, $userid);
    }

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
    $mysqli->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>