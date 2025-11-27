<?php
// M-Pesa API credentials
$consumerKey = "GVDWWYInK9uhW7UFpGGco0z8ZnUYexAJuF6SdyZFnsJAWDl0";
$consumerSecret = "UD0OoGyYso8Ed3sccAK2sh0AG2u3kWjG7FqDI35FqMZARGN59cl2tsehGDx34hno";

$shortcode = "174379"; // Sandbox Paybill
$passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";

// Callback URL for STK Push (update with your hosted domain)
$callbackURL = "https://hostelmanagementsystem.wuaze.com/mpesa_callback.php";

// ---------------- Functions ---------------- //

// Get Access Token from Safaricom
function getAccessToken($consumerKey, $consumerSecret){
    $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Authorization: Basic ' . base64_encode($consumerKey . ':' . $consumerSecret)
    ]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($response, true);
    return $result['access_token'] ?? null;
}

// Generate STK Push password and timestamp
function mpesaPassword($shortcode, $passkey){
    $timestamp = date('YmdHis');
    $password = base64_encode($shortcode . $passkey . $timestamp);
    return [$password, $timestamp];
}
?>
