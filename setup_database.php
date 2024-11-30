<?php
try {
    // Connect to MySQL server
    $db = new PDO('mysql:host=localhost', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Step 1: Create Database
    $db->exec("CREATE DATABASE IF NOT EXISTS edutasker");
    echo "Database 'edutasker' created or already exists.<br>";

    // Step 2: Connect to the new database
    $db->exec("USE edutasker");

    // Step 3: Create Users Table
    $db->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    echo "Table 'users' created or already exists.<br>";

    // Step 4: Create Tasks Table
    $db->exec("
        CREATE TABLE IF NOT EXISTS tasks (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            due_date DATE DEFAULT NULL,
            priority ENUM('High', 'Medium', 'Low') DEFAULT 'Medium',
            completed TINYINT(1) DEFAULT 0,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )
    ");
    echo "Table 'tasks' created or already exists.<br>";

    // Check if 'completed' column exists in the 'tasks' table
    $columns = $db->query("SHOW COLUMNS FROM tasks LIKE 'completed'")->fetchAll(PDO::FETCH_ASSOC);
    if (empty($columns)) {
        $db->exec("ALTER TABLE tasks ADD COLUMN completed TINYINT(1) DEFAULT 0");
        echo "Column 'completed' added to 'tasks' table.<br>";
    }

    // Step 5: Insert or Fetch User
    $db->exec("
        INSERT INTO users (username, email, password) 
        VALUES ('testuser', 'testuser@example.com', '" . password_hash('password123', PASSWORD_DEFAULT) . "')
        ON DUPLICATE KEY UPDATE username=username
    ");
    echo "Sample user data inserted or already exists.<br>";

    // Fetch the user ID
    $stmt = $db->prepare("SELECT id FROM users WHERE username = 'testuser'");
    $stmt->execute();
    $userId = $stmt->fetchColumn();

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
