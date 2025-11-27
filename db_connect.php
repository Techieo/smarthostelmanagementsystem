<?php
// Detect environment
$host = $_SERVER['HTTP_HOST'];

// If running on localhost (XAMPP)
if ($host === 'localhost' || $host === '127.0.0.1') {
    $hostname = "localhost";      // Local database host
    $username = "root";           // Local DB username
    $password = "";               // Local DB password (XAMPP default empty)
    $database = "smart_db";       // Your local database name

} else {
    // If running online (InfinityFree)
    $hostname = "sql100.infinityfree.com";
    $username = "if0_40512456";
    $password = "JQHuidZzwpCqnVq";
    $database = "if0_40512456_smart_db";
}

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
