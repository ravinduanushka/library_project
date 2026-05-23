<<<<<<< HEAD
<?php
// header.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar" style="background: rgba(51, 51, 51, 0.85); padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; color: white; font-family: sans-serif; position: relative; z-index: 10; backdrop-filter: blur(5px); box-shadow: 0 2px 10px rgba(0,0,0,0.2);">
    <div class="nav-logo" style="font-size: 20px; font-weight: bold; letter-spacing: 0.5px;">
        Library Management System
    </div>
    
    <div class="nav-actions" style="display: flex; align-items: center; gap: 15px;">
        <?php if (isset($_SESSION['user_id']) || isset($_SESSION['username'])): ?>
            <?php if (isset($_SESSION['username'])): ?>
                <span style="color: #ffc107; font-weight: bold; font-size: 14px; margin-right: 5px;">
                    [Admin: <?php echo htmlspecialchars($_SESSION['username']); ?>]
                </span>
            <?php endif; ?>
            <a href="logout.php" style="background-color: #dc3545; color: white; text-decoration: none; padding: 8px 16px; border-radius: 4px; font-weight: bold; font-size: 14px; transition: background 0.2s; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                Logout
            </a>
        <?php else: ?>
            <a href="login.php" style="background-color: #007bff; color: white; text-decoration: none; padding: 8px 16px; border-radius: 4px; font-weight: bold; font-size: 14px; transition: background 0.2s; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                Login
            </a>
        <?php endif; ?>
    </div>
</nav>
=======
<?php // header.php ?>
<style>
    .global-header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background: rgba(0, 0, 0, 0.7);
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 1000;
        box-sizing: border-box;
    }
    .global-header .brand {
        color: white;
        font-size: 24px;
        font-weight: bold;
        text-decoration: none;
    }
    .global-header nav {
        display: flex;
        align-items: center;
    }
    .global-header nav a {
        color: white;
        text-decoration: none;
        margin-left: 20px;
        font-size: 16px;
    }
    .global-header nav a:hover {
        text-decoration: underline;
    }
    /* Add padding to body to prevent content from hiding under fixed header */
    body {
        padding-top: 60px; 
    }
</style>

<header class="global-header">
    <a href="index.php" class="brand">Library</a>
    <nav>
        <a href="add_book.php"> Add Book</a>
        <a href="view_books.php"> View Books</a>
        <a href="index.php"> Login</a>
        <a href="register.php">Register</a>
        <?php if (isset($_SESSION['user_id'])) { ?>
            <a href="logout.php"> Logout</a>
        <?php } ?>
    </nav>
</header>
>>>>>>> 4ed3586e3ee0475fd601c1a12a152900d2f5702d
