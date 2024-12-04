<?php
session_start();
require 'database_connection.php';

if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
    $user_id = $_SESSION['user_id'];

    $delete_query = "DELETE FROM calendar WHERE event_id = '$event_id' AND user_id = '$user_id'";

    if (mysqli_query($conn, $delete_query)) {
        echo json_encode(['status' => true, 'message' => 'Event deleted successfully']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Failed to delete event']);
    }
}
?>
