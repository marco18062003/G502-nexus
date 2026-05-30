<?php
$apiKey = 'AIzaSyASQrEmVic42WIewPvDzO3J2uG4qugRHaY'; // <--- Tu clave va aquí

// Vamos a probar si la llave tiene permisos
$url = "https://vision.googleapis.com/v1/images:annotate?key=" . $apiKey;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    "requests" => [["image" => ["content" => ""], "features" => [["type" => "TEXT_DETECTION"]]]]
]));

$response = curl_exec($ch);
$data = json_decode($response, true);

if (isset($data['responses'][0]['error'])) {
    echo "❌ Error de llave: " . $data['responses'][0]['error']['message'];
} else {
    echo "✅ ¡Conexión exitosa! Tu proyecto g502 ya tiene ojos.";
}
curl_close($ch);
?>