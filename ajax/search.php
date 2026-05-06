<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

// Secure CORS Implementation
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
$allowed_domains = ['mosil.com', 'www.mosil.com', 'localhost', '127.0.0.1'];

if ($origin) {
    $parsed_url = parse_url($origin);
    if (isset($parsed_url['host']) && in_array($parsed_url['host'], $allowed_domains)) {
        header('Access-Control-Allow-Origin: ' . $origin);
        header('Access-Control-Allow-Methods: GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        header('Vary: Origin'); // Important for proxy caching
    }
}

// Handle preflight requests gracefully
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

// Return empty array if query is too short
if (strlen($q) < 2) {
    echo json_encode([]);
    exit;
}

$results = searchProducts($q);

// Enhance results with URL and ensuring required fields
$finalResults = [];
foreach ($results as $row) {
    $slug = isset($row['slug']) ? $row['slug'] : '';
    $name = isset($row['name']) ? $row['name'] : '';

    if ($slug && $name) {
        $finalResults[] = [
            'name' => $name,
            'slug' => $slug,
            'url' => SITE_URL . '/product-finder/all/' . $slug
        ];
    }
}

echo json_encode($finalResults);
exit;
?>