<?php
header('Content-Type: application/json');

// Error reporting for debugging - Turn off in production
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

require '../php_mailer/src/PHPMailer.php';
require '../php_mailer/src/SMTP.php';
require '../php_mailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// 1. Validate Inputs
$name = cleanText($_POST['name'] ?? '');
$position = cleanText($_POST['position'] ?? '');
$email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$mobile = cleanText($_POST['mobile'] ?? '');
$city = cleanText($_POST['city'] ?? '');
$pincode = cleanText($_POST['pincode'] ?? '');
$status = "Active"; // Default status

if (!$name || !$position || !$email || !$mobile || !$city || !$pincode) {
    echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
    exit;
}

// 2. Handle Resume Upload
$resume_path = '';
$resume_full_path = '';
$original_file_name = '';

if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/resumes/';
    // Ensure directory exists
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            error_log("Failed to create directory: " . $uploadDir);
            echo json_encode(['status' => 'error', 'message' => 'Server error: Upload directory creation failed.']);
            exit;
        }
    }

    $fileTmp = $_FILES['resume']['tmp_name'];
    $original_file_name = basename($_FILES['resume']['name']);
    $fileExt = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));
    $allowed = ['pdf', 'doc', 'docx'];

    if (!in_array($fileExt, $allowed)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Only PDF, DOC, DOCX are allowed.']);
        exit;
    }

    // 5MB Limit
    if ($_FILES['resume']['size'] > 5 * 1024 * 1024) {
        echo json_encode(['status' => 'error', 'message' => 'File size exceeds 5MB.']);
        exit;
    }

    $newFileName = uniqid('resume_', true) . '.' . $fileExt;
    $destination = $uploadDir . $newFileName;

    // We store the Web Path in DB
    // Assuming 'uploads' is at root: /uploads/resumes/filename
    // But keeping consistent with user Code: '/uploads/resumes/'
    $webPath = '/uploads/resumes/' . $newFileName;

    if (!move_uploaded_file($fileTmp, $destination)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload resume file.']);
        exit;
    }

    $resume_path = $webPath;
    $resume_full_path = realpath($destination);
} else {
    // If resume is mandatory:
    echo json_encode(['status' => 'error', 'message' => 'Resume upload is required.']);
    exit;
}

// 3. Insert into Database
// Using PDO ($db from includes/db.php) via db_execute helper if available or raw PDO
// The user code used `INSERT INTO career_enquiry ...`
$sql = "INSERT INTO career_enquiry (name, position, email, mobile, city, pincode, resume, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$params = [$name, $position, $email, $mobile, $city, $pincode, $resume_path, $status];

if (db_execute($sql, $params)) {
    // 4. Send Emails via PHPMailer
    $mail = new PHPMailer(true);
    try {
        // SMTP config
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'website.mosil@gmail.com';
        $mail->Password = 'efnn wrix irnt czpt';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('website.mosil@gmail.com', 'Mosil Careers');
        $mail->isHTML(true);

        // --- 1. Send confirmation to USER (NO Attachment) ---
        $mail->clearAllRecipients();
        $mail->clearAttachments();

        $mail->addAddress($email, $name);
        $mail->Subject = 'Application Received: ' . $position . ' - Mosil';
        $mail->Body = "
            <p style='font-family: Arial, sans-serif; font-size: 14px; color: #333;'>Dear $name,</p>
            <p style='font-family: Arial, sans-serif; font-size: 14px; color: #333;'>Thank you for applying for the position of <strong>$position</strong>.</p>
            <p style='font-family: Arial, sans-serif; font-size: 14px; color: #333;'>We have received your application and will get back to you if shortlisted.</p>
            <p style='font-family: Arial, sans-serif; font-size: 14px; color: #333;'>Best regards,<br>Mosil Pvt. Ltd.</p>
        ";
        $mail->send();

        // --- 2. Send notification to HR (WITH Attachment) ---
        $mail->clearAllRecipients();
        $mail->clearAttachments();

        $mail->addAddress('nowtestmehere@gmail.com', 'Recruitment Team');

        $mail->Subject = 'New Career Application: ' . $position;
        $mail->Body = "
            <h2 style='font-family: Arial, sans-serif; font-size: 18px; color: #333;'>New Application Details</h2>
            <table style='border-collapse: collapse; width: 100%; max-width: 600px; font-family: Arial, sans-serif; font-size: 14px;'>
                <tr style='background-color: #f2f2f2;'>
                    <th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Field</th>
                    <th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Details</th>
                </tr>
                <tr>
                    <td style='border: 1px solid #ddd; padding: 8px;'>Name</td>
                    <td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($name) . "</td>
                </tr>
                <tr>
                    <td style='border: 1px solid #ddd; padding: 8px;'>Email</td>
                    <td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($email) . "</td>
                </tr>
                <tr>
                    <td style='border: 1px solid #ddd; padding: 8px;'>Phone</td>
                    <td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($mobile) . "</td>
                </tr>
                <tr>
                    <td style='border: 1px solid #ddd; padding: 8px;'>City</td>
                    <td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($city) . "</td>
                </tr>
                <tr>
                    <td style='border: 1px solid #ddd; padding: 8px;'>Pincode</td>
                    <td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($pincode) . "</td>
                </tr>
                <tr>
                    <td style='border: 1px solid #ddd; padding: 8px;'>Position</td>
                    <td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($position) . "</td>
                </tr>
            </table>
            <p style='font-family: Arial, sans-serif; font-size: 14px; margin-top: 20px; color: #333;'>Please find the applicant's resume attached.</p>
        ";

        if (!empty($resume_full_path) && file_exists($resume_full_path)) {
            $mail->addAttachment($resume_full_path, $original_file_name);
        }

        $mail->send();

        echo json_encode(['status' => 'success', 'message' => 'Application submitted successfully.']);

    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        // Even if mail fails, we saved to DB, so we can consider it a qualified success or warn user
        echo json_encode(['status' => 'success', 'message' => 'Application saved, but email notification system encountered an issue. We have your details.']);
    }

} else {
    // DB Insert failed
    if (file_exists($resume_full_path)) {
        unlink($resume_full_path); // Delete uploaded file if DB insert fails
    }
    echo json_encode(['status' => 'error', 'message' => 'Database error: Could not save application.']);
}
?>