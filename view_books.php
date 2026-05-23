<?php
// view_books.php
include "auth.php"; 
include "db.php"; 

$query = "SELECT * FROM books ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books - Library System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .page-container { padding: 25px; background: rgba(255,255,255,0.5); margin: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 2px solid #eee; padding-bottom: 15px; }
        .page-header h1 { margin: 0; font-size: 26px; color: #333; }
        
        .data-table { width: 100%; border-collapse: collapse; margin-top: 15px; background: #fff; text-align: left; }
        .data-table th, .data-table td { padding: 12px 15px; border: 1px solid #ddd; font-size: 15px; }
        .data-table th { background-color: #333; color: white; font-weight: bold; }
        .data-table tr:nth-child(even) { background-color: #f9f9f9; }
        .data-table tr:hover { background-color: #f1f1f1; }
        
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 13px; font-weight: bold; display: inline-block; }
        .badge-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .badge-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        
        
        .btn-edit { 
            background-color: #007bff; 
            color: white; 
            text-decoration: none; 
            padding: 6px 12px; 
            border-radius: 4px; 
            font-weight: bold; 
            font-size: 14px; 
            display: inline-block;
        }
        .btn-edit:hover { 
            background-color: #0056b3; 
        }
        
        .btn-secondary { background: #6c757d; color: white; padding: 8px 15px; border-radius: 4px; text-decoration: none; font-size: 14px; }
        .btn-secondary:hover { background: #5a6268; }
        .empty-msg { text-align: center; color: #777; padding: 20px; font-style: italic; }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div style="display:flex;">
    <?php include "sidebar.php"; ?>

    <div class="page-container" style="flex:1;">
        <div class="page-header">
            <h1>Complete Book Inventory Stock</h1>
            <a href="dashboard.php" class="btn-secondary">← Back to Dashboard</a>
        </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Book Title</th>
                <th>Author</th>
                <th>Total Qty</th>
                <th>Available Count</th>
                <th>Status Badge</th>
                <th>Actions Controls</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><strong>#<?php echo $row['id']; ?></strong></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['author']); ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo $row['available']; ?></td>
                        <td>
                            <?php if ($row['available'] > 0): ?>
                                <span class="badge badge-success">In Stock (Available)</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Out of Stock</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit_book.php?id=<?php echo $row['id']; ?>" class="btn-edit" title="Edit Metadata">
                                 Edit
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="empty-msg">No books registered inside the database framework yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>