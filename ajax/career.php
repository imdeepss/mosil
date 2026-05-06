<?php
header('Content-Type: application/json');

// Error reporting for debugging - Turn off in production
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

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
$status = "Active";

// Check for required fields
if (!$name || !$position || !$email || !$mobile || !$city || !$pincode) {
    echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
    exit;
}

// 2. Handle Resume Upload
$resume_path = '';
$resume_full_path = '';
$original_file_name = '';

if (isset($_FILES['resume'])) {
    // Handle specific upload errors
    if ($_FILES['resume']['error'] !== UPLOAD_ERR_OK) {
        $uploadErrors = [
            UPLOAD_ERR_INI_SIZE => 'File size exceeds the server limit.',
            UPLOAD_ERR_FORM_SIZE => 'File size exceeds the form limit.',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded.',
            UPLOAD_ERR_NO_FILE => 'Resume upload is required.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
        ];
        $error_message = $uploadErrors[$_FILES['resume']['error']] ?? 'Unknown upload error.';
        echo json_encode(['status' => 'error', 'message' => $error_message]);
        exit;
    }

    $uploadDir = '../assets/uploads/resumes/';
    // Ensure directory exists securely
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) { // 0755 is more secure than 0777
            error_log("Failed to create directory: " . $uploadDir);
            echo json_encode(['status' => 'error', 'message' => 'Server error: Upload directory creation failed.']);
            exit;
        }
    }

    $fileTmp = $_FILES['resume']['tmp_name'];
    // Prevent path traversal issues by strictly getting the basename
    $original_file_name = basename($_FILES['resume']['name']);
    $fileExt = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));

    // a. Strict extension check
    $allowed_extensions = ['pdf', 'doc', 'docx'];
    if (!in_array($fileExt, $allowed_extensions)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file extension. Only PDF, DOC, and DOCX are allowed.']);
        exit;
    }

    // b. Verify file content (MIME type check)
    $allowed_mimes = [
        'application/pdf',
        'application/x-pdf',
        'application/msword',
        'application/vnd.ms-office',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/zip', // DOCX is often detected as ZIP
        'application/x-zip-compressed'
    ];

    $mime_type = false;
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $fileTmp);
        finfo_close($finfo);
    } elseif (function_exists('mime_content_type')) {
        $mime_type = mime_content_type($fileTmp);
    }

    if ($mime_type && !in_array($mime_type, $allowed_mimes)) {
        error_log("Upload failed: Mime type mismatch for {$original_file_name}. Detected MIME: {$mime_type}");
        echo json_encode(['status' => 'error', 'message' => 'Invalid file content. Please upload a genuine PDF or Word document.']);
        exit;
    }

    // c. 5MB Limit
    if ($_FILES['resume']['size'] > 5 * 1024 * 1024) {
        echo json_encode(['status' => 'error', 'message' => 'File size exceeds 5MB limit.']);
        exit;
    }

    // Generate secure unique filename
    $newFileName = uniqid('resume_', true) . '.' . $fileExt;
    $destination = $uploadDir . $newFileName;

    // Web Path for DB
    $webPath = '/uploads/resumes/' . $newFileName;

    if (!move_uploaded_file($fileTmp, $destination)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file.']);
        exit;
    }

    $resume_path = $webPath;
    $resume_full_path = realpath($destination);
} else {
    // Resume is mandatory
    echo json_encode(['status' => 'error', 'message' => 'Resume upload is required.']);
    exit;
}

// 3. Insert into Database
$sql = "INSERT INTO career_enquiry (name, position, email, mobile, city, pincode, resume, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$params = [$name, $position, $email, $mobile, $city, $pincode, $resume_path, $status];

if (db_execute($sql, $params)) {

    // --- EMAIL 1: User Confirmation ---
    $userSubject = 'Application Received: ' . $position . ' - Mosil Lubricants';
    $userBody = "
        <p style='font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #333;'>Dear $name,</p>
        <p style='font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #333;'>Thank you for applying for the position of <strong>$position</strong>.</p>
        <p style='font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #333;'>We have received your application and will get back to you if shortlisted.</p>
        <p style='font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #333;'>Best regards,<br>Mosil Pvt. Ltd.</p>
    ";

    $userMail = sendMail($email, $name, $userSubject, $userBody);

    // --- EMAIL 2: Admin Notification ---
    $adminSubject = '[Career] New Application: ' . $position . ' - ' . $name;
    $adminBody = "
        <h2 style='font-family: Helvetica, Arial, sans-serif; font-size: 18px; color: #333;'>New Application Details</h2>
        <table style='border-collapse: collapse; width: 100%; max-width: 600px; font-family: Helvetica, Arial, sans-serif; font-size: 14px;'>
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
            <tr>
                <td style='border: 1px solid #ddd; padding: 8px;'>Status</td>
                <td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($status) . "</td>
            </tr>
        </table>
        <p style='font-family: Helvetica, Arial, sans-serif; font-size: 14px; margin-top: 20px; color: #333;'>Please find the applicant's resume attached.</p>
    ";

    $attachments = [];
    if (!empty($resume_full_path) && file_exists($resume_full_path)) {
        // Pass attachment as [path => name] or just [path]
        // sendMail supports path => name key-value pair.
        $attachments[$resume_full_path] = $original_file_name;
    }

    $adminMail = sendMail('resume@mosil.com', 'Recruitment Team', $adminSubject, $adminBody, $attachments);

    if ($userMail['status'] === 'success' && $adminMail['status'] === 'success') {
        echo json_encode(['status' => 'success', 'message' => 'Application submitted successfully.']);
    } else {
        // Report error from either mail Attempt
        $errorMsg = ($userMail['status'] === 'error') ? $userMail['message'] : $adminMail['message'];
        echo json_encode(['status' => 'success', 'message' => 'Application saved, but email notification system encountered an issue: ' . $errorMsg]);
    }

} else {
    // DB Insert failed
    if (file_exists($resume_full_path)) {
        unlink($resume_full_path); // Delete uploaded file if DB insert fails
    }
    echo json_encode(['status' => 'error', 'message' => 'Database error: Could not save application.']);
}
?>