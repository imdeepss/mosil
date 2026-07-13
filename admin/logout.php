<?php
// Start session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Clear remember me cookie
if (isset($_COOKIE['admin_remember'])) {
    setcookie('admin_remember', '', time() - 3600, '/');
}

// Redirect to login page
header("Location: login");
exit;
