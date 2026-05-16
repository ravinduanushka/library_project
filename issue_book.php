<?php
include "auth.php";
include "db.php";

$message = $type = "";
$books_list = $conn->query("SELECT id, title, author, available FROM books WHERE available > 0 ORDER BY title");
$users_list = $conn->query("SELECT id, username, email FROM users ORDER BY username");

if (isset($_POST['issue'])) {
    $user_id       = (int)$_POST['user_id'];
    $book_id       = (int)$_POST['book_id'];
    $borrower_name = trim($_POST['borrower_name']);
    $due_days      = (int)$_POST['due_days'];

    $avail = $conn->prepare("SELECT available FROM books WHERE id = ?");
    $avail->bind_param("i", $book_id);
    $avail->execute();
    $avail_row = $avail->get_result()->fetch_assoc();
    $avail->close();

    if (!$avail_row || $avail_row['available'] < 1) {
        $message = "This book is not available.";
        $type    = "error";
    } elseif ($borrower_name === "" || $user_id < 1 || $book_id < 1 || $due_days < 1) {
        $message = "Please fill in all fields.";
        $type    = "error";
    } else {
        $stmt = $conn->prepare("INSERT INTO issued_books (user_id, book_id, borrower_name, issue_date, due_date)
                                VALUES (?, ?, ?, CURDATE(), DATE_ADD(CURDATE(), INTERVAL ? DAY))");
        $stmt->bind_param("iisi", $user_id, $book_id, $borrower_name, $due_days);
        if ($stmt->execute()) {
            $upd = $conn->prepare("UPDATE books SET available = available - 1 WHERE id = ?");
            $upd->bind_param("i", $book_id);
            $upd->execute();
            $upd->close();
            $message = "Book issued to " . htmlspecialchars($borrower_name) . " successfully!";
            $type    = "success";
            $books_list = $conn->query("SELECT id, title, author, available FROM books WHERE available > 0 ORDER BY title");
        } else {
            $message = "Error issuing book.";
            $type    = "error";
        }
        $stmt->close();
    }
}

$issued = $conn->query("
    SELECT ib.id, ib.borrower_name, b.title, ib.issue_date, ib.due_date
    FROM issued_books ib JOIN books b ON b.id = ib.book_id
    WHERE ib.return_date IS NULL ORDER BY ib.due_date ASC
");
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
<div class="page-container">
    <div class="page-header">
        <h1>Issue Book</h1>
        <a href="dashboard.php" class="btn-secondary">← Dashboard</a>
    </div>
    <div class="form-card">
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $type; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Select Book <span class="required">*</span></label>
                <select name="book_id" required>
                    <option value="">-- Choose a Book --</option>
                    <?php if ($books_list && $books_list->num_rows > 0):
                        while ($b = $books_list->fetch_assoc()): ?>
                        <option value="<?php echo $b['id']; ?>">
                            <?php echo htmlspecialchars($b['title']); ?> by <?php echo htmlspecialchars($b['author']); ?> (Avail: <?php echo $b['available']; ?>)
                        </option>
                    <?php endwhile; else: ?>
                        <option disabled>No books available</option>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Select User <span class="required">*</span></label>
                <select name="user_id" required>
                    <option value="">-- Choose a User --</option>
                    <?php while ($u = $users_list->fetch_assoc()): ?>
                        <option value="<?php echo $u['id']; ?>">
                            <?php echo htmlspecialchars($u['username']); ?> (<?php echo htmlspecialchars($u['email']); ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Borrower Name <span class="required">*</span></label>
                <input type="text" name="borrower_name" placeholder="Full name" required>
            </div>
            <div class="form-group">
                <label>Due in Days <span class="required">*</span></label>
                <input type="number" name="due_days" value="7" min="1" max="90" required>
            </div>
            <div class="form-actions">
                <button type="submit" name="issue" class="btn-primary">Issue Book</button>
            </div>
        </form>
    </div>

    <div class="section-card" style="margin-top:30px;">
        <h2 class="section-title">Currently Issued Books</h2>
        <?php if ($issued->num_rows > 0): ?>
        <table class="data-table">
            <thead>
                <tr><th>#</th><th>Borrower</th><th>Book</th><th>Issue Date</th><th>Due Date</th><th>Status</th></tr>
            </thead>
            <tbody>
                <?php while ($row = $issued->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['borrower_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo $row['issue_date']; ?></td>
                    <td><?php echo $row['due_date']; ?></td>
                    <td>
                        <?php if ($row['due_date'] < date('Y-m-d')): ?>
                            <span class="badge badge-danger">Overdue</span>
                        <?php else: ?>
                            <span class="badge badge-warning">Active</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p class="empty-msg">No books currently issued.</p>
        <?php endif; ?>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>