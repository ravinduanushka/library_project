<?php
include "auth.php";
include "db.php";

$books = $conn->query("SELECT * FROM books ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include "header.php"; ?>

<div class="page-container">
    <div class="page-header">
        <h1>View Books</h1>
        <a href="add_book.php" class="btn-primary">Add Book</a>
    </div>

    <table class="data-table">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>ISBN</th>
            <th>Quantity</th>
            <th>Available</th>
            <th>Action</th>
        </tr>

        <?php if ($books && $books->num_rows > 0): ?>
            <?php while ($row = $books->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['author']); ?></td>
                    <td><?php echo htmlspecialchars($row['isbn']); ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['available']; ?></td>
                    <td>
                        <a href="edit_book.php?id=<?php echo $row['id']; ?>">Edit</a> |
                        <a href="delete_book.php?id=<?php echo $row['id']; ?>"
                           onclick="return confirm('Delete this book?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No books found</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>