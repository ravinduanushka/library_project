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