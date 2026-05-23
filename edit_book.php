<?php
// edit_book.php
include "auth.php"; 
include "db.php"; 

$message = "";
$message_type = "";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: view_books.php");
    exit();
}

$id = intval($_GET['id']);

// Fetch active book details
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: view_books.php");
    exit();
}

$row = $result->fetch_assoc();
$stmt->close();

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $quantity = intval($_POST['quantity']);

    // When modifying total quantity, update both total quantity and adjust available count accordingly
    $diff = $quantity - $row['quantity'];
    $new_available = max(0, $row['available'] + $diff);

    // Update using prepared statements to prevent injection and handle quotes
    $stmt_update = $conn->prepare("UPDATE books SET title = ?, author = ?, quantity = ?, available = ? WHERE id = ?");
    $stmt_update->bind_param("ssiii", $title, $author, $quantity, $new_available, $id);

    if ($stmt_update->execute()) {
        // Refresh local view variables
        $row['title'] = $title;
        $row['author'] = $author;
        $row['quantity'] = $quantity;
        $row['available'] = $new_available;
        
        $message = " Success: Book details updated successfully!";
        $message_type = "success";
        
        // Brief delay before redirecting to catalog
        echo "<script>
            setTimeout(function() {
                window.location.href = 'view_books.php';
            }, 1500);
        </script>";
    } else {
        $message = " Error: Failed to update the book. Database error: " . $conn->error;
        $message_type = "error";
    }
    $stmt_update->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book - Library System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .page-container { padding: 25px; background: rgba(255,255,255,0.95); margin: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
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
            background-color: #007bff;
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
            background-color: #0056b3;
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
            <h1>Edit Book Information</h1>
            <a href="view_books.php" class="btn-secondary">← Back to Catalog</a>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="form-card">
            <h3 style="margin-top:0; margin-bottom: 20px; text-align: center; color: #333;">Edit Book Details (ID #<?php echo $id; ?>)</h3>
            <form method="POST">
                <div class="form-group">
                    <label for="title">Book Title</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="author">Author Name</label>
                    <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($row['author']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="quantity">Quantity (Total Copies)</label>
                    <input type="number" id="quantity" name="quantity" min="0" value="<?php echo htmlspecialchars($row['quantity']); ?>" required>
                </div>

                <button type="submit" name="update" class="btn-submit">💾 Save Changes</button>
            </form>
        </div>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>