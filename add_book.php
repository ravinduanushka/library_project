<?php
// add_book.php
include "auth.php"; 
include "db.php";   // දත්ත සමුදාය සම්බන්ධතාවය (Port: 3307)

$message = "";
$message_type = "";

if (isset($_POST['add_book'])) {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $quantity = intval($_POST['quantity']);
    
    // მთლიანი რაოდენობა ხელმისაწვდომი რაოდენობის ტოლია ინიციალურად
    $available = $quantity; 

    if (!empty($title) && !empty($author) && $quantity > 0) {
        // SQL ინექციიდან დასაცავად подготовкული დებულება გამოიყენება
        $stmt = $conn->prepare("INSERT INTO books (title, author, quantity, available) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            $message = "Prepare Error: " . htmlspecialchars($conn->error);
            $message_type = "error";
        } else {
            $stmt->bind_param("ssii", $title, $author, $quantity, $available);
            
            if ($stmt->execute()) {
                $message = "✅ Book registered successfully!";
                $message_type = "success";
                // Clear form fields after successful submission
                $_POST = array();
            } else {
                $message = "Execute Error: " . htmlspecialchars($stmt->error);
                $message_type = "error";
            }
            $stmt->close();
        }
    } else {
        $message = "⚠️ Please fill all fields correctly! Title and Author required, Quantity must be greater than 0.";
        $message_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book - Library System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            min-height: 100vh !important;
            font-family: Arial, sans-serif;
        }

        .page-container { 
            padding: 25px; 
            background: rgba(255, 255, 255, 0.5) !important; 
            margin: 20px; 
            border-radius: 8px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.05) !important;
        }
        
        .page-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 25px; 
            border-bottom: 2px solid #eee; 
            padding-bottom: 15px; 
        }
        .page-header h1 { margin: 0; font-size: 26px; color: #333; font-weight: bold; }

        /* Form Card Layout */
        .form-card {
            background: white !important;
            padding: 30px;
            border-radius: 8px;
            max-width: 500px;
            margin: 20px auto;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08) !important;
            border: 1px solid #eaeaea;
        }
        
        .form-group { text-align: left; margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: bold; color: #444; font-size: 14px; }
        
        .form-group input { 
            width: 100%; 
            padding: 12px 15px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
            font-size: 15px;
            margin: 0;
            box-sizing: border-box;
            background: #fff;
        }
        .form-group input:focus { 
            border-color: #007bff; 
            outline: none; 
            box-shadow: 0 0 5px rgba(0,123,255,0.25);
        }
        
        .btn-submit { 
            width: 100%; 
            background-color: #28a745; 
            color: white; 
            border: none; 
            padding: 12px 20px; 
            border-radius: 4px; 
            cursor: pointer; 
            font-size: 16px; 
            font-weight: bold;
            transition: background 0.2s;
        }
        .btn-submit:hover { background-color: #218838; }
        
        /* Alert Messages */
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
            <h1>Register New Book Asset</h1>
            <a href="dashboard.php" class="btn-secondary">← Back to Dashboard</a>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="form-card">
            <h3 style="margin-top:0; margin-bottom: 20px; text-align: center; color: #333;">Enter Book Details</h3>
            <form method="POST" action="add_book.php">
                <div class="form-group">
                    <label>Book Title</label>
                    <input type="text" name="title" placeholder="e.g. Introduction to PHP Frameworks" required>
                </div>
                
                <div class="form-group">
                    <label>Author / Publisher</label>
                    <input type="text" name="author" placeholder="e.g. Prof. J. Silva" required>
                </div>
                
                <div class="form-group">
                    <label>Total Copy Stock Quantity</label>
                    <input type="number" name="quantity" min="1" placeholder="e.g. 5" required>
                </div>
                
                <button type="submit" name="add_book" class="btn-submit">Save Book Data Block</button>
            </form>
        </div>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>