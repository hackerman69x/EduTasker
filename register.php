<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $db->prepare($query);

    try {
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $password
        ]);
        echo "Registration successful. <a href='../login.html'>Log in</a>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Duplicate entry
            echo "Username or email already exists. Please choose a different one.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
