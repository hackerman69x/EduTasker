<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "You must be logged in to view calendar events."]);
    exit();
}

$user_id = $_SESSION['user_id'];

header('Content-Type: application/json');

// Fetch events for a given month
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];

    $query = "SELECT * FROM events WHERE user_id = :user_id AND event_date BETWEEN :start_date AND :end_date";
    $stmt = $db->prepare($query);

    try {
        $stmt->execute([':user_id' => $user_id, ':start_date' => $start_date, ':end_date' => $end_date]);
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($events);
    } catch (PDOException $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
    exit();
}

// Add a new event
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_date = $_POST['event_date'];
    $description = $_POST['description'];

    $query = "INSERT INTO events (user_id, event_date, description) VALUES (:user_id, :event_date, :description)";
    $stmt = $db->prepare($query);

    try {
        $stmt->execute([':user_id' => $user_id, ':event_date' => $event_date, ':description' => $description]);
        echo json_encode(["success" => "Event added successfully."]);
    } catch (PDOException $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
    exit();
}
?>
