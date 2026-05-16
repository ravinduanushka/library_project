<?php
include "db.php";

echo "<h2>Database Test</h2>";

if ($conn) {
    echo "<p style='color:green;'>✅ Database Connected Successfully</p>";
} else {
    echo "<p style='color:red;'>❌ Connection Error</p>";
}

// Check tables
$check = $conn->query("SHOW TABLES");

if ($check && $check->num_rows > 0) {
    echo "<h3>Tables in Database:</h3>";
    while ($row = $check->fetch_array()) {
        echo "✔ " . $row[0] . "<br>";
    }
} else {
    echo "<p style='color:red;'>❌ No tables found</p>";
}
?>