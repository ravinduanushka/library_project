<?php
/**
 * Login - User Login Page
 * 
 * DEPRECATED - Use index.php?page=login instead
 */
session_start();
include "db.php";

$error = "";
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['email'] = $username;
        header("Location: index.php?page=dashboard");
        exit();
    } else {
        $error = "Invalid Username or Password!";
    }
    $stmt->close();
}

// Redirect to main index.php
header("Location: index.php?page=login");
exit();
?>