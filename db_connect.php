<?php
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    // Local XAMPP settings
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "smart_db";


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
