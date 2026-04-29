<?php
/**
 * Delete Book - Remove book from database
 */
$conn = new mysqli("localhost", "root", "", "library1");

$id = $_GET['id'];

$conn->query("DELETE FROM books WHERE id=$id");

header("Location: view_books.php");
?>