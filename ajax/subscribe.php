<?php
header('Content-Type: application/json');

require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);

if (!$email) {
    echo json_encode(['success' => false, 'message' => 'Please provide a valid email.']);
    exit;
}

// --- EMAIL: Admin Notification ---
$adminSubject = "[Newsletter] New Subscription from " . $email;
$adminBody = "
<div style='font-family: Helvetica, Arial, sans-serif; color: #333; max-width: 600px;'>
    <h2 style='color: #1A3B1B; border-bottom: 2px solid #1A3B1B; padding-bottom: 10px;'>New Newsletter Subscription</h2>
    <p>A new user has subscribed to the mailing list from the website footer.</p>
    
    <table width='100%' cellpadding='10' cellspacing='0' style='border: 1px solid #eeeeee; border-collapse: collapse;'>
        <tr>
            <td width='30%' style='border: 1px solid #eeeeee; font-weight: bold;'>Email Address</td>
            <td style='border: 1px solid #eeeeee;'><a href='mailto:" . htmlspecialchars($email) . "'>" . htmlspecialchars($email) . "</a></td>
        </tr>
    </table>
    
    <p style='font-size: 12px; color: #888; margin-top: 20px;'>
        This email was sent from the automated subscription system on " . date('Y-m-d H:i:s') . ".
    </p>
</div>
";

$adminMail = sendMail('enquiry@mosil.com', 'Mosil Support', $adminSubject, $adminBody);

if ($adminMail['status'] === 'success') {
    echo json_encode(['success' => true, 'message' => 'success']);
} else {
    // We can also return success if the email failed but we recorded it, but no DB insertion here so fail.
    echo json_encode(['success' => false, 'message' => 'Subscription failed, please try again.']);
}
