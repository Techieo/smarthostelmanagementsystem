<?php

$consumerKey = "GVDWWYInK9uhW7UFpGGco0z8ZnUYexAJuF6SdyZFnsJAWDl0"; 
$consumerSecret = "UD0OoGyYso8Ed3sccAK2sh0AG2u3kWjG7FqDI35FqMZARGN59cl2tsehGDx34hno";

$credentials = base64_encode($consumerKey . ":" . $consumerSecret);

access_token_url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";

$headers = [
    "Authorization: Basic " . $credentials,
    "Content-Type: application/json; charset=utf8"
];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);

$response = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

curl_close($curl);
echo $result;

/* $result = json_decode($response);

echo $response; // or $result->access_token;
 */
?>