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
$eventTitle = htmlspecialchars(trim($_POST['event_title'] ?? ''));
$fullName = htmlspecialchars(trim($_POST['full_name'] ?? ''));
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$mobile = htmlspecialchars(trim($_POST['mobile'] ?? ''));
$companyName = htmlspecialchars(trim($_POST['company_name'] ?? ''));
$jobTitle = htmlspecialchars(trim($_POST['job_title'] ?? ''));
$cityState = htmlspecialchars(trim($_POST['city_state'] ?? ''));

// Dropdowns & other fields
$industry = htmlspecialchars(trim($_POST['industry'] ?? ''));
$companySize = htmlspecialchars(trim($_POST['company_size'] ?? ''));
$relationship = htmlspecialchars(trim($_POST['relationship'] ?? ''));
$attendeesCount = htmlspecialchars(trim($_POST['attendees_count'] ?? ''));
$hearAboutSource = htmlspecialchars(trim($_POST['hear_about_source'] ?? ''));

// Multi-select (Arrays)
$areasOfInterest = isset($_POST['areas_of_interest']) ? $_POST['areas_of_interest'] : [];
if (is_array($areasOfInterest)) {
    $areasOfInterestStr = implode(', ', array_map('htmlspecialchars', $areasOfInterest));
} else {
    $areasOfInterestStr = htmlspecialchars(trim($areasOfInterest));
}

// Consent
$consentTerms = isset($_POST['consent_terms']) ? 1 : 0;
$consentUpdates = isset($_POST['consent_updates']) ? 1 : 0;

// Basic Validation
if (empty($fullName) || !$email || empty($mobile) || empty($companyName) || empty($jobTitle) || empty($cityState)) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields (Name, Email, Mobile, Company, Job Title, City/State).']);
    exit;
}

if (!$consentTerms) {
    echo json_encode(['success' => false, 'message' => 'You must agree to the Terms & Conditions and Privacy Policy.']);
    exit;
}

// 2. Prepare Data for DB
$status = 'Active';

// 3. Database Execution
$sql = "INSERT INTO event_registrations (
            event_title, full_name, email, mobile, 
            company_name, job_title, city_state, 
            industry, company_size, relationship, 
            attendees_count, areas_of_interest, hear_about_source, 
            consent_terms, consent_updates, status
        ) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

global $db;
try {
    $stmt = $db->prepare($sql);
    $result = $stmt->execute([
        $eventTitle,
        $fullName,
        $email,
        $mobile,
        $companyName,
        $jobTitle,
        $cityState,
        $industry,
        $companySize,
        $relationship,
        $attendeesCount,
        $areasOfInterestStr,
        $hearAboutSource,
        $consentTerms,
        $consentUpdates,
        $status
    ]);

    if ($result) {

        // --- EMAIL 1: User Confirmation ---
        $userSubject = "Registration Confirmed: " . $eventTitle . " - Mosil Lubricants";
        $userBody = "
        <p>Dear " . htmlspecialchars($fullName) . ",</p>
        <p>Thank you for registering for the event: <strong>" . htmlspecialchars($eventTitle) . "</strong>.</p>
        <p>We have successfully received your registration details.</p>
        <p>We look forward to seeing you there.</p>
        <p>Best regards,<br>Mosil Pvt. Ltd.</p>
    ";

        $userMail = sendMail($email, $fullName, $userSubject, $userBody);

        // --- EMAIL 2: Admin Notification ---
        $adminSubject = "[Event] New Registration: " . $eventTitle . " - " . $fullName;
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
                <td style='border: 1px solid #eeeeee;'>" . htmlspecialchars($fullName) . "</td>
            </tr>
            <tr style='background-color: #f9f9f9;'>
                <td style='border: 1px solid #eeeeee; font-weight: bold;'>Email</td>
                <td style='border: 1px solid #eeeeee;'><a href='mailto:" . htmlspecialchars($email) . "'>" . htmlspecialchars($email) . "</a></td>
            </tr>
            <tr>
                <td style='border: 1px solid #eeeeee; font-weight: bold;'>Mobile</td>
                <td style='border: 1px solid #eeeeee;'>" . htmlspecialchars($mobile) . "</td>
            </tr>
            <tr style='background-color: #f9f9f9;'>
                <td style='border: 1px solid #eeeeee; font-weight: bold;'>Company</td>
                <td style='border: 1px solid #eeeeee;'>" . htmlspecialchars($companyName) . "</td>
            </tr>
            <tr>
                <td style='border: 1px solid #eeeeee; font-weight: bold;'>Job Title</td>
                <td style='border: 1px solid #eeeeee;'>" . htmlspecialchars($jobTitle) . "</td>
            </tr>
            <tr style='background-color: #f9f9f9;'>
                <td style='border: 1px solid #eeeeee; font-weight: bold;'>City/State</td>
                <td style='border: 1px solid #eeeeee;'>" . htmlspecialchars($cityState) . "</td>
            </tr>
            <tr>
                <td style='border: 1px solid #eeeeee; font-weight: bold;'>Industry</td>
                <td style='border: 1px solid #eeeeee;'>" . htmlspecialchars($industry) . "</td>
            </tr>
             <tr style='background-color: #f9f9f9;'>
                <td style='border: 1px solid #eeeeee; font-weight: bold;'>Interest Areas</td>
                <td style='border: 1px solid #eeeeee;'>" . htmlspecialchars($areasOfInterestStr) . "</td>
            </tr>
        </table>
        
        <p style='font-size: 12px; color: #888; margin-top: 20px;'>
            This email was sent from the automated event registration system on " . date('Y-m-d H:i:s') . ".
        </p>
    </div>
";

        $adminMail = sendMail('enquiry@mosil.com', 'Events Team', $adminSubject, $adminBody);

        if ($userMail['status'] === 'success' && $adminMail['status'] === 'success') {
            echo json_encode(['success' => true, 'message' => 'success']);
        } else {
            $errorMsg = ($userMail['status'] === 'error') ? $userMail['message'] : $adminMail['message'];
            // Still consider success as DB insert worked
            echo json_encode(['success' => true, 'message' => 'success']);
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