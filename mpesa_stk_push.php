<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include 'db_connect.php';
include 'mpesa_config.php'; // your Consumer Key, Secret, Shortcode, Passkey

// ✅ Get checkout_request_id from URL
if (!isset($_GET['checkout_request_id'])) {
    die("No pending booking found.");
}
$checkoutRequestID = $_GET['checkout_request_id'];

// ✅ Fetch pending booking from database
$stmt = $conn->prepare("SELECT * FROM pending_bookings WHERE checkout_request_id = ?");
$stmt->bind_param("s", $checkoutRequestID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("No pending booking found.");
}

$booking = $result->fetch_assoc();

// Extract details
$phone   = $booking['payment_phone'];
$amount  = $booking['amount'];

// ✅ Generate M-Pesa access token
$token = getAccessToken($consumerKey, $consumerSecret);

// ✅ Generate STK Push password
list($password, $timestamp) = mpesaPassword($shortcode, $passkey);

// ✅ STK Push URL
$url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest'; // Use live URL in production

// ✅ Payload
$payload = [
    "BusinessShortCode" => $shortcode,
    "Password" => $password,
    "Timestamp" => $timestamp,
    "TransactionType" => "CustomerPayBillOnline",
    "Amount" => $amount,
    "PartyA" => $phone,
    "PartyB" => $shortcode,
    "PhoneNumber" => $phone,
    "CallBackURL" => "https://yourdomain.com/mpesa_callback.php", // Replace with your live callback URL
    "AccountReference" => "SmartHostel",
    "TransactionDesc" => "Room Payment"
];

// ✅ Initialize cURL
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token
]);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// ✅ Execute STK Push
$response = curl_exec($curl);
if (curl_errno($curl)) {
    die('cURL error: ' . curl_error($curl));
}
curl_close($curl);

// ✅ Save STK response for debugging if you like
file_put_contents('stk_response.json', $response);

// ✅ Show response to user
echo "<pre>";
echo "STK Push Sent. Response from Safaricom:\n";
print_r(json_decode($response, true));
echo "</pre>";
?>