<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "You must be logged in to manage notes."]);
    exit();
}

$user_id = $_SESSION['user_id'];

header('Content-Type: application/json');

// Add a note
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $query = "INSERT INTO notes (user_id, title, content) VALUES (:user_id, :title, :content)";
    $stmt = $db->prepare($query);

    try {
        $stmt->execute([':user_id' => $user_id, ':title' => $title, ':content' => $content]);
        echo json_encode(["success" => "Note added successfully."]);
    } catch (PDOException $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
    exit();
}

// Delete a note
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteData);
    $note_id = $deleteData['id'];

    $query = "DELETE FROM notes WHERE id = :id AND user_id = :user_id";
    $stmt = $db->prepare($query);

    try {
        $stmt->execute([':id' => $note_id, ':user_id' => $user_id]);
        echo json_encode(["success" => "Note deleted successfully."]);
    } catch (PDOException $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
    exit();
}

// Get all notes
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT * FROM notes WHERE user_id = :user_id ORDER BY id DESC";
    $stmt = $db->prepare($query);
    $stmt->execute([':user_id' => $user_id]);
    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($notes);
    exit();
}
?>
