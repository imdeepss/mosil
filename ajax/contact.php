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

// 1. Sanitize & Validate Inputs
$name = htmlspecialchars(trim($_POST['name'] ?? ''));
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$contact = htmlspecialchars(trim($_POST['contact'] ?? ''));
$companyName = htmlspecialchars(trim($_POST['company_name'] ?? ''));
$subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
$message = htmlspecialchars(trim($_POST['message'] ?? ''));
$pincode = htmlspecialchars(trim($_POST['pincode'] ?? ''));

if (empty($name) || !$email || empty($contact) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Please provide Name, Valid Email, Contact Number, and Message.']);
    exit;
}

// 2. Prepare Data for DB
$status = 'Active';

// 3. Database Execution
$sql = "INSERT INTO contact_enquiry (name, email, contact, company_name, subject, pincode, message, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$params = [$name, $email, $contact, $companyName, $subject, $pincode, $message, $status];

if (db_execute($sql, $params)) {

    // --- EMAIL 1: User Confirmation ---
    $userSubject = "Thank you for contacting Mosil";
    $userBody = "
        <p>Dear " . htmlspecialchars($name) . ",</p>
        <p>Thank you for your enquiry regarding: <strong>" . htmlspecialchars($subject) . "</strong>.</p>
        <p>We have received your message:</p>
        <blockquote>" . nl2br(htmlspecialchars($message)) . "</blockquote>
        <p>We will get back to you shortly.</p>
        <p>Best regards,<br>Mosil Pvt. Ltd.</p>
    ";

    $userMail = sendMail($email, $name, $userSubject, $userBody);

    // --- EMAIL 2: Admin Notification ---
    $adminSubject = 'New Contact Enquiry Received';
    $adminBody = "
    <div style='font-family: Helvetica, Arial, sans-serif; color: #333; max-width: 600px;'>
        <h2 style='color: #1A3B1B; border-bottom: 2px solid #1A3B1B; padding-bottom: 10px;'>New Enquiry Received</h2>
        <p>You have received a new message from the website contact form.</p>
        
        <table width='100%' cellpadding='10' cellspacing='0' style='border: 1px solid #eeeeee; border-collapse: collapse;'>
            <tr style='background-color: #f9f9f9;'>
                <td width='30%' style='border: 1px solid #eeeeee; font-weight: bold;'>Name</td>
                <td style='border: 1px solid #eeeeee;'>" . htmlspecialchars($name) . "</td>
            </tr>
            <tr>
                <td style='border: 1px solid #eeeeee; font-weight: bold;'>Email</td>
                <td style='border: 1px solid #eeeeee;'><a href='mailto:" . htmlspecialchars($email) . "'>" . htmlspecialchars($email) . "</a></td>
            </tr>
            <tr style='background-color: #f9f9f9;'>
                <td style='border: 1px solid #eeeeee; font-weight: bold;'>Phone</td>
                <td style='border: 1px solid #eeeeee;'>" . htmlspecialchars($contact) . "</td>
            </tr>
            <tr>
                <td style='border: 1px solid #eeeeee; font-weight: bold;'>Company</td>
                <td style='border: 1px solid #eeeeee;'>" . htmlspecialchars($companyName) . "</td>
            </tr>
            <tr style='background-color: #f9f9f9;'>
                <td style='border: 1px solid #eeeeee; font-weight: bold;'>Subject</td>
                <td style='border: 1px solid #eeeeee;'>" . htmlspecialchars($subject) . "</td>
            </tr>
            <tr>
                <td style='border: 1px solid #eeeeee; font-weight: bold;'>Pincode</td>
                <td style='border: 1px solid #eeeeee;'>" . htmlspecialchars($pincode) . "</td>
            </tr>
            <tr style='background-color: #f9f9f9;'>
                <td style='border: 1px solid #eeeeee; font-weight: bold; vertical-align: top;'>Message</td>
                <td style='border: 1px solid #eeeeee; line-height: 1.5;'>" . nl2br(htmlspecialchars($message)) . "</td>
            </tr>
        </table>
        
        <p style='font-size: 12px; color: #888; margin-top: 20px;'>
            This email was sent from the automated contact system on " . date('Y-m-d H:i:s') . ".
        </p>
    </div>
";

    $adminMail = sendMail('nowtestmehere@gmail.com', 'Support Team', $adminSubject, $adminBody);

    if ($userMail['status'] === 'success' && $adminMail['status'] === 'success') {
        echo json_encode(['success' => true, 'message' => 'success']);
    } else {
        $errorMsg = ($userMail['status'] === 'error') ? $userMail['message'] : $adminMail['message'];
        echo json_encode(['success' => true, 'message' => 'Enquiry submitted, but email delivery may be delayed.']);
    }

} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error. Please try again later.']);
}
?>