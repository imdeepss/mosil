<?php
// Start session
session_start();

// Include configuration and functions
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if session has timed out
$timeout = isSessionTimedOut();

// Return JSON response
header('Content-Type: application/json');
echo json_encode(['timeout' => $timeout]);
?>
