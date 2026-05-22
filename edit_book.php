<?php
include "db.php";

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM books WHERE id=$id");
$row = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $quantity = $_POST['quantity'];

    $conn->query("UPDATE books SET 
        title='$title', 
        author='$author', 
        quantity='$quantity'
        WHERE id=$id");

    header("Location: view_books.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
    <div class="card">
        <h2>Edit Book</h2>

        <form method="POST">
            <input type="text" name="title" value="<?php echo $row['title']; ?>">
            <input type="text" name="author" value="<?php echo $row['author']; ?>">
            <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>">

            <button name="update">Update</button>
        </form>
    </div>
</div>

</body>
</html>