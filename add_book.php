<?php
// add_book.php
include "auth.php"; // ආරක්ෂිත සෙෂන් වැටකඩ (Session Gateway)
include "db.php";   // දත්ත සමුදාය සම්බන්ධතාවය (Port: 3307)

$message = "";
$msg_class = "";

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
            $msg_class = "error-msg";
        } else {
            $stmt->bind_param("ssii", $title, $author, $quantity, $available);
            
            if ($stmt->execute()) {
                $message = "✅ Book registered successfully!";
                $msg_class = "success-msg";
                // Clear form fields after successful submission
                $_POST = array();
            } else {
                $message = "Execute Error: " . htmlspecialchars($stmt->error);
                $msg_class = "error-msg";
            }
            $stmt->close();
        }
    } else {
        $message = "⚠️ Please fill all fields correctly! Title and Author required, Quantity must be greater than 0.";
        $msg_class = "error-msg";
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
        /* Dashboard එකට සමාන නිල්, කොළ, රතු පසුබිම් පින්තූරය ලෝඩ් කරවීම */
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            min-height: 100vh !important;
            font-family: Arial, sans-serif;
        }

        /* Dashboard එකේ විදිහටම ප්‍රධාන Container එක විනිවිද පෙනෙන සේ සකස් කිරීම */
        .page-container { 
            padding: 30px; 
            background: rgba(255, 255, 255, 0.5) !important; /* 50% විනිවිදභාවය */
            margin: 20px; 
            border-radius: 8px; 
            backdrop-filter: blur(8px) !important; 
            -webkit-backdrop-filter: blur(8px) !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
        }
        
        .page-header { 
            margin-bottom: 25px; 
            border-bottom: 2px solid rgba(0,0,0,0.1); 
            padding-bottom: 15px; 
        }
        .page-header h1 { margin: 0; font-size: 26px; color: #222; font-weight: bold; }

        /* Form Card Layout */
        .form-card {
            background: rgba(255, 255, 255, 0.8) !important;
            padding: 30px;
            border-radius: 8px;
            max-width: 500px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border: 1px solid rgba(255,255,255,0.3);
        }
        
        .form-group { text-align: left; margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: bold; color: #333; font-size: 14px; }
        
        /* Input Fields හැඩගැන්වීම් */
        .form-group input { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #ccc; 
            border-radius: 6px; 
            box-sizing: border-box; 
            font-size: 15px;
            background: #fff;
        }
        .form-group input:focus { border-color: #007bff; outline: none; }
        
        /* Submit Button එක කළු පැහැයෙන් */
        .btn-submit { 
            width: 100%; 
            background: #222; 
            color: white; 
            border: none; 
            padding: 12px; 
            border-radius: 6px; 
            cursor: pointer; 
            font-size: 16px; 
            font-weight: bold;
            transition: background 0.2s;
        }
        .btn-submit:hover { background: #000; }
        
        /* నిවేదన సందేశాలు (Alert Messages) */
        .success-msg { 
            background: #d4edda; 
            color: #155724; 
            padding: 15px; 
            border-radius: 6px; 
            margin-bottom: 20px; 
            font-size: 15px; 
            border: 1px solid #c3e6cb;
            font-weight: 500;
        }
        .error-msg { 
            background: #f8d7da; 
            color: #721c24; 
            padding: 15px; 
            border-radius: 6px; 
            margin-bottom: 20px; 
            font-size: 15px; 
            border: 1px solid #f5c6cb;
            font-weight: 500;
        }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div style="display:flex;">
    <?php include "sidebar.php"; ?>

    <div class="page-container" style="flex:1;">
        <div class="page-header">
            <h1>Register New Book Asset</h1>
        </div>

        <div class="form-card">
            <?php if (!empty($message)): ?>
                <div class="<?php echo $msg_class; ?>"><?php echo $message; ?></div>
            <?php endif; ?>

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

</body>
</html>