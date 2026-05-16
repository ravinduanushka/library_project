<?php
include "auth.php";
include "db.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: view_books.php");
    exit();
}
$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) { header("Location: view_books.php"); exit(); }
$book = $result->fetch_assoc();
$stmt->close();

$message = $type = "";

if (isset($_POST['update'])) {
    $title    = trim($_POST['title']);
    $author   = trim($_POST['author']);
    $isbn     = trim($_POST['isbn']);
    $quantity = (int)$_POST['quantity'];
    $diff      = $quantity - $book['quantity'];
    $available = max(0, $book['available'] + $diff);

    $stmt = $conn->prepare("UPDATE books SET title=?, author=?, isbn=?, quantity=?, available=? WHERE id=?");
    $stmt->bind_param("sssiii", $title, $author, $isbn, $quantity, $available, $id);
    if ($stmt->execute()) {
        $stmt->close();
        header("Location: view_books.php?msg=updated");
        exit();
    } else {
        $message = "Update failed. Please try again.";
        $type    = "error";
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book - Library System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="page-container">
    <div class="page-header">
        <h1>Edit Book</h1>
        <a href="view_books.php" class="btn-secondary">← Back to Books</a>
    </div>
    <div class="form-card">
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $type; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Book Title <span class="required">*</span></label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
            </div>
            <div class="form-group">
                <label>Author <span class="required">*</span></label>
                <input type="text" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
            </div>
            <div class="form-group">
                <label>ISBN</label>
                <input type="text" name="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>">
            </div>
            <div class="form-group">
                <label>Quantity <span class="required">*</span></label>
                <input type="number" name="quantity" value="<?php echo $book['quantity']; ?>" min="1" required>
                <small class="hint">Currently <?php echo $book['available']; ?> available out of <?php echo $book['quantity']; ?>.</small>
            </div>
            <div class="form-actions">
                <button type="submit" name="update" class="btn-primary">Update Book</button>
                <a href="view_books.php" class="btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>