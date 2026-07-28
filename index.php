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
    'event-detail',
    'test',
    'disclaimer',
    'demo-ai-buttons',
    'landing'
];

// Dynamic Landing Page checking
$landingDataFile = "data/landings/{$page}.json";
$isLanding = file_exists($landingDataFile);

if (!in_array($page, $allowed_pages) && !$isLanding) {
    http_response_code(404);
    $page = '404'; // Default to show 404
}

// Prepare content file path
if ($isLanding) {
    $landingSlug = $page;
    $page = 'landing'; // Force template to use landing.php
}
$contentFile = "pages/{$page}.php";

// Load Content with output buffering
ob_start();
if (file_exists($contentFile)) {
    if ($isLanding) {
        $landingData = json_decode(file_get_contents($landingDataFile), true);
    }
    include $contentFile;
} else {
    echo '<div class="container section-padding"><h2>Page Not Found</h2><p>The page you are looking for does not exist.</p></div>';
}
$pageContent = ob_get_clean();

// Load Header
include 'includes/header.php';

// Output Content
echo '<main id="main-content" role="main">';
echo $pageContent;
echo '</main>';

// Load Footer
include 'includes/footer.php';
?>