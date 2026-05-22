<?php
// header.php
// Global unified header navigation bar layout template
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar" style="background: #333; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; color: white; font-family: sans-serif;">
    <div class="nav-logo" style="font-size: 20px; font-weight: bold;">
        Library Management System
    </div>
    
    <div class="nav-links">
        <a href="dashboard.php" style="color: white; text-decoration: none; margin-left: 20px; font-size: 15px;">Dashboard</a>
        <a href="add_book.php" style="color: white; text-decoration: none; margin-left: 20px; font-size: 15px;">Add Book</a>
        <a href="view_books.php" style="color: white; text-decoration: none; margin-left: 20px; font-size: 15px;">View Books</a>
        <a href="issue_book.php" style="color: white; text-decoration: none; margin-left: 20px; font-size: 15px;">Issue Book</a>
        <a href="return_book.php" style="color: white; text-decoration: none; margin-left: 20px; font-size: 15px;">Return Book</a>
        
        <?php if (isset($_SESSION['username'])): ?>
            <span style="color: #ffc107; margin-left: 25px; font-weight: bold;">[Admin: <?php echo htmlspecialchars($_SESSION['username']); ?>]</span>
            <a href="logout.php" style="color: #ff4d4d; text-decoration: none; margin-left: 15px; font-weight: bold;">Logout</a>
        <?php endif; ?>
    </div>
</nav>