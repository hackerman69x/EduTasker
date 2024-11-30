<?php
include 'db_connection.php';

try {
    // Create the users table if it doesn't exist
    $query = "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        );
    ";
    $db->exec($query);
    echo "Users table created or already exists.<br>";

    // Create the tasks table if it doesn't exist
    $query = "
        CREATE TABLE IF NOT EXISTS tasks (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            due_date DATE,
            priority VARCHAR(50),
            completed BOOLEAN DEFAULT 0,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        );
    ";
    $db->exec($query);
    echo "Tasks table created or already exists.<br>";

    // Insert a sample user if no users exist
    $query = "SELECT COUNT(*) FROM users";
    $stmt = $db->query($query);
    $userCount = $stmt->fetchColumn();

    if ($userCount == 0) {
        $query = "
            INSERT INTO users (username, email, password)
            VALUES ('testuser', 'testuser@example.com', '" . password_hash('password', PASSWORD_DEFAULT) . "')
        ";
        $db->exec($query);
        echo "Sample user inserted.<br>";
    }

} catch (PDOException $e) {
    echo "Error creating tables: " . $e->getMessage();
}
?>
