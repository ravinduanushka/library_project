<?php
// logout.php
session_start();
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged Out - Library System</title>
    <link rel="stylesheet" href="style.css"> <style>
        .logout-wrapper {
            min-height: calc(100vh - 70px);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        
        .logout-card {
            background: rgba(255, 255, 255, 0.65) !important;
            padding: 40px;
            border-radius: 12px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3) !important;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            text-align: center;
            box-sizing: border-box;
        }

        .logout-card h1 { margin: 0 0 10px 0; font-size: 28px; color: #c30000; font-weight: bold; }
        .logout-card p { margin: 0 0 25px 0; color: #222; font-size: 15px; font-weight: 500; line-height: 1.4; }

        .btn-relogin { 
            width: 100%; 
            background: #007bff; 
            color: white; 
            border: none; 
            padding: 12px; 
            border-radius: 6px; 
            cursor: pointer; 
            font-size: 16px; 
            font-weight: bold;
            text-decoration: none;
            display: block;
            box-sizing: border-box;
            transition: background 0.2s;
        }
        .btn-relogin:hover { background: #0056b3; }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="logout-wrapper">
    <div class="logout-card">
        <h1>Logged Out!</h1>
        <p>You have been safely disconnected from your library administrator control terminal dashboard session.</p>
        
        <a href="login.php" class="btn-relogin">Secure Login Again</a>
    </div>
</div>

</body>
</html>