<?php
session_start();
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
                
                <!-- Task Form -->

                <form id="taskForm">
                    <label for="taskTitle">Task Title:</label>
                    <input type="text" id="taskTitle" required>
    
                    <label for="taskDescription">Description:</label>
                    <textarea id="taskDescription" rows="4" required></textarea>
    
                    <label for="dueDate">Due Date:</label>
                    <input type="date" id="dueDate" required>
    
                    <label for="priority">Priority Level:</label>
                    <select id="priority" required>
                        <option value="Low">High</option>
                        <option value="Medium">Medium</option>
                        <option value="High">Low</option>
                    </select>
    
                    <button type="submit">Add Task</button>
                </form>
            </div>
    
            <div class="task-list">
                <h2>Your Tasks</h2>
                <ul id="taskDisplay">
                    <!-- Tasks will appear here -->
                    <li id="noTasksMessage">No tasks found. Add some tasks.</li>
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