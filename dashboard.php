<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css?v=100">
</head>
<body>

<header>
    <h2 class="logo">Library</h2>
    <nav class="navigation">
        <a href="dashboard.php">Dashboard</a>
        <a href="add_book.php">Add Book</a>
        <a href="view_books.php">View Books</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container">
    <div class="card">
        <h2>Dashboard</h2>
        <p>Welcome to Library System</p>
        <p><?php echo $_SESSION['email']; ?></p>
    </div>
</div>

</body>
</html>