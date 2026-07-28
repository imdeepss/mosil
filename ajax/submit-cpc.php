<?php
header('Content-Type: application/json');

// Security & Method Validation
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

// Helper function to sanitize text input
function sanitize_input($data) {
    return htmlspecialchars(trim($data ?? ''), ENT_QUOTES, 'UTF-8');
}

// 1. Capture & Sanitize Required Contact Fields (Part B)
$fullName = sanitize_input($_POST['full_name'] ?? '');
$designation = sanitize_input($_POST['designation'] ?? '');
$function = sanitize_input($_POST['function'] ?? '');
$company = sanitize_input($_POST['company'] ?? '');
$city = sanitize_input($_POST['city'] ?? '');
$workEmail = filter_var(trim($_POST['work_email'] ?? ''), FILTER_VALIDATE_EMAIL);
$mobileNumber = sanitize_input($_POST['mobile_number'] ?? '');

// Contact Validation Checks
if (empty($fullName) || empty($designation) || empty($function) || empty($company) || empty($city) || !$workEmail || empty($mobileNumber)) {
    echo json_encode(['success' => false, 'message' => 'Please provide all required contact fields including a valid work email and mobile number.']);
    exit;
}

if (!preg_match('/^[0-9]{10}$/', $mobileNumber)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid 10-digit mobile number.']);
    exit;
}

// 2. Capture Questionnaire Answers (Parts A, C, D, E, F)
$workingOnReduction = sanitize_input($_POST['working_on_reduction'] ?? '');
$reductionRoute = sanitize_input($_POST['reduction_route'] ?? '');
$annualSpend = sanitize_input($_POST['annual_spend'] ?? '');

$q4 = sanitize_input($_POST['q4'] ?? '');
$q5 = sanitize_input($_POST['q5'] ?? '');
$q6 = sanitize_input($_POST['q6'] ?? '');
$q7 = sanitize_input($_POST['q7'] ?? '');
$q8 = sanitize_input($_POST['q8'] ?? '');
$q9 = sanitize_input($_POST['q9'] ?? '');
$q10_amount = sanitize_input($_POST['q10_amount'] ?? '');
$q10_unit = sanitize_input($_POST['q10_unit'] ?? '');

$q11 = sanitize_input($_POST['q11'] ?? '');

$q12 = sanitize_input($_POST['q12'] ?? '');
$q13 = sanitize_input($_POST['q13'] ?? '');
$q14a = sanitize_input($_POST['q14a'] ?? '');
$q14b = sanitize_input($_POST['q14b'] ?? '');
$q15 = sanitize_input($_POST['q15'] ?? '');

$q16 = sanitize_input($_POST['q16'] ?? '');
$q17 = sanitize_input($_POST['q17'] ?? '');
$q18 = sanitize_input($_POST['q18'] ?? '');
$q19 = sanitize_input($_POST['q19'] ?? '');

// Capture UTM Parameters
$utmSource = sanitize_input($_POST['utm_source'] ?? $_GET['utm_source'] ?? 'Direct/Organic');
$utmMedium = sanitize_input($_POST['utm_medium'] ?? $_GET['utm_medium'] ?? 'CPC Landing Page');
$utmCampaign = sanitize_input($_POST['utm_campaign'] ?? $_GET['utm_campaign'] ?? 'Cost Per Component');

// 3. Lead Scoring & Logic Classification
$leadScoreCategory = 'COMMERCIAL_SAVINGS';
if (in_array($function, ['Design', 'R&D']) || $q16 === 'Yes' || strpos(strtolower($workingOnReduction), 'no') !== false) {
    $leadScoreCategory = 'HIGH_VALUE_RD';
}

// Build Submission Data Structure
$submissionId = 'cpc_' . date('Ymd_His') . '_' . substr(md5(uniqid()), 0, 6);
$submissionData = [
    'submission_id' => $submissionId,
    'timestamp' => date('c'),
    'lead_score_category' => $leadScoreCategory,
    'utm_tracking' => [
        'source' => $utmSource,
        'medium' => $utmMedium,
        'campaign' => $utmCampaign
    ],
    'contact' => [
        'full_name' => $fullName,
        'designation' => $designation,
        'function' => $function,
        'company' => $company,
        'city' => $city,
        'work_email' => $workEmail,
        'mobile_number' => $mobileNumber
    ],
    'part_a_direction' => [
        'q1_working_on_reduction' => $workingOnReduction,
        'q2_reduction_route' => $reductionRoute,
        'q3_annual_spend' => $annualSpend
    ],
    'part_c_grease_cost' => [
        'q4_identified_alternate' => $q4,
        'q5_largest_budget_grease' => $q5,
        'q6_evaluate_for_cpc' => $q6,
        'q7_component_and_stage' => $q7,
        'q8_physio_chem_specs' => $q8,
        'q9_performance_specs' => $q9,
        'q10_amount_applied' => $q10_amount . ' ' . $q10_unit
    ],
    'part_d_validation' => [
        'q11_validation_preference' => $q11
    ],
    'part_e_inventory' => [
        'q12_current_lead_time' => $q12,
        'q13_stock_days' => $q13,
        'q14a_target_lead_time' => $q14a,
        'q14b_target_stock_days' => $q14b,
        'q15_imported_status' => $q15
    ],
    'part_f_design_nurture' => [
        'q16_new_components' => $q16,
        'q17_programme_details' => $q17,
        'q18_supplier_stage' => $q18,
        'q19_notes' => $q19
    ]
];

// 4. Persistence: Atomic Save to data/submissions/ Directory
$submissionsDir = __DIR__ . '/../data/submissions/';
if (!is_dir($submissionsDir)) {
    mkdir($submissionsDir, 0755, true);
}

$filePath = $submissionsDir . $submissionId . '.json';
file_put_contents($filePath, json_encode($submissionData, JSON_PRETTY_PRINT));

// 5. Email Notification to Engineering Team
$toEmail = 'cpc-engineering@mosil.com';
$emailSubject = "CPC Assessment Lead [{$leadScoreCategory}]: {$company} - {$fullName}";
$emailHeaders = "From: MOSIL Campaigns <no-reply@mosil.com>\r\n";
$emailHeaders .= "Reply-To: {$workEmail}\r\n";
$emailHeaders .= "Content-Type: text/html; charset=UTF-8\r\n";

$emailBody = "<h2>New Cost Per Component Assessment Submission</h2>";
$emailBody .= "<p><strong>Lead Score:</strong> <span style='color:#FF6B00; font-weight:bold;'>{$leadScoreCategory}</span></p>";
$emailBody .= "<h3>Contact Info:</h3><ul>";
$emailBody .= "<li><strong>Name:</strong> {$fullName} ({$designation})</li>";
$emailBody .= "<li><strong>Company:</strong> {$company} ({$city})</li>";
$emailBody .= "<li><strong>Email:</strong> {$workEmail}</li>";
$emailBody .= "<li><strong>Mobile:</strong> {$mobileNumber}</li>";
$emailBody .= "</ul>";
$emailBody .= "<h3>Key Answers:</h3>";
$emailBody .= "<p><strong>Primary Route:</strong> {$reductionRoute} | <strong>Spend:</strong> {$annualSpend}</p>";
$emailBody .= "<p><strong>Target Grease / Component:</strong> {$q5} / {$q7}</p>";
$emailBody .= "<p><strong>Validation Route:</strong> {$q11}</p>";
$emailBody .= "<hr><p><small>Saved to: {$submissionId}.json</small></p>";

@mail($toEmail, $emailSubject, $emailBody, $emailHeaders);

// 6. Return JSON Response
echo json_encode([
    'success' => true,
    'message' => 'Thank you. Your CPC diagnostic has been submitted successfully.',
    'submission_id' => $submissionId,
    'sla_working_days' => 3
]);
