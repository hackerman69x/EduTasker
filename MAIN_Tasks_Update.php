<?php
session_start();
require 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];

    $query = "SELECT * FROM tasks WHERE task_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $task_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_id = $_POST['task_id'];
    $taskTitle = $_POST['taskTitle'];
    $taskDescription = $_POST['taskDescription'];
    $dueDate = $_POST['dueDate'];
    $priority = $_POST['priority'];

    $query = "UPDATE tasks SET task_title = ?, task_description = ?, due_date = ?, priority = ? WHERE task_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssii', $taskTitle, $taskDescription, $dueDate, $priority, $task_id, $_SESSION['user_id']);
    $stmt->execute();

    header('Location: MAIN_Tasks.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Task</title>
</head>
<body>
    <h2>Update Task</h2>
    <form method="POST">
        <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
        <label for="taskTitle">Task Title:</label>
        <input type="text" id="taskTitle" name="taskTitle" value="<?php echo htmlspecialchars($task['task_title']); ?>" required>

        <label for="taskDescription">Description:</label>
        <textarea id="taskDescription" name="taskDescription" rows="4" required><?php echo htmlspecialchars($task['task_description']); ?></textarea>

        <label for="dueDate">Due Date:</label>
        <input type="date" id="dueDate" name="dueDate" value="<?php echo htmlspecialchars($task['due_date']); ?>" required>

        <label for="priority">Priority Level:</label>
        <select id="priority" name="priority" required>
            <option value="High" <?php echo $task['priority'] == 'High' ? 'selected' : ''; ?>>High</option>
            <option value="Medium" <?php echo $task['priority'] == 'Medium' ? 'selected' : ''; ?>>Medium</option>
            <option value="Low" <?php echo $task['priority'] == 'Low' ? 'selected' : ''; ?>>Low</option>
        </select>

        <button type="submit">Update Task</button>
    </form>
</body>
</html>
