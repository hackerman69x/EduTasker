<?php
require 'database_connection.php';

$event_name = $_POST['event_name'];
$event_start_date = $_POST['event_start_date'];
$event_end_date = $_POST['event_end_date'];

$insert_query = "INSERT INTO calendar (event_name, event_start_date, event_end_date) 
                 VALUES ('$event_name', '$event_start_date', '$event_end_date')";

if (mysqli_query($con, $insert_query)) {
    echo json_encode(['status' => true, 'message' => 'Event added successfully']);
} else {
    echo json_encode(['status' => false, 'message' => 'Failed to add event']);
}
?>
