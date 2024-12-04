<?php
require 'database_connection.php';

$query = "SELECT event_id, event_name AS title, event_start_date AS start, event_end_date AS end 
          FROM calendar";
$result = mysqli_query($con, $query);

$events = [];
while ($row = mysqli_fetch_assoc($result)) {
    $row['color'] = '#007bff'; // Set a default highlight color
    $events[] = $row;
}

echo json_encode($events);
?>
