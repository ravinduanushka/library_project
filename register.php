<?php
/**
 * Register - User Registration Page
 */
include "db.php";

if(isset($_POST['register'])){
    $u = $_POST['username'];
    $e = $_POST['email'];
    $p = $_POST['password'];

    $sql = "INSERT INTO users (username,email,password)
            VALUES ('$u','$e','$p')";

    if($conn->query($sql)){
        echo "<script>alert('Registered Successfully');</script>";
    } else {
        echo "<script>alert('Registration Failed');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Library System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
    <div class="card">
        <h2>Register</h2>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</div>

</body>
</html>