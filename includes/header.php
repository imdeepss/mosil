<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' | ' . SITE_NAME : SITE_NAME; ?></title>

    <!-- Core CSS -->
    <?php include 'tailwind-setup.php'; ?>

    <!-- libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/common.css">

    <!-- Page Specific CSS -->
    <?php
    $pageCss = 'assets/css/' . $page . '.css';
    if (file_exists($pageCss)) {
        echo '<link rel="stylesheet" href="' . SITE_URL . '/' . $pageCss . '">';
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

<body class="">

    <header class="fixed top-0 z-50 h-[60px] w-full max-w-[1440px] left-0 right-0 mx-auto">
        <div class="absolute inset-0 w-full h-full bg-[#0e0e0e]/40 backdrop-blur-[18px] -z-10"></div>
        <div class="container flex h-full items-center justify-between">
            <div class="shrink-0">
                <a href="<?php echo SITE_URL; ?>">
                    <img src="<?php echo SITE_URL; ?>/assets/images/logos/mosil.png" alt="MOSIL" width="95" height="44"
                        class="block">
                </a>
            </div>

            <nav class="flex items-center md:gap-8 gap-4">

                <div class="relative hidden h-8 w-[218px] md:block">
                    <input type="text" name="search" placeholder="Search"
                        class="search-input h-full w-full rounded-full border border-white bg-white/35 px-4 text-sm text-white placeholder-neutral-300 outline-none focus:ring-1 focus:ring-white/50" />
                    <img src="<?php echo SITE_URL; ?>/assets/icons/png/search.png" alt="Search"
                        class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4">
                    <!-- Search Results Dropdown (Desktop) -->
                    <div
                        class="search-results-container absolute top-full left-0 mt-4 w-[300px] -ml-[41px] flex flex-col items-start gap-4 border border-[#F5F5F5] bg-white p-4 shadow-[0_4px_17.9px_5px_rgba(0,0,0,0.15)] text-[#3B3B3B] font-['Helvetica'] text-base font-normal leading-[150%] tracking-[0.24px] z-50 rounded hidden">
                    </div>
                </div>
                <!-- Mobile Search Trigger -->
                <div class="relative md:hidden h-8 w-8 block cursor-pointer transition-opacity duration-300"
                    id="openMobileSearch">
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
                        <svg class="shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 32 32" fill="none">
                            <path
                                d="M28 28L20 20M22.6667 13.3333C22.6667 18.488 18.488 22.6667 13.3333 22.6667C8.17868 22.6667 4 18.488 4 13.3333C4 8.17868 8.17868 4 13.3333 4C18.488 4 22.6667 8.17868 22.6667 13.3333Z"
                                stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <input type="text" placeholder="Search..."
                            class="search-input flex-grow bg-transparent text-white placeholder-neutral-400 outline-none text-lg h-full min-w-0">
                        <!-- Search Results Dropdown (Mobile) -->
                        <div
                            class="search-results-container absolute top-[60px] left-0 w-full flex flex-col items-start gap-4 border border-[#F5F5F5] bg-white p-4 shadow-[0_4px_17.9px_5px_rgba(0,0,0,0.15)] text-[#3B3B3B] font-['Helvetica'] text-base font-normal leading-[150%] tracking-[0.24px] z-40 hidden max-h-[80vh] overflow-y-auto">
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
                                <div class="relative h-8 w-[200px]">
                                    <input type="text" placeholder="Search"
                                        class="search-input h-full w-full rounded-full border border-white bg-white/35 px-5 text-sm text-white placeholder-neutral-300 outline-none focus:ring-1 focus:ring-white/50">
                                    <img src="<?php echo SITE_URL; ?>/assets/icons/png/search.png" alt="Search"
                                        class="absolute right-5 top-1/2 -translate-y-1/2 w-4 h-4" loading="lazy">
                                    <!-- Sidebar Search Results -->
                                    <div
                                        class="search-results-container absolute top-full left-0 mt-2 w-full flex flex-col items-start gap-4 border border-[#F5F5F5] bg-white p-4 shadow-[0_4px_17.9px_5px_rgba(0,0,0,0.15)] text-[#3B3B3B] font-['Helvetica'] text-base font-normal leading-[150%] tracking-[0.24px] z-50 rounded hidden">
                                    </div>
                                </div>
                                <button id="closeSidebar"
                                    class="p-2 hover:scale-95 transition-transform cursor-pointer">
                                    <img src="<?php echo SITE_URL; ?>/assets/icons/png/x.png" alt="Close" width="24"
                                        height="24" loading="lazy">
                                </button>
                            </li>

                            <?php foreach ($sidebarNav as $item): ?>
                                <?php if (isset($item['submenu'])): ?>
                                    <li class="group has-submenu !px-0 !py-0">
                                        <div
                                            class="flex items-center justify-between w-full px-6 py-2.5 border-[#EAEAEA] border-b">
                                            <a href="<?php echo SITE_URL . $item['url']; ?>">
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
                                                    <li><a
                                                            href="<?php echo SITE_URL . $subItem['url']; ?>"><?php echo $subItem['label']; ?></a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </li>
                                <?php else: ?>
                                    <li
                                        class="group hover:bg-[var(--color-b900)]/50 transition-all duration-300 ease-in-out cursor-pointer">
                                        <a href="<?php echo SITE_URL . $item['url']; ?>"
                                            class="inline-block w-full h-full transition-transform duration-300 group-hover:translate-x-2 group-hover:text-[var(--color-b100)]">
                                            <?php echo $item['label']; ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <button type="button" id="openSidebar"
                        class="flex h-10 w-10 items-center justify-center bg-transparent p-2 transition-transform active:scale-95 cursor-pointer">
                        <img src="<?php echo SITE_URL; ?>/assets/icons/png/menu.png" alt="Menu" width="40" height="40">
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInputs = document.querySelectorAll('.search-input');

            // Debounce function
            function debounce(func, wait) {
                let timeout;
                return function (...args) {
                    const context = this;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), wait);
                };
            }

            // Search Handler
            const handleSearch = debounce(function (e) {
                const input = e.target;
                const val = input.value.trim();

                // Find sibling or parent's sibling results container
                // Structure varies:
                // Desktop: Sibling
                // Mobile: Sibling
                // Sidebar: Sibling (added)
                let container = input.parentNode.querySelector('.search-results-container');
                if (!container && input.parentNode.parentNode) {
                    container = input.parentNode.parentNode.querySelector('.search-results-container');
                }

                if (!container) return;

                if (val.length < 2) {
                    container.innerHTML = '';
                    container.classList.add('hidden');
                    return;
                }

                fetch('<?php echo SITE_URL; ?>/ajax/search.php?q=' + encodeURIComponent(val))
                    .then(response => response.json())
                    .then(data => {
                        container.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(item => {
                                const link = document.createElement('a');
                                link.href = item.url;
                                link.className = 'hover:text-main-green w-full block py-1 border-b border-gray-100 last:border-0';
                                link.textContent = item.name;
                                container.appendChild(link);
                            });
                            container.classList.remove('hidden');
                        } else {
                            container.innerHTML = '<span class="text-gray-500 p-2 block text-sm">No results found</span>';
                            container.classList.remove('hidden');
                        }
                    })
                    .catch(err => {
                        console.error('Search error:', err);
                    });
            }, 300);

            searchInputs.forEach(input => {
                input.addEventListener('input', handleSearch);

                // Close on blur (delay to allow click)
                input.addEventListener('blur', function (e) {
                    setTimeout(() => {
                        let container = e.target.parentNode.querySelector('.search-results-container');
                        if (!container && e.target.parentNode.parentNode) {
                            container = e.target.parentNode.parentNode.querySelector('.search-results-container');
                        }
                        if (container) {
                            // container.classList.add('hidden'); 
                            // We rely on the document click listener to close it, 
                            // so clicking on a result doesn't close it before navigation
                        }
                    }, 200);
                });
            });

            // Close results when clicking outside
            document.addEventListener('click', function (e) {
                if (!e.target.closest('.search-input') && !e.target.closest('.search-results-container')) {
                    document.querySelectorAll('.search-results-container').forEach(el => el.classList.add('hidden'));
                }
            });
        });
    </script>