<?php
session_start();
require 'database_connection.php';

// new note
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['noteTitle']) && isset($_POST['noteDescription'])) {
    $noteTitle = htmlspecialchars(trim($_POST['noteTitle']));
    $noteDescription = htmlspecialchars(trim($_POST['noteDescription']));
    $user_id = $_SESSION['user_id'];

    if (!empty($noteTitle) && !empty($noteDescription)) {
        $query = "INSERT INTO notes (note_title, note_description, user_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssi', $noteTitle, $noteDescription, $user_id);
        $stmt->execute();
    } else {
        echo "Please fill out both the title and description.";
    }
}

// fetch the notes
$query = "SELECT * FROM notes WHERE user_id = ?";
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
    <title>Manage Notes</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/MAIN_Notes.css">
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

    <!---------- Notes ---------->

    <div class="content-wrapper">
        <div class="note-container">
            <div class="note-form">
                <h2>Add Notes</h2>
                <form method="POST">
                    <label for="noteTitle">Note Title:</label>
                    <input type="text" id="noteTitle" name="noteTitle" required>
    
                    <label for="noteDescription">Description:</label>
                    <textarea id="noteDescription" name="noteDescription" rows="12" required></textarea>
    
                    <button type="submit">Add Notes</button>
                </form>
            </div>
    
            <div class="note-list">
                <h2>Your Notes</h2>
                <ul id="noteDisplay">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($note = $result->fetch_assoc()): ?>
            <li class="note-item">
                <h3><?php echo htmlspecialchars($note['note_title']); ?>:</h3>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($note['note_description']); ?></p>
                <!-- Update form -->
                <form method="GET" action="MAIN_Notes_Update.php" style="display:inline;">
                    <input type="hidden" name="note_id" value="<?php echo $note['note_id']; ?>">
                    <button type="submit">Update</button>
                </form>

                <!-- Delete form -->
                <form method="POST" action="MAIN_Notes_Delete.php" style="display:inline;">
                    <input type="hidden" name="note_id" value="<?php echo $note['note_id']; ?>">
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this note?')">Delete</button>
                </form>
            </li>
        <?php endwhile; ?>
    <?php else: ?>
        <li id="noNotesMessage">No notes found. Add some notes.</li>
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
