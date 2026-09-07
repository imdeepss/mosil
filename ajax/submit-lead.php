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

// 1. Allowed Lead Sources
$allowed_sources = [
    'DM - LinkedIN',
    'DM - Paid Leads',
    'DM - TDS',
    'DM - Website Enquiry',
    'Exhibitions',
    'Telephonic',
    'DM - Email Marketing',
    'Lead Generation - Outbound',
    'WhatsApp'
];

// 2. Sanitize & Validate Inputs
// Executive / Submitter Info
$submittedBy = htmlspecialchars(trim($_POST['submitted_by'] ?? 'Sales Executive'));
$submitterRole = htmlspecialchars(trim($_POST['submitter_role'] ?? 'Representative'));

// Prospect / Lead Details
$name = htmlspecialchars(trim($_POST['name'] ?? ''));
$designation = htmlspecialchars(trim($_POST['designation'] ?? ''));
$companyName = htmlspecialchars(trim($_POST['company_name'] ?? ''));
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$contact = htmlspecialchars(trim($_POST['contact'] ?? ''));
$pincode = htmlspecialchars(trim($_POST['pincode'] ?? ''));
$source = htmlspecialchars(trim($_POST['source'] ?? 'DM - Website Enquiry'));
$subject = htmlspecialchars(trim($_POST['subject'] ?? 'Product / Technical Lead Enquiry'));
$message = htmlspecialchars(trim($_POST['message'] ?? ''));

// Validate valid source (fallback if not in list)
if (!in_array($source, $allowed_sources)) {
    $source = 'DM - Website Enquiry';
}

if (empty($name) || empty($companyName) || !$email || empty($contact) || empty($pincode) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields accurately.']);
    exit;
}

// 3. Prepare full message with metadata for database storage
$fullMessage = "Logged By: " . $submittedBy . " (" . $submitterRole . ")\n"
             . (!empty($designation) ? "Designation: " . $designation . "\n" : "")
             . "Source: " . $source . "\n\n"
             . "Requirement Details:\n" . $message;
$status = 'Active';

// 4. Save to Database
$sql = "INSERT INTO contact_enquiry (name, email, contact, company_name, subject, pincode, message, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$params = [$name, $email, $contact, $companyName, $subject, $pincode, $fullMessage, $status];

$dbSaved = db_execute($sql, $params);

if ($dbSaved) {
    // 5. Split Name into First & Last Name for Salesforce
    $nameParts = explode(' ', trim($name), 2);
    $firstName = isset($nameParts[1]) ? $nameParts[0] : '';
    $lastName = isset($nameParts[1]) ? $nameParts[1] : $nameParts[0];

    // Format Salesforce Description
    $sfDescription = "Logged By: " . $submittedBy . " (" . $submitterRole . ")\n"
                   . "Lead Source: " . $source . "\n"
                   . "Designation: " . $designation . "\n"
                   . "Subject: " . $subject . "\n\n"
                   . "Requirement / Notes:\n" . $message;

    // 6. Send Lead to Salesforce
    $sfPayload = [
        'FirstName' => $firstName,
        'LastName' => $lastName,
        'Title' => $designation,
        'Designation__c' => $designation,
        'Company' => $companyName,
        'Email' => $email,
        'Phone' => $contact,
        'MobilePhone' => $contact,
        'LeadSource' => $source,
        'PostalCode' => $pincode,
        'Description' => $sfDescription,
        'Status' => 'New'
    ];

    $sfResult = sendToSalesforce($sfPayload);

    // 7. Audit Logging for Tracking
    $logDir = __DIR__ . '/../data/logs';
    if (!is_dir($logDir)) {
        @mkdir($logDir, 0755, true);
    }
    $logFile = $logDir . '/salesforce_leads.log';
    $logData = [
        'timestamp' => date('Y-m-d H:i:s'),
        'submitted_by' => $submittedBy,
        'submitter_role' => $submitterRole,
        'lead_name' => $name,
        'lead_designation' => $designation,
        'company' => $companyName,
        'email' => $email,
        'phone' => $contact,
        'pincode' => $pincode,
        'source' => $source,
        'subject' => $subject,
        'salesforce_status' => $sfResult['status'] ?? 'unknown',
        'salesforce_message' => $sfResult['message'] ?? 'N/A',
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
    ];
    @file_put_contents($logFile, json_encode($logData) . PHP_EOL, FILE_APPEND);

    // 8. User Confirmation Email
    $userEmailSubject = "Thank you for connecting with MOSIL Lubricants";
    $userEmailBody = "
        <div style='font-family: Helvetica, Arial, sans-serif; color: #333; max-width: 600px; line-height: 1.6; border: 1px solid #eaeaea; border-radius: 8px; overflow: hidden;'>
            <div style='background: #1A3B1B; padding: 20px; text-align: center;'>
                <h1 style='color: #F4C300; margin: 0; font-size: 24px; font-weight: 700;'>MOSIL Lubricants</h1>
            </div>
            <div style='padding: 24px;'>
                <p>Dear <strong>" . htmlspecialchars($name) . "</strong>,</p>
                <p>Thank you for reaching out to us. We have successfully received your enquiry regarding <strong>" . htmlspecialchars($subject) . "</strong>.</p>
                <div style='background: #f9f9f9; padding: 15px; border-left: 4px solid #1A3B1B; border-radius: 4px; margin: 15px 0;'>
                    <p style='margin: 0 0 5px;'><strong>Designation:</strong> " . htmlspecialchars($designation) . "</p>
                    <p style='margin: 0 0 5px;'><strong>Company:</strong> " . htmlspecialchars($companyName) . "</p>
                    <p style='margin: 0;'><strong>Requirement:</strong> " . nl2br(htmlspecialchars($message)) . "</p>
                </div>
                <p>Our dedicated technical and application team will review your requirements and get in touch with you shortly.</p>
                <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                <p style='font-size: 13px; color: #666;'>
                    Best Regards,<br>
                    <strong>MOSIL Lubricants Pvt. Ltd.</strong><br>
                    Website: <a href='" . SITE_URL . "' style='color: #1A3B1B;'>www.mosil.com</a> | Email: enquiry@mosil.com
                </p>
            </div>
        </div>
    ";
    sendMail($email, $name, $userEmailSubject, $userEmailBody);

    // 9. Admin / Salesforce Notification Email
    $adminEmailSubject = "[Salesforce Lead - " . $source . "] " . $name . " (" . $companyName . ") - Logged by " . $submittedBy;
    $adminEmailBody = "
        <div style='font-family: Helvetica, Arial, sans-serif; color: #333; max-width: 650px; line-height: 1.5;'>
            <h2 style='color: #1A3B1B; border-bottom: 2px solid #1A3B1B; padding-bottom: 8px;'>New Salesforce Lead Submitted</h2>
            
            <h4 style='color: #555; margin-bottom: 6px; text-transform: uppercase;'>1. Submitter Details</h4>
            <table width='100%' cellpadding='8' cellspacing='0' style='border: 1px solid #e0e0e0; border-collapse: collapse; font-family: Helvetica, Arial, sans-serif; margin-bottom: 20px;'>
                <tr style='background-color: #f9f9f9;'>
                    <td width='30%' style='border: 1px solid #e0e0e0; font-weight: bold;'>Logged By (Name)</td>
                    <td style='border: 1px solid #e0e0e0;'>" . htmlspecialchars($submittedBy) . "</td>
                </tr>
                <tr>
                    <td style='border: 1px solid #e0e0e0; font-weight: bold;'>Submitter Role</td>
                    <td style='border: 1px solid #e0e0e0;'>" . htmlspecialchars($submitterRole) . "</td>
                </tr>
                <tr style='background-color: #FEF9E6;'>
                    <td style='border: 1px solid #e0e0e0; font-weight: bold; color: #1A3B1B;'>Lead Source</td>
                    <td style='border: 1px solid #e0e0e0; font-weight: bold; color: #1A3B1B;'>" . htmlspecialchars($source) . "</td>
                </tr>
            </table>

            <h4 style='color: #555; margin-bottom: 6px; text-transform: uppercase;'>2. Prospect / Customer Details</h4>
            <table width='100%' cellpadding='8' cellspacing='0' style='border: 1px solid #e0e0e0; border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;'>
                <tr style='background-color: #f5f5f5;'>
                    <td width='30%' style='border: 1px solid #e0e0e0; font-weight: bold;'>Lead / Customer Name</td>
                    <td style='border: 1px solid #e0e0e0;'>" . htmlspecialchars($name) . "</td>
                </tr>
                <tr>
                    <td style='border: 1px solid #e0e0e0; font-weight: bold;'>Designation / Title</td>
                    <td style='border: 1px solid #e0e0e0;'>" . htmlspecialchars($designation) . "</td>
                </tr>
                <tr style='background-color: #f5f5f5;'>
                    <td style='border: 1px solid #e0e0e0; font-weight: bold;'>Company Name</td>
                    <td style='border: 1px solid #e0e0e0;'>" . htmlspecialchars($companyName) . "</td>
                </tr>
                <tr>
                    <td style='border: 1px solid #e0e0e0; font-weight: bold;'>Email Address</td>
                    <td style='border: 1px solid #e0e0e0;'><a href='mailto:" . htmlspecialchars($email) . "'>" . htmlspecialchars($email) . "</a></td>
                </tr>
                <tr style='background-color: #f5f5f5;'>
                    <td style='border: 1px solid #e0e0e0; font-weight: bold;'>Contact Number</td>
                    <td style='border: 1px solid #e0e0e0;'><a href='tel:" . htmlspecialchars($contact) . "'>" . htmlspecialchars($contact) . "</a></td>
                </tr>
                <tr>
                    <td style='border: 1px solid #e0e0e0; font-weight: bold;'>Pin Code</td>
                    <td style='border: 1px solid #e0e0e0;'>" . htmlspecialchars($pincode) . "</td>
                </tr>
                <tr style='background-color: #f5f5f5;'>
                    <td style='border: 1px solid #e0e0e0; font-weight: bold;'>Subject</td>
                    <td style='border: 1px solid #e0e0e0;'>" . htmlspecialchars($subject) . "</td>
                </tr>
                <tr>
                    <td style='border: 1px solid #e0e0e0; font-weight: bold; vertical-align: top;'>Message / Notes</td>
                    <td style='border: 1px solid #e0e0e0;'>" . nl2br(htmlspecialchars($message)) . "</td>
                </tr>
                <tr style='background-color: #f9f9f9;'>
                    <td style='border: 1px solid #e0e0e0; font-weight: bold;'>Salesforce Sync Status</td>
                    <td style='border: 1px solid #e0e0e0; color: " . ($sfResult['status'] === 'success' ? '#1A3B1B' : '#c0392b') . ";'>" . htmlspecialchars($sfResult['status']) . " (" . htmlspecialchars($sfResult['message']) . ")</td>
                </tr>
            </table>
            <p style='font-size: 11px; color: #999; margin-top: 15px;'>Submitted on: " . date('Y-m-d H:i:s') . " from IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . "</p>
        </div>
    ";
    sendMail(ADMIN_EMAIL, 'MOSIL Sales Team', $adminEmailSubject, $adminEmailBody);

    echo json_encode([
        'success' => true,
        'message' => 'Lead has been successfully submitted and logged to Salesforce!'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Unable to submit enquiry due to a server issue. Please try again later.'
    ]);
}
