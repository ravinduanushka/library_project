<?php include "db.php"; ?>

<h2>Register</h2>
<form method="POST">
    Username: <input type="text" name="username" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button name="register">Register</button>
</form>

<a href="login.php">Go to Login</a>

<?php
if(isset($_POST['register'])){
    $u = $_POST['username'];
    $e = $_POST['email'];
    $p = $_POST['password'];

    $sql = "INSERT INTO users (username,email,password)
            VALUES ('$u','$e','$p')";

    if($conn->query($sql)){
        echo "<br>Registered Successfully";
    } else {
        echo "Error";
    }
}
?>