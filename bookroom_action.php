<?php
session_start();
include 'db_connect.php';

// Ensure student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Validate form submission
$room_id       = $_POST['room_id'] ?? '';
$fullname      = trim($_POST['fullname'] ?? '');
$phone         = trim($_POST['phone'] ?? '');
$country       = trim($_POST['country'] ?? '');
$payment_phone = trim($_POST['payment_phone'] ?? '');
$booking_date  = trim($_POST['booking_date'] ?? '');

$errors = [];

// Basic validation
if (empty($fullname))      $errors[] = "Full name is required.";
if (empty($phone))         $errors[] = "Phone number is required.";
if (empty($country))       $errors[] = "Country is required.";
if (empty($payment_phone)) $errors[] = "Payment phone number is required.";
if (empty($booking_date))  $errors[] = "Booking date is required.";

if (!empty($phone) && !preg_match("/^\+?[0-9]{6,15}$/", $phone))
    $errors[] = "Invalid phone number format.";
if (!empty($payment_phone) && !preg_match("/^\+?[0-9]{6,15}$/", $payment_phone))
    $errors[] = "Invalid payment phone number format.";

if (!empty($errors)) {
    // Redirect back with error
    $_SESSION['booking_errors'] = $errors;
    header("Location: dayforbooking.php?room_id=$room_id");
    exit();
}

// Check if room exists and is available
$room_sql = "SELECT * FROM rooms WHERE room_id = '$room_id' LIMIT 1";
$room_result = $conn->query($room_sql);

if (!$room_result || $room_result->num_rows == 0) {
    $_SESSION['booking_errors'] = ["Room not found."];
    header("Location: book_room.php");
    exit();
}

$room = $room_result->fetch_assoc();

// Check if room is already booked (optional, depends on your system)
$check_booking_sql = "SELECT * FROM bookings WHERE room_id = '$room_id' AND booking_date = '$booking_date' LIMIT 1";
$check_booking_result = $conn->query($check_booking_sql);

if ($check_booking_result && $check_booking_result->num_rows > 0) {
    $_SESSION['booking_errors'] = ["This room is already booked on the selected date."];
    header("Location: dayforbooking.php?room_id=$room_id");
    exit();
}

// Insert booking
$stmt = $conn->prepare("INSERT INTO bookings (student_id, room_id, fullname, phone, country, payment_phone, booking_date, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("iisssss", $student_id, $room_id, $fullname, $phone, $country, $payment_phone, $booking_date);
$stmt->execute();

// Optionally, mark room as booked (depends on your system)
// $conn->query("UPDATE rooms SET status='Booked' WHERE room_id='$room_id'");

$stmt->close();

// Redirect with success message
$_SESSION['booking_success'] = "You have successfully booked Room " . $room['room_number'] . " for " . date('F d, Y', strtotime($booking_date)) . ".";
header("Location: book_room.php");
exit();
?>
