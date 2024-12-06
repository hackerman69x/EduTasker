<?php
session_start();
require 'database_connection.php';

// new task
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['taskTitle']) && isset($_POST['taskDescription']) && isset($_POST['dueDate']) && isset($_POST['priority'])) {
    $taskTitle = $_POST['taskTitle'];
    $taskDescription = $_POST['taskDescription'];
    $dueDate = $_POST['dueDate'];
    $priority = $_POST['priority'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO tasks (task_title, task_description, due_date, priority, user_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssi', $taskTitle, $taskDescription, $dueDate, $priority, $user_id);
    $stmt->execute();
}

// fetch te tasks
$query = "SELECT * FROM tasks WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tasks</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/MAIN_Tasks.css">
    <script type="text/javascript" src="js/main.js"></script>
</head>

<body>

    <!---------- Left Header ---------->

    <header class="left-header">
        <a class="logo">
            <img src="pic/edutasker.png">
        </a>

        <ul class="navbar">
            <li><a href="MAIN_Index.php">Home</a></li>
            <li><a href="MAIN_Tasks.php">Tasks</a></li>
            <li><a href="MAIN_Notes.php">Notes</a></li>
            <li><a href="MAIN_Calendar.php">Calendar</a></li>
        </ul>
    </header>

    <!---------- Top Header ---------->

    <header class="top-header">
        <div class="welcome-message">
            <h1>Welcome to EduTasker!</h1>
        </div>
        <div class="user-menu">
            <div class="user-dropdown">
                <span class="username">
                    
                    <?php
                    echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Guest';
                    ?>
                    
                    <i class='bx bx-chevron-down'></i>
                </span>
                <ul class="dropdown-menu">
                    <li><a href="LR_Logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!---------- Tasks ---------->

    <div class="content-wrapper">
        <div class="task-container">
            <div class="task-form">
                <h2>Add Task</h2>
                <form method="POST">
                    <label for="taskTitle">Task Title:</label>
                    <input type="text" id="taskTitle" name="taskTitle" required>
    
                    <label for="taskDescription">Description:</label>
                    <textarea id="taskDescription" name="taskDescription" rows="4" required></textarea>
    
                    <label for="dueDate">Due Date:</label>
                    <input type="date" id="dueDate" name="dueDate" required>

                    <label for="priority">Priority Level:</label>
                    <select id="priority" name="priority" required>
                        <option value="High">High</option>
                        <option value="Medium">Medium</option>
                        <option value="Low">Low</option>
                    </select>
    
                    <button type="submit">Add Task</button>
                </form>
            </div>
    
            <div class="task-list">
                <h2>Your Tasks</h2>
                <ul id="taskDisplay">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($task = $result->fetch_assoc()): ?>
            <li class="task-item">
                <h3><?php echo htmlspecialchars($task['task_title']); ?></h3>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($task['task_description']); ?></p>
                <p><strong>Due Date:</strong> <?php echo htmlspecialchars($task['due_date']); ?></p>
                <p><strong>Priority:</strong> 
                    <span class="priority <?php echo strtolower($task['priority']); ?>">
                        <?php echo htmlspecialchars($task['priority']); ?>
                    </span>
                </p>
                <!-- Update form -->
                <form method="GET" action="MAIN_Tasks_Update.php" style="display:inline;">
                    <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
                    <button type="submit">Update</button>
                </form>
                <!-- Delete form -->
                <form method="POST" action="MAIN_Tasks_Delete.php" style="display:inline;">
                    <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                </form>
            </li>
        <?php endwhile; ?>
    <?php else: ?>
        <li id="noTasksMessage">No tasks found. Add some tasks.</li>
    <?php endif; ?>
</ul>


            </div>
        </div>
    </div>
    
    <!---------- Footer ---------->

    <footer class="top-footer">
        <div class="footer-message">
            <h1>&copy; 2024 EduTasker. All rights reserved.</h1>
        </div>
        <div class="footer-names">
            <a>Gingoyon</a>
            <a>Primicias</a>
            <a>Ramos</a>
        </div>
    </footer>
    
</body>
</html>
