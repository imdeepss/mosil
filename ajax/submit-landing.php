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
$componentManufactured = htmlspecialchars(trim($_POST['component_manufactured'] ?? ''));
$message = htmlspecialchars(trim($_POST['message'] ?? ''));
$pincode = htmlspecialchars(trim($_POST['pincode'] ?? ''));

$landingSlug = htmlspecialchars(trim($_POST['landing_slug'] ?? ''));
$landingTitle = htmlspecialchars(trim($_POST['landing_title'] ?? 'Generic Landing Page'));
$customEmailTo = htmlspecialchars(trim($_POST['email_to'] ?? ''));

if (empty($name) || !$email || empty($contact) || empty($companyName) || empty($componentManufactured) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Please provide all required fields: Name, Email, Contact Number, Company, Component Manufactured, and Message.']);
    exit;
}

// Prepend Component Manufactured details to the database message field
$fullMessage = "Component Manufactured: " . $componentManufactured . "\n\n" . $message;

// 2. Prepare Data for Database
$subject = "Landing Page Inquiry: " . $landingTitle . " (/" . $landingSlug . ")";
$status = 'New';

// 3. Database Execution
$sql = "INSERT INTO contact_enquiry (name, email, contact, company_name, subject, pincode, message, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$params = [$name, $email, $contact, $companyName, $subject, $pincode, $fullMessage, $status];

if (db_execute($sql, $params)) {

    // --- SALESFORCE INTEGRATION ---
    $nameParts = explode(' ', trim($name), 2);
    $firstName = isset($nameParts[1]) ? $nameParts[0] : '';
    $lastName = isset($nameParts[1]) ? $nameParts[1] : $nameParts[0];

    sendToSalesforce([
        'FirstName' => $firstName,
        'LastName' => $lastName,
        'Company' => $companyName,
        'Email' => $email,
        'Phone' => $contact,
        'Description' => "Subject: " . $subject . "\nMessage: " . $fullMessage,
        'LeadSource' => 'Landing Page Enquiry',
        'PostalCode' => $pincode
    ]);

    // --- EMAIL 1: User Confirmation ---
    $userSubject = "Thank you for contacting Mosil Lubricants";
    $userBody = "
        <div style='font-family: Helvetica, Arial, sans-serif; color: #333; max-width: 600px; line-height: 1.6;'>
            <p>Dear " . htmlspecialchars($name) . ",</p>
            <p>Thank you for reaching out to us via our landing page: <strong>" . htmlspecialchars($landingTitle) . "</strong>.</p>
            <p>We have received your request and our technical team will review your requirements and get back to you shortly.</p>
            <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
            <p style='font-size: 12px; color: #777;'>
                Best Regards,<br><br>
                <strong>MOSIL Lubricants Private Limited</strong><br>
                Mumbai, India<br>
                <a href='mailto:enquiry@mosil.com' style='color: #1A3B1B;'>enquiry@mosil.com</a>
            </p>
        </div>
    ";

    sendMail($email, $name, $userSubject, $userBody);

    // --- EMAIL 2: Admin Notification ---
    $adminRecipient = (!empty($customEmailTo) && filter_var($customEmailTo, FILTER_VALIDATE_EMAIL)) ? $customEmailTo : ADMIN_EMAIL;
    $adminSubject = "[Landing Page] New Lead from /" . $landingSlug . " - " . $name;
    $adminBody = "
    <div style='font-family: Helvetica, Arial, sans-serif; color: #333; max-width: 600px;'>
        <h2 style='color: #1A3B1B; border-bottom: 2px solid #1A3B1B; padding-bottom: 10px;'>New Landing Page Lead</h2>
        <p>A new enquiry was submitted from the landing page: <strong>" . htmlspecialchars($landingTitle) . "</strong>.</p>
        
        <table width='100%' cellpadding='10' cellspacing='0' style='border: 1px solid #eeeeee; border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;'>
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
                <td style='border: 1px solid #eeeeee; font-weight: bold;'>Component Manufactured</td>
                <td style='border: 1px solid #eeeeee;'>" . htmlspecialchars($componentManufactured) . "</td>
            </tr>
            <tr>
                <td style='border: 1px solid #eeeeee; font-weight: bold;'>Landing Page</td>
                <td style='border: 1px solid #eeeeee;'>" . htmlspecialchars($landingTitle) . " (/" . htmlspecialchars($landingSlug) . ")</td>
            </tr>
            <?php if (!empty($pincode)): ?>
            <tr>
                <td style='border: 1px solid #eeeeee; font-weight: bold;'>Pin Code</td>
                <td style='border: 1px solid #eeeeee;'>" . htmlspecialchars($pincode) . "</td>
            </tr>
            <?php endif; ?>
            <tr style='background-color: #f9f9f9;'>
                <td style='border: 1px solid #eeeeee; font-weight: bold; vertical-align: top;'>Message</td>
                <td style='border: 1px solid #eeeeee;'>" . nl2br(htmlspecialchars($message)) . "</td>
            </tr>
        </table>
        <p style='margin-top: 20px; font-size: 11px; color: #999;'>Submitted on: " . date('Y-m-d H:i:s') . "</p>
    </div>
    ";

    sendMail($adminRecipient, 'Admin Team', $adminSubject, $adminBody);

    echo json_encode(['success' => true, 'message' => 'Your enquiry has been successfully submitted.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to save enquiry. Please try again later.']);
}
