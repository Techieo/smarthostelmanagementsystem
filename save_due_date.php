<?php
include 'db_connect.php';

// Ensure POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request.");
}

// Get form values
$open_date  = $_POST['open_date'];
$open_time  = $_POST['open_time'];
$close_date = $_POST['close_date'];
$close_time = $_POST['close_time'];

// Combine into full timestamps
$open_datetime  = "$open_date $open_time";
$close_datetime = "$close_date $close_time";

// Validate: Closing must be after opening
if (strtotime($close_datetime) <= strtotime($open_datetime)) {
    die("Error: Closing date/time must be AFTER opening date/time.");
}

// Check if schedule exists (only 1 record allowed)
$check = $conn->query("SELECT id FROM booking_due_dates LIMIT 1");

if ($check->num_rows > 0) {
    // UPDATE existing schedule
    $row = $check->fetch_assoc();
    $id = $row['id'];

    $stmt = $conn->prepare("
        UPDATE booking_due_dates 
        SET open_date=?, open_time=?, close_date=?, close_time=? 
        WHERE id=?
    ");
    $stmt->bind_param("ssssi", $open_date, $open_time, $close_date, $close_time, $id);

    if ($stmt->execute()) {
        echo "Booking schedule updated successfully.";
    } else {
        echo "Database error: " . $stmt->error;
    }

} else {
    // INSERT new schedule
    $stmt = $conn->prepare("
        INSERT INTO booking_due_dates 
        (open_date, open_time, close_date, close_time) 
        VALUES (?,?,?,?)
    ");
    $stmt->bind_param("ssss", $open_date, $open_time, $close_date, $close_time);

    if ($stmt->execute()) {
        echo "Booking schedule created successfully.";
    } else {
        echo "Database error: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>
