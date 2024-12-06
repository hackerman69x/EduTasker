<?php
session_start();
require 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];

    $query = "DELETE FROM tasks WHERE task_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $task_id, $_SESSION['user_id']);
    $stmt->execute();

    header('Location: MAIN_Tasks.php');
    exit;
}
?>
