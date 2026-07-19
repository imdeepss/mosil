<?php
// demo-ai-buttons.php
$pageTitle = "Ultra-Premium AI Triggers - MOSIL";
?>
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {}
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

            <div class="relative hidden w-[520px] md:block group">
                <button type="button" 
                    class="cursor-pointer ai-trigger h-10 w-full rounded-full border border-white/20 bg-white/5 backdrop-blur-sm px-6 flex items-center justify-center gap-3 text-[13px] text-white/80 hover:text-white hover:bg-white/10 hover:border-white/40 transition-all duration-300 shadow-[0_0_15px_rgba(255,255,255,0.02)] hover:shadow-[0_0_20px_rgba(255,255,255,0.08)]">
                    <img src="<?php echo defined('SITE_URL') ? SITE_URL : ''; ?>/assets/icons/png/search.png" alt="Search"
                        class="w-4 h-4 opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                    <span class="truncate font-light tracking-wide">To choose the right lubricant & multiply performance? <strong class="font-medium text-white">Ask Sara.</strong></span>
                </button>
            </div>

            <div class="relative md:hidden h-8 w-8 block cursor-pointer transition-opacity duration-300"
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

<div class="pt-[100px] pb-20 bg-[#070707] min-h-screen text-white font-sans selection:bg-white/20">
    <div class="container mx-auto px-4 max-w-5xl">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 text-center text-white tracking-tight">Ultra-Premium AI
            Triggers</h1>
        <p class="text-white/40 text-center mb-16 text-lg max-w-2xl mx-auto font-light">Sophisticated, luxury-grade, and
            highly creative designs. Hover to experience the micro-animations.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-12">

            <!-- 1. Obsidian Glass -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-white/30 mb-2">1. Obsidian
                    Glass</span>
                <div class="relative w-max cursor-pointer ai-trigger group">
                    <div
                        class="absolute inset-0 bg-white/5 rounded-full blur-md opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                    </div>
                    <div
                        class="relative h-12 px-8 bg-[#0a0a0a] border border-white/10 rounded-full flex items-center justify-center backdrop-blur-xl group-hover:border-white/30 transition-all duration-500 shadow-[inset_0_1px_1px_rgba(255,255,255,0.05)]">
                        <span
                            class="text-white/70 group-hover:text-white font-light tracking-[0.15em] text-sm transition-colors duration-500">Sarah
                            ko sara pata hai</span>
                    </div>
                </div>
            </div>

            <!-- 2. Gold Foil -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#D4AF37]/50 mb-2">2. Gold
                    Foil</span>
                <div class="relative w-max cursor-pointer ai-trigger group overflow-hidden rounded-full">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-transparent via-[rgba(212,175,55,0.4)] to-transparent translate-x-[-150%] group-hover:translate-x-[150%] transition-transform duration-[1.5s] ease-in-out">
                    </div>
                    <div
                        class="relative h-12 px-8 bg-[#050505] border border-[#D4AF37]/30 rounded-full flex items-center justify-center group-hover:border-[#D4AF37] transition-colors duration-500">
                        <span
                            class="text-[#D4AF37] font-serif italic tracking-widest text-sm group-hover:brightness-125 transition-all duration-500">Why
                            search? Chatbot knows all</span>
                    </div>
                </div>
            </div>

            <!-- 3. Frostbite -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-white/40 mb-2">3. Frostbite</span>
                <div class="relative w-max cursor-pointer ai-trigger group">
                    <div
                        class="h-12 px-8 bg-white/5 border border-white/20 rounded-full flex items-center justify-center backdrop-blur-2xl group-hover:bg-white/10 transition-all duration-500 shadow-[0_8px_32px_rgba(255,255,255,0.05)] hover:shadow-[0_8px_32px_rgba(255,255,255,0.1)]">
                        <div
                            class="w-1.5 h-1.5 rounded-full bg-white/50 group-hover:bg-white transition-colors duration-500 mr-3 shadow-[0_0_5px_rgba(255,255,255,0.8)]">
                        </div>
                        <span
                            class="text-white/80 group-hover:text-white font-medium tracking-wider text-xs uppercase transition-colors duration-500">I
                            know things</span>
                    </div>
                </div>
            </div>

            <!-- 4. Cyber-Titanium -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-cyan-500/50 mb-2">4.
                    Cyber-Titanium</span>
                <div class="relative w-max cursor-pointer ai-trigger group">
                    <div
                        class="h-12 px-8 bg-gradient-to-b from-[#2a2a2a] to-[#1a1a1a] rounded-sm border border-[#333] flex items-center justify-center relative overflow-hidden group-hover:border-[#444] transition-colors duration-300 shadow-[inset_0_1px_0_rgba(255,255,255,0.1)]">
                        <div
                            class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-cyan-500 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                        <span
                            class="text-[#aaa] group-hover:text-cyan-400 font-mono text-xs tracking-[0.2em] transition-colors duration-500 uppercase">ChatGPT's
                            cooler cousin</span>
                    </div>
                </div>
            </div>

            <!-- 5. Midnight Velvet -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#a875d9]/50 mb-2">5. Midnight
                    Velvet</span>
                <div class="relative w-max cursor-pointer ai-trigger group">
                    <div
                        class="absolute inset-0 bg-[#1e0a2d] rounded-full blur-xl opacity-0 group-hover:opacity-60 transition-opacity duration-700">
                    </div>
                    <div
                        class="relative h-12 px-8 bg-[#0f0518] border border-[#2a0d45] rounded-full flex items-center justify-center group-hover:border-[#4a157a] transition-colors duration-500 shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)]">
                        <span
                            class="text-[#a875d9] group-hover:text-[#d3a5ff] font-light tracking-[0.3em] text-xs uppercase transition-colors duration-500">Smarter
                            than your boss</span>
                    </div>
                </div>
            </div>

            <!-- 6. Aurora Borealis -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-emerald-500/50 mb-2">6. Aurora
                    Borealis</span>
                <div class="relative w-max cursor-pointer ai-trigger group rounded-full p-[1px] overflow-hidden">
                    <div
                        class="absolute inset-[-50%] bg-[conic-gradient(from_0deg,transparent,theme(colors.emerald.500),theme(colors.purple.500),transparent)] opacity-20 group-hover:opacity-100 group-hover:animate-slow-spin transition-opacity duration-700">
                    </div>
                    <div
                        class="relative h-12 px-8 bg-[#050505] rounded-full flex items-center justify-center group-hover:bg-black transition-colors duration-500">
                        <span
                            class="text-white/60 group-hover:text-white font-light tracking-widest text-sm transition-colors duration-500">Speak
                            to the machine</span>
                    </div>
                </div>
            </div>

            <!-- 7. Phantom Outline -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-white/30 mb-2">7. Phantom
                    Outline</span>
                <div class="relative w-max cursor-pointer ai-trigger group">
                    <div
                        class="absolute inset-0 border border-white/0 group-hover:border-white/40 rounded-full transition-all duration-700 scale-95 group-hover:scale-100">
                    </div>
                    <div class="h-12 px-8 flex items-center justify-center">
                        <span
                            class="text-white/50 group-hover:text-white font-medium tracking-[0.2em] text-xs uppercase transition-colors duration-700">Omniscient
                            AI</span>
                    </div>
                </div>
            </div>

            <!-- 8. Prismatic Crystal -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-rose-300/50 mb-2">8. Prismatic
                    Crystal</span>
                <div class="relative w-max cursor-pointer ai-trigger group">
                    <div
                        class="h-12 px-8 bg-white/[0.02] border border-white/5 rounded-2xl flex items-center justify-center backdrop-blur-3xl group-hover:bg-white/[0.04] group-hover:border-white/20 transition-all duration-500 shadow-[0_0_15px_rgba(255,255,255,0.02)] group-hover:shadow-[0_0_25px_rgba(255,255,255,0.05)] relative overflow-hidden">
                        <div
                            class="absolute inset-0 bg-gradient-to-tr from-rose-500/10 via-transparent to-cyan-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                        </div>
                        <span
                            class="text-slate-300 group-hover:text-white font-light tracking-wide text-sm relative z-10 transition-colors duration-500">Magic
                            button of knowledge</span>
                    </div>
                </div>
            </div>

            <!-- 9. Onyx & Chrome -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-zinc-400 mb-2">9. Onyx &
                    Chrome</span>
                <div class="relative w-max cursor-pointer ai-trigger group">
                    <div
                        class="h-12 px-8 bg-black border border-[#222] rounded-full flex items-center justify-center relative overflow-hidden group-hover:border-[#555] transition-colors duration-500 shadow-[0_10px_20px_rgba(0,0,0,0.8)]">
                        <div
                            class="absolute top-0 left-[10%] right-[10%] h-[1px] bg-gradient-to-r from-transparent via-white/50 to-transparent">
                        </div>
                        <span
                            class="text-zinc-400 group-hover:text-zinc-100 font-bold tracking-[0.2em] text-xs uppercase transition-colors duration-500">Siri
                            who?</span>
                    </div>
                </div>
            </div>

            <!-- 10. The Monolith -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-white/50 mb-2">10. The
                    Monolith</span>
                <div class="relative w-max cursor-pointer ai-trigger group">
                    <div
                        class="h-12 px-8 bg-[#111] border-l-2 border-white flex items-center justify-center group-hover:bg-white transition-colors duration-500 shadow-2xl">
                        <span
                            class="text-white group-hover:text-black font-semibold tracking-widest text-xs uppercase transition-colors duration-500">Your
                            personal Einstein</span>
                    </div>
                </div>
            </div>

            <!-- 11. Liquid Mercury -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-zinc-300/50 mb-2">11. Liquid
                    Mercury</span>
                <div class="relative w-max cursor-pointer ai-trigger group">
                    <div
                        class="h-12 px-8 bg-gradient-to-b from-zinc-700 to-zinc-900 border border-zinc-600 rounded-full flex items-center justify-center group-hover:from-zinc-300 group-hover:to-zinc-500 group-hover:border-white transition-all duration-700 shadow-[inset_0_2px_4px_rgba(255,255,255,0.1)]">
                        <span
                            class="text-zinc-300 group-hover:text-zinc-900 font-medium tracking-widest text-sm transition-colors duration-700">The
                            Oracle is listening</span>
                    </div>
                </div>
            </div>

            <!-- 12. Neon Noir -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-red-500/50 mb-2">12. Neon Noir</span>
                <div class="relative w-max cursor-pointer ai-trigger group">
                    <div
                        class="absolute inset-0 bg-red-600 rounded-full blur-lg opacity-0 group-hover:opacity-40 transition-opacity duration-700">
                    </div>
                    <div
                        class="relative h-12 px-8 bg-[#050505] border border-transparent group-hover:border-red-600/50 rounded-full flex items-center justify-center transition-all duration-500">
                        <span
                            class="text-[#444] group-hover:text-red-500 font-mono tracking-widest text-xs uppercase transition-colors duration-500 drop-shadow-[0_0_5px_rgba(220,38,38,0)] group-hover:drop-shadow-[0_0_8px_rgba(220,38,38,0.8)]">Click
                            for wisdom</span>
                    </div>
                </div>
            </div>

            <!-- 13. Diamond Cut -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-white/50 mb-2">13. Diamond Cut</span>
                <div class="relative w-max cursor-pointer ai-trigger group">
                    <div
                        class="h-12 px-8 bg-[#0a0a0a] border-t border-l border-white/20 border-b border-r border-white/5 flex items-center justify-center group-hover:border-t-white/40 group-hover:border-l-white/40 transition-colors duration-500 shadow-[inset_1px_1px_0_rgba(255,255,255,0.1),_2px_2px_10px_rgba(0,0,0,0.8)]">
                        <span
                            class="text-white/80 group-hover:text-white font-medium tracking-[0.2em] text-xs uppercase transition-colors duration-500">I
                            got 99 answers</span>
                    </div>
                </div>
            </div>

            <!-- 14. Velvet Copper -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#b87333]/70 mb-2">14. Velvet
                    Copper</span>
                <div class="relative w-max cursor-pointer ai-trigger group">
                    <div
                        class="h-12 px-8 bg-[#030303] border-b-2 border-[#b87333]/40 rounded-t-sm flex items-center justify-center group-hover:border-[#b87333] transition-colors duration-700 shadow-[0_10px_20px_-10px_rgba(184,115,51,0)] group-hover:shadow-[0_10px_20px_-10px_rgba(184,115,51,0.4)]">
                        <span
                            class="text-[#b87333]/80 group-hover:text-[#b87333] font-serif italic tracking-[0.1em] text-sm transition-colors duration-500">Omniscient
                            AI</span>
                    </div>
                </div>
            </div>

            <!-- 15. Holographic Chrome -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-zinc-300/50 mb-2">15. Holographic
                    Chrome</span>
                <div class="relative w-max cursor-pointer ai-trigger group">
                    <div
                        class="h-12 px-8 bg-gradient-to-r from-zinc-800 via-zinc-400 to-zinc-800 rounded-full p-[1px] group-hover:from-red-400 group-hover:via-green-400 group-hover:to-blue-400 transition-colors duration-1000">
                        <div class="h-full w-full bg-[#111] rounded-full flex items-center justify-center">
                            <span
                                class="text-zinc-400 group-hover:text-white font-medium tracking-[0.2em] text-xs uppercase transition-colors duration-500">Just
                                ask already</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 16. Zen Garden -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-white/50 mb-2">16. Zen Garden</span>
                <div class="relative w-max cursor-pointer ai-trigger group flex flex-col items-center justify-center h-12">
                    <span
                        class="text-white/60 group-hover:text-white font-light tracking-[0.3em] text-[11px] uppercase transition-colors duration-700 mb-2">Tap
                        for infinite IQ</span>
                    <div class="w-1 h-1 bg-white rounded-full group-hover:w-full transition-all duration-700 ease-out">
                    </div>
                </div>
            </div>

            <!-- 17. Abyss Glow -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-blue-500/50 mb-2">17. Abyss
                    Glow</span>
                <div class="relative w-max cursor-pointer ai-trigger group">
                    <div
                        class="absolute inset-0 bg-[#001020] rounded-full blur-md opacity-0 group-hover:opacity-100 transition-opacity duration-1000">
                    </div>
                    <div
                        class="relative h-12 px-8 bg-[#00050a] border border-[#001530] rounded-full flex items-center justify-center group-hover:border-[#003060] transition-colors duration-1000 shadow-[inset_0_0_15px_rgba(0,10,20,1)] group-hover:shadow-[inset_0_0_20px_rgba(0,40,80,0.5)]">
                        <span
                            class="text-[#306090] group-hover:text-[#60a0e0] font-medium tracking-[0.2em] text-xs uppercase transition-colors duration-1000">Stop
                            typing, start asking</span>
                    </div>
                </div>
            </div>

            <!-- 18. The Ghost -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-white/20 mb-2">18. The Ghost</span>
                <div class="relative w-max cursor-pointer ai-trigger group">
                    <div
                        class="absolute inset-0 bg-white/5 backdrop-blur-sm rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                    </div>
                    <div class="relative h-12 px-8 flex items-center justify-center">
                        <span
                            class="text-white/30 group-hover:text-white font-light tracking-[0.4em] text-xs uppercase transition-colors duration-700">Wisdom
                            dispenser</span>
                    </div>
                </div>
            </div>

            <!-- 19. Molten Amber -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-amber-500/50 mb-2">19. Molten
                    Amber</span>
                <div class="relative w-max cursor-pointer ai-trigger group overflow-hidden rounded-full">
                    <div
                        class="absolute bottom-0 left-0 w-full h-0 bg-gradient-to-t from-amber-600/40 to-transparent group-hover:h-full transition-all duration-700 ease-out">
                    </div>
                    <div
                        class="relative h-12 px-8 bg-[#0a0500] border border-amber-900/50 rounded-full flex items-center justify-center group-hover:border-amber-600/80 transition-colors duration-700">
                        <span
                            class="text-amber-700/80 group-hover:text-amber-400 font-serif italic tracking-[0.15em] text-sm transition-colors duration-700">I
                            know your secrets</span>
                    </div>
                </div>
            </div>

            <!-- 20. Ceramic White -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-white/80 mb-2">20. Ceramic
                    White</span>
                <div class="relative w-max cursor-pointer ai-trigger group">
                    <div
                        class="h-12 px-8 bg-[#f5f5f5] rounded-full flex items-center justify-center shadow-[inset_0_-2px_5px_rgba(0,0,0,0.1),_0_5px_15px_rgba(255,255,255,0.05)] group-hover:bg-white transition-colors duration-500">
                        <span
                            class="text-[#222] font-black tracking-widest text-xs uppercase opacity-80 group-hover:opacity-100 transition-opacity duration-500 shadow-sm"
                            style="text-shadow: 0 1px 1px rgba(255,255,255,0.8);">Feed me questions</span>
                    </div>
                </div>
            </div>

            <!-- 21. Laser Engraved -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-cyan-400/50 mb-2">21. Laser
                    Engraved</span>
                <div class="relative w-max cursor-pointer ai-trigger group">
                    <div
                        class="h-12 px-8 bg-[#111] rounded-sm flex items-center justify-center shadow-[inset_0_2px_4px_rgba(0,0,0,1)] border border-[#222] group-hover:border-[#333] transition-colors duration-500">
                        <span
                            class="text-[#050505] group-hover:text-cyan-400 font-mono tracking-[0.2em] text-[11px] uppercase transition-colors duration-[1.5s] ease-in-out"
                            style="text-shadow: 0 -1px 1px rgba(255,255,255,0.1);">Google is so 2010</span>
                    </div>
                </div>
            </div>

            <!-- 22. Crimson Silk -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-red-500/50 mb-2">22. Crimson
                    Silk</span>
                <div class="relative w-max cursor-pointer ai-trigger group">
                    <div
                        class="h-12 px-8 bg-black rounded-full flex items-center justify-center overflow-hidden border border-[#1a0505]">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-transparent via-red-900/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-[2s] ease-in-out">
                        </div>
                        <span
                            class="text-[#5a1a1a] group-hover:text-red-500 font-serif italic tracking-[0.2em] text-sm transition-colors duration-[2s]">The
                            Oracle is listening</span>
                    </div>
                </div>
            </div>

            <!-- 23. Stealth Bomber -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-zinc-500 mb-2">23. Stealth
                    Bomber</span>
                <div class="relative w-max cursor-pointer ai-trigger group">
                    <div
                        class="h-12 px-8 bg-[#181818] border border-t-[#222] border-b-[#050505] border-x-[#111] flex items-center justify-center transform group-hover:scale-[0.98] transition-transform duration-300">
                        <span
                            class="text-[#444] group-hover:text-white font-bold tracking-[0.25em] text-[10px] uppercase transition-colors duration-300">Unleash
                            the bot</span>
                    </div>
                </div>
            </div>

            <!-- 24. Aura Glass -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-fuchsia-500/50 mb-2">24. Aura
                    Glass</span>
                <div class="relative w-max cursor-pointer ai-trigger group overflow-hidden rounded-full">
                    <div
                        class="absolute -inset-8 bg-gradient-to-r from-fuchsia-500 via-cyan-500 to-fuchsia-500 blur-xl opacity-0 group-hover:opacity-30 group-hover:animate-slow-spin transition-opacity duration-1000">
                    </div>
                    <div
                        class="relative h-12 px-8 bg-white/5 border border-white/10 rounded-full flex items-center justify-center backdrop-blur-2xl">
                        <span
                            class="text-white/60 group-hover:text-white font-medium tracking-[0.15em] text-xs uppercase transition-colors duration-500">I'm
                            literally a genius</span>
                    </div>
                </div>
            </div>
            <!-- 25. Liquid Morph (Classic) -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-teal-400 mb-2">25. Liquid
                    Morph</span>
                <div class="relative h-10 w-max px-6 cursor-pointer ai-trigger group flex items-center justify-center bg-teal-500 hover:bg-teal-400 transition-all duration-500 ease-in-out"
                    style="border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;"
                    onmouseover="this.style.borderRadius='30% 70% 70% 30% / 30% 30% 70% 70%'"
                    onmouseout="this.style.borderRadius='60% 40% 30% 70% / 60% 30% 70% 40%'">
                    <span class="text-white font-bold tracking-widest drop-shadow-md whitespace-nowrap text-sm">Ask the
                        magic 8 ball</span>
                </div>
            </div>

            <!-- 26. Bubble Gum (Classic) -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-pink-400 mb-2">26. Bubble Gum</span>
                <div
                    class="relative h-12 w-max px-8 cursor-pointer ai-trigger group bg-pink-500 hover:bg-pink-400 rounded-full flex items-center justify-center hover:-translate-y-2 hover:scale-105 active:scale-95 transition-all duration-300 shadow-[0_5px_0_rgb(219,39,119)] hover:shadow-[0_8px_0_rgb(219,39,119),0_15px_20px_rgba(236,72,153,0.4)] active:shadow-[0_0px_0_rgb(219,39,119)] active:translate-y-1">
                    <span class="text-white font-extrabold tracking-wider text-lg whitespace-nowrap">I got 99
                        answers</span>
                </div>
            </div>

            <!-- 27. Retro Arcade (Classic) -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-red-500 mb-2">27. Retro Arcade</span>
                <div
                    class="relative cursor-pointer ai-trigger group border-4 border-red-500 bg-black hover:bg-red-500 transition-colors duration-150 px-6 py-2 w-max">
                    <span
                        class="text-red-500 group-hover:text-black font-mono font-bold tracking-[0.3em] uppercase whitespace-nowrap">AI-cadabra!</span>
                    <div
                        class="absolute -inset-1 border-2 border-red-500/30 group-hover:animate-ping opacity-0 group-hover:opacity-100">
                    </div>
                </div>
            </div>

            <!-- 28. Chat Bubble (Classic) -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-yellow-300 mb-2">28. Chat
                    Bubble</span>
                <div
                    class="relative h-10 w-max px-6 cursor-pointer ai-trigger group hover:-translate-y-1 transition-transform duration-300">
                    <div
                        class="absolute -bottom-2 right-4 w-4 h-4 bg-yellow-400 rotate-45 group-hover:bg-yellow-300 transition-colors duration-300 shadow-[2px_2px_5px_rgba(250,204,21,0.5)]">
                    </div>
                    <div
                        class="relative h-full w-full bg-gradient-to-r from-yellow-500 to-yellow-400 group-hover:from-yellow-400 group-hover:to-yellow-300 rounded-2xl shadow-[0_5px_15px_rgba(234,179,8,0.4)] flex items-center justify-center transition-colors duration-300">
                        <svg class="w-4 h-4 text-yellow-900 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-bold text-yellow-900 whitespace-nowrap">ChatGPT's cooler cousin</span>
                    </div>
                </div>
            </div>

            <!-- 29. Prismatic Rainbow (Classic) -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-pink-300 mb-2">29. Prismatic
                    Rainbow</span>
                <div
                    class="relative h-10 w-max px-6 cursor-pointer ai-trigger group bg-zinc-900 rounded-full flex items-center justify-center border border-white/10 overflow-hidden hover:border-white/30 transition-colors">
                    <div
                        class="absolute inset-0 opacity-20 group-hover:opacity-100 bg-[linear-gradient(90deg,red,orange,yellow,green,blue,indigo,violet,red)] bg-[length:200%_100%] animate-[pan_3s_linear_infinite] transition-opacity duration-500">
                    </div>
                    <div class="absolute inset-[1px] bg-zinc-900 rounded-full"></div>
                    <span
                        class="relative z-10 font-bold tracking-widest text-transparent bg-clip-text bg-[linear-gradient(90deg,red,orange,yellow,green,blue,indigo,violet,red)] bg-[length:200%_100%] animate-[pan_3s_linear_infinite] group-hover:brightness-150 transition-all whitespace-nowrap text-xs">Stop
                        typing, start asking</span>
                </div>
                <style>
                    @keyframes pan {
                        to {
                            background-position: -200% center;
                        }
                    }
                </style>
            </div>

            <!-- 30. Typewriter Tape (Classic) -->
            <div
                class="flex flex-col items-center gap-4 p-8 rounded-2xl bg-white/[0.01] border border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-400 mb-2">30. Typewriter
                    Tape</span>
                <div
                    class="relative cursor-pointer ai-trigger group bg-[#e8e8e8] px-6 py-1.5 rotate-[-2deg] hover:rotate-0 transition-transform duration-300 shadow-[2px_2px_4px_rgba(0,0,0,0.5)] w-max">
                    <span
                        class="text-black font-mono font-bold tracking-widest uppercase text-sm border-b border-black/30 pb-0.5 group-hover:border-black transition-colors whitespace-nowrap">Summons
                        the AI</span>
                </div>
            </div>

        </div>
    </div>
</div>

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