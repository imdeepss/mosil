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
// Botpress Chat Integration (Webhook ID)
// ---------------------------------------------------------
$BP_WEBHOOK_ID = '2106dd20-84dd-48b1-b21e-4bd90858c5e9';

$latestMessage = end($input['messages']);
$query = $latestMessage['content'] ?? '';

if (empty($query)) {
    echo json_encode(['error' => 'Empty message content.']);
    exit;
}

function chat_api($method, $endpoint, $data = null, $userKey = null) {
    global $BP_WEBHOOK_ID;
    $ch = curl_init("https://chat.botpress.cloud/{$BP_WEBHOOK_ID}" . $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    
    $headers = ['Content-Type: application/json'];
    if ($userKey) {
        $headers[] = 'x-user-key: ' . $userKey;
    }
    
    if ($data !== null) {
        $json = empty($data) ? "{}" : json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $headers[] = 'Content-Length: ' . strlen($json);
    }
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return ['code' => $httpCode, 'data' => json_decode($response, true)];
}

// 1. Get or Create User Session
if (!isset($_SESSION['bp_v2_user_key']) || !isset($_SESSION['bp_v2_user_id'])) {
    $userRes = chat_api('POST', '/users', []);
    if ($userRes['code'] !== 200 && $userRes['code'] !== 201) {
        $errMsg = $userRes['data']['message'] ?? 'Unknown error';
        echo json_encode(['error' => 'Failed to connect to Botpress (User Creation). API said: ' . $errMsg]);
        exit;
    }
    $_SESSION['bp_v2_user_key'] = $userRes['data']['key'];
    $_SESSION['bp_v2_user_id'] = $userRes['data']['user']['id'];
    
    // Clear any old conversation since we have a new user
    unset($_SESSION['bp_v2_conversation_id']);
}
$userKey = $_SESSION['bp_v2_user_key'];
$userId = $_SESSION['bp_v2_user_id'];

// 2. Get or Create Conversation Session
if (!isset($_SESSION['bp_v2_conversation_id'])) {
    $convRes = chat_api('POST', '/conversations', [], $userKey);
    if ($convRes['code'] !== 200 && $convRes['code'] !== 201) {
        $errMsg = $convRes['data']['message'] ?? 'Unknown error';
        echo json_encode(['error' => 'Failed to connect to Botpress (Conversation). API said: ' . $errMsg]);
        exit;
    }
    $_SESSION['bp_v2_conversation_id'] = $convRes['data']['conversation']['id'];
}
$conversationId = $_SESSION['bp_v2_conversation_id'];

// 3. Send the message to Botpress
$msgRes = chat_api('POST', '/messages', [
    'conversationId' => $conversationId,
    'userId' => $userId,
    'payload' => [
        'type' => 'text',
        'text' => $query
    ]
], $userKey);

if ($msgRes['code'] !== 200 && $msgRes['code'] !== 201) {
    $errMsg = $msgRes['data']['message'] ?? 'Unknown error';
    
    // Auto-heal session if Botpress complains about participation
    if (stripos($errMsg, 'participant') !== false || stripos($errMsg, 'key') !== false) {
        unset($_SESSION['bp_v2_user_key']);
        unset($_SESSION['bp_v2_user_id']);
        unset($_SESSION['bp_v2_conversation_id']);
    }
    
    echo json_encode(['error' => 'Failed to send message to Botpress API. API said: ' . $errMsg]);
    exit;
}

// 4. Poll for the Bot's response (Botpress replies asynchronously)
$botReply = "";
$startTime = time();
$maxWait = 12; // Wait up to 12 seconds for the bot to generate a response

while (time() - $startTime < $maxWait) {
    sleep(1); // Poll every 1 second
    
    $pollRes = chat_api('GET', "/conversations/{$conversationId}/messages", null, $userKey);
    if ($pollRes['code'] === 200 && isset($pollRes['data']['messages'])) {
        $messages = $pollRes['data']['messages'];
        $hasNewReply = false;
        
        foreach ($messages as $msg) {
            // Find messages from the bot (not from our userId) created after our request
            if (!isset($msg['userId']) || $msg['userId'] !== $userId) {
                $msgTime = strtotime($msg['createdAt']);
                if ($msgTime >= $startTime - 1) { // Account for slight server clock variance
                    if (isset($msg['payload']['text'])) {
                        $botReply .= $msg['payload']['text'] . "\n\n";
                        $hasNewReply = true;
                    }
                }
            }
        }
        
        if ($hasNewReply) {
            break;
        }
    }
}

if (empty(trim($botReply))) {
    $botReply = "I am experiencing high latency. Please ask again.";
}

echo json_encode(['text' => trim($botReply)]);
?>