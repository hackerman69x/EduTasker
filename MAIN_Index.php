<?php
session_start();
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
                <!-- Tasks will appear here -->
                <li id="noTasksMessage">No tasks found. Add some tasks.</li>
            </ul>
        </div>
    
        <!-- Your Notes Container -->

        <div class="note-list">
            <h2>Your Notes</h2>
            <ul id="noteDisplay">
                <!-- Notes will appear here -->
                <li id="noNotesMessage">No notes found. Add some notes.</li>
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