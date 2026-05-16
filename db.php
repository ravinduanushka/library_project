<?php
$conn = new mysqli("127.0.0.1", "root", "", "library1", 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>