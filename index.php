<?php
session_start();
include "db.php";

// LOGIN
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $row['username'];
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Invalid Email or Password');</script>";
    }
}

// REGISTER
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (username, email, password) 
            VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql)) {
        echo "<script>alert('Registered Successfully');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login & Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h2 class="logo">Logo</h2>
    <nav class="navigation">

        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Service</a>
        <a href="#">Contact</a>

        <?php if (isset($_SESSION['email'])) { ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        <?php } else { ?>
            <button class="btnLogin">Login</button>
        <?php } ?>

    </nav>
</header>

<div class="wrapper" style="display:none;">

    <span class="close-btn">×</span>

    <!-- LOGIN -->
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

    <!-- REGISTER -->
    <div class="form-box register">
        <h2>Register</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <label class="check">
                <input type="checkbox">
                <span>I agree to terms</span>
            </label>

            <button type="submit" name="register">Register</button>

            <p>Already have an account?
                <a href="#" class="goLogin">Login</a>
            </p>
        </form>
    </div>

</div>

<script src="script.js"></script>

<?php if (isset($_SESSION['email'])) { ?>
<script>
    document.querySelector('.wrapper').style.display = "none";
</script>
<?php } ?>

</body>
</html>