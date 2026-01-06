<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Set header for JSON response
header('Content-Type: application/json');

try {
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

    echo json_encode(['status' => 'success', 'data' => $result]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>