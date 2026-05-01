<?php
include "db.php";

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO books (title, author, quantity, available)
            VALUES ('$title', '$author', '$quantity', '$quantity')";

    if ($conn->query($sql)) {
        echo "<script>alert('Book Added Successfully');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
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
        <h2>Add Book</h2>

        <form method="POST">
            <input type="text" name="title" placeholder="Book Title" required>
            <input type="text" name="author" placeholder="Author" required>
            <input type="number" name="quantity" placeholder="Quantity" required>

            <button name="submit">Add Book</button>
        </form>
    </div>
</div>

</body>
</html>