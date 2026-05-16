<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$message = "";

if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = isset($_POST['isbn']) ? $_POST['isbn'] : '';
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    $available = $quantity;

    $stmt = $conn->prepare("INSERT INTO books (title, author, isbn, quantity, available) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sssii", $title, $author, $isbn, $quantity, $available);
        if ($stmt->execute()) {
            $message = "<p style='color: green; padding: 10px; background: #d4edda; border-radius: 5px;'>Book added successfully!</p>";
        } else {
            $message = "<p style='color: red; padding: 10px; background: #f8d7da; border-radius: 5px;'>Error adding book.</p>";
        }
        $stmt->close();
    } else {
        $message = "<p style='color: red; padding: 10px; background: #f8d7da; border-radius: 5px;'>Database error.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include "header.php"; ?>

<div class="page-container">
    <div class="page-header">
        <h1>Add Book</h1>
        <a href="view_books.php" class="btn-secondary">← Back to Books</a>
    </div>

    <?php echo $message; ?>

    <div class="form-card">
        <form method="POST">
            <div class="form-group">
                <label>Book Title</label>
                <input type="text" name="title" placeholder="Enter book title" required>
            </div>
            <div class="form-group">
                <label>Author</label>
                <input type="text" name="author" placeholder="Enter author name" required>
            </div>
            <div class="form-group">
                <label>ISBN</label>
                <input type="text" name="isbn" placeholder="Enter ISBN">
            </div>
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" placeholder="Number of copies" value="1" min="1" required>
            </div>
            <button type="submit" name="add" class="btn-primary">Add Book</button>
        </form>
    </div>
</div>

</body>
</html>