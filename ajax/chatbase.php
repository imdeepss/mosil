<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

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

// Generate or retrieve persistent conversation ID for the user's session
if (!empty($input['conversationId'])) {
    $conversationId = trim($input['conversationId']);
    $_SESSION['sarah_conversation_id'] = $conversationId;
} elseif (!empty($_SESSION['sarah_conversation_id'])) {
    $conversationId = $_SESSION['sarah_conversation_id'];
} else {
    $conversationId = 'web_' . date('YmdHis') . '_' . bin2hex(random_bytes(6));
    $_SESSION['sarah_conversation_id'] = $conversationId;
}

$payload = [
    'messages' => $input['messages'],
    'chatbotId' => $CHATBOT_ID,
    'conversationId' => $conversationId,
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
    // Send email notification to enquiry@mosil.com when a user starts a conversation
    $messages = $input['messages'];
    $userMessages = array_filter($messages, function ($m) {
        return isset($m['role']) && $m['role'] === 'user';
    });

    if (count($userMessages) === 1) {
        try {
            $firstMessageObj = array_values($userMessages)[0];
            $userQuery = $firstMessageObj['content'] ?? '';
            $botResponse = $data['text'];

            $toEmail = defined('ADMIN_EMAIL') ? ADMIN_EMAIL : 'enquiry@mosil.com';
            $subject = "[SARAH AI Chat] New Conversation Started: " . cleanText($userQuery, 40);

            $pageUrl = $_SERVER['HTTP_REFERER'] ?? 'Website (Direct)';
            $userIp = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
            $currentTime = date('Y-m-d H:i:s');

            $mailBody = "
            <div style='font-family: Helvetica, Arial, sans-serif; color: #333; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05);'>
                <div style='background-color: #1A3B1B; padding: 20px; text-align: center; color: #ffffff;'>
                    <h2 style='margin: 0; font-size: 20px; color: #F4C300;'>SARAH AI Chat Notification</h2>
                    <p style='margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;'>A visitor has started a new conversation on the website</p>
                </div>
                
                <div style='padding: 24px; background-color: #ffffff;'>
                    <table width='100%' cellpadding='10' cellspacing='0' style='border-collapse: collapse; font-family: Helvetica, Arial, sans-serif; font-size: 14px;'>
                        <tr style='background-color: #f9fafb;'>
                            <td width='30%' style='border: 1px solid #edf2f7; color: #4a5568;'><strong>User Query:</strong></td>
                            <td style='border: 1px solid #edf2f7; color: #1a202c; font-weight: 500;'>" . htmlspecialchars($userQuery) . "</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #edf2f7; color: #4a5568; vertical-align: top;'><strong>SARAH Response:</strong></td>
                            <td style='border: 1px solid #edf2f7; color: #2d3748; line-height: 1.5;'>" . nl2br(htmlspecialchars($botResponse)) . "</td>
                        </tr>
                        <tr style='background-color: #f9fafb;'>
                            <td style='border: 1px solid #edf2f7; color: #4a5568;'><strong>Page Referrer:</strong></td>
                            <td style='border: 1px solid #edf2f7; color: #1a202c;'><a href='" . htmlspecialchars($pageUrl) . "' style='color: #1A3B1B; text-decoration: underline;'>" . htmlspecialchars($pageUrl) . "</a></td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #edf2f7; color: #4a5568;'><strong>Date & Time:</strong></td>
                            <td style='border: 1px solid #edf2f7; color: #1a202c;'>" . htmlspecialchars($currentTime) . "</td>
                        </tr>
                        <tr style='background-color: #f9fafb;'>
                            <td style='border: 1px solid #edf2f7; color: #4a5568;'><strong>IP Address:</strong></td>
                            <td style='border: 1px solid #edf2f7; color: #1a202c;'>" . htmlspecialchars($userIp) . "</td>
                        </tr>
                    </table>
                </div>
                
                <div style='background-color: #f7fafc; padding: 15px; text-align: center; font-size: 12px; color: #718096; border-t: 1px solid #edf2f7;'>
                    This email was automatically generated by MOSIL Lubricants SARAH AI Assistant.
                </div>
            </div>";

            sendMail($toEmail, 'Mosil Support', $subject, $mailBody);
        } catch (\Throwable $e) {
            error_log("SARAH AI Mail Error: " . $e->getMessage());
        }
    }

    echo json_encode([
        'text' => $data['text'],
        'conversationId' => $conversationId
    ]);
} else {
    $errorMsg = $data['message'] ?? $data['error'] ?? ('Unknown Chatbase API error (HTTP ' . $httpCode . ')');
    echo json_encode(['error' => $errorMsg]);
}