<?php
/**
 * Return Book - Process book return
 */
include "db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Book - Library System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
    <div class="card">
        <h2>Return Book</h2>

        <form method="POST">
            <input type="number" name="id" placeholder="Issue ID" required>
            <button name="return">Return Book</button>
        </form>

        <?php
        if(isset($_POST['return'])){
            $id = $_POST['id'];

            $res = $conn->query("SELECT * FROM issued_books WHERE id=$id");
            $row = $res->fetch_assoc();

            $book_id = $row['book_id'];

            $conn->query("UPDATE issued_books SET return_date=CURDATE() WHERE id=$id");
            $conn->query("UPDATE books SET available = available + 1 WHERE id=$book_id");

            echo "<p>Book Returned Successfully</p>";
        }
        ?>
    </div>
</div>

</body>
</html>