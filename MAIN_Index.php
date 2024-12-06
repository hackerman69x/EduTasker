<?php
session_start();
require 'database_connection.php';

// fetch the tasks and notes from the pages

$sql_tasks = "SELECT * FROM tasks WHERE user_id = ?";
$stmt = $conn->prepare($sql_tasks);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result_tasks = $stmt->get_result();

$sql_notes = "SELECT * FROM notes WHERE user_id = ?"; 
$stmt_notes = $conn->prepare($sql_notes);
$stmt_notes->bind_param("i", $_SESSION['user_id']); 
$stmt_notes->execute();
$result_notes = $stmt_notes->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduTasker</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/MAIN_Index.css">
    <script type="text/javascript" src="js/main.js"></script>
</head>

<body>

    <!---------- Left Header ---------->

    <header class="left-header">
        <a class="logo">
            <img src="pic/edutasker.png">
        </a>

        <ul class="navbar">
            <li><a href="#home">Home</a></li>
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

    <!---------- Content ---------->

    <div class="content-wrapper">
        
        <!-- Your Tasks Container -->
        <div class="task-list">
            <h2>Your Tasks</h2>
            <ul id="taskDisplay">
                <?php if ($result_tasks->num_rows > 0): ?>
                    <?php while ($task = $result_tasks->fetch_assoc()): ?>
                        <li class="task-item">
                            <h3><?php echo htmlspecialchars($task['task_title']); ?></h3>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($task['task_description']); ?></p>
                            <p><strong>Due Date:</strong> <?php echo htmlspecialchars($task['due_date']); ?></p>
                            <p><strong>Priority:</strong> 
                                <span class="priority <?php echo strtolower($task['priority']); ?>">
                                    <?php echo htmlspecialchars($task['priority']); ?>
                                </span>
                            </p>
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li id="noTasksMessage">No tasks found. Add some tasks.</li>
                <?php endif; ?>
            </ul>
        </div>
    
        <!-- Your Notes Container -->
        <div class="note-list">
            <h2>Your Notes</h2>
            <ul id="noteDisplay">
                <?php if ($result_notes->num_rows > 0): ?>
                    <?php while ($note = $result_notes->fetch_assoc()): ?>
                        <li class="note-item">
                            <h3><?php echo htmlspecialchars($note['note_title']); ?>:</h3>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($note['note_description']); ?></p>
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li id="noNotesMessage">No notes found. Add some notes.</li>
                <?php endif; ?>
            </ul>
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
