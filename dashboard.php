<?php
session_start();
include "db.php";

// Authentication check disabled as requested by user
// if (!isset($_SESSION['user_id'])) {
//     header("Location: index.php");
//     exit();
// }

// stats
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
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="page-container">
    <div class="dashboard-header">Dashboard Overview</div>

    <div class="cards">
        <div class="box cyan">
            <h2><?php echo $total_users; ?></h2>
            <p>Members</p>
            <span>👥</span>
        </div>

        <div class="box green">
            <h2><?php echo $issued_books; ?></h2>
            <p>Issued Books</p>
            <span>📖</span>
        </div>

        <div class="box red">
            <h2><?php echo $total_books; ?></h2>
            <p>Total Books</p>
            <span>📚</span>
        </div>

        <div class="box orange">
            <h2>$<?php echo $fine; ?></h2>
            <p>Pending Fines</p>
            <span>💰</span>
        </div>
    </div>
</div>

</body>
</html>