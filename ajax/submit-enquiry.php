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
$fullName = trim("$firstName $lastName");
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$contact = htmlspecialchars(trim($_POST['contact'] ?? ''));
$companyName = htmlspecialchars(trim($_POST['company_name'] ?? ''));
$pincode = htmlspecialchars(trim($_POST['pincode'] ?? ''));
$message = htmlspecialchars(trim($_POST['message'] ?? ''));
$subject = htmlspecialchars(trim($_POST['subject'] ?? 'Product Enquiry'));
$city = htmlspecialchars(trim($_POST['city'] ?? ''));
$country = htmlspecialchars(trim($_POST['country'] ?? ''));
$industry = htmlspecialchars(trim($_POST['industry'] ?? ''));

if (empty($fullName) || !$email || empty($contact)) {
    echo json_encode(['success' => false, 'message' => 'Please provide a valid Name, Email, and Contact Number.']);
    exit;
}

// 2. Format Message Body for DB
$extraDetails = [];
if ($city)
    $extraDetails[] = "City: $city";
if ($country)
    $extraDetails[] = "Country: $country";
if ($industry)
    $extraDetails[] = "Industry: $industry";

$dbMessage = $message;
if (!empty($extraDetails)) {
    $dbMessage .= "\n\n--- Location & Industry Details ---\n" . implode("\n", $extraDetails);
}

// 3. Database Execution
$sql = "INSERT INTO contact_enquiry (name, email, contact, company_name, subject, pincode, message, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, 'New')";
$params = [$fullName, $email, $contact, $companyName, $subject, $pincode, $dbMessage];

if (db_execute($sql, $params)) {

    // --- EMAIL 1: User Confirmation ---
    $userSubject = "Enquiry Received: $subject";
    $userBody = "
        <div style='font-family: Arial, sans-serif; color: #333;'>
            <p>Dear <strong>$fullName</strong>,</p>
            <p>Thank you for reaching out to Mosil. We have successfully received your enquiry regarding <strong>$subject</strong>.</p>
            <p>Our technical team will review your requirements and get back to you shortly.</p>
            <hr style='border:none; border-top:1px solid #eee;'>
            <p style='font-size: 12px; color: #777;'>Best Regards,<br><strong>Mosil Lubricants</strong></p>
        </div>";

    $userMail = sendMail($email, $fullName, $userSubject, $userBody);

    // --- EMAIL 2: Admin Notification ---
    $adminSubject = "New Website Enquiry - $fullName";
    $adminBody = "
        <h2 style='color: #1A3B1B;'>New Lead Details</h2>
        <table cellpadding='5' cellspacing='0' style='width: 100%; border: 1px solid #eee;'>
            <tr style='background: #f9f9f9;'><td><strong>Name:</strong></td><td>$fullName</td></tr>
            <tr><td><strong>Email:</strong></td><td>$email</td></tr>
            <tr style='background: #f9f9f9;'><td><strong>Phone:</strong></td><td>$contact</td></tr>
            <tr><td><strong>Company:</strong></td><td>$companyName</td></tr>
            <tr style='background: #f9f9f9;'><td><strong>Location:</strong></td><td>$city, $country ($pincode)</td></tr>
            <tr><td><strong>Industry:</strong></td><td>$industry</td></tr>
            <tr><td><strong>Message:</strong></td><td>" . nl2br($dbMessage) . "</td></tr>
        </table>";

    $adminMail = sendMail('imdeepsv@gmail.com', 'Mosil Support', $adminSubject, $adminBody);

    if ($userMail['status'] === 'success' && $adminMail['status'] === 'success') {
        echo json_encode(['success' => true, 'message' => 'Thank you! Your enquiry has been submitted and a confirmation email has been sent.']);
    } else {
        // Report error from either mail Attempt
        $errorMsg = ($userMail['status'] === 'error') ? $userMail['message'] : $adminMail['message'];
        echo json_encode(['success' => true, 'message' => 'Enquiry submitted successfully. Error: ' . $errorMsg]);
    }

} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error. Please try again later.']);
}
?>