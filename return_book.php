<?php
// return_book.php
include "auth.php"; 
include "db.php"; 

$message = "";
$message_type = "";

if (isset($_POST['return'])) {
    $id = $_POST['id'];

    // Verify if the issue record exists and is not already returned
    $issue_check = $conn->query("SELECT * FROM issued_books WHERE id=$id");
    
    if ($issue_check->num_rows == 0) {
        $message = " Error: Issue Transaction ID #$id does not exist in the database!";
        $message_type = "error";
    } else {
        $row = $issue_check->fetch_assoc();
        
        if (!is_null($row['return_date'])) {
            $message = "ℹ Note: This book has already been returned on " . htmlspecialchars($row['return_date']) . "!";
            $message_type = "error";
        } else {
            $book_id = $row['book_id'];

            // Fetch book details for confirmation message
            $book_res = $conn->query("SELECT * FROM books WHERE id=$book_id");
            $book = $book_res->fetch_assoc();

            $sql = "UPDATE issued_books SET return_date=CURDATE() WHERE id=$id";

            if ($conn->query($sql)) {
                $conn->query("UPDATE books SET available = available + 1 WHERE id=$book_id");
                $message = " Success: Book '" . htmlspecialchars($book['title']) . "' (Transaction ID #$id) was successfully returned and restocked!";
                $message_type = "success";
            } else {
                $message = " Error: Failed to return the book. Database error: " . $conn->error;
                $message_type = "error";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return a Book - Library System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .page-container { padding: 25px; background: rgba(255,255,255,0.5); margin: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 2px solid #eee; padding-bottom: 15px; }
        .page-header h1 { margin: 0; font-size: 26px; color: #333; }
        
        .form-card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            max-width: 500px;
            margin: 20px auto;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border: 1px solid #eaeaea;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #444;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 15px;
            transition: border 0.3s;
            margin: 0; /* Reset global style */
            box-sizing: border-box;
        }
        
        .form-group input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0,123,255,0.25);
        }
        
        .btn-submit {
            background-color: #fd7e14;
            color: white;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 4px;
            width: 100%;
            cursor: pointer;
            transition: background 0.2s;
        }
        
        .btn-submit:hover {
            background-color: #e06907;
        }
        
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 15px;
            font-weight: 500;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .btn-secondary { background: #6c757d; color: white; padding: 8px 15px; border-radius: 4px; text-decoration: none; font-size: 14px; }
        .btn-secondary:hover { background: #5a6268; }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div style="display:flex;">
    <?php include "sidebar.php"; ?>

    <div class="page-container" style="flex:1;">
        <div class="page-header">
            <h1>Return a Borrowed Book</h1>
            <a href="dashboard.php" class="btn-secondary">← Back to Dashboard</a>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="form-card">
            <h3 style="margin-top:0; margin-bottom: 20px; text-align: center; color: #333;">Enter Transaction Details</h3>
            <form method="POST">
                <div class="form-group">
                    <label for="id">Issue ID (Transaction #)</label>
                    <input type="number" id="id" name="id" placeholder="e.g. 5" required>
                </div>

                <button type="submit" name="return" class="btn-submit"> Return & Restock Book</button>
            </form>
        </div>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>