<?php
header('Content-Type: application/json');

// Get POST data
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

if (!isset($input['messages']) || empty($input['messages'])) {
    echo json_encode(['error' => 'Messages array is required.']);
    exit;
}

// ---------------------------------------------------------
// TODO: Replace these with your actual Chatbase credentials
// ---------------------------------------------------------
$CHATBASE_API_KEY = 'c45d168a-61bc-453a-a973-b35668e05b0f';
$CHATBOT_ID = '6MqeSpCR1QiEXI65v5iEk';
// ---------------------------------------------------------

$messages = $input['messages'];

$data = [
    'messages' => $messages,
    'chatbotId' => $CHATBOT_ID,
    'stream' => false,
    'temperature' => 0,
    'model' => 'gpt-3.5-turbo' // Fallback to ensure compatibility with all Chatbase plans
];

$ch = curl_init('https://www.chatbase.co/api/v1/chat');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $CHATBASE_API_KEY,
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo json_encode(['error' => 'CURL Error: ' . $error]);
    exit;
}

if ($httpCode !== 200) {
    // Attempt to parse the Chatbase JSON error message cleanly
    $errorData = json_decode($response, true);
    if (isset($errorData['error']['message'])) {
        $cleanMessage = $errorData['error']['message'];
        echo json_encode(['error' => $cleanMessage]);
    } else {
        echo json_encode(['error' => 'Chatbase API returned HTTP code ' . $httpCode]);
    }
    exit;
}

echo $response;
?>