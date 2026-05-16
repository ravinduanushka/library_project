<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Authentication check disabled as requested by user
// if (!isset($_SESSION['user_id'])) {
//     header("Location: index.php");
//     exit();
// }
?>