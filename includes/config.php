<?php
// Load .env file (using a simple INI parser without external dependencies)
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $envVars = parse_ini_file($envFile);
    if ($envVars) {
        foreach ($envVars as $key => $value) {
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}

// Function to get env value with fallback
function env($key, $default = null)
{
    if (isset($_ENV[$key]))
        return $_ENV[$key];
    $val = getenv($key);
    return $val !== false ? $val : $default;
}

// Environment
define('APP_ENV', env('APP_ENV', 'production'));
define('APP_DEBUG', env('APP_DEBUG', false));

// Site Configuration
define('SITE_NAME', env('SITE_NAME', 'MOSIL Lubricants'));
define('SITE_URL', env('SITE_URL', 'http://localhost/mosil-new'));
define('BASE_URL', SITE_URL . '/');
define('HOME_URL', BASE_URL);

// Email Configuration
define('ADMIN_EMAIL', env('ADMIN_EMAIL', 'enquiry@mosil.com'));
define('CAREER_EMAIL', env('CAREER_EMAIL', 'resume@mosil.com'));

// Database Configuration
define('DB_HOST', env('DB_HOST', 'localhost'));
define('DB_USER', env('DB_USER', 'root'));
define('DB_PASS', env('DB_PASS', ''));
define('DB_NAME', env('DB_NAME', 'u698941191_mosil'));

// Error Reporting
if (APP_DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

// Session Configuration
define('SESSION_TIMEOUT', 1800); // 30 minutes

// Database Connection
require_once 'db.php';
?>