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
<style>
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

<!-- SARA Premium Search Modal -->
<div id="evaModal"
    class="fixed inset-0 z-[100] hidden flex-col items-center pt-[8vh] pb-4 px-4 bg-slate-900/40 backdrop-blur-xl opacity-0 transition-opacity duration-500">
    <div class="relative w-full max-w-4xl bg-white/40 backdrop-blur-3xl rounded-[32px] shadow-[0_30px_60px_rgba(0,0,0,0.15),0_0_0_1px_rgba(255,255,255,0.4)] overflow-visible flex flex-col transform scale-95 transition-all duration-500"
        id="evaModalContent">

        <!-- Modal Header / Search input -->
        <div
            class="bg-white/95 backdrop-blur-2xl p-6 flex items-center gap-4 relative z-20 shadow-[0_4px_30px_rgba(0,0,0,0.03)] rounded-t-[32px] border-b border-white/40">
            <div
                class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 relative overflow-hidden shadow-[0_8px_20px_rgba(244,195,0,0.25)] bg-gradient-to-tr from-primary to-primary-mid">
                <img src="<?php echo defined('SITE_URL') ? SITE_URL : ''; ?>/assets/icons/png/search.png" alt="Search"
                    class="w-6 h-6 relative z-10 brightness-0">
            </div>
            <div class="flex flex-col shrink-0 mr-2 border-r border-gray-100 pr-5">
                <span
                    class="text-[11px] font-black text-primary tracking-[0.25em] leading-none uppercase mb-1.5 opacity-90">Ask</span>
                <span class="text-[22px] font-black text-main-green leading-none tracking-tight">SARA</span>
            </div>
            <input type="text" placeholder="What can I help you find today?"
                class="flex-1 bg-transparent border-none outline-none text-main-green text-[22px] font-light placeholder:text-gray-400 px-2 w-full tracking-wide"
                autofocus id="evaSearchInput" onkeydown="if(event.key === 'Enter') triggerChatbase(this.value)">
            <button onclick="triggerChatbase(document.getElementById('evaSearchInput').value)"
                class="w-14 h-14 flex items-center justify-center text-slate-300 hover:text-main-green hover:bg-gradient-to-r hover:from-primary hover:to-primary-mid hover:shadow-[0_8px_20px_rgba(244,195,0,0.3)] rounded-2xl transition-all duration-300 shrink-0 transform hover:scale-105 border border-transparent hover:border-primary/30 group">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 transform rotate-45 group-hover:rotate-0 transition-transform duration-300"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </button>
        </div>

        <!-- Close button (absolute top right of modal) -->
        <button onclick="closeEvaModal()"
            class="absolute -top-5 -right-5 w-11 h-11 bg-white/90 backdrop-blur-md border border-white/50 rounded-full shadow-[0_8px_20px_rgba(0,0,0,0.1)] flex items-center justify-center text-slate-400 hover:text-main-green hover:bg-primary hover:border-primary hover:shadow-[0_8px_20px_rgba(244,195,0,0.3)] transition-all duration-300 z-30 group transform hover:scale-110">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Body / Trending Searches -->
        <div id="trendingSearches"
            class="p-10 bg-slate-50/90 relative rounded-b-[32px] transition-all duration-500 overflow-hidden">
            <div
                class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-primary-low/40 via-transparent to-transparent pointer-events-none">
            </div>

            <div class="flex items-center gap-3 mb-8 relative z-10">
                <div class="w-8 h-8 rounded-full bg-primary-high flex items-center justify-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary animate-pulse"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="text-main-green font-bold text-[17px] tracking-tight">Trending searches</h3>
            </div>

            <div class="flex flex-wrap gap-3 relative z-10">
                <?php
                $trending = [
                    "High Temperature Grease",
                    "Food Grade Lubricants",
                    "Silicone Grease",
                    "Gear Oils",
                    "Chain Lubricants",
                    "Anti-Seize Compounds",
                    "Compressor Oils",
                    "Moly Paste",
                    "Synthetic Oils",
                    "Aerosol Sprays",
                    "Corrosion Preventives",
                    "Find MSDS",
                    "Product Selector Tool",
                    "Distributor Login",
                    "Request a Sample",
                    "O-Ring Compatibility",
                    "Bearing Lubrication Guide"
                ];
                foreach ($trending as $tag):
                    ?>
                    <button onclick="triggerChatbase('<?= htmlspecialchars($tag, ENT_QUOTES) ?>')"
                        class="px-5 py-2.5 bg-white border border-white/60 rounded-full text-[13.5px] text-slate-600 font-medium hover:border-transparent hover:text-main-green hover:bg-gradient-to-r hover:from-primary hover:to-primary-mid hover:shadow-[0_8px_20px_rgba(244,195,0,0.3)] transition-all duration-300 shadow-[0_2px_10px_rgba(0,0,0,0.02)] active:scale-95 transform hover:-translate-y-0.5">
                        <?= $tag ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Body / Chat Interface -->
        <div id="chatInterface"
            class="hidden flex-col h-[55vh] min-h-[400px] max-h-[600px] bg-slate-50/80 relative rounded-b-[32px] overflow-hidden transition-all duration-500 backdrop-blur-sm">
            <!-- Hidden element to force Tailwind CDN to generate dynamic classes -->
            <div
                class="hidden bg-gradient-to-tr from-secondary to-main-green text-slate-800 animate-[slideInRight_0.4s_ease-out_forwards] animate-[slideInLeft_0.4s_ease-out_forwards] text-white">
            </div>

            <!-- Decorative ambient glows -->
            <div
                class="absolute top-0 left-[-20%] w-96 h-96 bg-primary rounded-full mix-blend-multiply filter blur-[100px] opacity-10 pointer-events-none">
            </div>
            <div
                class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-main-green rounded-full mix-blend-multiply filter blur-[100px] opacity-10 pointer-events-none">
            </div>

            <div class="flex-1 overflow-y-auto p-8 flex flex-col scroll-smooth relative z-10" id="chatMessages">
                <!-- Chat bubbles injected here -->
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px) scale(0.98);
        }

        to {
            opacity: 1;
            transform: translateX(0) scale(1);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px) scale(0.98);
        }

        to {
            opacity: 1;
            transform: translateX(0) scale(1);
        }
    }

    /* Custom Scrollbar for Chat */
    #chatMessages::-webkit-scrollbar {
        width: 6px;
    }

    #chatMessages::-webkit-scrollbar-track {
        background: transparent;
    }

    #chatMessages::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.3);
        border-radius: 10px;
    }

    #chatMessages::-webkit-scrollbar-thumb:hover {
        background: rgba(148, 163, 184, 0.5);
    }
</style>
<script>
    function openEvaModal() {
        const modal = document.getElementById('evaModal');
        const content = document.getElementById('evaModalContent');
        const input = document.getElementById('evaSearchInput');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Small delay to allow display:flex to apply before animating opacity
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

        // Wait for animation to finish before hiding
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 300);
    }

    // Close on clicking outside
    document.getElementById('evaModal').addEventListener('click', function (e) {
        if (e.target === this) {
            closeEvaModal();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !document.getElementById('evaModal').classList.contains('hidden')) {
            closeEvaModal();
        }
    });

    // Chatbase API Integration
    let chatHistory = [];

    async function triggerChatbase(query) {
        if (!query || !query.trim()) return;

        // Hide trending, show chat
        const trendingEl = document.getElementById('trendingSearches');
        if (!trendingEl.classList.contains('hidden')) {
            trendingEl.classList.add('opacity-0');
            setTimeout(() => {
                trendingEl.classList.add('hidden');
                const chatInterface = document.getElementById('chatInterface');
                chatInterface.classList.remove('hidden');
                chatInterface.classList.add('flex');
            }, 300);
        }

        // Clear input
        document.getElementById('evaSearchInput').value = '';

        const chatContainer = document.getElementById('chatMessages');

        // Add User Bubble with premium styling
        chatContainer.insertAdjacentHTML('beforeend', `
            <div class="flex justify-end mb-8 opacity-0 animate-[slideInRight_0.4s_ease-out_forwards]">
                <div class="text-white rounded-[24px] rounded-tr-[6px] px-6 py-3.5 max-w-[80%] shadow-[0_8px_20px_rgba(26,59,27,0.25)] border border-white/10" style="background: linear-gradient(to top right, #30442C, #1A3B1B);">
                    <p class="text-[15.5px] font-normal leading-relaxed tracking-wide">${query.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</p>
                </div>
            </div>
        `);

        // Scroll to bottom immediately for user message
        setTimeout(() => chatContainer.scrollTop = chatContainer.scrollHeight, 50);

        // Add Loading Bubble
        const loaderId = 'loader_' + Date.now();
        setTimeout(() => {
            chatContainer.insertAdjacentHTML('beforeend', `
                <div id="${loaderId}" class="flex justify-start mb-8 opacity-0 animate-[slideInLeft_0.4s_ease-out_forwards]">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 mr-4 shadow-[0_4px_15px_rgba(244,195,0,0.4)] relative" style="background: linear-gradient(to top right, #F4C300, #FAE696);">
                        <span class="text-[#1A3B1B] text-[13px] font-black tracking-widest relative z-10">S</span>
                        <div class="absolute inset-0 rounded-full bg-white opacity-20 animate-ping"></div>
                    </div>
                    <div class="bg-white/90 backdrop-blur-xl border border-white/60 rounded-[24px] rounded-tl-[6px] px-7 py-5 max-w-[80%] shadow-[0_8px_30px_rgba(0,0,0,0.06)] flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full animate-bounce" style="background-color: #F4C300;"></div>
                        <div class="w-2 h-2 rounded-full animate-bounce" style="background-color: #FAE696; animation-delay: 0.15s;"></div>
                        <div class="w-2 h-2 rounded-full animate-bounce" style="background-color: #F9DC6B; animation-delay: 0.3s;"></div>
                    </div>
                </div>
            `);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }, 300);

        // Add to history
        chatHistory.push({ role: 'user', content: query });

        try {
            const response = await fetch(`http://localhost/mosil-new/ajax/chatbase.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ messages: chatHistory })
            });

            const data = await response.json();

            // Remove Loader
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
        }
    }

    function appendSaraResponse(text) {
        // Convert basic markdown to HTML for demo purposes
        let formattedText = text
            .replace(/\*\*(.*?)\*\*/g, '<strong class="font-bold text-slate-800">$1</strong>')
            .replace(/\n/g, '<br>')
            .replace(/`(.*?)`/g, '<code class="bg-slate-100 text-pink-600 px-1.5 py-0.5 rounded text-[13px] font-mono">$1</code>');

        const chatContainer = document.getElementById('chatMessages');
        chatContainer.insertAdjacentHTML('beforeend', `
            <div class="flex justify-start mb-8 opacity-0 animate-[slideInLeft_0.4s_ease-out_forwards]">
                <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 mr-4 shadow-[0_4px_15px_rgba(244,195,0,0.4)] relative" style="background: linear-gradient(to top right, #F4C300, #FAE696);">
                    <span class="text-[#1A3B1B] text-[13px] font-black tracking-widest relative z-10">S</span>
                </div>
                <div class="bg-white/95 backdrop-blur-xl border border-white/60 text-slate-700 rounded-[24px] rounded-tl-[6px] px-6 py-4 max-w-[82%] shadow-[0_8px_30px_rgba(0,0,0,0.06)] text-[15.5px] leading-relaxed font-light tracking-wide">
                    ${formattedText}
                </div>
            </div>
        `);
        setTimeout(() => chatContainer.scrollTop = chatContainer.scrollHeight, 50);
    }
</script>

<!-- Chatbot Trigger Script -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Find all the clickable button areas
        const buttons = document.querySelectorAll('.ai-trigger');

        buttons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();

                // Common logic to open Chatbase chatbot
                const chatbaseBubble = document.getElementById('chatbase-bubble-button') || document.querySelector('.chatbase-bubble-button');

                if (chatbaseBubble) {
                    // Trigger click if the bubble is found in the DOM
                    chatbaseBubble.click();
                } else if (window.chatbase) {
                    // Alternative: use Chatbase JS API if available
                    window.chatbase('open');
                } else {
                    // Fallback for the demo page if Chatbase isn't embedded here yet
                    console.log('Chatbase bot triggered!');
                    alert('Chatbot triggered! (The Chatbase widget will open here once it is loaded on the live site)');
                }
            });
        });
    });
</script>