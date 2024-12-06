<?php
session_start();
require 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['note_id'])) {
    $note_id = $_POST['note_id'];
    $query = "DELETE FROM notes WHERE note_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $note_id, $_SESSION['user_id']);
    $stmt->execute();
    header('Location: MAIN_Notes.php'); // Redirect back to notes page
    exit;
}
?>
