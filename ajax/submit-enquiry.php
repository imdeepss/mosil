<?php
header('Content-Type: application/json');

require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

require '../php_mailer/src/PHPMailer.php';
require '../php_mailer/src/SMTP.php';
require '../php_mailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
    $mail = new PHPMailer(true);
    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'website.mosil@gmail.com';
        $mail->Password = 'efnn wrix irnt czpt';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('website.mosil@gmail.com', 'Mosil Lubricants');
        $mail->isHTML(true);

        // --- EMAIL 1: User Confirmation ---
        $mail->addAddress($email, $fullName);
        $mail->Subject = "Enquiry Received: $subject";
        $mail->Body = "
            <div style='font-family: Arial, sans-serif; color: #333;'>
                <p>Dear <strong>$fullName</strong>,</p>
                <p>Thank you for reaching out to Mosil. We have successfully received your enquiry regarding <strong>$subject</strong>.</p>
                <p>Our technical team will review your requirements and get back to you shortly.</p>
                <hr style='border:none; border-top:1px solid #eee;'>
                <p style='font-size: 12px; color: #777;'>Best Regards,<br><strong>Mosil Lubricants</strong></p>
            </div>";
        $mail->send();

        // --- EMAIL 2: Admin Notification ---
        $mail->clearAllRecipients(); // Safety first: clear user info before admin send
        $mail->addAddress('imdeepsv@gmail.com', 'Mosil Support');
        $mail->Subject = "New Website Enquiry - $fullName";
        $mail->Body = "
            <h2 style='color: #1A3B1B;'>New Lead Details</h2>
            <table cellpadding='5' cellspacing='0' style='width: 100%; border: 1px solid #eee;'>
                <tr style='background: #f9f9f9;'><td><strong>Name:</strong></td><td>$fullName</td></tr>
                <tr><td><strong>Email:</strong></td><td>$email</td></tr>
                <tr style='background: #f9f9f9;'><td><strong>Phone:</strong></td><td>$contact</td></tr>
                <tr><td><strong>Company:</strong></td><td>$companyName</td></tr>
                <tr style='background: #f9f9f9;'><td><strong>Location:</strong></td><td>$city, $country ($pincode)</td></tr>
                <tr><td><strong>Industry:</strong></td><td>$industry</td></tr>
            </table>
            <p><strong>Message:</strong><br>" . nl2br($dbMessage) . "</p>";
        $mail->send();

        echo json_encode(['success' => true, 'message' => 'Thank you! Your enquiry has been submitted and a confirmation email has been sent.']);

    } catch (Exception $e) {
        error_log("PHPMailer Error: " . $mail->ErrorInfo);
        // Important: Still return success:true because the data WAS saved in the database
        echo json_encode(['success' => true, 'message' => 'Enquiry submitted successfully. (Email notification failed, but our team will reach out shortly.)']);
    }
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error. Please try again later.']);
}