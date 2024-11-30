<?php
include 'db_connection.php';
session_start();

// Debugging settings
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Assuming user_id is retrieved from session
$user_id = $_SESSION['user_id'] ?? 1;

header('Content-Type: application/json');

// Handle POST request (Add a new task)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? null;
    $due_date = $_POST['due_date'] ?? null;
    $priority = $_POST['priority'] ?? 'Medium'; // Default to Medium if not provided

    if (!$title) {
        echo json_encode(["error" => "Task title is required."]);
        exit();
    }

    $query = "INSERT INTO tasks (user_id, title, due_date, priority, completed) VALUES (:user_id, :title, :due_date, :priority, 0)";
    $stmt = $db->prepare($query);

    try {
        $stmt->execute([
            ':user_id' => $user_id,
            ':title' => $title,
            ':due_date' => $due_date,
            ':priority' => $priority
        ]);
        echo json_encode(["success" => "Task added successfully."]);
    } catch (PDOException $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
    exit();
}

// Handle GET request (Retrieve tasks)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT * FROM tasks WHERE user_id = :user_id ORDER BY due_date ASC";
    $stmt = $db->prepare($query);
    $stmt->execute([':user_id' => $user_id]);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($tasks);
    exit();
}

// Handle PUT request (Edit or toggle completion)
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $putData);
    $task_id = $putData['id'];

    if (isset($putData['completed'])) {
        $completed = $putData['completed'];
        $query = "UPDATE tasks SET completed = :completed WHERE id = :id AND user_id = :user_id";
        $stmt = $db->prepare($query);

        try {
            $stmt->execute([
                ':completed' => $completed,
                ':id' => $task_id,
                ':user_id' => $user_id
            ]);
            echo json_encode(["success" => "Task completion status updated."]);
        } catch (PDOException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    } else {
        $title = $putData['title'] ?? null;
        $due_date = $putData['due_date'] ?? null;
        $priority = $putData['priority'] ?? null;

        $query = "UPDATE tasks SET title = :title, due_date = :due_date, priority = :priority WHERE id = :id AND user_id = :user_id";
        $stmt = $db->prepare($query);

        try {
            $stmt->execute([
                ':title' => $title,
                ':due_date' => $due_date,
                ':priority' => $priority,
                ':id' => $task_id,
                ':user_id' => $user_id
            ]);
            echo json_encode(["success" => "Task updated successfully."]);
        } catch (PDOException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
    exit();
}

// Handle DELETE request (Delete a task)
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteData);
    $task_id = $deleteData['id'];

    $query = "DELETE FROM tasks WHERE id = :id AND user_id = :user_id";
    $stmt = $db->prepare($query);

    try {
        $stmt->execute([
            ':id' => $task_id,
            ':user_id' => $user_id
        ]);
        echo json_encode(["success" => "Task deleted successfully."]);
    } catch (PDOException $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
    exit();
}
?>
