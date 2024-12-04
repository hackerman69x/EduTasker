<?php
session_start();
require 'database_connection.php';

$event_name = $_POST['event_name'];
$event_start_date = $_POST['event_start_date'];
$event_end_date = $_POST['event_end_date'];
$user_id = $_SESSION['user_id'];

if(!$user_id){
  die(json_encode(["status"=> false,"message"=> "Session expired: re-login"])); 
}

$insert_query = "INSERT INTO calendar (event_name, event_start_date, event_end_date, user_id) 
                 VALUES ('$event_name', '$event_start_date', '$event_end_date', '$user_id')";

if (mysqli_query($conn, $insert_query)) {
    echo json_encode(['status' => true, 'message' => 'Event added successfully']);
} else {
    echo json_encode(['status' => false, 'message' => 'Failed to add event']);
}
?>
