<?php
// Database configuration
$hostname = "sql100.infinityfree.com";     // Server name
$username = "if0_40512456";          // Database username
$password = "JQHuidZzwpCqnVq";              // Database password
$database = "if0_40512456_smart_db"; // Your database name

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
