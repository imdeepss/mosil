<?php
// Start output buffering to capture any unwanted output
ob_start();

// Set error reporting to log but not display
error_reporting(E_ALL);
ini_set('display_errors', 0);

try {
    if (!defined('SITE_URL')) {
        // logic to define or skip
    }

    require_once '../includes/config.php';
    require_once '../includes/db.php';
    require_once '../includes/functions.php';

    // Get parameters from GET request
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 6;
    $category = isset($_GET['category']) ? trim($_GET['category']) : 'All';

    // Fetch data
    $result = getCaseStudiesWithPagination($page, $limit, $category);

    // Process case studies to clean content and format dates
    foreach ($result['caseStudies'] as &$study) {
        // Clean content for preview (introduction)
        $intro = trim(preg_replace('/\s+/', ' ', strip_tags($study['introduction'])));
        $study['excerpt'] = mb_strlen($intro) > 150 ? substr($intro, 0, 150) . '...' : $intro;

        // Format date
        $study['formatted_date'] = date('F d, Y', strtotime($study['created_at']));

        // Add full image URL
        $study['image_url'] = SITE_URL . '/assets/uploads/case_studies/' . $study['image'];

        // Add detail link
        $study['link'] = SITE_URL . '/case-studies/' . urlencode($study['slug']);
    }

    // Clear buffer before outputting JSON
    ob_end_clean();
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'data' => $result]);

} catch (Exception $e) {
    // Clear buffer before outputting error JSON
    ob_end_clean();
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>