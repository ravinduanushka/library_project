<?php
/**
 * Register - User Registration Page
 */
session_start();
include "db.php";

$message = "";
if(isset($_POST['register'])){
    $u = $_POST['username'];
    $e = $_POST['email'];
    $p = $_POST['password'];

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $u, $e, $p);

    if($stmt->execute()){
        $message = "Registration successful! Please login.";
    } else {
        $message = "Registration failed. Username or email may already exist.";
    }
    $stmt->close();
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
        <h2>📝 Register</h2>

        <?php if ($message) { ?>
            <p class="message"><?php echo $message; ?></p>
        <?php } ?>

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