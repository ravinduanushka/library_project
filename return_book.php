<?php
include "auth.php";
include "db.php";

$message = $type = "";

if (isset($_POST['return_book'])) {
    $issue_id = (int)$_POST['issue_id'];

    $stmt = $conn->prepare("SELECT * FROM issued_books WHERE id = ? AND return_date IS NULL");
    $stmt->bind_param("i", $issue_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows === 0) {
        $message = "No active record found with that Issue ID.";
        $type    = "error";
    } else {
        $row     = $result->fetch_assoc();
        $book_id = $row['book_id'];

        $upd = $conn->prepare("UPDATE issued_books SET return_date = CURDATE() WHERE id = ?");
        $upd->bind_param("i", $issue_id);
        $upd->execute();
        $upd->close();

        $upd2 = $conn->prepare("UPDATE books SET available = available + 1 WHERE id = ?");
        $upd2->bind_param("i", $book_id);
        $upd2->execute();
        $upd2->close();

        $message = "Book returned successfully! (Issue ID: $issue_id)";
        $type    = "success";
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
    <title>Return Book - Library System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="page-container">
    <div class="page-header">
        <h1>Return Book</h1>
        <a href="dashboard.php" class="btn-secondary">← Dashboard</a>
    </div>
    <div class="form-card">
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $type; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        <p style="margin-bottom:16px;color:#555;">Enter the Issue ID from the table below.</p>
        <form method="POST">
            <div class="form-group">
                <label>Issue ID <span class="required">*</span></label>
                <input type="number" name="issue_id" placeholder="e.g. 3" min="1" required>
            </div>
            <div class="form-actions">
                <button type="submit" name="return_book" class="btn-primary">Return Book</button>
            </div>
        </form>
    </div>

    <div class="section-card" style="margin-top:30px;">
        <h2 class="section-title">Books Awaiting Return</h2>
        <?php if ($issued->num_rows > 0): ?>
        <table class="data-table">
            <thead>
                <tr><th>Issue ID</th><th>Borrower</th><th>Book</th><th>Issue Date</th><th>Due Date</th><th>Status</th></tr>
            </thead>
            <tbody>
                <?php while ($row = $issued->fetch_assoc()): ?>
                <tr>
                    <td><strong>#<?php echo $row['id']; ?></strong></td>
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
            <p class="empty-msg">All books returned! 🎉</p>
        <?php endif; ?>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>