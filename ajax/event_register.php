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
$firstName = htmlspecialchars(trim($_POST['first_name'] ?? ''));
$lastName = htmlspecialchars(trim($_POST['last_name'] ?? ''));
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$mobile = htmlspecialchars(trim($_POST['mobile'] ?? ''));
$eventTitle = htmlspecialchars(trim($_POST['event_title'] ?? ''));

if (empty($firstName) || empty($lastName) || !$email || empty($mobile)) {
    echo json_encode(['success' => false, 'message' => 'Please provide First Name, Last Name, Valid Email, and Mobile Number.']);
    exit;
}

// 2. Prepare Data for DB
$status = 'Active';

// 3. Database Execution
$sql = "INSERT INTO event_registrations (event_title, first_name, last_name, email, mobile, status) 
        VALUES (?, ?, ?, ?, ?, ?)";
// $params = [$eventTitle, $firstName, $lastName, $email, $mobile, $status];

global $db;
try {
    $stmt = $db->prepare($sql);
    $result = $stmt->execute([$eventTitle, $firstName, $lastName, $email, $mobile, $status]);

    if ($result) {

        // --- EMAIL 1: User Confirmation ---
        $userSubject = "Registration Confirmation: " . $eventTitle;
        $userBody = "
        <p>Dear " . htmlspecialchars($firstName) . " " . htmlspecialchars($lastName) . ",</p>
        <p>Thank you for registering for the event: <strong>" . htmlspecialchars($eventTitle) . "</strong>.</p>
        <p>We have successfully received your registration details.</p>
        <p>We look forward to seeing you there.</p>
        <p>Best regards,<br>Mosil Pvt. Ltd.</p>
    ";

        $userMail = sendMail($email, $firstName . ' ' . $lastName, $userSubject, $userBody);

        // --- EMAIL 2: Admin Notification ---
        $adminSubject = 'New Event Registration Received';
        $adminBody = "
    <div style='font-family: Helvetica, Arial, sans-serif; color: #333; max-width: 600px;'>
        <h2 style='color: #1A3B1B; border-bottom: 2px solid #1A3B1B; padding-bottom: 10px;'>New Event Registration</h2>
        <p>A new user has registered for an event.</p>
        
        <table width='100%' cellpadding='10' cellspacing='0' style='border: 1px solid #eeeeee; border-collapse: collapse;'>
            <tr style='background-color: #f9f9f9;'>
                <td width='30%' style='border: 1px solid #eeeeee; font-weight: bold;'>Event</td>
                <td style='border: 1px solid #eeeeee;'>" . htmlspecialchars($eventTitle) . "</td>
            </tr>
            <tr>
                <td style='border: 1px solid #eeeeee; font-weight: bold;'>Name</td>
                <td style='border: 1px solid #eeeeee;'>" . htmlspecialchars($firstName) . " " . htmlspecialchars($lastName) . "</td>
            </tr>
            <tr style='background-color: #f9f9f9;'>
                <td style='border: 1px solid #eeeeee; font-weight: bold;'>Email</td>
                <td style='border: 1px solid #eeeeee;'><a href='mailto:" . htmlspecialchars($email) . "'>" . htmlspecialchars($email) . "</a></td>
            </tr>
            <tr>
                <td style='border: 1px solid #eeeeee; font-weight: bold;'>Mobile</td>
                <td style='border: 1px solid #eeeeee;'>" . htmlspecialchars($mobile) . "</td>
            </tr>
        </table>
        
        <p style='font-size: 12px; color: #888; margin-top: 20px;'>
            This email was sent from the automated event registration system on " . date('Y-m-d H:i:s') . ".
        </p>
    </div>
";

        $adminMail = sendMail('nowtestmehere@gmail.com', 'Events Team', $adminSubject, $adminBody);

        if ($userMail['status'] === 'success' && $adminMail['status'] === 'success') {
            echo json_encode(['success' => true, 'message' => 'success']);
        } else {
            $errorMsg = ($userMail['status'] === 'error') ? $userMail['message'] : $adminMail['message'];
            echo json_encode(['success' => true, 'message' => 'Registration submitted, but email delivery may be delayed.']);
        }

    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error. Please try again later.']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'DB Exception: ' . $e->getMessage()]);
}
?>