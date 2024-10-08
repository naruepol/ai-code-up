<?php

// The API endpoint
$url = 'https://api.anthropic.com/v1/messages';

// The JSON data to send
$data = [
    "model" => "claude-3-opus-20240229",
    "max_tokens" => 1024,
    "messages" => [
        ["role" => "user", "content" => "2+6*3 ="]
    ]
];

// Initialize a cURL session
$ch = curl_init($url);

// Set the API key here
$apiKey = 'sk-';

// Set cURL options
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "x-api-key: {$apiKey}",
    "anthropic-version: 2023-06-01",
    "content-type: application/json",
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Execute the POST request
$response = curl_exec($ch);

// Close the cURL session
curl_close($ch);

// Decode the JSON response
$responseData = json_decode($response, true);

// Print the response
echo "Response:\n";
print_r($responseData);

?>
