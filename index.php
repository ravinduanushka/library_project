<?php
session_start();
include "db.php";

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: dashboard.php");
            exit();

        } else {
            $error = "Wrong password!";
        }

    } else {
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Library System</title>
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
    <h2>Login</h2>

    <?php if ($error != ""): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" name="login" class="btn-primary">Login</button>
    </form>
    
    <p class="auth-link"><a href="register.php">Go to Register</a></p>
</div>
</body>
</html>