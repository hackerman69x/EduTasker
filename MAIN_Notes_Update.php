<?php
session_start();
require 'database_connection.php';

// fetches the note
if (isset($_GET['note_id'])) {
    $note_id = $_GET['note_id'];
    $query = "SELECT * FROM notes WHERE note_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $note_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $note = $result->fetch_assoc();
}

// note update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['noteTitle'], $_POST['noteDescription'], $_POST['note_id'])) {
    $noteTitle = htmlspecialchars(trim($_POST['noteTitle']));
    $noteDescription = htmlspecialchars(trim($_POST['noteDescription']));
    $note_id = $_POST['note_id'];

    $query = "UPDATE notes SET note_title = ?, note_description = ? WHERE note_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssii', $noteTitle, $noteDescription, $note_id, $_SESSION['user_id']);
    $stmt->execute();
    header('Location: MAIN_Notes.php'); // Redirect back to notes page
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Note</title>
</head>
<body>
    <h2>Update Note</h2>
    <form method="POST">
        <input type="hidden" name="note_id" value="<?php echo htmlspecialchars($note['note_id']); ?>">
        <label for="noteTitle">Note Title:</label>
        <input type="text" id="noteTitle" name="noteTitle" value="<?php echo htmlspecialchars($note['note_title']); ?>" required>

        <label for="noteDescription">Description:</label>
        <textarea id="noteDescription" name="noteDescription" rows="8" required><?php echo htmlspecialchars($note['note_description']); ?></textarea>

        <button type="submit">Update Note</button>
    </form>
</body>
</html>
