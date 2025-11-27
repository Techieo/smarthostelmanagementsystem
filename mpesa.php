<?php
// Include config file
include 'db_connect.php';
include 'mpesa_config.php';

// Function to generate access token
function getAccessToken($consumerKey, $consumerSecret) {
    $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

    $credentials = base64_encode($consumerKey . ':' . $consumerSecret);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    curl_close($curl);

    $result = json_decode($response);

    return $result->access_token;
}

// Generate password for STK push
function mpesaPassword($shortcode, $passkey) {
    $timestamp = date('YmdHis');
    $password  = base64_encode($shortcode . $passkey . $timestamp);

    return [$password, $timestamp];
}

// MAIN LOGIC
$amount = $_POST['amount'] ?? 1;  
$phone  = $_POST['phone'] ?? '2547XXXXXXXX';

// Get token
$token = getAccessToken($consumerKey, $consumerSecret);

// Generate password + timestamp
list($password, $timestamp) = mpesaPassword($shortcode, $passkey);

// STK API Endpoint
$url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token
]);

$payload = [
    "BusinessShortCode" => $shortcode,
    "Password" => $password,
    "Timestamp" => $timestamp,
    "TransactionType" => "CustomerPayBillOnline",
    "Amount" => $amount,
    "PartyA" => $phone,
    "PartyB" => $shortcode,
    "PhoneNumber" => $phone,
    "CallBackURL" => $callbackURL,
    "AccountReference" => "SmartHostel",
    "TransactionDesc" => "Room Payment"
];

curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl);
curl_close($curl);

// Show response
echo $response;
?>
