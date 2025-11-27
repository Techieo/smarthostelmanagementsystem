<?php
// ======================== CONFIGURATION ========================
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ======= Credentials =======
$consumerKey    = "GVDWWYInK9uhW7UFpGGco0z8ZnUYexAJuF6SdyZFnsJAWDl0";
$consumerSecret = "UD0OoGyYso8Ed3sccAK2sh0AG2u3kWjG7FqDI35FqMZARGN59cl2tsehGDx34hno";

$shortcode = "174379"; // Paybill (sandbox) or live shortcode
$passkey   = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";

// ======= Callback URL =======
$callbackURL = "https://yourdomain.com/mpesa_callback.php"; // Replace with your live callback URL

// ======= Environment =======
$environment = "sandbox"; // Change to "live" for production

// ======================== FUNCTIONS ========================

// Get M-Pesa Access Token
if (!function_exists('getAccessToken')) {
    function getAccessToken($consumerKey, $consumerSecret) {
        global $environment;
        $url = ($environment === "live") ?
            "https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials" :
            "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ["Authorization: Basic " . base64_encode("$consumerKey:$consumerSecret")]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        if(curl_errno($curl)) {
            die("cURL error: ".curl_error($curl));
        }
        curl_close($curl);

        $data = json_decode($response, true);
        return $data['access_token'] ?? die("Error fetching access token");
    }
}

// Generate STK Push Password
if (!function_exists('mpesaPassword')) {
    function mpesaPassword($shortcode, $passkey) {
        $timestamp = date('YmdHis');
        $password  = base64_encode($shortcode . $passkey . $timestamp);
        return [$password, $timestamp];
    }
}

// Get STK Push URL
if (!function_exists('getStkUrl')) {
    function getStkUrl() {
        global $environment;
        return ($environment === "live") ?
            "https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest" :
            "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";
    }
}
?>
