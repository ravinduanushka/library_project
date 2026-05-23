<?php
// dashboard.php
include "auth.php"; 
include "db.php";

// Authentication check disabled as requested by user
// if (!isset($_SESSION['user_id'])) {
//     header("Location: index.php");
//     exit();
// }

$total_books = $conn->query("SELECT COUNT(*) as c FROM books")->fetch_assoc()['c'];
$total_users = $conn->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'];
$issued_books = $conn->query("SELECT COUNT(*) as c FROM issued_books WHERE return_date IS NULL")->fetch_assoc()['c'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .page-container { padding: 25px; background: rgba(255,255,255,0.5); margin: 20px; border-radius: 8px; }
        .dashboard-header { margin-bottom: 30px; font-size: 24px; color: #333; font-weight: bold; }
        
        /* Dashboard Layout Grid Styles */
        .cards { display: flex; gap: 20px; margin-top: 20px; }
        .box { padding: 25px; border-radius: 8px; flex: 1; text-align: center; color: white; font-family: sans-serif; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .box h2 { margin: 0; font-size: 32px; font-weight: bold; }
        .box p { margin: 5px 0 0 0; font-size: 16px; font-weight: 500; opacity: 0.9; }
        
        /* Box Colors background themes */
        .cyan { background-color: #17a2b8; }
        .green { background-color: #28a745; }
        .red { background-color: #dc3545; }

        
        .box span, .box::before, .box::after, .cards .box span, .cards .box::before, .cards .box::after {
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
    <?php include "sidebar.php"; ?>

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
        </div>
    </div>
</div>

</body>
</html>