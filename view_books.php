<?php
include "db.php";
$result = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Books</title>
    <link rel="stylesheet" href="style.css?v=100">
</head>
<body>

<header>
    <h2 class="logo">Library</h2>
    <nav class="navigation">
        <a href="dashboard.php">Dashboard</a>
        <a href="add_book.php">Add Book</a>
        <a href="view_books.php">View Books</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Author</th>
        <th>Quantity</th>
        <th>Available</th>
        <th>Action</th>
    </tr>

    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['author']; ?></td>
        <td><?php echo $row['quantity']; ?></td>
        <td><?php echo $row['available']; ?></td>
        <td>
            <a href="edit_book.php?id=<?php echo $row['id']; ?>">Edit</a> |
            <a href="delete_book.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this book?')">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>