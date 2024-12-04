<?php
session_start();
require 'database_connection.php';

$user_id = $_SESSION['user_id'];

$query = "SELECT event_id, event_name AS title, event_start_date AS start, event_end_date AS end
FROM calendar 
WHERE user_id = '$user_id'"; // Fetch the events of the user

$result = mysqli_query($conn, $query);

$events = [];
while ($row = mysqli_fetch_assoc($result)) {
    $row['color'] = '#007bff';  // Event color (can be customized)
    $events[] = $row;
}

echo json_encode($events);
?>
