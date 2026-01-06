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
    $result = getBlogsWithPagination($page, $limit, $category);

    // Process blogs to clean content and format dates
    foreach ($result['blogs'] as &$blog) {
        // Clean content for preview
        $plainText = trim(preg_replace('/\s+/', ' ', strip_tags($blog['content'])));
        $blog['excerpt'] = mb_substr($plainText, 0, 150) . (mb_strlen($plainText) > 150 ? '...' : '');

        // Format date
        $blog['formatted_date'] = date('F d, Y', strtotime($blog['created_at']));

        // Add full image URL
        $blog['image_url'] = SITE_URL . '/assets/uploads/blog/' . $blog['image'];

        // Add detail link
        $blog['link'] = SITE_URL . '/blog/' . urlencode($blog['slug']);
    }

    echo json_encode(['status' => 'success', 'data' => $result]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>