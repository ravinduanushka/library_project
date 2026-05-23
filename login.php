<?php
// login.php
session_start();
include "db.php"; 

$error = "";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                if ($password === $user['password']) { 
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $error = "Invalid username or password!";
                }
            } else {
                $error = "Invalid username or password!";
            }
            $stmt->close();
        }
    } else {
        $error = "Please fill in all fields!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Login - Library System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            height: 100% !important;
            font-family: sans-serif;
        }

        body {
           
            background: linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45)), url('27db861f-46ea-443e-8a13-6e9d4a54ec8b.png') no-repeat center center fixed !important;
            background-size: cover !important;
            display: flex;
            flex-direction: column;
        }

        .login-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.65) !important;
            padding: 40px;
            border-radius: 12px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3) !important;
            backdrop-filter: blur(8px) !important;
            -webkit-backdrop-filter: blur(8px) !important;
            border: 1px solid rgba(255, 255, 255, 0.25);
            text-align: center;
            box-sizing: border-box;
        }

        .login-card h1 { margin: 0 0 5px 0; font-size: 28px; color: #111; font-weight: bold; }
        .login-card p { margin: 0 0 25px 0; color: #333; font-size: 14px; font-weight: 500; }
        
        .form-group { text-align: left; margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 6px; font-weight: bold; color: #222; font-size: 14px; }
        .form-group input { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid rgba(0,0,0,0.2); 
            border-radius: 6px; 
            box-sizing: border-box; 
            font-size: 15px;
            background: rgba(255, 255, 255, 0.9);
        }

        .btn-submit { 
            width: 100%; 
            background: #222222; 
            color: white; 
            border: none; 
            padding: 12px; 
            border-radius: 6px; 
            cursor: pointer; 
            font-size: 16px; 
            font-weight: bold;
            margin-top: 10px;
        }
        .btn-submit:hover { background: #FF8000; }
        .error-msg { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 14px; }
        .switch-link { margin-top: 20px; font-size: 14px; color: #222; font-weight: 500; }
        .switch-link a { color: #0056b3; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="login-wrapper">
    <div class="login-card">
        <h1>System Login</h1>
        <p>Library Management Portal</p>

        <?php if (!empty($error)): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter password" required>
            </div>
            <button type="submit" name="login" class="btn-submit">Login to Dashboard</button>
        </form>

        <div class="switch-link">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
    </div>
</div>

</body>
</html>