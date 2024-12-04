<?php
session_start();

require 'database_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = mysqli_real_escape_string($conn, $_POST['name']); // mysqli_real_escape_string is used for extra protection
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // check if email exist
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // if email exist
        echo "Email is already registered.";
    } else {
        // new user
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
        
        if (mysqli_query($conn, $sql)) {
            header("Location: LR_Login.html");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

