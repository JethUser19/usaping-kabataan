<?php
// Database configuration
$host = 'localhost';      // Host name (usually localhost)
$db   = 'user_db';        // Your database name
$user = 'root';           // Your MySQL username
$pass = '';               // Your MySQL password (empty if using XAMPP default)
$charset = 'utf8mb4';

// Create a new MySQLi connection
$conn = new mysqli($host, $user, $pass, $db);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set charset (not required but recommended)
$conn->set_charset($charset);
?>
