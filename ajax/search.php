<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

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