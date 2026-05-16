<?php
include "auth.php";
include "db.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: view_books.php");
    exit();
}
$id = (int)$_GET['id'];

// Block delete if book is currently issued
$check = $conn->prepare("SELECT COUNT(*) as c FROM issued_books WHERE book_id = ? AND return_date IS NULL");
$check->bind_param("i", $id);
$check->execute();
$count = $check->get_result()->fetch_assoc()['c'];
$check->close();

if ($count > 0) {
    header("Location: view_books.php?error=cannot_delete");
    exit();
}

$stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: view_books.php?msg=deleted");
exit();
?>