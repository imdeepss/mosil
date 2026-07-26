<?php
// demo-ai-buttons.php
$pageTitle = "Ultra-Premium AI Triggers - MOSIL";
?>
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#F4C300',
                    'primary-high': '#FEF9E6',
                    'primary-mid': '#FAE696',
                    'primary-low': '#F9DC6B',
                    secondary: '#30442C',
                    'main-green': '#1A3B1B',
                }
            }
        }
    }
</script>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
<style>
    body {
        font-family: 'Outfit', sans-serif;
    }

    @keyframes slow-spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .animate-slow-spin {
        animation: slow-spin 4s linear infinite;
    }
</style>
<!-- STATIC HEADER FOR DEMO -->
<header class="fixed top-0 z-50 h-[60px] w-full left-0 right-0">
    <div class="absolute inset-0 w-full h-full bg-[#0e0e0e]/40 backdrop-blur-[18px] -z-10"></div>
    <div class="container flex h-full items-center justify-between mx-auto px-4 max-w-5xl">
        <div class="shrink-0">
            <a href="<?php echo defined('SITE_URL') ? SITE_URL : ''; ?>">
                <img src="<?php echo defined('SITE_URL') ? SITE_URL : ''; ?>/assets/images/logos/mosil.webp" alt="MOSIL"
                    width="95" height="44" class="block">
            </a>
        </div>

        <nav class="flex items-center md:gap-8 gap-4">

            <!-- Premium Header Search Button -->
            <div class="relative hidden w-[340px] md:block group z-50">
                <button type="button" onclick="openEvaModal()"
                    class="group relative flex items-center bg-white hover:bg-gray-50 rounded-full px-2 py-1.5 pr-6 border border-transparent hover:border-primary hover:shadow-[0_4px_20px_rgba(244,195,0,0.3)] transition-all w-full text-left shadow-lg">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-[36px] h-[36px] rounded-full bg-primary-high flex items-center justify-center shrink-0 border border-primary-low overflow-hidden relative shadow-inner">
                            <div class="absolute inset-0 bg-gradient-to-tr from-primary to-primary-mid">
                            </div>
                            <img src="<?php echo defined('SITE_URL') ? SITE_URL : ''; ?>/assets/icons/png/search.png"
                                alt="Search" class="w-4 h-4 opacity-90 relative z-10 brightness-0">
                        </div>
                        <div class="flex flex-col">
                            <span
                                class="text-[9px] font-bold text-main-green tracking-widest leading-none uppercase">Ask</span>
                            <span class="text-[14px] font-black text-main-green leading-none mt-0.5">SARA</span>
                        </div>
                    </div>
                    <span class="ml-4 text-gray-400 font-light text-[13px] italic truncate">Search...</span>

                    <div
                        class="absolute right-3 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </div>
                </button>
            </div>

            <div class="relative md:hidden h-8 w-8 block cursor-pointer transition-opacity duration-300 ai-trigger"
                id="openMobileSearch" aria-label="Open mobile search" role="button" tabindex="0">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <path
                        d="M28 28L20 20M22.6667 13.3333C22.6667 18.488 18.488 22.6667 13.3333 22.6667C8.17868 22.6667 4 18.488 4 13.3333C4 8.17868 8.17868 4 13.3333 4C18.488 4 22.6667 8.17868 22.6667 13.3333Z"
                        stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
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
                            <div class="relative h-8 w-[280px]">
                                <input type="text"
                                    placeholder="To choose the right lubricant & multiply performance.? Ask Sara."
                                    class="search-input h-full w-full rounded-full border border-white bg-white/35 px-5 pr-10 text-xs text-white placeholder-neutral-300 outline-none focus:ring-1 focus:ring-white/50 truncate">
                                <img src="<?php echo defined('SITE_URL') ? SITE_URL : ''; ?>/assets/icons/png/search.png"
                                    alt="Search"
                                    class="absolute right-5 top-1/2 -translate-y-1/2 w-4 h-4 search-icon-trigger cursor-pointer"
                                    loading="lazy">
                            </div>
                            <button id="closeSidebar" aria-label="Close sidebar"
                                class="p-2 hover:scale-95 transition-transform cursor-pointer">
                                <img src="<?php echo defined('SITE_URL') ? SITE_URL : ''; ?>/assets/icons/png/x.png"
                                    alt="Close" width="24" height="24" loading="lazy">
                            </button>
                        </li>

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
                        foreach ($sidebarNav as $item): ?>
                            <?php if (isset($item['submenu'])): ?>
                                <li class="has-submenu !px-0 !py-0">
                                    <div
                                        class="group flex items-center justify-between w-full px-6 py-2.5 border-[#EAEAEA] border-b">
                                        <a href="<?php echo (defined('SITE_URL') ? SITE_URL : '') . $item['url']; ?>"
                                            class="transition-colors duration-300 group-hover:text-b70">
                                            <?php echo $item['label']; ?>
                                        </a>
                                        <span class="cursor-pointer submenu-toggle px-2">
                                            <svg class="plus-icon transition-transform duration-300"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none">
                                                <path d="M12 4V20M20 12L4 12" stroke="white" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <svg class="minus-icon hidden transition-transform duration-300"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none">
                                                <path d="M20 12L4 12" stroke="white" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="submenu-wrapper grid grid-rows-[0fr] transition-all duration-300 ease-in-out">
                                        <ul
                                            class="overflow-hidden w-full bg-[#0E0E0E]/20 text-white [&>li]:border-b [&>li]:border-[#EAEAEA] [&>li]:px-16 [&>li]:py-2.5 text-lg font-light leading-[140%] tracking-normal [&>li:last-child]:border-b-0">
                                            <?php foreach ($item['submenu'] as $subItem): ?>
                                                <li class="group">
                                                    <a href="<?php echo (defined('SITE_URL') ? SITE_URL : '') . $subItem['url']; ?>"
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
                                    <a href="<?php echo (defined('SITE_URL') ? SITE_URL : '') . $item['url']; ?>"
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
                    <img src="<?php echo defined('SITE_URL') ? SITE_URL : ''; ?>/assets/icons/png/menu.png" alt="Menu"
                        width="40" height="40">
                </button>
            </div>
        </nav>
    </div>
</header>
<!-- END STATIC HEADER -->

<div class="pt-[100px] pb-20 bg-[#f4f7f6] min-h-screen flex items-center justify-center">
    <div class="text-center max-w-2xl px-4">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 text-slate-800 tracking-tight">Search Integrated into Header
        </h1>
        <p class="text-slate-500 text-lg mx-auto font-light mb-8">The premium "Ask SARA" AI trigger button has been
            successfully migrated to the main navigation header above.</p>
        <button onclick="openEvaModal()"
            class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-main-green bg-primary hover:bg-primary-mid shadow-md transition-colors">
            Trigger Modal From Here Instead
        </button>
    </div>
</div>

<div id="evaModal"
    class="fixed inset-0 z-[100] hidden items-center justify-center p-4 sm:p-6 bg-slate-900/40 backdrop-blur-lg opacity-0 transition-opacity duration-500"
    role="dialog" aria-modal="true" aria-labelledby="evaModalTitle">

    <!-- Ultra-Premium Modal Container -->
    <div class="relative w-full max-w-[950px] h-[85vh] bg-[#FAFBFA]/95 backdrop-blur-2xl rounded-[32px] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.25),inset_0_2px_4px_rgba(255,255,255,1)] border border-white/80 flex flex-col transform scale-95 transition-all duration-500 overflow-hidden"
        id="evaModalContent">

        <!-- Subtle Aurora Background Effects -->
        <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden">
            <div
                class="absolute -top-[10%] -left-[10%] w-[60%] h-[60%] bg-primary/10 rounded-full mix-blend-multiply filter blur-[100px] opacity-70">
            </div>
            <div
                class="absolute top-[30%] -right-[15%] w-[50%] h-[50%] bg-main-green/5 rounded-full mix-blend-multiply filter blur-[100px] opacity-70">
            </div>
            <div
                class="absolute bottom-0 left-[20%] w-[40%] h-[40%] bg-[#facc15]/5 rounded-full mix-blend-multiply filter blur-[80px] opacity-50">
            </div>
        </div>

        <!-- Elegant Header -->
        <div
            class="relative z-20 flex items-center justify-between px-6 sm:px-8 py-5 sm:py-6 border-b border-slate-200/50 bg-white/40 backdrop-blur-md shrink-0">
            <div class="flex items-center gap-4">
                <div class="relative group cursor-default">
                    <!-- Soft ambient glow -->
                    <div class="absolute inset-0 bg-[#facc15]/30 filter blur-[12px] rounded-full scale-110 z-0 group-hover:bg-[#facc15]/40 transition-colors duration-500"></div>
                    
                    <!-- Premium Light Glass Container -->
                    <div class="w-12 h-12 rounded-[16px] bg-gradient-to-br from-[#FFFCF2] to-[#FFF6D6] flex items-center justify-center shadow-[0_8px_20px_rgba(250,204,21,0.15)] border border-white relative z-10 overflow-hidden">
                        <!-- Elegant top highlight -->
                        <div class="absolute top-0 left-0 right-0 h-1/2 bg-gradient-to-b from-white/80 to-transparent rounded-t-[16px]"></div>

                        <!-- Solid Golden AI Sparkles -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-primary drop-shadow-[0_2px_6px_rgba(244,195,0,0.4)] transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 relative z-20">
                            <path d="M10.813 1.25a.75.75 0 011.374 0l1.71 4.562 4.562 1.71a.75.75 0 010 1.374l-4.562 1.71-1.71 4.562a.75.75 0 01-1.374 0l-1.71-4.562-4.562-1.71a.75.75 0 010-1.374l4.562-1.71 1.71-4.562z" />
                            <path d="M20.25 15.5a.75.75 0 011.374 0l.57 1.521 1.521.57a.75.75 0 010 1.374l-1.521.57-.57 1.521a.75.75 0 01-1.374 0l-.57-1.521-1.521-.57a.75.75 0 010-1.374l1.521-.57.57-1.521z" />
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col">
                    <span
                        class="text-[10px] font-black text-primary uppercase tracking-[0.25em] leading-none mb-1.5 opacity-90">AI
                        Assistant</span>
                    <span id="evaModalTitle"
                        class="text-[20px] font-black text-main-green leading-none tracking-tight">Ask SARA</span>
                </div>
            </div>

            <button onclick="closeEvaModal()"
                class="w-10 h-10 bg-white hover:bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center text-slate-400 hover:text-slate-800 shadow-sm transition-all duration-300 z-50 transform hover:rotate-90">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Main Body Area (Flex container) -->
        <div class="relative z-10 flex-1 flex flex-col w-full min-h-0 overflow-y-auto">

            <!-- Trending State (Standard Flow) -->
            <div id="evaEmptyState"
                class="p-6 md:p-10 transition-opacity duration-500 z-10 flex flex-col justify-center flex-1 min-h-full">
                <div class="max-w-3xl mx-auto w-full animate-[smoothEnter_0.6s_ease-out_forwards]">
                    <div class="text-center mb-10">
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-800 tracking-tight mb-3">How can I
                            help you today?</h2>
                        <p class="text-slate-500 text-[16px] font-medium">Search for products, discover technical
                            guides, or ask anything about our lubricants.</p>
                    </div>

                    <div class="flex items-center justify-center gap-3 mb-6">
                        <div
                            class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-[15px] font-bold text-slate-800 tracking-tight uppercase">Trending Ideas</h3>
                    </div>

                    <div class="flex flex-wrap justify-center gap-3">
                        <?php
                        $trending = [
                            "High Temp Grease",
                            "Food Grade Lubricants",
                            "Silicone Grease",
                            "Heavy Duty Gear Oils",
                            "Find MSDS",
                            "Request a Sample",
                            "Product Selector Tool",
                            "Bearing Guide"
                        ];
                        foreach ($trending as $index => $tag):
                            ?>
                            <button onclick="triggerChatbase('<?= htmlspecialchars($tag, ENT_QUOTES) ?>')"
                                class="group relative px-5 sm:px-6 py-2.5 sm:py-3 bg-main-green text-white text-[14px] sm:text-[15px] font-medium tracking-[0.24px] sm:font-semibold rounded-full shadow-[0_4px_15px_rgba(26,59,27,0.2)] hover:shadow-[0_8px_30px_rgba(244,195,0,0.3)] border border-[#264C27] hover:border-primary transition-all duration-400 flex items-center gap-2.5 transform hover:-translate-y-1 overflow-hidden animate-[fadeInUp_0.4s_ease-out_forwards]"
                                style="animation-delay: <?= $index * 0.04 ?>s; opacity: 0;">

                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]">
                                </div>

                                <div
                                    class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center shrink-0 group-hover:bg-primary/20 group-hover:shadow-[0_0_10px_rgba(244,195,0,0.5)] transition-all duration-300 relative z-10">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-3.5 h-3.5 text-primary group-hover:scale-110 transition-transform duration-300"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>

                                <span
                                    class="relative z-10 group-hover:text-primary-high transition-colors duration-300"><?= $tag ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Chat Stream State -->
            <div id="chatBubblesContainer" class="hidden flex-col w-full max-w-4xl mx-auto p-6 sm:p-8 z-20 gap-6">
                <!-- Initial Welcome Message -->
                <div class="flex justify-start chat-bubble-enter w-full">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#FFFCF2] to-[#FFF6D6] flex items-center justify-center shrink-0 mr-3 mt-1 shadow-[0_4px_12px_rgba(250,204,21,0.15)] border border-white relative overflow-hidden group">
                        <div class="absolute top-0 left-0 right-0 h-1/2 bg-gradient-to-b from-white/70 to-transparent"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-primary drop-shadow-[0_2px_4px_rgba(244,195,0,0.3)] relative z-20">
                            <path d="M10.813 1.25a.75.75 0 011.374 0l1.71 4.562 4.562 1.71a.75.75 0 010 1.374l-4.562 1.71-1.71 4.562a.75.75 0 01-1.374 0l-1.71-4.562-4.562-1.71a.75.75 0 010-1.374l4.562-1.71 1.71-4.562z" />
                            <path d="M20.25 15.5a.75.75 0 011.374 0l.57 1.521 1.521.57a.75.75 0 010 1.374l-1.521.57-.57 1.521a.75.75 0 01-1.374 0l-.57-1.521-1.521-.57a.75.75 0 010-1.374l1.521-.57.57-1.521z" />
                        </svg>
                    </div>
                    <div
                        class="bg-white/95 backdrop-blur-xl border border-slate-100 text-slate-700 rounded-[28px] rounded-tl-[8px] px-7 py-5 max-w-[90%] shadow-[0_12px_40px_rgba(0,0,0,0.06)] text-[16px] leading-[160%] font-normal">
                        Hello! I am SARA, your intelligent assistant. How can I help you discover the perfect
                        lubrication solution today?
                    </div>
                </div>
            </div>

        </div>

        <!-- Dynamic Bottom Search Area -->
        <div class="shrink-0 relative z-30 p-5 sm:p-6 bg-white/40 backdrop-blur-md border-t border-slate-200/50">
            <div class="max-w-4xl mx-auto w-full relative">
                <!-- Search Box -->
                <div
                    class="w-full bg-white/90 backdrop-blur-2xl rounded-[28px] p-2.5 sm:p-3 shadow-[0_10px_40px_rgba(0,0,0,0.08),inset_0_1px_2px_rgba(255,255,255,1)] border border-slate-200/80 flex items-end relative focus-within:shadow-[0_15px_50px_rgba(244,195,0,0.15),0_0_0_1px_rgba(244,195,0,0.4)] focus-within:border-primary/50 transition-all duration-400">

                    <div class="pl-4 sm:pl-5 pr-2 flex items-center justify-center opacity-40 h-[50px] shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <textarea id="evaSearchInput" rows="1" placeholder="Message SARA or search for products..."
                        class="flex-1 bg-transparent border-none outline-none px-3 py-3 text-[16px] sm:text-[17px] text-slate-800 placeholder:text-slate-400 font-medium w-full tracking-wide resize-none overflow-y-auto max-h-[150px]"
                        autofocus
                        oninput="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px'; toggleSendButton();"
                        onkeydown="if(event.key === 'Enter' && !event.shiftKey) { event.preventDefault(); triggerChatbase(this.value); }"></textarea>

                    <!-- Premium Send Button -->
                    <button id="evaSendBtn" disabled
                        onclick="triggerChatbase(document.getElementById('evaSearchInput').value)"
                        class="w-[50px] h-[50px] flex items-center justify-center rounded-[20px] bg-slate-900 text-white hover:bg-[#1A3B1B] active:scale-95 transition-all duration-300 shrink-0 shadow-[0_4px_15px_rgba(0,0,0,0.1)] hover:shadow-[0_8px_25px_rgba(26,59,27,0.25)] group relative overflow-hidden ml-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 transform -rotate-45 group-hover:-rotate-12 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-all duration-300 relative z-10"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </div>

                <!-- Disclaimer -->
                <div class="text-center mt-3">
                    <p class="text-[12px] text-slate-400/80 font-medium tracking-wide">SARA is an AI assistant and may
                        occasionally generate incorrect information.</p>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    @keyframes shimmer {
        100% {
            transform: translateX(100%);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes smoothEnter {
        from {
            opacity: 0;
            transform: translateY(15px) scale(0.98);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes dotBounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-4px);
        }
    }

    .chat-bubble-enter {
        animation: smoothEnter 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* Elegant Thin Scrollbar */
    #evaModalContent ::-webkit-scrollbar {
        width: 5px;
    }

    #evaModalContent ::-webkit-scrollbar-track {
        background: transparent;
        margin-top: 15px;
        margin-bottom: 15px;
    }

    #evaModalContent ::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.4);
        border-radius: 10px;
    }

    #evaModalContent ::-webkit-scrollbar-thumb:hover {
        background: rgba(148, 163, 184, 0.7);
    }
</style>

<script>
    function openEvaModal() {
        const modal = document.getElementById('evaModal');
        const content = document.getElementById('evaModalContent');
        const input = document.getElementById('evaSearchInput');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
            input.focus();
        }, 10);
    }

    function closeEvaModal() {
        const modal = document.getElementById('evaModal');
        const content = document.getElementById('evaModalContent');

        modal.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 500);
    }

    document.getElementById('evaModal').addEventListener('click', function (e) {
        if (e.target === this) closeEvaModal();
    });

    document.addEventListener('keydown', function (e) {
        const modal = document.getElementById('evaModal');
        if (modal.classList.contains('hidden')) return;

        if (e.key === 'Escape') {
            closeEvaModal();
            return;
        }

        if (e.key === 'Tab') {
            const focusableElements = modal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            if (focusableElements.length === 0) return;

            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];

            if (e.shiftKey) {
                if (document.activeElement === firstElement) {
                    lastElement.focus();
                    e.preventDefault();
                }
            } else {
                if (document.activeElement === lastElement) {
                    firstElement.focus();
                    e.preventDefault();
                }
            }
        }
    });

    let chatHistory = [];
    let isSending = false;

    async function triggerChatbase(query) {
        if (!query || !query.trim() || isSending) return;
        isSending = true;
        toggleSendButton();

        // Transition from Empty State to Chat View
        const emptyState = document.getElementById('evaEmptyState');
        const chatBubbles = document.getElementById('chatBubblesContainer');

        if (!emptyState.classList.contains('hidden')) {
            emptyState.style.opacity = '0';
            setTimeout(() => {
                emptyState.classList.add('hidden');
                chatBubbles.classList.remove('hidden');
                chatBubbles.classList.add('flex');
            }, 400);
        } else {
            chatBubbles.classList.remove('hidden');
            chatBubbles.classList.add('flex');
        }

        const inputEl = document.getElementById('evaSearchInput');
        inputEl.value = '';
        inputEl.style.height = 'auto';
        toggleSendButton();

        // Add User Bubble (Refined Matte Green)
        setTimeout(() => {
            chatBubbles.insertAdjacentHTML('beforeend', `
                <div class="flex justify-end chat-bubble-enter opacity-0 w-full">
                    <div class="bg-main-green text-white rounded-[28px] rounded-tr-[8px] px-7 py-4 max-w-[85%] sm:max-w-[75%] shadow-md border border-[#1A3B1B]">
                        <p class="text-[16px] font-medium leading-[150%] tracking-[0.2px]">${query.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</p>
                    </div>
                </div>
            `);
            scrollToBottom(true);
        }, emptyState.classList.contains('hidden') ? 0 : 350);

        // Add Loading Bubble (Bento Style)
        const loaderId = 'loader_' + Date.now();
        setTimeout(() => {
            chatBubbles.insertAdjacentHTML('beforeend', `
                <div id="${loaderId}" class="flex justify-start chat-bubble-enter opacity-0 w-full">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#FFFCF2] to-[#FFF6D6] flex items-center justify-center shrink-0 mr-3 mt-1 shadow-[0_4px_12px_rgba(250,204,21,0.15)] border border-white relative overflow-hidden group">
                        <div class="absolute top-0 left-0 right-0 h-1/2 bg-gradient-to-b from-white/70 to-transparent"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-primary drop-shadow-[0_2px_4px_rgba(244,195,0,0.3)] relative z-20">
                            <path d="M10.813 1.25a.75.75 0 011.374 0l1.71 4.562 4.562 1.71a.75.75 0 010 1.374l-4.562 1.71-1.71 4.562a.75.75 0 01-1.374 0l-1.71-4.562-4.562-1.71a.75.75 0 010-1.374l4.562-1.71 1.71-4.562z" />
                            <path d="M20.25 15.5a.75.75 0 011.374 0l.57 1.521 1.521.57a.75.75 0 010 1.374l-1.521.57-.57 1.521a.75.75 0 01-1.374 0l-.57-1.521-1.521-.57a.75.75 0 010-1.374l1.521-.57.57-1.521z" />
                        </svg>
                    </div>
                    <div class="bg-white/95 backdrop-blur-xl border border-slate-100 rounded-[28px] rounded-tl-[8px] px-7 py-5 max-w-[85%] flex items-center gap-2 shadow-[0_12px_40px_rgba(0,0,0,0.06)]">
                        <div class="w-2.5 h-2.5 rounded-full bg-primary animate-[dotBounce_1s_infinite]"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-primary animate-[dotBounce_1s_infinite_0.15s]"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-primary animate-[dotBounce_1s_infinite_0.3s]"></div>
                    </div>
                </div>
            `);
            scrollToBottom();
        }, emptyState.classList.contains('hidden') ? 250 : 600);

        chatHistory.push({ role: 'user', content: query });

        try {
            const response = await fetch(`<?php echo defined('SITE_URL') ? SITE_URL : ''; ?>/ajax/chatbase.php`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ messages: chatHistory })
            });

            const data = await response.json();
            const loaderEl = document.getElementById(loaderId);
            if (loaderEl) loaderEl.remove();

            if (data.error) {
                appendSaraResponse("Oops, I encountered an error: " + data.error);
            } else {
                appendSaraResponse(data.text);
                chatHistory.push({ role: 'assistant', content: data.text });
            }
        } catch (e) {
            const loaderEl = document.getElementById(loaderId);
            if (loaderEl) loaderEl.remove();
            appendSaraResponse("I am having trouble connecting to the server right now. Please check your network.");
        } finally {
            isSending = false;
            toggleSendButton();
        }
    }

    function appendSaraResponse(text) {
        let formattedText = text
            // Parse Markdown Links first
            .replace(/\[([^\]]+)\]\((https?:\/\/[^\s]+)\)/g, '%%LINK_START%%$2%%LINK_MID%%$1%%LINK_END%%')
            // Parse Bare URLs (ignoring already parsed ones)
            .replace(/(^|\s)(https?:\/\/[^\s<]+)/g, function(match, space, url) {
                // Remove trailing punctuation from URL if any
                let punctuation = '';
                if (url.match(/[.,;:!?)\]]$/)) {
                    punctuation = url.slice(-1);
                    url = url.slice(0, -1);
                }
                return space + '%%LINK_START%%' + url + '%%LINK_MID%%' + url + '%%LINK_END%%' + punctuation;
            })
            // Convert placeholders to styled HTML anchor tags
            .replace(/%%LINK_START%%(.*?)%%LINK_MID%%(.*?)%%LINK_END%%/g, '<a href="$1" target="_blank" class="inline-flex items-center gap-1.5 text-main-green font-bold hover:text-primary transition-colors underline underline-offset-4 decoration-primary/40 hover:decoration-primary break-all"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>$2</a>')
            // Standard markdown
            .replace(/### (.*?)\n/g, '<h3 class="text-lg font-bold text-slate-800 mt-4 mb-2">$1</h3>')
            .replace(/\*\*(.*?)\*\*/g, '<strong class="font-bold text-slate-900">$1</strong>')
            .replace(/\*(.*?)\*/g, '<em class="italic text-slate-800">$1</em>')
            .replace(/```([\s\S]*?)```/g, '<pre class="bg-slate-800 text-slate-100 p-3 rounded-lg my-3 overflow-x-auto text-sm font-mono leading-relaxed"><code>$1</code></pre>')
            .replace(/`(.*?)`/g, '<code class="bg-slate-100/80 text-slate-800 px-1.5 py-0.5 rounded text-[13.5px] font-mono border border-slate-200/60">$1</code>')
            .replace(/\n/g, '<br>');

        const chatBubbles = document.getElementById('chatBubblesContainer');
        chatBubbles.insertAdjacentHTML('beforeend', `
            <div class="flex justify-start chat-bubble-enter opacity-0 w-full">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#FFFCF2] to-[#FFF6D6] flex items-center justify-center shrink-0 mr-3 mt-1 shadow-[0_4px_12px_rgba(250,204,21,0.15)] border border-white relative overflow-hidden group">
                    <div class="absolute top-0 left-0 right-0 h-1/2 bg-gradient-to-b from-white/70 to-transparent"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-primary drop-shadow-[0_2px_4px_rgba(244,195,0,0.3)] relative z-20">
                        <path d="M10.813 1.25a.75.75 0 011.374 0l1.71 4.562 4.562 1.71a.75.75 0 010 1.374l-4.562 1.71-1.71 4.562a.75.75 0 01-1.374 0l-1.71-4.562-4.562-1.71a.75.75 0 010-1.374l4.562-1.71 1.71-4.562z" />
                        <path d="M20.25 15.5a.75.75 0 011.374 0l.57 1.521 1.521.57a.75.75 0 010 1.374l-1.521.57-.57 1.521a.75.75 0 01-1.374 0l-.57-1.521-1.521-.57a.75.75 0 010-1.374l1.521-.57.57-1.521z" />
                    </svg>
                </div>
                <div class="bg-white/95 backdrop-blur-xl border border-slate-100 text-slate-700 rounded-[28px] rounded-tl-[8px] px-7 py-5 max-w-[90%] shadow-[0_12px_40px_rgba(0,0,0,0.06)] text-[16px] leading-[160%] font-normal">
                    ${formattedText}
                </div>
            </div>
        `);
        scrollToBottom();
    }

    function toggleSendButton() {
        const inputEl = document.getElementById('evaSearchInput');
        const btn = document.getElementById('evaSendBtn');
        if (inputEl.value.trim() !== '' && !isSending) {
            btn.removeAttribute('disabled');
        } else {
            btn.setAttribute('disabled', 'true');
        }
    }

    function scrollToBottom(force = false) {
        const container = document.getElementById('chatBubblesContainer');
        const scrollParent = container.parentElement;

        const isNearBottom = scrollParent.scrollHeight - scrollParent.scrollTop <= scrollParent.clientHeight + 200;

        if (force || isNearBottom) {
            setTimeout(() => {
                scrollParent.scrollTo({ top: scrollParent.scrollHeight, behavior: 'smooth' });
            }, 50);
        }
    }
</script>

<!-- Chatbot Trigger Script -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buttons = document.querySelectorAll('.ai-trigger');
        buttons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                openEvaModal();
            });
        });
    });
</script>