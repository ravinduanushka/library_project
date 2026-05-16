<?php
session_start();
include "db.php";

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$message = "";
$type    = "";

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if (strlen($password) < 6) {
        $message = "Password must be at least 6 characters.";
        $type    = "error";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt   = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed);

        if ($stmt->execute()) {
            $message = "Registered successfully! You can now login.";
            $type    = "success";
        } else {
            $message = "Registration failed. Username or email may already exist.";
            $type    = "error";
        }
        $stmt->close();
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
    <style>
        .auth-page { display: flex; justify-content: center; align-items: center; min-height: 100vh; background: url('27db861f-46ea-443e-8a13-6e9d4a54ec8b.png') no-repeat center center/cover; margin: 0; padding: 0; }
        .auth-wrapper { background: rgba(255, 255, 255, 0.95); padding: 40px; border-radius: 10px; width: 100%; max-width: 450px; box-shadow: 0 4px 15px rgba(0,0,0,0.3); text-align: center; margin-top: 60px; }
        .auth-wrapper h2 { font-size: 28px; margin-bottom: 25px; color: #000; font-weight: bold; }
        .form-group { text-align: left; margin-bottom: 20px; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; font-size: 15px; }
        .btn-primary { background: #000; color: white; border: none; padding: 12px 15px; width: 100%; border-radius: 5px; cursor: pointer; font-size: 16px; margin-top: 5px;}
        .btn-primary:hover { background: #222; }
        .auth-link { margin-top: 20px; font-size: 15px; }
        .auth-link a { color: blue; text-decoration: none; }
        .auth-link a:hover { text-decoration: underline; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 5px; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body class="auth-page">
<?php include "header.php"; ?>

<div class="auth-wrapper">
    <h2>Register</h2>

    <?php if ($message): ?>
        <div class="alert alert-<?php echo $type; ?>"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="form-group">
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" name="register" class="btn-primary">Register</button>
    </form>
    
    <p class="auth-link"><a href="index.php">Go to Login</a></p>
</div>
</body>
</html>