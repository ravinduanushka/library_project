<?php
// dashboard.php
include "auth.php"; 
include "db.php";

// stats ගණනය කිරීම් / Statistical data metrics queries
$total_books = $conn->query("SELECT COUNT(*) as c FROM books")->fetch_assoc()['c'];
$total_users = $conn->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'];
$issued_books = $conn->query("SELECT COUNT(*) as c FROM issued_books WHERE return_date IS NULL")->fetch_assoc()['c'];
$fine = 150; // demo value
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .page-container { padding: 25px; background: rgba(255,255,255,0.9); margin: 20px; border-radius: 8px; }
        .dashboard-header { margin-bottom: 30px; font-size: 24px; color: #333; font-weight: bold; }
        
        /* Dashboard Layout Grid Styles */
        .cards { display: flex; gap: 20px; margin-top: 20px; }
        .box { padding: 25px; border-radius: 8px; flex: 1; text-align: center; color: white; font-family: sans-serif; box-shadow: 0 4px 10px rgba(0,0,0,0.05); position: relative; }
        .box h2 { margin: 0; font-size: 32px; font-weight: bold; }
        .box p { margin: 5px 0 0 0; font-size: 16px; font-weight: 500; opacity: 0.9; }
        
        /* Box Colors background themes */
        .cyan { background-color: #17a2b8; }
        .green { background-color: #28a745; }
        .red { background-color: #dc3545; }
        .orange { background-color: #fd7e14; }

        /* FIXED: style.css එකෙන් එන ඕනෑම රූපයක්/Emoji එකක් බලෙන්ම සැඟවීම සඳහා මෙම කේතය එක් කරන ලදී */
        .box span, 
        .box::before, 
        .box::after,
        .cards .box span,
        .cards .box::before,
        .cards .box::after {
            display: none !important;
            content: "" !important;
            opacity: 0 !important;
            visibility: hidden !important;
        }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div style="display:flex;">
    <div class="sidebar" style="width:250px; background:#222; min-height:100vh; padding:20px; color:white; font-family:sans-serif;">
        <h3>Navigation</h3>
        <hr style="border-color:#444;">
        <ul style="list-style:none; padding:0; line-height:2.5;">
            <li><a href="dashboard.php" style="color:white; text-decoration:none;">Dashboard</a></li>
            <li><a href="add_book.php" style="color:white; text-decoration:none;">Add New Book</a></li>
            <li><a href="view_books.php" style="color:white; text-decoration:none;">View Book Inventory</a></li>
            <li><a href="issue_book.php" style="color:white; text-decoration:none;">Issue a Book</a></li>
            <li><a href="return_book.php" style="color:white; text-decoration:none;">Return a Book</a></li>
            <li><a href="logout.php" style="color:red; text-decoration:none; font-weight:bold;">Logout</a></li>
        </ul>
    </div>

    <div class="page-container" style="flex:1;">
        <div class="dashboard-header">Dashboard Overview</div>

        <div class="cards">
            <div class="box cyan">
                <h2><?php echo $total_users; ?></h2>
                <p>Members</p>
            </div>

            <div class="box green">
                <h2><?php echo $issued_books; ?></h2>
                <p>Issued Books</p>
            </div>

            <div class="box red">
                <h2><?php echo $total_books; ?></h2>
                <p>Total Books</p>
            </div>

            <div class="box orange">
                <h2>Rs. <?php echo $fine; ?></h2>
                <p>Pending Fines</p>
            </div>
        </div>
    </div>
</div>

</body>
<h1>SRI LANKA CHECKING</h1>
</html>