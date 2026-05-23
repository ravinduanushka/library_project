<?php
include "db.php";

echo "<h2>🔧 Database Setup</h2>";

// Check if books table exists
$check_table = $conn->query("SHOW TABLES LIKE 'books'");

if ($check_table && $check_table->num_rows > 0) {
    echo "<p style='color:green;'>✅ Books table already exists</p>";
} else {
    echo "<p style='color:orange;'>⚠️ Books table not found. Creating it...</p>";
    
    $create_table = "CREATE TABLE books (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        author VARCHAR(255) NOT NULL,
        quantity INT NOT NULL DEFAULT 0,
        available INT NOT NULL DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($create_table)) {
        echo "<p style='color:green;'>✅ Books table created successfully!</p>";
    } else {
        echo "<p style='color:red;'>❌ Error creating books table: " . htmlspecialchars($conn->error) . "</p>";
    }
}

// Check if users table exists (for login/register)
$check_users = $conn->query("SHOW TABLES LIKE 'users'");

if ($check_users && $check_users->num_rows > 0) {
    echo "<p style='color:green;'>✅ Users table already exists</p>";
} else {
    echo "<p style='color:orange;'>⚠️ Users table not found. Creating it...</p>";
    
    $create_users = "CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($create_users)) {
        echo "<p style='color:green;'>✅ Users table created successfully!</p>";
    } else {
        echo "<p style='color:red;'>❌ Error creating users table: " . htmlspecialchars($conn->error) . "</p>";
    }
}

// Check if issues table exists
$check_issues = $conn->query("SHOW TABLES LIKE 'issues'");

if ($check_issues && $check_issues->num_rows > 0) {
    echo "<p style='color:green;'>✅ Issues table already exists</p>";
} else {
    echo "<p style='color:orange;'>⚠️ Issues table not found. Creating it...</p>";
    
    $create_issues = "CREATE TABLE issues (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        book_id INT NOT NULL,
        issue_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        return_date DATETIME,
        status ENUM('active', 'returned') DEFAULT 'active',
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (book_id) REFERENCES books(id)
    )";
    
    if ($conn->query($create_issues)) {
        echo "<p style='color:green;'>✅ Issues table created successfully!</p>";
    } else {
        echo "<p style='color:red;'>❌ Error creating issues table: " . htmlspecialchars($conn->error) . "</p>";
    }
}

echo "<hr>";
echo "<h3>📋 Current Tables:</h3>";
$tables = $conn->query("SHOW TABLES");
if ($tables && $tables->num_rows > 0) {
    while ($row = $tables->fetch_array()) {
        echo "✔ " . htmlspecialchars($row[0]) . "<br>";
    }
} else {
    echo "<p style='color:red;'>No tables found</p>";
}

echo "<br><a href='dashboard.php' style='background: #007bff; color: white; padding: 8px 15px; border-radius: 4px; text-decoration: none; display: inline-block;'>← Back to Dashboard</a>";
?>
