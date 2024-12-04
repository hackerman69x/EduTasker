<?php
require 'database_connection.php';

if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
    $delete_query = "DELETE FROM calendar WHERE event_id = '$event_id'";

    if (mysqli_query($con, $delete_query)) {
        echo json_encode(['status' => true, 'message' => 'Event deleted successfully']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Failed to delete event']);
    }
}
?>
