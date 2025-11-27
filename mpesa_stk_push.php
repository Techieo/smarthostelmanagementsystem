<?php
session_start();
include 'db_connect.php';
include 'mpesa_config.php';

if (!isset($_SESSION['pending_booking'])) {
    die("No pending booking found.");
}

$booking = $_SESSION['pending_booking'];
$phone   = $booking['payment_phone'];
$amount  = $booking['amount'];

// Generate access token
$token = getAccessToken($consumerKey, $consumerSecret);

// Generate password
list($password, $timestamp) = mpesaPassword($shortcode, $passkey);

$url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

$payload = [
    "BusinessShortCode" => $shortcode,
    "Password" => $password,
    "Timestamp" => $timestamp,
    "TransactionType" => "CustomerPayBillOnline",
    "Amount" => $amount,
    "PartyA" => $phone,
    "PartyB" => $shortcode,
    "PhoneNumber" => $phone,
    "CallBackURL" => "https://yourdomain.com/mpesa_callback.php", // change to real URL
    "AccountReference" => "SmartHostel",
    "TransactionDesc" => "Room Payment"
];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token
]);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    die("cURL Error: $err");
}

// Decode Safaricom response to get CheckoutRequestID
$responseData = json_decode($response, true);
if (isset($responseData['CheckoutRequestID'])) {
    $checkoutRequestID = $responseData['CheckoutRequestID'];

    // Insert into pending_bookings table
    $stmt = $conn->prepare("INSERT INTO pending_bookings 
        (student_id, room_id, fullname, phone, country, payment_phone, payment_method, booking_date, amount, checkout_request_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param(
        "iissssssds",
        $booking['student_id'],
        $booking['room_id'],
        $booking['fullname'],
        $booking['phone'],
        $booking['country'],
        $booking['payment_phone'],
        $booking['payment_method'],
        $booking['booking_date'],
        $booking['amount'],
        $checkoutRequestID
    );
    $stmt->execute();

    // Optionally clear session
    unset($_SESSION['pending_booking']);
}

echo $response;
?>
