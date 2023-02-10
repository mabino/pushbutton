<?php

$config = include 'config.php';
$token = $config['token'];
$user_key = $config['user_key'];

$message = $_POST['message'];

$data = array(
  "token" => $token,
  "user" => $user_key,
  "message" => $message,
);

$ch = curl_init("https://api.pushover.net/1/messages.json");
curl_setopt_array($ch, array(
  CURLOPT_POST => TRUE,
  CURLOPT_RETURNTRANSFER => TRUE,
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json"
  ),
  CURLOPT_POSTFIELDS => json_encode($data)
));

$response = curl_exec($ch);

$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

if ($http_code != 200) {
  header("HTTP/1.1 500 Internal Server Error");
  die(json_encode(array("success" => false, "error" => "Pushover API returned HTTP code $http_code")));
}

echo json_encode(array("success" => true));

?>
