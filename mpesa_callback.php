<?php
include 'db_connect.php';

// Read JSON from Safaricom
$callbackJSON = file_get_contents('php://input');
$callbackData = json_decode($callbackJSON, true);

$resultCode = $callbackData['Body']['stkCallback']['ResultCode'];
$checkoutRequestID = $callbackData['Body']['stkCallback']['CheckoutRequestID'];

if ($resultCode == 0) {
    // Payment successful
    // Extract amount and phone from callback metadata
    $items = $callbackData['Body']['stkCallback']['CallbackMetadata']['Item'];
    $amount = 0;
    $phone  = '';
    foreach ($items as $item) {
        if ($item['Name'] === 'Amount') $amount = $item['Value'];
        if ($item['Name'] === 'PhoneNumber') $phone = $item['Value'];
    }

    // Fetch the pending booking using checkoutRequestID
    $stmt = $conn->prepare("SELECT * FROM pending_bookings WHERE checkout_request_id = ? LIMIT 1");
    $stmt->bind_param("s", $checkoutRequestID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $pending = $result->fetch_assoc();

        // Insert into bookings table
        $insert = $conn->prepare("INSERT INTO bookings 
            (student_id, room_id, fullname, phone, country, payment_phone, payment_method, booking_date, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $status = "paid";
        $payment_method = "M-Pesa";

        $insert->bind_param(
            "iisssssss",
            $pending['student_id'],
            $pending['room_id'],
            $pending['fullname'],
            $pending['phone'],
            $pending['country'],
            $phone,              // Payment phone from M-Pesa
            $payment_method,
            $pending['booking_date'],
            $status
        );
        $insert->execute();

        // Delete from pending_bookings
        $del = $conn->prepare("DELETE FROM pending_bookings WHERE checkout_request_id = ?");
        $del->bind_param("s", $checkoutRequestID);
        $del->execute();
    }
}

// Always respond with 200 OK
http_response_code(200);
?>
