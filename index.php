<?php


require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';



// Simple Router
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Whitelist of allowed pages (Security)
$allowed_pages = [
    'home',
    'about',
    'quadra-approach',
    'mosils-advantages',
    'product-finder',
    'product-listing',
    'product-detail',
    'industries',
    'industry-detail',
    'newsroom',
    'news',
    'events',
    'blog',
    'case-studies',
    'beyond-business',
    'glossary',
    'faqs',
    'careers',
    'contact',
    'privacy-policy',
    'industry-category',
    'product-category',
    'blog-detail',
    'case-study-detail',
    'event-detail'
];

if (!in_array($page, $allowed_pages)) {
    $page = 'home'; // Default to home or show 404
}

// Prepare content file path
$contentFile = "pages/{$page}.php";

// Load Header
include 'includes/header.php';

// Load Content
if (file_exists($contentFile)) {
    include $contentFile;
} else {
    echo '<div class="container section-padding"><h2>Page Not Found</h2><p>The page you are looking for does not exist.</p></div>';
}

// Load Footer
include 'includes/footer.php';
?>