<?php
/**
 * Logout - Destroy session and redirect
 */
session_start();
session_destroy();
header("Location: index.php");
?>
