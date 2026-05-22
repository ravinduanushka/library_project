<?php include "db.php"; ?>

<h2>Issue Book</h2>

<form method="POST">
    User ID: <input type="number" name="user_id" required><br><br>
    Book ID: <input type="number" name="book_id" required><br><br>
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

    echo "Book Issued";
}
?>