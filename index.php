<?php
session_start();
include "db.php";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['email'] = $email;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid Email or Password');</script>";
    }
    $stmt->close();
}

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Registered Successfully. Now Login');</script>";
    } else {
        echo "<script>alert('Registration Failed. Email may already exist.');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library System</title>
    <link rel="stylesheet" href="style.css?v=100">
</head>
<body>

<header>
    <h2 class="logo">Library</h2>

    <nav class="navigation">
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Service</a>
        <a href="#">Contact</a>
        <button type="button" class="btnLogin">Login</button>
    </nav>
</header>

<div class="wrapper" style="display:none;">

    <span class="close-btn">×</span>

    <div class="form-box login active">
        <h2>Login</h2>

        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <div class="row">
                <label class="check">
                    <input type="checkbox">
                    <span>Remember me</span>
                </label>
                <a href="#">Forgot?</a>
            </div>

            <button type="submit" name="login">Login</button>

            <p>Don't have an account?
                <a href="#" class="goRegister">Register</a>
            </p>
        </form>
    </div>

    <div class="form-box register">
        <h2>Register</h2>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <label class="check">
                <input type="checkbox" required>
                <span>I agree to terms</span>
            </label>

            <button type="submit" name="register">Register</button>

            <p>Already have an account?
                <a href="#" class="goLogin">Login</a>
            </p>
        </form>
    </div>

</div>

<script src="script.js?v=100"></script>
</body>
</html>