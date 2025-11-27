<?php
// stk_push.php
require 'mpesa_config.php';

// Function to get access token
function getAccessToken($consumerKey, $consumerSecret) {
    $credentials = base64_encode($consumerKey . ":" . $consumerSecret);
    $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    curl_close($curl);

    $result = json_decode($response);
    return $result->access_token;
}

// Student phone number and amount (example)
// Get phone from user input
$phoneNumber = $_POST['phoneNumber']; // user enters number in a form
$amount = $_POST['amount'];           // user enters the amount to pay

$accessToken = getAccessToken($consumerKey, $consumerSecret);

// Prepare STK Push request
$timestamp = date('YmdHis');
$password = base64_encode($shortCode . $passkey . $timestamp);

$stkPushData = [
    'BusinessShortCode' => $shortCode,
    'Password' => $password,
    'Timestamp' => $timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $amount,
    'PartyA' => $phoneNumber,
    'PartyB' => $shortCode,
    'PhoneNumber' => $phoneNumber,
    'CallBackURL' => $callbackURL,
    'AccountReference' => 'Hostel001',
    'TransactionDesc' => 'Hostel Payment'
];

$curl = curl_init('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Content-Type:application/json',
    'Authorization:Bearer ' . $accessToken
]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($stkPushData));

$response = curl_exec($curl);
curl_close($curl);

$result = json_decode($response, true);
print_r($result); // display response for debugging
?>
