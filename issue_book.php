<?php
/**
 * Issue Book - Issue book to user
 */
include "db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Book - Library System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
    <div class="card">
        <h2>Issue Book</h2>

        <form method="POST">
            <input type="number" name="user_id" placeholder="User ID" required>
            <input type="number" name="book_id" placeholder="Book ID" required>
            <button name="issue">Issue Book</button>
        </form>

        <?php
        if(isset($_POST['issue'])){
            $u = $_POST['user_id'];
            $b = $_POST['book_id'];

            $sql = "INSERT INTO issued_books (user_id,book_id,issue_date,due_date)
                    VALUES ($u,$b,CURDATE(),DATE_ADD(CURDATE(), INTERVAL 7 DAY))";

            $conn->query($sql);
            $conn->query("UPDATE books SET available = available - 1 WHERE id=$b");

            echo "<p>Book Issued Successfully</p>";
        }
        ?>
    </div>
</div>

</body>
</html>