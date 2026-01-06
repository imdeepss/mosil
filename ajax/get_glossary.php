<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

try {
    if (!defined('SITE_URL')) {
        // Define SITE_URL if needed, or include config
    }

    require_once '../includes/config.php';
    require_once '../includes/db.php';
    require_once '../includes/functions.php';

    // Get parameters
    $letter = isset($_GET['letter']) ? trim($_GET['letter']) : 'A';
    $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 8;
    $offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;

    // Fetch data
    $result = getGlossary($letter, $limit, $offset);

    // Process data if needed (e.g. formatting)
    // Currently getGlossary returns raw rows.
    // We can just return it directly.

    ob_end_clean();
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'data' => $result]);

} catch (Exception $e) {
    ob_end_clean();
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>