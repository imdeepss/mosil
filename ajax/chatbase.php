<?php
session_start();
header('Content-Type: application/json');

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

if (!isset($input['messages']) || empty($input['messages'])) {
    echo json_encode(['error' => 'Messages array is required.']);
    exit;
}

// ---------------------------------------------------------
// Chatbase API Integration
// ---------------------------------------------------------
$CHATBASE_API_KEY = 'c45d168a-61bc-453a-a973-b35668e05b0f';
$CHATBOT_ID = '6MqeSpCR1QiEXI65v5iEk';

$payload = [
    'messages' => $input['messages'],
    'chatbotId' => $CHATBOT_ID,
    'stream' => false,
    'temperature' => 0.2
];

$ch = curl_init('https://www.chatbase.co/api/v1/chat');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $CHATBASE_API_KEY
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr = curl_error($ch);
curl_close($ch);

if ($response === false) {
    echo json_encode(['error' => 'Network error connecting to Chatbase API: ' . $curlErr]);
    exit;
}

$data = json_decode($response, true);

if ($httpCode >= 200 && $httpCode < 300 && isset($data['text'])) {
    echo json_encode(['text' => $data['text']]);
} else {
    $errorMsg = $data['message'] ?? $data['error'] ?? ('Unknown Chatbase API error (HTTP ' . $httpCode . ')');
    echo json_encode(['error' => $errorMsg]);
}