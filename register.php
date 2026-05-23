<?php
// register.php
session_start();
include "db.php"; 

$error = "";
$success = "";

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($email) && !empty($password)) {
        $check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $check->bind_param("ss", $username, $email);
        $check->execute();
        $res = $check->get_result();

        if ($res->num_rows > 0) {
            $error = "Username or Email already exists!";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("sss", $username, $email, $password);
                if ($stmt->execute()) {
                    $success = "Registration completed successfully! You can now log in.";
                } else {
                    $error = "Something went wrong. Please try again.";
                }
                $stmt->close();
            }
        }
        $check->close();
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
    <title>Create Account - Library System</title>
    <style>
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            min-height: 100vh !important;
            font-family: Arial, sans-serif;
        }

        body {
           
            background: linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45)), url('27db861f-46ea-443e-8a13-6e9d4a54ec8b.png') no-repeat center center fixed !important;
            background-size: cover !important;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: rgba(51, 51, 51, 0.85);
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            backdrop-filter: blur(5px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .register-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .register-card {
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

        .register-card h1 { margin: 0 0 5px 0; font-size: 28px; color: #111; font-weight: bold; }
        .register-card p { margin: 0 0 25px 0; color: #333; font-size: 14px; font-weight: 500; }
        
        .form-group { text-align: left; margin-bottom: 18px; }
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
        .form-group input:focus { border-color: #28a745; outline: none; }

        .btn-submit { 
            width: 100%; 
            background: #514641; 
            color: white; 
            border: none; 
            padding: 12px; 
            border-radius: 6px; 
            cursor: pointer; 
            font-size: 16px; 
            font-weight: bold;
            margin-top: 10px;
        }
        .btn-submit:hover { background: #FF8000 ; }
        .error-msg { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 14px; text-align: left; }
        .success-msg { background: #d4edda; color: #155724; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 14px; text-align: left; }
        .switch-link { margin-top: 20px; font-size: 14px; color: #222; font-weight: 500; }
        .switch-link a { color: #0056b3; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="register-wrapper">
    <div class="register-card">
        <h1>Create Account</h1>
        <p>Library Management Portal</p>

        <?php if (!empty($error)): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="success-msg"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Choose a username" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="e.g. ravindu2@gmail.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Choose a password" required>
            </div>
            <button type="submit" name="register" class="btn-submit"> Registration</button>
        </form>

        <div class="switch-link">
            Already have an account? <a href="login.php">Log in here</a>
        </div>
    </div>
</div>

</body>
</html>