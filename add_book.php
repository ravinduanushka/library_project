<?php
include "db.php";

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $quantity = $_POST['quantity'];

    $conn->query("INSERT INTO books (title, author, quantity)
                  VALUES ('$title', '$author', '$quantity')");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

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