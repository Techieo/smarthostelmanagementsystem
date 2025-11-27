<?php
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "smart_db";
} else {
    $host = "sql100.infinityfree.com";
    $user = "if0_40512456";
    $pass = "JQHuidZzwpCqnVq";
    $db = "if0_40512456_smart_db";
}

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
