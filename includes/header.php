<?php
// Security Headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
header("Referrer-Policy: strict-origin-when-cross-origin");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    if (!isset($canonicalUrl)) {
        $siteUrl = rtrim(SITE_URL, '/');
        $parsedSite = parse_url($siteUrl);
        $sitePath = isset($parsedSite['path']) ? rtrim($parsedSite['path'], '/') : '';
        $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (!empty($sitePath) && strpos($requestPath, $sitePath) === 0) {
            $cleanPath = substr($requestPath, strlen($sitePath));
        } else {
            $cleanPath = $requestPath;
        }

        // Remove trailing slash for consistent canonical URLs
        if ($cleanPath !== '/' && $cleanPath !== '') {
            $cleanPath = rtrim($cleanPath, '/');
        }

        $canonicalUrl = rtrim($siteUrl, '/') . $cleanPath;
    }
    ?>
    <!-- Open Graph / Social Tags -->
    <meta property="og:title" content="<?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : SITE_NAME; ?>">
    <meta property="og:description"
        content="<?php echo isset($metaDescription) ? htmlspecialchars($metaDescription) : ''; ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo SITE_NAME; ?>">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Preconnect & Resource Hints -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://www.googletagmanager.com">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="MOSIL Lubricants Pvt. Ltd.">
    <title><?php echo isset($pageTitle) ? $pageTitle : SITE_NAME; ?></title>
    <?php if (isset($page) && $page === 'home'): ?>
        <!-- Preload desktop hero image -->
        <link rel="preload" as="image" href="<?php echo SITE_URL; ?>/assets/images/banners/home-banner-poster.webp"
            media="(min-width: 768px)" fetchpriority="high">
        <!-- Preload mobile hero image -->
        <link rel="preload" as="image" href="<?php echo SITE_URL; ?>/assets/images/banners/mb-home-banner-poster.webp"
            media="(max-width: 767px)" fetchpriority="high">
    <?php endif; ?>
    <?php if (isset($metaDescription) && !empty($metaDescription)): ?>
        <meta name="description" content="<?php echo htmlspecialchars($metaDescription); ?>">
    <?php endif; ?>
    <?php if (isset($metaKeywords) && !empty($metaKeywords)): ?>
        <meta name="keywords" content="<?php echo htmlspecialchars($metaKeywords); ?>">
    <?php endif; ?>

    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>">

    <!-- Structured Data -->
    <?php if (isset($page) && $page === 'home'): ?>
        <script type="application/ld+json">
                                                                        {
                                                                          "@context": "https://schema.org",
                                                                          "@type": "Organization",
                                                                          "name": "MOSIL Lubricants Pvt. Ltd.",
                                                                          "url": "https://mosil.com",
                                                                          "logo": "https://mosil.com/logo.png",
                                                                          "description": "MOSIL Lubricants is a specialty industrial lubricant manufacturer providing greases, oils, coatings, and defence lubrication solutions.",
                                                                          "email": "enquiry@mosil.com",
                                                                          "telephone": "+91-9619234158",
                                                                          "foundingDate": "1971"
                                                                        }
                                                                        </script>
        <script type="application/ld+json">
                                                                        {
                                                                          "@context": "https://schema.org",
                                                                          "@type": "WebSite",
                                                                          "name": "MOSIL Lubricants",
                                                                          "url": "https://mosil.com",
                                                                          "potentialAction": {
                                                                            "@type": "SearchAction",
                                                                            "target": "https://mosil.com/product-finder?search={search_term_string}",
                                                                            "query-input": "required name=search_term_string"
                                                                          }
                                                                        }
                                                                        </script>
        <script type="application/ld+json">
                                                                        {
                                                                          "@context": "https://schema.org",
                                                                          "@type": "LocalBusiness",
                                                                          "name": "MOSIL Lubricants Pvt. Ltd.",
                                                                          "image": "https://mosil.com/logo.png",
                                                                          "telephone": "+91-9619234158",
                                                                          "email": "enquiry@mosil.com",
                                                                          "address": {
                                                                            "@type": "PostalAddress",
                                                                            "streetAddress": "Plot no. A-791/3, MIDC, Kopar-Khairane",
                                                                            "addressLocality": "Navi Mumbai",
                                                                            "addressRegion": "Maharashtra",
                                                                            "postalCode": "400710",
                                                                            "addressCountry": "IN"
                                                                          },
                                                                          "url": "https://mosil.com"
                                                                        }
                                                                        </script>
    <?php endif; ?>

    <!-- Favicon -->
    <link rel="icon" type="image/webp" href="<?php echo SITE_URL; ?>/assets/images/logos/mosil.webp">
    <link rel="shortcut icon" type="image/webp" href="<?php echo SITE_URL; ?>/assets/images/logos/mosil.webp">

    <!-- Core CSS -->
    <?php include 'tailwind-setup.php'; ?>

    <!-- libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/common.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/sara-modal.css?v=<?php echo time(); ?>">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-J8BDPPXN66"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'G-J8BDPPXN66');
    </script>

    <!-- Page Specific CSS -->
    <?php
    $pageCss = 'assets/css/' . $page . '.css';
    if (file_exists($pageCss)) {
        echo '<link rel="stylesheet" href="' . SITE_URL . '/' . $pageCss . '?v=' . time() . '">';
    }
    ?>
    <?php
    $sidebarNav = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Product Finder', 'url' => '/product-finder'],
        ['label' => 'Quadra Approach', 'url' => '/quadra-approach'],
        ['label' => 'About Us', 'url' => '/about'],
        [
            'label' => 'MOSIL newsroom',
            'url' => '/newsroom',
            'submenu' => [
                ['label' => 'Blog', 'url' => '/blog'],
                ['label' => 'Case Studies', 'url' => '/case-studies'],
                ['label' => 'Events', 'url' => '/events'],
                ['label' => 'Glossary', 'url' => '/glossary'],
                ['label' => 'FAQs', 'url' => '/faqs'],
            ]
        ],
        ['label' => 'Career', 'url' => '/careers'],
        ['label' => 'Contact Us', 'url' => '/contact']
    ];
    ?>


</head>

<body>

    <header class="fixed top-0 z-50 h-[60px] w-full left-0 right-0">
        <div class="absolute inset-0 w-full h-full bg-[#0e0e0e]/40 backdrop-blur-[18px] -z-10"></div>
        <div class="container flex h-full items-center justify-between">
            <div class="shrink-0">
                <a href="<?php echo SITE_URL; ?>">
                    <img src="<?php echo SITE_URL; ?>/assets/images/logos/mosil.webp" alt="MOSIL" width="95" height="44"
                        class="block">
                </a>
            </div>

            <nav class="flex items-center md:gap-8 gap-4">

                <!-- Premium Header Search Button -->
                <div class="relative hidden w-[340px] md:block group z-50">
                    <button type="button" onclick="openEvaModal()"
                        class="group relative flex items-center justify-between bg-white hover:bg-slate-50/80 rounded-full p-1.5 border border-slate-200 hover:border-primary/60 hover:shadow-[0_8px_30px_rgba(244,195,0,0.12)] transition-all duration-300 w-full text-left shadow-sm">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-9 h-9 rounded-full bg-gradient-to-tr from-primary to-primary-mid flex items-center justify-center shrink-0 border border-primary-low relative overflow-hidden shadow-sm group-hover:scale-105 transition-transform duration-300">
                                <svg class="w-6 h-6 relative z-10" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 64 64">
                                    <path d="M 8 52 C 8 46, 12 44, 18 44 L 18 64 L 8 64 Z" fill="#CBD5E1" />
                                    <path d="M 56 52 C 56 46, 52 44, 46 44 L 46 64 L 56 64 Z" fill="#CBD5E1" />
                                    <path d="M 12 56 C 12 46, 18 42, 32 42 C 46 42, 52 46, 52 56 L 52 64 L 12 64 Z"
                                        fill="#E2E8F0" />
                                    <rect x="24" y="38" width="16" height="12" fill="#94A3B8" />
                                    <path
                                        d="M 14 30 C 14 16, 18 12, 32 12 C 46 12, 50 16, 50 30 C 50 42, 46 46, 32 46 C 18 46, 14 42, 14 30 Z"
                                        fill="#F1F5F9" />
                                    <path
                                        d="M 14 30 C 14 42, 18 46, 32 46 C 46 46, 50 42, 50 30 L 50 34 C 50 46, 46 50, 32 50 C 18 50, 14 46, 14 34 Z"
                                        fill="#E2E8F0" />
                                    <path d="M 8 30 C 8 8, 20 4, 32 4 C 44 4, 56 8, 56 30" fill="none" stroke="#1E3A8A"
                                        stroke-width="5" stroke-linecap="round" />
                                    <rect x="24" y="1" width="16" height="6" rx="2" fill="#2563EB" />
                                    <rect x="4" y="24" width="8" height="18" rx="4" fill="#1E3A8A" />
                                    <rect x="52" y="24" width="8" height="18" rx="4" fill="#1E3A8A" />
                                    <rect x="6" y="26" width="8" height="14" rx="2" fill="#2563EB" />
                                    <rect x="50" y="26" width="8" height="14" rx="2" fill="#2563EB" />
                                    <path
                                        d="M 16 28 C 16 22, 18 21, 32 21 C 46 21, 48 22, 48 28 L 48 32 C 48 38, 46 39, 32 39 C 18 39, 16 38, 16 32 Z"
                                        fill="#172554" />
                                    <circle cx="25" cy="30" r="3" fill="#22D3EE" />
                                    <circle cx="39" cy="30" r="3" fill="#22D3EE" />
                                    <path d="M 54 36 L 54 48 C 54 52, 50 54, 46 54 L 40 54" fill="none" stroke="#94A3B8"
                                        stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                    <rect x="34" y="51" width="8" height="6" rx="3" fill="#1E3A8A" />
                                </svg>
                            </div>
                            <div class="flex items-baseline gap-1.5">
                                <span
                                    class="text-[11px] font-bold text-main-green/70 uppercase tracking-widest leading-none">Ask</span>
                                <span
                                    class="text-[16px] font-black text-main-green leading-none tracking-tight">SARA</span>
                            </div>
                            <div class="w-[1px] h-4 bg-slate-200 ml-1"></div>
                            <span class="ml-2 text-[14px] text-slate-400 font-normal tracking-wide">Search...</span>
                        </div>

                        <div
                            class="pr-3 text-slate-300 group-hover:text-primary group-hover:translate-x-1 transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </div>
                    </button>
                </div>
                <!-- Mobile Search Trigger -->
                <div class="relative md:hidden h-8 w-8 flex items-center justify-center cursor-pointer transition-opacity duration-300 hover:opacity-80"
                    id="openMobileSearch" onclick="openEvaModal()" aria-label="Open Ask Sara search" role="button" tabindex="0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <path
                            d="M28 28L20 20M22.6667 13.3333C22.6667 18.488 18.488 22.6667 13.3333 22.6667C8.17868 22.6667 4 18.488 4 13.3333C4 8.17868 8.17868 4 13.3333 4C18.488 4 22.6667 8.17868 22.6667 13.3333Z"
                            stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>

                <!-- In-Header Mobile Search Bar -->
                <div id="mobileSearchBar"
                    class="absolute top-0 right-0 h-full z-40 bg-[#0e0e0e] flex items-center overflow-hidden transition-[width] duration-300 ease-in-out w-0 md:hidden">
                    <div class="flex items-center w-screen max-w-[100vw] text-white px-4">
                        <!-- Search Icon (Slides with the bar) -->
                        <svg class="shrink-0 mr-3 search-icon-trigger cursor-pointer" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 32 32" fill="none">
                            <path
                                d="M28 28L20 20M22.6667 13.3333C22.6667 18.488 18.488 22.6667 13.3333 22.6667C8.17868 22.6667 4 18.488 4 13.3333C4 8.17868 8.17868 4 13.3333 4C18.488 4 22.6667 8.17868 22.6667 13.3333Z"
                                stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <input type="text" placeholder="Search..."
                            class="search-input flex-grow bg-transparent text-white placeholder-neutral-400 outline-none text-lg h-full min-w-0">
                        <!-- Search Results Dropdown (Mobile) -->
                        <div
                            class="search-results-container fixed top-[60px] left-0 w-full flex flex-col items-start gap-4 border border-[#F5F5F5] bg-white p-4 shadow-[0_4px_17.9px_5px_rgba(0,0,0,0.15)] text-[#3B3B3B] font-['Helvetica'] text-base font-normal leading-[150%] tracking-[0.24px] z-[60] hidden max-h-[80vh] overflow-y-auto">
                        </div>
                        <!-- Spacer for Hamburger/Close Button -->
                        <div class="w-12 shrink-0"></div>
                    </div>
                </div>

                <!-- Hamburger / Close Wrapper -->
                <div class="z-50">
                    <div id="sidebarOverlay"
                        class="fixed inset-0 hidden bg-black/50 opacity-0 transition-opacity duration-300 h-screen w-screen">
                    </div>

                    <div id="sidebar"
                        class="z-20 absolute right-0 top-0 h-screen w-full md:w-[382px] translate-x-full invisible bg-[#0e0e0e]/50 backdrop-blur-[18px] transition-transform duration-300 ease-in-out overflow-y-auto">
                        <ul
                            class="text-white [&>li]:border-b [&>li]:border-[#EAEAEA] [&>li]:px-6 [&>li]:py-2.5 text-lg font-light leading-[140%] tracking-normal">
                            <li class="flex items-center justify-between">
                                <div class="relative w-full max-w-[280px]">
                                    <button type="button"
                                        onclick="openEvaModal(); document.getElementById('sidebar').classList.add('invisible'); document.getElementById('sidebar').classList.add('translate-x-full');"
                                        class="group relative flex items-center justify-between bg-white hover:bg-slate-50/80 rounded-full p-1.5 border border-slate-200 hover:border-primary/60 hover:shadow-[0_8px_30px_rgba(244,195,0,0.12)] transition-all duration-300 w-full text-left shadow-sm">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-gradient-to-tr from-primary to-primary-mid flex items-center justify-center shrink-0 border border-primary-low relative overflow-hidden shadow-sm group-hover:scale-105 transition-transform duration-300">
                                                <svg class="w-5 h-5 relative z-10" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 64 64">
                                                    <path d="M 8 52 C 8 46, 12 44, 18 44 L 18 64 L 8 64 Z"
                                                        fill="#CBD5E1" />
                                                    <path d="M 56 52 C 56 46, 52 44, 46 44 L 46 64 L 56 64 Z"
                                                        fill="#CBD5E1" />
                                                    <path
                                                        d="M 12 56 C 12 46, 18 42, 32 42 C 46 42, 52 46, 52 56 L 52 64 L 12 64 Z"
                                                        fill="#E2E8F0" />
                                                    <rect x="24" y="38" width="16" height="12" fill="#94A3B8" />
                                                    <path
                                                        d="M 14 30 C 14 16, 18 12, 32 12 C 46 12, 50 16, 50 30 C 50 42, 46 46, 32 46 C 18 46, 14 42, 14 30 Z"
                                                        fill="#F1F5F9" />
                                                    <path
                                                        d="M 14 30 C 14 42, 18 46, 32 46 C 46 46, 50 42, 50 30 L 50 34 C 50 46, 46 50, 32 50 C 18 50, 14 46, 14 34 Z"
                                                        fill="#E2E8F0" />
                                                    <path d="M 8 30 C 8 8, 20 4, 32 4 C 44 4, 56 8, 56 30" fill="none"
                                                        stroke="#1E3A8A" stroke-width="5" stroke-linecap="round" />
                                                    <rect x="24" y="1" width="16" height="6" rx="2" fill="#2563EB" />
                                                    <rect x="4" y="24" width="8" height="18" rx="4" fill="#1E3A8A" />
                                                    <rect x="52" y="24" width="8" height="18" rx="4" fill="#1E3A8A" />
                                                    <rect x="6" y="26" width="8" height="14" rx="2" fill="#2563EB" />
                                                    <rect x="50" y="26" width="8" height="14" rx="2" fill="#2563EB" />
                                                    <path
                                                        d="M 16 28 C 16 22, 18 21, 32 21 C 46 21, 48 22, 48 28 L 48 32 C 48 38, 46 39, 32 39 C 18 39, 16 38, 16 32 Z"
                                                        fill="#172554" />
                                                    <circle cx="25" cy="30" r="3" fill="#22D3EE" />
                                                    <circle cx="39" cy="30" r="3" fill="#22D3EE" />
                                                    <path d="M 54 36 L 54 48 C 54 52, 50 54, 46 54 L 40 54" fill="none"
                                                        stroke="#94A3B8" stroke-width="3" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <rect x="34" y="51" width="8" height="6" rx="3" fill="#1E3A8A" />
                                                </svg>
                                            </div>
                                            <div class="flex items-baseline gap-1.5">
                                                <span
                                                    class="text-[11px] font-bold text-main-green/70 uppercase tracking-widest leading-none">Ask</span>
                                                <span
                                                    class="text-[16px] font-black text-main-green leading-none tracking-tight">SARA</span>
                                            </div>
                                        </div>
                                        <div
                                            class="pr-3 text-slate-300 group-hover:text-primary group-hover:translate-x-1 transition-all duration-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </div>
                                    </button>
                                </div>
                                <button id="closeSidebar" aria-label="Close sidebar"
                                    class="p-2 hover:scale-95 transition-transform cursor-pointer">
                                    <img src="<?php echo SITE_URL; ?>/assets/icons/png/x.png" alt="Close" width="24"
                                        height="24" loading="lazy">
                                </button>
                            </li>

                            <?php foreach ($sidebarNav as $item): ?>
                                <?php if (isset($item['submenu'])): ?>
                                    <li class="has-submenu !px-0 !py-0">
                                        <div
                                            class="group flex items-center justify-between w-full px-6 py-2.5 border-[#EAEAEA] border-b">
                                            <a href="<?php echo SITE_URL . $item['url']; ?>"
                                                class="transition-colors duration-300 group-hover:text-b70">
                                                <?php echo $item['label']; ?>
                                            </a>
                                            <span class="cursor-pointer submenu-toggle px-2">
                                                <!-- Plus Icon -->
                                                <svg class="plus-icon transition-transform duration-300"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path d="M12 4V20M20 12L4 12" stroke="white" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <!-- Minus Icon (Hidden by default) -->
                                                <svg class="minus-icon hidden transition-transform duration-300"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path d="M20 12L4 12" stroke="white" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div
                                            class="submenu-wrapper grid grid-rows-[0fr] transition-all duration-300 ease-in-out">
                                            <ul
                                                class="overflow-hidden w-full bg-[#0E0E0E]/20 text-white [&>li]:border-b [&>li]:border-[#EAEAEA] [&>li]:px-16 [&>li]:py-2.5 text-lg font-light leading-[140%] tracking-normal [&>li:last-child]:border-b-0">
                                                <?php foreach ($item['submenu'] as $subItem): ?>
                                                    <li class="group">
                                                        <a href="<?php echo SITE_URL . $subItem['url']; ?>"
                                                            class="block w-full transition-colors duration-300 group-hover:text-b70">
                                                            <?php echo $subItem['label']; ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </li>
                                <?php else: ?>
                                    <li class="group transition-all duration-300 ease-in-out cursor-pointer">
                                        <a href="<?php echo SITE_URL . $item['url']; ?>"
                                            class="inline-block w-full h-full transition-transform duration-300 group-hover:text-b70">
                                            <?php echo $item['label']; ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <button type="button" id="openSidebar" aria-label="Open sidebar"
                        class="flex h-10 w-10 items-center justify-center bg-transparent p-2 transition-transform active:scale-95 cursor-pointer">
                        <img src="<?php echo SITE_URL; ?>/assets/icons/png/menu.png" alt="Menu" width="40" height="40">
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var searchInputs = document.querySelectorAll('.search-input');

            // Debounce function (ES5 compatible)
            function debounce(func, wait) {
                var timeout;
                return function () {
                    var context = this;
                    var args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(function () {
                        func.apply(context, args);
                    }, wait);
                };
            }

            // Polyfill for Element.prototype.closest for older browsers
            if (!Element.prototype.matches) {
                Element.prototype.matches = Element.prototype.msMatchesSelector ||
                    Element.prototype.webkitMatchesSelector ||
                    function (s) {
                        var matches = (this.document || this.ownerDocument).querySelectorAll(s),
                            i = matches.length;
                        while (--i >= 0 && matches.item(i) !== this) { }
                        return i > -1;
                    };
            }
            if (!Element.prototype.closest) {
                Element.prototype.closest = function (s) {
                    var el = this;
                    if (!document.documentElement.contains(el)) return null;
                    do {
                        if (el.matches(s)) return el;
                        el = el.parentElement || el.parentNode;
                    } while (el !== null && el.nodeType === 1);
                    return null;
                };
            }

            // Helper to handle class toggling safely
            function addClass(el, className) {
                if (el.classList) {
                    el.classList.add(className);
                } else if (el.className.indexOf(className) === -1) {
                    el.className += ' ' + className;
                }
            }

            function removeClass(el, className) {
                if (el.classList) {
                    el.classList.remove(className);
                } else {
                    el.className = el.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
                }
            }

            // Store active XHR requests to abort them if needed (prevents race conditions)
            var activeRequests = {};

            // Search Handler
            var handleSearch = debounce(function (e) {
                var input = this;
                var val = input.value.trim();

                var container = input.parentNode.querySelector('.search-results-container');
                if (!container && input.parentNode.parentNode) {
                    container = input.parentNode.parentNode.querySelector('.search-results-container');
                }

                if (!container) return;

                if (val.length < 2) {
                    container.innerHTML = '';
                    addClass(container, 'hidden');
                    return;
                }

                // Show loading state
                container.innerHTML = '<span class="text-gray-500 p-2 block text-sm">Searching...</span>';
                removeClass(container, 'hidden');

                // Abort previous request for this input
                var inputId = input.id || input.name || Math.random().toString();
                if (!input.getAttribute('data-search-id')) {
                    input.setAttribute('data-search-id', inputId);
                }
                var searchId = input.getAttribute('data-search-id');

                if (activeRequests[searchId]) {
                    activeRequests[searchId].abort();
                }

                var xhr = new XMLHttpRequest();
                activeRequests[searchId] = xhr;

                // Append timestamp to prevent aggressive IE/Safari caching
                var noCacheUrl = '<?php echo SITE_URL; ?>/ajax/search.php?q=' + encodeURIComponent(val) + '&_=' + new Date().getTime();

                xhr.open('GET', noCacheUrl, true);
                xhr.setRequestHeader('Accept', 'application/json');

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            try {
                                var data = JSON.parse(xhr.responseText);
                                container.innerHTML = '';
                                if (Object.prototype.toString.call(data) === '[object Array]' && data.length > 0) {
                                    for (var i = 0; i < data.length; i++) {
                                        var item = data[i];
                                        var link = document.createElement('a');
                                        link.href = item.url;
                                        // Added search-result-item class for keyboard navigation
                                        link.className = 'search-result-item hover:text-main-green hover:bg-gray-50 focus:bg-gray-100 focus:outline-none w-full block py-2 px-2 border-b border-gray-100 last:border-0 transition-colors';

                                        if (typeof link.textContent !== 'undefined') {
                                            link.textContent = item.name;
                                        } else {
                                            link.innerText = item.name;
                                        }

                                        container.appendChild(link);
                                    }
                                    removeClass(container, 'hidden');
                                } else {
                                    // Safe text injection
                                    var safeVal = val.replace(/</g, "&lt;").replace(/>/g, "&gt;");
                                    container.innerHTML = '<span class="text-gray-500 p-2 block text-sm">No results found for "' + safeVal + '"</span>';
                                    removeClass(container, 'hidden');
                                }
                            } catch (err) {
                                console.error('Search parsing error:', err);
                                container.innerHTML = '<span class="text-red-500 p-2 block text-sm">Error loading results</span>';
                            }
                        } else if (xhr.status !== 0) { // 0 means aborted, don't show error
                            console.error('Search network error');
                            container.innerHTML = '<span class="text-red-500 p-2 block text-sm">Network error occurred</span>';
                        }
                    }
                };
                xhr.send();
            }, 300);

            for (var i = 0; i < searchInputs.length; i++) {
                var input = searchInputs[i];
                input.setAttribute('autocomplete', 'off'); // Prevent browser autocomplete from overlapping
                input.addEventListener('input', handleSearch);

                // Keyboard Navigation (Accessibility & UX)
                input.addEventListener('keydown', function (e) {
                    var container = this.parentNode.querySelector('.search-results-container');
                    if (!container && this.parentNode.parentNode) {
                        container = this.parentNode.parentNode.querySelector('.search-results-container');
                    }

                    if (!container || container.className.indexOf('hidden') !== -1) {
                        if (e.key === 'Enter' || e.keyCode === 13) {
                            e.preventDefault();
                            if (this.value.trim()) handleSearch.call(this);
                        }
                        return;
                    }

                    var items = container.querySelectorAll('.search-result-item');
                    if (!items.length) {
                        // If no items (like "No results found"), just allow Enter to do nothing or fallback
                        if (e.key === 'Enter' || e.keyCode === 13) {
                            e.preventDefault();
                        }
                        return;
                    }

                    var activeItem = container.querySelector('.search-result-item:focus') || document.activeElement;
                    var currentIndex = Array.prototype.indexOf.call(items, activeItem);

                    if (e.key === 'ArrowDown' || e.keyCode === 40) {
                        e.preventDefault();
                        var nextIndex = (currentIndex + 1) % items.length;
                        items[nextIndex].focus();
                    } else if (e.key === 'ArrowUp' || e.keyCode === 38) {
                        e.preventDefault();
                        if (currentIndex === -1) {
                            items[items.length - 1].focus(); // Loop to bottom
                        } else {
                            var prevIndex = (currentIndex - 1 + items.length) % items.length;
                            items[prevIndex].focus();
                        }
                    } else if (e.key === 'Escape' || e.keyCode === 27) {
                        addClass(container, 'hidden');
                        this.focus();
                    } else if (e.key === 'Enter' || e.keyCode === 13) {
                        e.preventDefault();
                        if (currentIndex > -1) {
                            items[currentIndex].click();
                        } else {
                            items[0].click(); // Default to first result
                        }
                    }
                });
            }

            // Result Item Keyboard Navigation support
            document.addEventListener('keydown', function (e) {
                var target = e.target || e.srcElement;
                if (!target || typeof target.className !== 'string' || target.className.indexOf('search-result-item') === -1) return;

                var container = target.closest ? target.closest('.search-results-container') : null;
                if (!container) return;

                var items = container.querySelectorAll('.search-result-item');
                var currentIndex = Array.prototype.indexOf.call(items, target);

                if (e.key === 'ArrowDown' || e.keyCode === 40) {
                    e.preventDefault();
                    var nextIndex = (currentIndex + 1) % items.length;
                    items[nextIndex].focus();
                } else if (e.key === 'ArrowUp' || e.keyCode === 38) {
                    e.preventDefault();
                    if (currentIndex === 0) {
                        // Go back to input
                        var input = container.parentNode.querySelector('.search-input');
                        if (!input) input = container.parentNode.parentNode.querySelector('.search-input');
                        if (input) {
                            input.focus();
                            // Move cursor to end of text
                            var val = input.value;
                            input.value = '';
                            input.value = val;
                        }
                    } else {
                        var prevIndex = (currentIndex - 1) % items.length;
                        items[prevIndex].focus();
                    }
                } else if (e.key === 'Escape' || e.keyCode === 27) {
                    addClass(container, 'hidden');
                    var input = container.parentNode.querySelector('.search-input');
                    if (!input) input = container.parentNode.parentNode.querySelector('.search-input');
                    if (input) input.focus();
                }
            });

            // Click on search icon triggers search
            var searchIcons = document.querySelectorAll('.search-icon-trigger');
            for (var m = 0; m < searchIcons.length; m++) {
                searchIcons[m].addEventListener('click', function (e) {
                    e.stopPropagation(); // Prevent document click from closing it immediately
                    var container = this.parentNode;
                    var input = container.querySelector('.search-input');
                    if (input) {
                        input.focus();
                        handleSearch.call(input);
                    }
                });
            }

            // Close results when clicking outside
            var events = ['click', 'touchstart'];
            for (var j = 0; j < events.length; j++) {
                document.addEventListener(events[j], function (e) {
                    var target = e.target || e.srcElement;

                    // Safari text node bug fix
                    if (target && target.nodeType === 3) target = target.parentNode;

                    var isSearchInput = false;
                    var isSearchResults = false;
                    var isSearchIcon = false;

                    // Check if click was inside search components
                    if (target && typeof target.closest === 'function') {
                        isSearchInput = target.closest('.search-input');
                        isSearchResults = target.closest('.search-results-container');
                        isSearchIcon = target.closest('.search-icon-trigger');
                    }

                    // Only close if we clicked completely outside of any search UI
                    if (!isSearchInput && !isSearchResults && !isSearchIcon) {
                        var containers = document.querySelectorAll('.search-results-container');
                        for (var k = 0; k < containers.length; k++) {
                            addClass(containers[k], 'hidden');
                        }
                    }
                }, false);
            }
        });
    </script>


    <?php include 'sara-modal.php'; ?>