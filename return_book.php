<?php include "db.php"; ?>

<h2>Return Book</h2>

<form method="POST">
    Issue ID: <input type="number" name="id" required><br><br>
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

    echo "Book Returned";
}
?>