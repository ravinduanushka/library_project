<?php
session_start();
// Redirect root URL to the dashboard home page
header("Location: dashboard.php");
exit();
?>