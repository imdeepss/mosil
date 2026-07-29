<?php
/**
 * Master Dynamic Landing Page Template - MOSIL Brand Masterwork Edition
 * MOSIL Lubricants Pvt. Ltd. - Cost Per Component (CPC) Landing Page
 */

if (!isset($landingData) || empty($landingData)) {
    echo "<div class='container mx-auto py-20 text-center'><h2 class='text-2xl font-bold text-slate-800'>Landing page data not found.</h2></div>";
    return;
}

// Safely extract sections with fallbacks
$id = $landingData['id'] ?? 'cost-per-component';
$seo = $landingData['seo'] ?? [];
$hero = $landingData['hero'] ?? [];
$levers = $landingData['levers'] ?? [];
$trust = $landingData['trust'] ?? [];
$form = $landingData['form'] ?? [];
$approach = $landingData['approach'] ?? [];
$proof = $landingData['proof'] ?? [];
$process = $landingData['process'] ?? [];
$faq = $landingData['faq'] ?? [];

$isNoIndex = !empty($seo['noindex']);
?>

<?php if ($isNoIndex): ?>
    <meta name="robots" content="noindex, nofollow">
<?php endif; ?>

<!-- Tailwind CSS Engine Injector with Official MOSIL Brand System Tokens -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          mainGreen: '#1A3B1B',
          mosilGreen: '#1A3B1B',
          mosilGreenDark: '#0D2010',
          mosilGreenDeep: '#07140A',
          mosilGold: '#F4C300',
          mosilGoldHover: '#E0B200',
          mosilGoldLight: '#FEF9E6',
          mosilSecondary: '#30442C',
        },
        fontFamily: {
          sans: ['Inter', 'Plus Jakarta Sans', 'system-ui', '-apple-system', 'sans-serif'],
          mono: ['JetBrains Mono', 'Fira Code', 'monospace'],
        },
        keyframes: {
          glowPulse: {
            '0%, 100%': { opacity: '0.4', transform: 'scale(1)' },
            '50%': { opacity: '0.8', transform: 'scale(1.05)' },
          }
        },
        animation: {
          'glow-pulse': 'glowPulse 6s ease-in-out infinite',
        }
      }
    }
  }
</script>

<div class="bg-slate-50 text-slate-900 font-sans antialiased selection:bg-mosilGold selection:text-mosilGreenDeep">

    <!-- ================================================== -->
    <!-- STICKY GLASSMORPHIC HEADER NAVIGATION (MOSIL Brand)-->
    <!-- ================================================== -->
    <nav class="sticky top-0 z-50 backdrop-blur-xl bg-mosilGreenDeep/95 border-b border-mosilGreen/40 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            
            <!-- Brand Badge & Live NABL Indicator -->
            <a href="#hero" class="flex items-center gap-3 group">
                <div class="w-8 h-8 rounded-xl bg-mosilGold text-mosilGreenDeep font-extrabold flex items-center justify-center text-sm shadow-md group-hover:scale-105 transition-transform">
                    M
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-white text-sm tracking-tight leading-none group-hover:text-mosilGold transition-colors">MOSIL CPC</span>
                    <span class="text-[10px] text-slate-400 font-mono tracking-wider">COST PER COMPONENT</span>
                </div>
            </a>

            <!-- Center Navigation Anchor Links (Desktop) -->
            <div class="hidden lg:flex items-center gap-8 text-xs font-semibold text-slate-300">
                <a href="#cost-levers" class="hover:text-mosilGold transition-colors">Value Levers</a>
                <a href="#spec-trust" class="hover:text-mosilGold transition-colors">OEM Specs</a>
                <a href="#cpc-form" class="hover:text-mosilGold transition-colors">Diagnostic Check</a>
                <a href="#approach" class="hover:text-mosilGold transition-colors">Methodology</a>
                <a href="#proof-lab" class="hover:text-mosilGold transition-colors">TriboIntel™ Lab</a>
                <a href="#faq-section" class="hover:text-mosilGold transition-colors">FAQ</a>
            </div>

            <!-- Right Live Pulse & CTA Button -->
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-2 px-3 py-1 rounded-full bg-mosilGreenDark border border-mosilGreen/60 text-[11px] font-mono text-slate-300">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span>NABL Accredited</span>
                </div>

                <a href="#cpc-form" class="bg-mosilGold hover:bg-mosilGoldHover text-mosilGreenDeep font-bold px-4 sm:px-5 py-2 rounded-xl text-xs sm:text-sm shadow-lg shadow-mosilGold/20 hover:shadow-[0_0_30px_rgba(244,195,0,0.4)] hover:-translate-y-0.5 transition-all inline-flex items-center gap-1.5">
                    <span>Start CPC Check</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

        </div>
    </nav>

    <!-- ================================================== -->
    <!-- SECTION 1: HERO / BANNER — MOSIL Deep Green Canvas -->
    <!-- ================================================== -->
    <?php if (!empty($hero['headline'])): ?>
        <?php 
            $heroImg = !empty($hero['image']) ? $hero['image'] : 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=1200&q=80';
            $heroAlt = !empty($hero['image_alt']) ? $hero['image_alt'] : 'Precision Automotive Component Grease Application';
            $heroPos = $hero['image_position'] ?? 'right';
        ?>
    <header id="hero" class="bg-mosilGreenDeep text-white pt-20 pb-24 px-4 sm:px-6 relative overflow-hidden border-b border-mosilGreen/40">
        
        <!-- Ambient Grid Background Pattern & Floating MOSIL Gold Light Blobs -->
        <div class="absolute inset-0 bg-[radial-gradient(#1A3B1B_1px,transparent_1px)] [background-size:32px_32px] opacity-40 pointer-events-none"></div>
        <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[900px] h-[400px] bg-mosilGold/15 blur-[160px] rounded-full pointer-events-none animate-glow-pulse"></div>
        <div class="absolute bottom-0 right-10 w-[500px] h-[300px] bg-mosilGreen/40 blur-[140px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            
            <?php if ($heroPos === 'background'): ?>
                <!-- Hero Full Background Banner Layout -->
                <div class="relative rounded-3xl overflow-hidden border border-white/10 p-8 sm:p-14 text-center max-w-4xl mx-auto bg-cover bg-center shadow-2xl" style="background-image: linear-gradient(to bottom, rgba(7,20,10,0.85), rgba(7,20,10,0.95)), url('<?php echo htmlspecialchars($heroImg); ?>');">
                    <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-mosilGreen/80 border border-mosilGold/30 shadow-md mb-6">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-mosilGold opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-mosilGold"></span>
                        </span>
                        <span class="font-mono text-xs font-bold uppercase tracking-widest text-mosilGold">
                            AUTOMOTIVE COMPONENT LUBRICATION
                        </span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-[1.12] mb-6">
                        The grease you apply on the component is a line item in your cost per component. <span class="text-transparent bg-clip-text bg-gradient-to-r from-mosilGold via-amber-300 to-mosilGold">When did you last challenge it?</span>
                    </h1>

                    <?php if (!empty($hero['sub_headline'])): ?>
                        <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl mx-auto mb-8 font-normal">
                            <?php echo htmlspecialchars($hero['sub_headline']); ?>
                        </p>
                    <?php endif; ?>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="#cpc-form" class="bg-mosilGold hover:bg-mosilGoldHover text-mosilGreenDeep font-bold px-8 py-4 rounded-xl shadow-lg shadow-mosilGold/20 hover:shadow-[0_0_30px_rgba(244,195,0,0.4)] hover:-translate-y-0.5 transition-all flex items-center gap-3 text-base sm:text-lg group">
                            <span><?php echo htmlspecialchars($hero['cta_text'] ?? 'Start the CPC Check — 5 minutes'); ?></span>
                            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                    <div class="text-xs sm:text-sm text-slate-400 flex items-center justify-center gap-2 pt-4">
                        <svg class="w-4 h-4 text-mosilGold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <span>5-min diagnostic • Engineer-led revert • Confidential assessment</span>
                    </div>
                </div>

            <?php else: ?>
                <!-- Hero 2-Column Asymmetric Bento Grid (Right vs Left Image) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center <?php echo $heroPos === 'left' ? 'lg:flex-row-reverse' : ''; ?>">
                    
                    <!-- Left Column: Text & CTAs -->
                    <div class="lg:col-span-7 space-y-6 text-left <?php echo $heroPos === 'left' ? 'lg:order-2' : ''; ?>">
                        
                        <!-- Floating Pulsing Eyebrow Badge -->
                        <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-mosilGreenDark border border-mosilGreen/60 shadow-md">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-mosilGold opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-mosilGold"></span>
                            </span>
                            <span class="font-mono text-xs font-bold uppercase tracking-widest text-mosilGold">
                                AUTOMOTIVE COMPONENT LUBRICATION
                            </span>
                        </div>

                        <!-- Kinetic Headline (H1) -->
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-[1.12]">
                            The grease you apply on the component is a line item in your cost per component. <span class="text-transparent bg-clip-text bg-gradient-to-r from-mosilGold via-amber-300 to-mosilGold">When did you last challenge it?</span>
                        </h1>

                        <!-- Subheadline -->
                        <?php if (!empty($hero['sub_headline'])): ?>
                            <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl font-normal">
                                <?php echo htmlspecialchars($hero['sub_headline']); ?>
                            </p>
                        <?php endif; ?>

                        <!-- Primary Action CTA -->
                        <div class="pt-2 space-y-3">
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                                <a href="#cpc-form" class="bg-mosilGold hover:bg-mosilGoldHover text-mosilGreenDeep font-bold px-8 py-4 rounded-xl shadow-lg shadow-mosilGold/20 hover:shadow-[0_0_30px_rgba(244,195,0,0.4)] hover:-translate-y-0.5 transition-all flex items-center justify-center gap-3 text-base sm:text-lg group">
                                    <span><?php echo htmlspecialchars($hero['cta_text'] ?? 'Start the CPC Check — 5 minutes'); ?></span>
                                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>

                            <!-- Micro-copy Badge Below CTA -->
                            <div class="text-xs sm:text-sm text-slate-400 flex items-center gap-2 pt-1">
                                <svg class="w-4 h-4 text-mosilGold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                <span>5-min diagnostic • Engineer-led revert • Confidential assessment</span>
                            </div>
                        </div>

                        <!-- KPI Bar (3 Metric Counters) -->
                        <div class="pt-6 border-t border-mosilGreen/50 grid grid-cols-3 gap-4 max-w-lg">
                            <div class="p-3.5 bg-mosilGreenDark/80 rounded-xl border border-mosilGreen/60 shadow">
                                <div class="font-mono text-xl sm:text-2xl font-extrabold text-mosilGold">100%</div>
                                <div class="text-[11px] sm:text-xs text-slate-400 font-medium">OEM Spec Compliant</div>
                            </div>
                            <div class="p-3.5 bg-mosilGreenDark/80 rounded-xl border border-mosilGreen/60 shadow">
                                <div class="font-mono text-xl sm:text-2xl font-extrabold text-emerald-400">0 Days</div>
                                <div class="text-[11px] sm:text-xs text-slate-400 font-medium">Import Duty Delays</div>
                            </div>
                            <div class="p-3.5 bg-mosilGreenDark/80 rounded-xl border border-mosilGreen/60 shadow">
                                <div class="font-mono text-xl sm:text-2xl font-extrabold text-white">40+ Yrs</div>
                                <div class="text-[11px] sm:text-xs text-slate-400 font-medium">Indian Industry Trust</div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Interactive 3D Card Viewport -->
                    <div class="lg:col-span-5 relative <?php echo $heroPos === 'left' ? 'lg:order-1' : ''; ?>">
                        <div class="relative rounded-3xl overflow-hidden border border-mosilGreen/60 shadow-2xl bg-mosilGreenDark aspect-[4/3] group">
                            <img src="<?php echo htmlspecialchars($heroImg); ?>" alt="<?php echo htmlspecialchars($heroAlt); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-mosilGreenDeep via-mosilGreenDeep/40 to-transparent"></div>

                            <!-- Floating Glassmorphic Badge overlaid at bottom corner -->
                            <div class="absolute bottom-4 left-4 right-4 backdrop-blur-md bg-mosilGreenDeep/90 border border-white/10 p-4 rounded-2xl shadow-2xl text-xs text-slate-200 flex items-center gap-3.5">
                                <div class="w-9 h-9 rounded-xl bg-mosilGold/20 border border-mosilGold/40 text-mosilGold flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <div class="font-bold text-white uppercase tracking-wide">TriboIntel™ Validated</div>
                                    <div class="text-slate-400">Formulated against OEM spec, not brand names.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            <?php endif; ?>

        </div>
    </header>
    <?php endif; ?>

    <!-- ================================================== -->
    <!-- SECTION 2: COST LEVERS — Modern 3-Card Grid        -->
    <!-- ================================================== -->
    <?php if (!empty($levers['formula']) || (!empty($levers['items']) && count($levers['items']) > 0)): ?>
    <section id="cost-levers" class="bg-slate-50 py-20 px-4 sm:px-6 border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto">
            
            <div class="text-center max-w-3xl mx-auto mb-3">
                <span class="font-mono text-xs font-bold uppercase tracking-widest text-mosilGreen bg-mosilGreen/10 px-3.5 py-1 rounded-full border border-mosilGreen/20">CPC ARITHMETIC</span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mt-3 mb-2 tracking-tight">
                    <?php echo htmlspecialchars($levers['intro_1'] ?? 'Where the Grease Cost Actually Sits'); ?>
                </h2>
                <?php if (!empty($levers['intro_2'])): ?>
                    <p class="text-slate-600 text-base sm:text-lg leading-relaxed">
                        <?php echo htmlspecialchars($levers['intro_2']); ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Dynamic Monospaced Formula Band Card -->
            <?php if (!empty($levers['formula'])): ?>
            <div class="max-w-3xl mx-auto my-8 p-6 sm:p-8 bg-mosilGreenDeep rounded-2xl border-l-4 border-mosilGold border border-mosilGreen/40 shadow-2xl text-mosilGold font-mono text-sm sm:text-base md:text-lg leading-relaxed text-center overflow-x-auto relative group">
                <span class="text-xs uppercase tracking-widest text-slate-400 font-sans block mb-2">Cost Per Component Equation</span>
                <div class="font-mono font-bold tracking-tight">
                    <?php echo htmlspecialchars($levers['formula']); ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- 3-Card Grid for Value Levers -->
            <?php if (!empty($levers['items']) && count($levers['items']) > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 mb-12 mt-8">
                <?php foreach ($levers['items'] as $index => $item): ?>
                <?php 
                    $isGramsCard = ($index === 1);
                ?>
                <div class="bg-white p-6 sm:p-8 rounded-2xl border <?php echo $isGramsCard ? 'border-2 border-mosilGold shadow-xl' : 'border-slate-200/80 shadow-sm'; ?> hover:border-mosilGold/60 hover:shadow-2xl hover:-translate-y-1.5 hover:scale-[1.01] transition-all duration-300 ease-out flex flex-col justify-between relative group">
                    
                    <?php if ($isGramsCard): ?>
                        <!-- Highest Impact Badge for Card 2 (Grams Applied) -->
                        <span class="bg-mosilGold text-mosilGreenDeep font-bold uppercase text-[10px] tracking-wider px-2.5 py-1 rounded-full absolute -top-3 right-6 shadow-md">
                            Highest Impact
                        </span>
                    <?php endif; ?>

                    <div>
                        <div class="w-10 h-10 rounded-xl bg-mosilGreen/10 text-mosilGreen font-mono font-bold text-base flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                            0<?php echo $index + 1; ?>
                        </div>
                        <h3 class="text-xl font-bold <?php echo $isGramsCard ? 'text-mosilGreen' : 'text-slate-900'; ?> mb-3 uppercase tracking-wide">
                            <?php echo htmlspecialchars($item['title']); ?>
                        </h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            <?php echo htmlspecialchars($item['description']); ?>
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Closing Line -->
            <?php if (!empty($levers['closing'])): ?>
            <div class="bg-slate-200/80 rounded-xl p-6 text-center border border-slate-300/80 max-w-3xl mx-auto">
                <p class="text-slate-900 font-bold text-base sm:text-lg">
                    <?php echo htmlspecialchars($levers['closing']); ?>
                </p>
            </div>
            <?php endif; ?>

        </div>
    </section>
    <?php endif; ?>

    <!-- ================================================== -->
    <!-- SECTION 3: TRUST BLOCK — Side-by-Side Matcher     -->
    <!-- ================================================== -->
    <?php if (!empty($trust['heading']) || !empty($trust['body_1'])): ?>
        <?php
            $trustPos = $trust['image_position'] ?? 'right';
            $trustImg = $trust['image'] ?? '';
            $trustAlt = $trust['image_alt'] ?? 'MOSIL Specification Match';
        ?>
    <section id="spec-trust" class="bg-white py-16 px-4 sm:px-6 border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left Column: Bold Narrative -->
                <div class="lg:col-span-6 space-y-5 <?php echo $trustPos === 'left' ? 'lg:order-2' : ''; ?>">
                    <span class="font-mono text-xs font-semibold text-mosilGreen uppercase tracking-widest bg-mosilGreen/10 px-3 py-1 rounded-full border border-mosilGreen/20 inline-block">COMPLIANCE FIRST</span>
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        <?php echo htmlspecialchars($trust['heading']); ?>
                    </h2>
                    
                    <div class="text-slate-700 text-base sm:text-lg leading-relaxed space-y-4 mb-6">
                        <?php if (!empty($trust['body_1'])): ?>
                            <p><?php echo htmlspecialchars($trust['body_1']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($trust['body_2'])): ?>
                            <p><?php echo htmlspecialchars($trust['body_2']); ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Soft Amber Callout Highlight Box -->
                    <?php if (!empty($trust['sub_line'])): ?>
                    <div class="bg-mosilGoldLight border-l-4 border-mosilGold p-4 rounded-r-xl text-sm text-slate-900 font-semibold shadow-sm">
                        <?php echo htmlspecialchars($trust['sub_line']); ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Right Column: Interactive Parameter Matcher Card -->
                <div class="lg:col-span-6 <?php echo $trustPos === 'left' ? 'lg:order-1' : ''; ?>">
                    <?php if (!empty($trustImg)): ?>
                        <div class="relative rounded-2xl overflow-hidden border border-slate-200/80 shadow-lg">
                            <img src="<?php echo htmlspecialchars($trustImg); ?>" alt="<?php echo htmlspecialchars($trustAlt); ?>" class="w-full h-auto object-cover">
                        </div>
                    <?php else: ?>
                        <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-6 sm:p-8 shadow-md">
                            <div class="flex items-center justify-between border-b border-slate-200 pb-3 mb-4">
                                <span class="font-mono text-xs font-bold uppercase text-slate-900">OEM Spec Match Matrix</span>
                                <span class="font-mono text-xs font-bold text-emerald-600 bg-emerald-100 px-3 py-1 rounded-full">100% Parameter Match</span>
                            </div>
                            <div class="space-y-3 font-mono text-xs sm:text-sm">
                                <div class="grid grid-cols-3 gap-2 bg-white p-3 rounded-lg border border-slate-200/80 font-bold text-slate-800">
                                    <span>Test Parameter</span>
                                    <span class="text-center">OEM Target</span>
                                    <span class="text-right text-emerald-600">MOSIL Tested</span>
                                </div>
                                <div class="grid grid-cols-3 gap-2 bg-white p-3 rounded-lg border border-slate-100 text-slate-700">
                                    <span>Base Oil Viscosity</span>
                                    <span class="text-center">100 cSt @ 40°C</span>
                                    <span class="text-right text-emerald-600 font-bold">102 cSt ✓</span>
                                </div>
                                <div class="grid grid-cols-3 gap-2 bg-white p-3 rounded-lg border border-slate-100 text-slate-700">
                                    <span>4-Ball Weld Load</span>
                                    <span class="text-center">> 400 kgf</span>
                                    <span class="text-right text-emerald-600 font-bold">440 kgf ✓</span>
                                </div>
                                <div class="grid grid-cols-3 gap-2 bg-white p-3 rounded-lg border border-slate-100 text-slate-700">
                                    <span>Working Temp Range</span>
                                    <span class="text-center">-40°C to +160°C</span>
                                    <span class="text-right text-emerald-600 font-bold">Pass ✓</span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================================================== -->
    <!-- SECTION 4: DIAGNOSTIC FORM — Modern Multi-Step    -->
    <!-- ================================================== -->
    <?php if (!empty($form['heading'])): ?>
    <section id="cpc-form" class="bg-slate-50 pt-20 pb-24 px-4 sm:px-6 border-b border-slate-200/80">
        <div class="max-w-4xl mx-auto">
            
            <!-- Section Header -->
            <div class="text-center mb-10">
                <span class="font-mono text-xs font-bold uppercase tracking-widest text-mosilGreen bg-mosilGreen/10 px-3.5 py-1 rounded-full border border-mosilGreen/20">ENTERPRISE DIAGNOSTIC</span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mt-3 mb-3 text-center tracking-tight">
                    <?php echo htmlspecialchars($form['heading']); ?>
                </h2>
                <?php if (!empty($form['intro'])): ?>
                    <p class="text-slate-600 text-center text-base sm:text-lg mb-6 max-w-2xl mx-auto leading-relaxed">
                        <?php echo htmlspecialchars($form['intro']); ?>
                    </p>
                <?php endif; ?>

                <!-- Confidentiality Banner -->
                <?php if (!empty($form['confidentiality'])): ?>
                <div class="bg-sky-50 border border-sky-200/80 p-4 rounded-2xl text-xs sm:text-sm text-sky-900 flex items-start gap-3.5 shadow-sm text-left max-w-3xl mx-auto">
                    <svg class="w-5 h-5 text-sky-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <span class="leading-relaxed"><?php echo htmlspecialchars($form['confidentiality']); ?></span>
                </div>
                <?php endif; ?>
            </div>

            <!-- Form Card Container (Master Wizard Container) -->
            <div class="bg-white p-8 lg:p-12 rounded-3xl border border-slate-200/80 shadow-2xl relative overflow-hidden">
                
                <!-- Top Progress Stepper Bar: 3-Step Indicator -->
                <div class="mb-10 pb-8 border-b border-slate-200/80" id="wizardStepper">
                    <div class="grid grid-cols-3 gap-2 relative">
                        
                        <!-- Connecting Line Behind Indicators -->
                        <div class="absolute top-4 left-[16%] right-[16%] h-0.5 bg-slate-200 -z-0 hidden sm:block"></div>
                        <div class="absolute top-4 left-[16%] h-0.5 bg-mosilGold transition-all duration-500 -z-0 hidden sm:block" id="stepperProgressBar" style="width: 0%;"></div>

                        <!-- Step 1 Tab -->
                        <button type="button" onclick="goToWizardStep(1)" id="stepTab-1" class="flex flex-col items-center text-center group cursor-pointer relative z-10 focus:outline-none">
                            <div class="w-8 h-8 rounded-full bg-mosilGold text-mosilGreenDeep font-mono font-extrabold text-xs flex items-center justify-center shadow-md ring-4 ring-mosilGold/20 transition-all mb-2" id="stepBadge-1">
                                1
                            </div>
                            <span class="text-xs font-bold text-slate-950 tracking-tight" id="stepTitle-1">1. Direction & Contact</span>
                        </button>

                        <!-- Step 2 Tab -->
                        <button type="button" onclick="goToWizardStep(2)" id="stepTab-2" class="flex flex-col items-center text-center group cursor-pointer relative z-10 focus:outline-none">
                            <div class="w-8 h-8 rounded-full bg-slate-100 border border-slate-300 text-slate-500 font-mono font-bold text-xs flex items-center justify-center transition-all group-hover:scale-110 mb-2" id="stepBadge-2">
                                2
                            </div>
                            <span class="text-xs font-semibold text-slate-500 tracking-tight" id="stepTitle-2">2. Contact & Spec</span>
                        </button>

                        <!-- Step 3 Tab -->
                        <button type="button" onclick="goToWizardStep(3)" id="stepTab-3" class="flex flex-col items-center text-center group cursor-pointer relative z-10 focus:outline-none">
                            <div class="w-8 h-8 rounded-full bg-slate-100 border border-slate-300 text-slate-500 font-mono font-bold text-xs flex items-center justify-center transition-all group-hover:scale-110 mb-2" id="stepBadge-3">
                                3
                            </div>
                            <span class="text-xs font-semibold text-slate-500 tracking-tight" id="stepTitle-3">3. Route Details</span>
                        </button>

                    </div>
                </div>

                <form action="ajax/submit-cpc.php" method="POST" id="cpcDiagnosticForm">
                    <input type="hidden" name="landing_id" value="<?php echo htmlspecialchars($id); ?>">
                    
                    <!-- ========================================== -->
                    <!-- STEP 1: DIRECTION & PRIMARY ROUTE          -->
                    <!-- ========================================== -->
                    <div id="wizardStepContent-1" class="space-y-10">
                        
                        <!-- PART A: DIRECTION -->
                        <div class="space-y-6">
                            <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                                <span class="font-mono text-mosilGreen uppercase text-xs tracking-widest font-bold">PART A</span>
                                <h3 class="text-slate-900 font-extrabold text-lg">Direction & Primary Route</h3>
                            </div>

                            <!-- Q1 Choice Pills -->
                            <div>
                                <label class="block text-slate-900 font-semibold text-base mb-3">Q1. Are you currently working on reducing your cost per component?</label>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-sm text-slate-700">
                                        <input type="radio" name="working_on_reduction" value="Yes" class="sr-only"> Yes
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-sm text-slate-700">
                                        <input type="radio" name="working_on_reduction" value="No" class="sr-only"> No
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-sm text-slate-700">
                                        <input type="radio" name="working_on_reduction" value="Not formally, but there is pressure to" class="sr-only"> Under pressure to reduce
                                    </label>
                                </div>
                            </div>

                            <!-- Q2 Choice Pills -->
                            <div>
                                <label class="block text-slate-900 font-semibold text-base mb-3">Q2. What is your primary route to reducing CPC?</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-sm text-slate-700">
                                        <input type="radio" name="reduction_route" value="Grease cost" class="sr-only"> Grease Cost
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-sm text-slate-700">
                                        <input type="radio" name="reduction_route" value="Inventory and working capital" class="sr-only"> Inventory & Capital
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-sm text-slate-700">
                                        <input type="radio" name="reduction_route" value="Both" class="sr-only"> Both Routes
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-sm text-slate-700">
                                        <input type="radio" name="reduction_route" value="Not decided yet" class="sr-only"> Not Decided Yet
                                    </label>
                                </div>
                            </div>

                            <!-- Q3 Choice Pills -->
                            <div>
                                <label class="block text-slate-900 font-semibold text-base mb-3">Q3. Approximately what is your annual spend on assembly greases?</label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs sm:text-sm text-slate-700 text-center">
                                        <input type="radio" name="annual_spend" value="Under ₹10 lakh" class="sr-only"> Under ₹10L
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs sm:text-sm text-slate-700 text-center">
                                        <input type="radio" name="annual_spend" value="₹10–50 lakh" class="sr-only"> ₹10L – ₹50L
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs sm:text-sm text-slate-700 text-center">
                                        <input type="radio" name="annual_spend" value="₹50 lakh – ₹2 crore" class="sr-only"> ₹50L – ₹2Cr
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs sm:text-sm text-slate-700 text-center">
                                        <input type="radio" name="annual_spend" value="Above ₹2 crore" class="sr-only"> Above ₹2Cr
                                    </label>
                                    <label class="col-span-2 sm:col-span-1 has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs sm:text-sm text-slate-700 text-center">
                                        <input type="radio" name="annual_spend" value="Prefer not to disclose" class="sr-only"> Undisclosed
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- PART B: CONTACT DETAILS -->
                        <div class="space-y-6 pt-4 border-t border-slate-100">
                            <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                                <span class="font-mono text-mosilGreen uppercase text-xs tracking-widest font-bold">PART B</span>
                                <h3 class="text-slate-900 font-extrabold text-lg">Contact & Revert Details</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Full Name -->
                                <div>
                                    <label class="block font-semibold text-slate-800 text-xs mb-1">Full Name *</label>
                                    <input type="text" name="full_name" class="bg-slate-50 border border-slate-200 rounded-xl p-4 focus:bg-white focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/10 transition-all w-full text-sm text-slate-900 outline-none" placeholder="Rajesh Kumar" required>
                                </div>

                                <!-- Designation -->
                                <div>
                                    <label class="block font-semibold text-slate-800 text-xs mb-1">Designation *</label>
                                    <input type="text" name="designation" class="bg-slate-50 border border-slate-200 rounded-xl p-4 focus:bg-white focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/10 transition-all w-full text-sm text-slate-900 outline-none" placeholder="GM Procurement" required>
                                </div>

                                <!-- Function -->
                                <div>
                                    <label class="block font-semibold text-slate-800 text-xs mb-1">Function *</label>
                                    <select name="function" class="bg-slate-50 border border-slate-200 rounded-xl p-4 focus:bg-white focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/10 transition-all w-full text-sm text-slate-900 outline-none appearance-none" required>
                                        <option value="">Select Function...</option>
                                        <option value="Procurement">Procurement</option>
                                        <option value="Vendor development">Vendor development</option>
                                        <option value="Design">Design</option>
                                        <option value="R&D">R&D</option>
                                        <option value="Quality">Quality</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>

                                <!-- Company -->
                                <div>
                                    <label class="block font-semibold text-slate-800 text-xs mb-1">Company *</label>
                                    <input type="text" name="company" class="bg-slate-50 border border-slate-200 rounded-xl p-4 focus:bg-white focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/10 transition-all w-full text-sm text-slate-900 outline-none" placeholder="AutoComp Industries" required>
                                </div>

                                <!-- City -->
                                <div>
                                    <label class="block font-semibold text-slate-800 text-xs mb-1">Plant Location (City) *</label>
                                    <input type="text" name="city" class="bg-slate-50 border border-slate-200 rounded-xl p-4 focus:bg-white focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/10 transition-all w-full text-sm text-slate-900 outline-none" placeholder="Pune" required>
                                </div>

                                <!-- Work Email -->
                                <div>
                                    <label class="block font-semibold text-slate-800 text-xs mb-1">Work Email *</label>
                                    <input type="email" name="work_email" class="bg-slate-50 border border-slate-200 rounded-xl p-4 focus:bg-white focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/10 transition-all w-full text-sm text-slate-900 outline-none" placeholder="r.kumar@autocomp.com" required>
                                </div>

                                <!-- Mobile Number -->
                                <div class="md:col-span-2">
                                    <label class="block font-semibold text-slate-800 text-xs mb-1">Mobile Number *</label>
                                    <input type="tel" name="mobile_number" class="bg-slate-50 border border-slate-200 rounded-xl p-4 focus:bg-white focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/10 transition-all w-full text-sm text-slate-900 outline-none" placeholder="10-digit mobile number" pattern="[0-9]{10}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Step 1 Button -->
                        <div class="pt-6 flex justify-end">
                            <button type="button" onclick="goToWizardStep(2)" class="bg-mosilGold hover:bg-mosilGoldHover text-mosilGreenDeep font-bold px-8 py-3.5 rounded-xl shadow-lg shadow-mosilGold/20 hover:-translate-y-0.5 transition-all inline-flex items-center gap-2 text-sm group">
                                <span>Next: Technical & Spec Details</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>

                    </div>

                    <!-- ========================================== -->
                    <!-- STEP 2: PARTS C & D                        -->
                    <!-- ========================================== -->
                    <div id="wizardStepContent-2" class="space-y-10 hidden">
                        
                        <!-- PART C: GREASE COST ROUTE -->
                        <div class="space-y-6">
                            <div class="bg-sky-50 text-sky-800 border border-sky-200/80 rounded-xl p-3.5 text-xs flex items-center gap-2.5 font-medium">
                                <svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Skip questions in this section if grease cost is not one of your focus routes.</span>
                            </div>

                            <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                                <span class="font-mono text-mosilGreen uppercase text-xs tracking-widest font-bold">PART C</span>
                                <h3 class="text-slate-900 font-extrabold text-lg">Grease Cost & Technical Route</h3>
                            </div>

                            <!-- Q4 Choice Pills -->
                            <div>
                                <label class="block text-slate-900 font-semibold text-base mb-3">Q4. Have you already identified a specific grease you want an alternate for?</label>
                                <div class="grid grid-cols-2 gap-3 max-w-sm">
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-sm text-slate-700">
                                        <input type="radio" name="q4" value="Yes" class="sr-only"> Yes
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-sm text-slate-700">
                                        <input type="radio" name="q4" value="No" class="sr-only"> No
                                    </label>
                                </div>
                            </div>

                            <!-- Q5 Input -->
                            <div>
                                <label class="block text-slate-900 font-semibold text-base mb-2">Q5. Which grease carries the largest annual budget allocation in your plant?</label>
                                <input type="text" name="q5" placeholder="Application or component name (e.g. CV Joint grease, High Temp Bearing paste)" class="bg-slate-50 border border-slate-200 rounded-xl p-4 focus:bg-white focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/10 transition-all w-full text-sm text-slate-900 outline-none">
                            </div>

                            <!-- Q6 Choice Pills -->
                            <div>
                                <label class="block text-slate-900 font-semibold text-base mb-3">Q6. Would you like MOSIL to evaluate that grease for a CPC reduction project?</label>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-sm text-slate-700">
                                        <input type="radio" name="q6" value="Yes" class="sr-only"> Yes
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-sm text-slate-700">
                                        <input type="radio" name="q6" value="No" class="sr-only"> No
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-sm text-slate-700">
                                        <input type="radio" name="q6" value="Later in the year" class="sr-only"> Later in the year
                                    </label>
                                </div>
                            </div>

                            <!-- Q7 Textarea -->
                            <div>
                                <label class="block text-slate-900 font-semibold text-base mb-2">Q7. Which component is the grease applied on, and at what stage of assembly?</label>
                                <textarea name="q7" rows="2" placeholder="e.g. Applied on steering column gear assembly during sub-assembly stage" class="bg-slate-50 border border-slate-200 rounded-xl p-4 focus:bg-white focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/10 transition-all w-full text-sm text-slate-900 outline-none"></textarea>
                            </div>

                            <!-- Q8 & Q9 Choice Pills -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-slate-900 font-semibold text-sm mb-2">Q8. Physio-chemical specs specified?</label>
                                    <div class="grid grid-cols-3 gap-2">
                                        <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-3 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs text-slate-700">
                                            <input type="radio" name="q8" value="Yes" class="sr-only"> Yes
                                        </label>
                                        <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-3 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs text-slate-700">
                                            <input type="radio" name="q8" value="No" class="sr-only"> No
                                        </label>
                                        <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-3 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs text-slate-700">
                                            <input type="radio" name="q8" value="Not sure" class="sr-only"> Not Sure
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-slate-900 font-semibold text-sm mb-2">Q9. Performance specs specified?</label>
                                    <div class="grid grid-cols-3 gap-2">
                                        <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-3 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs text-slate-700">
                                            <input type="radio" name="q9" value="Yes" class="sr-only"> Yes
                                        </label>
                                        <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-3 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs text-slate-700">
                                            <input type="radio" name="q9" value="No" class="sr-only"> No
                                        </label>
                                        <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-3 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs text-slate-700">
                                            <input type="radio" name="q9" value="Not sure" class="sr-only"> Not Sure
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Q10: Quantity Applied -->
                            <div>
                                <label class="block text-slate-900 font-semibold text-base mb-2">Q10. Approximately how much grease is applied per component?</label>
                                <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                                    <div class="sm:col-span-5">
                                        <input type="text" name="q10_amount" placeholder="Amount (e.g. 2.5)" class="bg-slate-50 border border-slate-200 rounded-xl p-4 focus:bg-white focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/10 transition-all w-full text-sm text-slate-900 outline-none">
                                    </div>
                                    <div class="sm:col-span-7 grid grid-cols-3 gap-2">
                                        <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-3.5 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs text-slate-700">
                                            <input type="radio" name="q10_unit" value="grams" class="sr-only"> Grams
                                        </label>
                                        <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-3.5 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs text-slate-700">
                                            <input type="radio" name="q10_unit" value="millilitres" class="sr-only"> mL
                                        </label>
                                        <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-3.5 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs text-slate-700 text-center">
                                            <input type="radio" name="q10_unit" value="Not measured" class="sr-only"> Not Measured
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PART D: VALIDATION PREFERENCE -->
                        <div class="space-y-6 pt-4 border-t border-slate-100">
                            <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                                <span class="font-mono text-mosilGreen uppercase text-xs tracking-widest font-bold">PART D</span>
                                <h3 class="text-slate-900 font-extrabold text-lg">Validation Preference</h3>
                            </div>

                            <div>
                                <label class="block text-slate-900 font-semibold text-base mb-3">Q11. If MOSIL proposes an alternate built to your OEM spec, how would you want it validated?</label>
                                <div class="space-y-3">
                                    
                                    <!-- Route 1: TriboIntel Lab (Recommended) -->
                                    <label class="flex items-start gap-3.5 p-4 bg-mosilGold/10 hover:bg-mosilGold/20 border-2 border-mosilGold rounded-2xl cursor-pointer transition-all has-[:checked]:border-mosilGold has-[:checked]:bg-mosilGold/20 shadow-sm relative">
                                        <div class="mt-0.5">
                                            <input type="radio" name="q11" value="Validation at MOSIL's NABL-accredited TriboIntel laboratory" class="w-4 h-4 text-mosilGreen font-bold focus:ring-mosilGold border-slate-300">
                                        </div>
                                        <div class="flex-grow">
                                            <div class="flex items-center gap-2 mb-0.5">
                                                <span class="font-bold text-slate-900 text-sm">MOSIL TriboIntel™ Laboratory Validation</span>
                                                <span class="font-mono text-[10px] font-bold text-mosilGreenDeep bg-mosilGold px-2 py-0.5 rounded-full uppercase tracking-wider">Recommended</span>
                                            </div>
                                            <p class="text-xs text-slate-600">Full physical, chemical, and performance testing at MOSIL's NABL-accredited lab. Full test report shared directly with your team.</p>
                                        </div>
                                    </label>

                                    <!-- Route 2: Third-party -->
                                    <label class="flex items-start gap-3.5 p-4 bg-slate-50 hover:bg-mosilGold/10 border border-slate-200 hover:border-mosilGold/60 rounded-2xl cursor-pointer transition-all has-[:checked]:border-mosilGold has-[:checked]:bg-mosilGold/15">
                                        <div class="mt-0.5">
                                            <input type="radio" name="q11" value="Validation at a third-party laboratory" class="w-4 h-4 text-mosilGreen focus:ring-mosilGold border-slate-300">
                                        </div>
                                        <div class="flex-grow">
                                            <span class="font-bold text-slate-900 text-sm block mb-0.5">Third-Party Laboratory Validation</span>
                                            <p class="text-xs text-slate-600">Testing at an independent third-party lab nominated by your team (testing cost to our account).</p>
                                        </div>
                                    </label>

                                    <!-- Route 3: Both -->
                                    <label class="flex items-start gap-3.5 p-4 bg-slate-50 hover:bg-mosilGold/10 border border-slate-200 hover:border-mosilGold/60 rounded-2xl cursor-pointer transition-all has-[:checked]:border-mosilGold has-[:checked]:bg-mosilGold/15">
                                        <div class="mt-0.5">
                                            <input type="radio" name="q11" value="Both" class="w-4 h-4 text-mosilGreen focus:ring-mosilGold border-slate-300">
                                        </div>
                                        <div class="flex-grow">
                                            <span class="font-bold text-slate-900 text-sm block mb-0.5">Dual Route (Both Labs)</span>
                                            <p class="text-xs text-slate-600">MOSIL NABL testing first, followed by third-party confirmation before changeover begins.</p>
                                        </div>
                                    </label>

                                    <!-- Route 4: Decide Later -->
                                    <label class="flex items-start gap-3.5 p-4 bg-slate-50 hover:bg-mosilGold/10 border border-slate-200 hover:border-mosilGold/60 rounded-2xl cursor-pointer transition-all has-[:checked]:border-mosilGold has-[:checked]:bg-mosilGold/15">
                                        <div class="mt-0.5">
                                            <input type="radio" name="q11" value="We will decide after seeing the proposal" class="w-4 h-4 text-mosilGreen focus:ring-mosilGold border-slate-300">
                                        </div>
                                        <div class="flex-grow">
                                            <span class="font-bold text-slate-900 text-sm block mb-0.5">Decide After Proposal</span>
                                            <p class="text-xs text-slate-600">We will determine the validation route after reviewing the initial technical proposal.</p>
                                        </div>
                                    </label>

                                </div>
                            </div>
                        </div>

                        <!-- Step 2 Buttons -->
                        <div class="pt-6 flex items-center justify-between">
                            <button type="button" onclick="goToWizardStep(1)" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-6 py-3.5 rounded-xl transition-all inline-flex items-center gap-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                <span>Back</span>
                            </button>
                            <button type="button" onclick="goToWizardStep(3)" class="bg-mosilGold hover:bg-mosilGoldHover text-mosilGreenDeep font-bold px-8 py-3.5 rounded-xl shadow-lg shadow-mosilGold/20 hover:-translate-y-0.5 transition-all inline-flex items-center gap-2 text-sm group">
                                <span>Next: Supply Chain & Future</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>

                    </div>

                    <!-- ========================================== -->
                    <!-- STEP 3: PARTS E & F                        -->
                    <!-- ========================================== -->
                    <div id="wizardStepContent-3" class="space-y-10 hidden">
                        
                        <!-- PART E: INVENTORY ROUTE -->
                        <div class="space-y-6">
                            <div class="bg-sky-50 text-sky-800 border border-sky-200/80 rounded-xl p-3.5 text-xs flex items-center gap-2.5 font-medium">
                                <svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Skip questions in this section if inventory & lead time is not one of your focus routes.</span>
                            </div>

                            <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                                <span class="font-mono text-mosilGreen uppercase text-xs tracking-widest font-bold">PART E</span>
                                <h3 class="text-slate-900 font-extrabold text-lg">Inventory & Working Capital Route</h3>
                            </div>

                            <!-- Q12 Choice Pills -->
                            <div>
                                <label class="block text-slate-900 font-semibold text-base mb-3">Q12. What is your current lead time from grease order to receipt?</label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs sm:text-sm text-slate-700 text-center">
                                        <input type="radio" name="q12" value="Under 2 weeks" class="sr-only"> &lt; 2 Weeks
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs sm:text-sm text-slate-700 text-center">
                                        <input type="radio" name="q12" value="2-4 weeks" class="sr-only"> 2–4 Weeks
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs sm:text-sm text-slate-700 text-center">
                                        <input type="radio" name="q12" value="1-2 months" class="sr-only"> 1–2 Months
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs sm:text-sm text-slate-700 text-center">
                                        <input type="radio" name="q12" value="Over 2 months" class="sr-only"> &gt; 2 Months
                                    </label>
                                    <label class="col-span-2 sm:col-span-1 has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs sm:text-sm text-slate-700 text-center">
                                        <input type="radio" name="q12" value="Varies widely" class="sr-only"> Varies Widely
                                    </label>
                                </div>
                            </div>

                            <!-- Q13, Q14a, Q14b Inputs -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block font-semibold text-slate-800 text-xs mb-1">Q13. Days of stock held?</label>
                                    <input type="number" name="q13" placeholder="Days (e.g. 45)" class="bg-slate-50 border border-slate-200 rounded-xl p-4 focus:bg-white focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/10 transition-all w-full text-sm text-slate-900 outline-none">
                                </div>
                                <div>
                                    <label class="block font-semibold text-slate-800 text-xs mb-1">Q14a. Target lead time?</label>
                                    <input type="text" name="q14a" placeholder="Target (e.g. 5 days)" class="bg-slate-50 border border-slate-200 rounded-xl p-4 focus:bg-white focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/10 transition-all w-full text-sm text-slate-900 outline-none">
                                </div>
                                <div>
                                    <label class="block font-semibold text-slate-800 text-xs mb-1">Q14b. Target stock days?</label>
                                    <input type="text" name="q14b" placeholder="Target (e.g. 15 days)" class="bg-slate-50 border border-slate-200 rounded-xl p-4 focus:bg-white focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/10 transition-all w-full text-sm text-slate-900 outline-none">
                                </div>
                            </div>

                            <!-- Q15 Choice Pills -->
                            <div>
                                <label class="block text-slate-900 font-semibold text-base mb-3">Q15. Is any part of your grease requirement currently imported?</label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-sm text-slate-700">
                                        <input type="radio" name="q15" value="Yes, fully" class="sr-only"> Yes, Fully
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-sm text-slate-700">
                                        <input type="radio" name="q15" value="Yes, partly" class="sr-only"> Yes, Partly
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-sm text-slate-700">
                                        <input type="radio" name="q15" value="No" class="sr-only"> No
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-sm text-slate-700">
                                        <input type="radio" name="q15" value="Not sure" class="sr-only"> Not Sure
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- PART F: DESIGN ROUTE -->
                        <div class="space-y-6 pt-4 border-t border-slate-100">
                            <div class="bg-sky-50 text-sky-800 border border-sky-200/80 rounded-xl p-3.5 text-xs flex items-center gap-2.5 font-medium">
                                <svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>For Design & R&D teams, or new component development programmes.</span>
                            </div>

                            <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                                <span class="font-mono text-mosilGreen uppercase text-xs tracking-widest font-bold">PART F</span>
                                <h3 class="text-slate-900 font-extrabold text-lg">Design & New Projects (Nurture Route)</h3>
                            </div>

                            <!-- Q16 Choice Pills -->
                            <div>
                                <label class="block text-slate-900 font-semibold text-base mb-3">Q16. Are there new components in development where grease is not yet finalised?</label>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-sm text-slate-700">
                                        <input type="radio" name="q16" value="Yes" class="sr-only"> Yes
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-sm text-slate-700">
                                        <input type="radio" name="q16" value="No" class="sr-only"> No
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-sm text-slate-700">
                                        <input type="radio" name="q16" value="Cannot disclose" class="sr-only"> Cannot Disclose
                                    </label>
                                </div>
                            </div>

                            <!-- Q17 Input -->
                            <div>
                                <label class="block text-slate-900 font-semibold text-base mb-2">Q17. What are those components or programmes, broadly?</label>
                                <input type="text" name="q17" placeholder="Component type and expected SOP timing..." class="bg-slate-50 border border-slate-200 rounded-xl p-4 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all w-full text-sm text-slate-900 outline-none">
                            </div>

                            <!-- Q18 Choice Pills -->
                            <div>
                                <label class="block text-slate-900 font-semibold text-base mb-3">Q18. At what stage would you want a grease supplier involved?</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs sm:text-sm text-slate-700 text-center">
                                        <input type="radio" name="q18" value="Concept and specification stage" class="sr-only"> Concept & Spec Stage
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs sm:text-sm text-slate-700 text-center">
                                        <input type="radio" name="q18" value="Prototype and validation" class="sr-only"> Prototype & Validation
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs sm:text-sm text-slate-700 text-center">
                                        <input type="radio" name="q18" value="Pre-production" class="sr-only"> Pre-production
                                    </label>
                                    <label class="has-[:checked]:bg-mosilGold/15 has-[:checked]:border-mosilGold has-[:checked]:text-slate-900 has-[:checked]:font-bold cursor-pointer p-4 rounded-xl border border-slate-200 hover:border-mosilGold/60 transition-all flex items-center justify-center font-medium text-xs sm:text-sm text-slate-700 text-center">
                                        <input type="radio" name="q18" value="Only after OEM approval" class="sr-only"> Only After OEM Approval
                                    </label>
                                </div>
                            </div>

                            <!-- Q19 Textarea -->
                            <div>
                                <label class="block text-slate-900 font-semibold text-base mb-2">Q19. Anything else we should know before we revert?</label>
                                <textarea name="q19" rows="2" placeholder="Any specific constraints, test parameters, or notes..." class="bg-slate-50 border border-slate-200 rounded-xl p-4 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all w-full text-sm text-slate-900 outline-none"></textarea>
                            </div>
                        </div>

                        <!-- Step 3 Submit Buttons -->
                        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <button type="button" onclick="goToWizardStep(2)" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-6 py-3.5 rounded-xl transition-all inline-flex items-center gap-2 text-sm w-full sm:w-auto justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                <span>Back</span>
                            </button>

                            <!-- Submit Button CTA -->
                            <button type="submit" class="bg-mosilGold hover:bg-mosilGoldHover text-mosilGreenDeep font-bold text-base py-4 px-8 rounded-xl shadow-lg shadow-mosilGold/20 hover:shadow-[0_0_30px_rgba(244,195,0,0.4)] hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center justify-center gap-2.5 w-full sm:w-auto group">
                                <svg class="w-5 h-5 text-mosilGreenDeep shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                <span>Submit Confidential Assessment</span>
                            </button>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </section>

    <!-- WIZARD STEPPERS SCRIPT -->
    <script>
    let currentWizardStep = 1;

    function goToWizardStep(step) {
        if (step < 1 || step > 3) return;

        // Hide all step content divs
        document.getElementById('wizardStepContent-1').classList.add('hidden');
        document.getElementById('wizardStepContent-2').classList.add('hidden');
        document.getElementById('wizardStepContent-3').classList.add('hidden');

        // Show target step
        document.getElementById('wizardStepContent-' + step).classList.remove('hidden');
        currentWizardStep = step;

        // Update progress bar line width
        const progressBar = document.getElementById('stepperProgressBar');
        if (progressBar) {
            if (step === 1) progressBar.style.width = '0%';
            if (step === 2) progressBar.style.width = '50%';
            if (step === 3) progressBar.style.width = '100%';
        }

        // Update Stepper Tab Badges & Text Styling
        for (let i = 1; i <= 3; i++) {
            const badge = document.getElementById('stepBadge-' + i);
            const title = document.getElementById('stepTitle-' + i);
            
            if (i < step) {
                // Completed Step
                badge.className = 'w-8 h-8 rounded-full bg-emerald-500 text-white font-bold text-xs flex items-center justify-center shadow transition-all mb-2';
                badge.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>';
                title.className = 'text-xs font-semibold text-slate-800 tracking-tight';
            } else if (i === step) {
                // Active Current Step
                badge.className = 'w-8 h-8 rounded-full bg-mosilGold text-mosilGreenDeep font-mono font-extrabold text-xs flex items-center justify-center shadow-md ring-4 ring-mosilGold/20 transition-all mb-2';
                badge.innerHTML = i.toString();
                title.className = 'text-xs font-bold text-slate-950 tracking-tight';
            } else {
                // Future Step
                badge.className = 'w-8 h-8 rounded-full bg-slate-100 border border-slate-300 text-slate-500 font-mono font-bold text-xs flex items-center justify-center transition-all mb-2';
                badge.innerHTML = i.toString();
                title.className = 'text-xs font-semibold text-slate-500 tracking-tight';
            }
        }

        // Smooth scroll to top of form
        const formSection = document.getElementById('cpc-form');
        if (formSection) {
            formSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
    </script>
    <?php endif; ?>

    <!-- ================================================== -->
    <!-- SECTION 5: QUADRA APPROACH® — 4-Stage Timeline     -->
    <!-- ================================================== -->
    <?php if (!empty($approach['stages']) && count($approach['stages']) > 0): ?>
    <section id="approach" class="bg-white py-20 px-4 sm:px-6 border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="font-mono text-xs font-bold uppercase tracking-widest text-mosilGreen bg-mosilGreen/10 px-3.5 py-1 rounded-full border border-mosilGreen/20">OUR METHODOLOGY</span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mt-3 mb-3 tracking-tight">
                    How We Work: The Quadra Approach®
                </h2>
                <?php if (!empty($approach['intro'])): ?>
                    <p class="text-slate-600 text-base sm:text-lg leading-relaxed">
                        <?php echo htmlspecialchars($approach['intro']); ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- 4 Numbered Stage Cards (01 to 04) with top gradient border highlights -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($approach['stages'] as $stage): ?>
                <div class="bg-white border border-slate-200/80 border-t-4 border-t-mosilGold p-6 rounded-2xl shadow-sm hover:border-mosilGold/60 hover:shadow-2xl hover:-translate-y-2 transition-transform duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="font-mono text-xs font-bold text-mosilGreen mb-2 uppercase tracking-wider group-hover:text-mosilGold transition-colors">
                            Stage 0<?php echo htmlspecialchars($stage['number'] ?? 1); ?>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 uppercase tracking-wide mb-3">
                            <?php echo htmlspecialchars($stage['title']); ?>
                        </h3>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                            <?php echo htmlspecialchars($stage['description']); ?>
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================================================== -->
    <!-- SECTION 6: PROOF & TRIBOINTEL™ LAB — Dark Tech     -->
    <!-- ================================================== -->
    <?php if (!empty($proof['heading']) || !empty($proof['body_1'])): ?>
        <?php 
            $proofPos = $proof['image_position'] ?? 'right';
            $proofImg = $proof['image'] ?? '';
            $proofAlt = $proof['image_alt'] ?? 'MOSIL TriboIntel Laboratory';
        ?>
    <section id="proof-lab" class="bg-mosilGreenDeep py-20 px-4 sm:px-6 border-b border-mosilGreen/40 text-white relative overflow-hidden">
        
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-mosilGold/10 blur-[150px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left Column -->
                <div class="lg:col-span-7 space-y-6 <?php echo $proofPos === 'left' ? 'lg:order-2' : ''; ?>">
                    <span class="font-mono text-xs font-bold text-mosilGold bg-mosilGreenDark px-3.5 py-1 rounded-full border border-mosilGreen/60 uppercase tracking-widest">NABL ACCREDITED LAB</span>
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-white tracking-tight mb-4">
                        <?php echo htmlspecialchars($proof['heading']); ?>
                    </h2>
                    
                    <?php if (!empty($proof['body_1'])): ?>
                        <p class="text-slate-300 leading-relaxed mb-4 text-base">
                            <?php echo htmlspecialchars($proof['body_1']); ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($proof['body_2'])): ?>
                        <p class="text-slate-300 leading-relaxed mb-8 text-base">
                            <?php echo htmlspecialchars($proof['body_2']); ?>
                        </p>
                    <?php endif; ?>

                    <!-- Dark Glassmorphism Trust Chips -->
                    <?php if (!empty($proof['badges']) && count($proof['badges']) > 0): ?>
                        <div class="flex flex-wrap gap-2 font-mono text-xs">
                            <?php foreach ($proof['badges'] as $badgeText): ?>
                                <span class="bg-mosilGreenDark border border-mosilGreen/60 text-mosilGold rounded-full px-4 py-2 font-mono text-xs flex items-center gap-2 shadow-md">
                                    ✓ <?php echo htmlspecialchars($badgeText); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Right Column Image or Lab Card -->
                <div class="lg:col-span-5 <?php echo $proofPos === 'left' ? 'lg:order-1' : ''; ?>">
                    <?php if (!empty($proofImg)): ?>
                        <div class="relative rounded-2xl overflow-hidden border border-mosilGreen/60 shadow-2xl">
                            <img src="<?php echo htmlspecialchars($proofImg); ?>" alt="<?php echo htmlspecialchars($proofAlt); ?>" class="w-full h-auto object-cover">
                        </div>
                    <?php else: ?>
                        <div class="bg-mosilGreenDark/90 backdrop-blur-md border border-mosilGreen/60 p-8 rounded-2xl shadow-2xl relative overflow-hidden text-center">
                            <div class="w-14 h-14 rounded-2xl bg-mosilGold/20 text-mosilGold flex items-center justify-center mx-auto mb-4 border border-mosilGold/30">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-1">TriboIntel™ Laboratory</h3>
                            <div class="font-mono text-xs text-mosilGold font-bold mb-3 uppercase tracking-widest">ISO/IEC 17025 ACCREDITED</div>
                            <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                                Equipped with 4-Ball EP Tester, SRV Oscillation Tester, Rheometers, and Thermal Stability Chamber.
                            </p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================================================== -->
    <!-- SECTION 7 & 8: PROCESS & POST-SUBMIT BANNER       -->
    <!-- ================================================== -->
    <?php if (!empty($process['steps']) && count($process['steps']) > 0): ?>
    <section class="bg-slate-50 py-16 px-4 sm:px-6 border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <span class="font-mono text-xs font-bold uppercase tracking-widest text-mosilGreen block mb-2">TIMELINE & NEXT STEPS</span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    <?php echo htmlspecialchars($process['heading'] ?? 'What Happens After You Submit'); ?>
                </h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-<?php echo min(count($process['steps']), 4); ?> gap-6">
                <?php foreach ($process['steps'] as $idx => $step): ?>
                    <?php $stepText = is_array($step) ? ($step['description'] ?? '') : $step; ?>
                    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:border-mosilGold/60 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-mosilGreen/10 text-mosilGreen font-mono font-bold flex items-center justify-center mb-4 text-sm">
                                0<?php echo $idx + 1; ?>
                            </div>
                            <p class="text-slate-700 text-sm leading-relaxed font-medium">
                                <?php echo htmlspecialchars($stepText); ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================================================== -->
    <!-- SECTION 9: FREQUENTLY ASKED QUESTIONS (Accordion)  -->
    <!-- ================================================== -->
    <?php if (!empty($faq) && count($faq) > 0): ?>
    <section class="bg-white py-20 px-4 sm:px-6 border-b border-slate-200/80" id="faq-section">
        <div class="max-w-4xl mx-auto">
            
            <!-- Section Header System -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6 pb-6 border-b border-slate-100">
                <div class="text-left space-y-2">
                    <span class="font-mono text-xs font-bold text-mosilGreen uppercase tracking-widest block">
                        OBJECTION HANDLING & CLARITY
                    </span>
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                        Frequently Asked Questions
                    </h2>
                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed max-w-xl">
                        Everything you need to know about specification matching, validation routes, and domestic transition.
                    </p>
                </div>

                <!-- Global Toggle Actions -->
                <div class="flex items-center gap-2 shrink-0">
                    <button type="button" onclick="toggleAllFaqs(false)" class="text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 px-3.5 py-2 rounded-xl transition-all border border-slate-200">
                        Collapse All
                    </button>
                    <button type="button" onclick="toggleAllFaqs(true)" class="text-xs font-bold text-mosilGreenDeep bg-mosilGold hover:bg-mosilGoldHover px-3.5 py-2 rounded-xl shadow-sm transition-all">
                        Expand All
                    </button>
                </div>
            </div>
            
            <!-- Accordion Cards Stack (Open by Default with Soft Amber Glow) -->
            <div class="space-y-4">
                <?php foreach ($faq as $idx => $item): ?>
                    <?php 
                        $question = $item['q'] ?? '';
                        $answer = $item['a'] ?? '';
                    ?>
                    <div class="faq-card bg-white border border-mosilGold/50 ring-4 ring-mosilGold/10 rounded-2xl transition-all duration-300 overflow-hidden shadow-sm hover:shadow-md group">
                        
                        <!-- Trigger Button Header -->
                        <button type="button" 
                                onclick="toggleFaqAccordion(this)" 
                                class="flex items-center justify-between w-full p-5 sm:p-6 text-left cursor-pointer transition-colors focus:outline-none" 
                                aria-expanded="true"
                                aria-controls="faq-answer-<?php echo $idx; ?>">
                            
                            <div class="flex items-center gap-3.5 pr-4">
                                <div class="w-7 h-7 rounded-lg bg-mosilGreen/10 text-mosilGreen font-mono font-bold text-xs flex items-center justify-center shrink-0">
                                    Q<?php echo $idx + 1; ?>
                                </div>
                                <h3 class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-mosilGreen transition-colors leading-snug">
                                    <?php echo htmlspecialchars($question); ?>
                                </h3>
                            </div>

                            <!-- Circular Rotating Chevron Indicator -->
                            <div class="w-8 h-8 rounded-full bg-mosilGold text-mosilGreenDeep flex items-center justify-center transition-transform duration-300 shrink-0 rotate-180 faq-chevron">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                            </div>

                        </button>

                        <!-- Answer Panel (Visible / Open by Default) -->
                        <div id="faq-answer-<?php echo $idx; ?>" class="faq-answer-panel px-5 pb-6 sm:px-6 sm:pb-6 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                            <div class="pl-1 sm:pl-10">
                                <?php echo htmlspecialchars($answer); ?>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Bottom Support Callout Micro-Card -->
            <div class="mt-12 p-6 sm:p-8 bg-mosilGreenDeep text-white rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-6 border border-mosilGreen/60 shadow-xl">
                <div class="space-y-1 text-center sm:text-left">
                    <div class="font-bold text-white text-base sm:text-lg">Have a specific technical or OEM compliance question not answered here?</div>
                    <p class="text-xs sm:text-sm text-slate-400">Our application engineering team reviews all diagnostic queries directly.</p>
                </div>
                <a href="#cpc-form" class="bg-mosilGold hover:bg-mosilGoldHover text-mosilGreenDeep font-bold px-6 py-3.5 rounded-xl text-xs sm:text-sm shadow-md hover:-translate-y-0.5 transition-all shrink-0 inline-flex items-center gap-2 group">
                    <span>Talk to an Application Engineer</span>
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

        </div>
    </section>

    <!-- PRO ACCORDION TOGGLE SCRIPT -->
    <script>
    function toggleFaqAccordion(button) {
        const card = button.closest('.faq-card');
        const answer = card.querySelector('.faq-answer-panel');
        const chevron = card.querySelector('.faq-chevron');
        const isExpanded = button.getAttribute('aria-expanded') === 'true';

        if (isExpanded) {
            button.setAttribute('aria-expanded', 'false');
            answer.classList.add('hidden');
            chevron.classList.remove('rotate-180', 'bg-mosilGold', 'text-mosilGreenDeep');
            chevron.classList.add('bg-slate-200/60', 'text-slate-600');
            card.className = 'faq-card bg-slate-50 hover:bg-slate-100/80 border border-slate-200/80 rounded-2xl transition-all duration-300 overflow-hidden shadow-sm hover:shadow-md group';
        } else {
            button.setAttribute('aria-expanded', 'true');
            answer.classList.remove('hidden');
            chevron.classList.add('rotate-180', 'bg-mosilGold', 'text-mosilGreenDeep');
            chevron.classList.remove('bg-slate-200/60', 'text-slate-600');
            card.className = 'faq-card bg-white border border-mosilGold/50 ring-4 ring-mosilGold/10 rounded-2xl transition-all duration-300 overflow-hidden shadow-sm hover:shadow-md group';
        }
    }

    function toggleAllFaqs(openState) {
        document.querySelectorAll('#faq-section .faq-card').forEach(card => {
            const btn = card.querySelector('button');
            const isCurrentlyOpen = btn.getAttribute('aria-expanded') === 'true';
            if (openState && !isCurrentlyOpen) {
                toggleFaqAccordion(btn);
            } else if (!openState && isCurrentlyOpen) {
                toggleFaqAccordion(btn);
            }
        });
    }
    </script>
    <?php endif; ?>

    <!-- ================================================== -->
    <!-- SECTION 10: FOOTER & METADATA ZONE (Executive Dark)-->
    <!-- ================================================== -->
    <footer class="bg-mosilGreenDeep text-slate-400 py-12 px-4 sm:px-6 border-t border-mosilGreen/40 text-xs">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="space-y-1 text-center md:text-left">
                <div class="font-bold text-white text-base flex items-center justify-center md:justify-start gap-2">
                    <span class="w-5 h-5 rounded bg-mosilGold text-mosilGreenDeep font-extrabold text-xs inline-flex items-center justify-center">M</span>
                    <span>MOSIL LUBRICANTS PVT. LTD.</span>
                </div>
                <div>Cost Per Component (CPC) Enterprise Masterwork</div>
                <div class="text-slate-500 text-[11px]">Specialized Campaign Page • ISO 9001 & NABL ISO/IEC 17025 Certified</div>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-6 font-medium">
                <a href="#hero" class="hover:text-mosilGold transition">Hero</a>
                <a href="#cost-levers" class="hover:text-mosilGold transition">Value Levers</a>
                <a href="#spec-trust" class="hover:text-mosilGold transition">OEM Specs</a>
                <a href="#cpc-form" class="hover:text-mosilGold transition">CPC Check</a>
                <a href="#proof-lab" class="hover:text-mosilGold transition">TriboIntel™ Lab</a>
                <a href="#faq-section" class="hover:text-mosilGold transition">FAQ</a>
            </div>
            <div class="text-center md:text-right space-y-1">
                <div class="font-bold text-slate-200">Indian Specialty Lubricant Manufacturer</div>
                <div class="text-slate-400">Domestic R&D & NABL Tribology Laboratory</div>
            </div>
        </div>
    </footer>

</div>

<!-- INTERACTIVE SCRIPTS & POST-SUBMIT CONFIRMATION BANNER -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('cpcDiagnosticForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btn = form.querySelector('button[type="submit"]');
            btn.innerHTML = '<span>Submitting Assessment...</span>';
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-not-allowed');
            
            setTimeout(() => {
                const container = form.parentElement;
                container.innerHTML = `
                    <div class="max-w-xl mx-auto bg-emerald-50 border border-emerald-200 p-6 sm:p-8 rounded-2xl shadow-lg flex items-start gap-4 text-emerald-950 text-sm leading-relaxed">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-emerald-950 mb-1">Thank you.</h4>
                            <p class="mb-3">Your CPC check has reached our application engineering team. A MOSIL engineer will revert within <strong>3 working days</strong>.</p>
                            <div class="bg-white/80 p-3 rounded-lg border border-emerald-200 text-xs text-emerald-900">
                                💡 <strong>Next Step:</strong> If you would like to share the OEM specification sheet in the meantime, write to us quoting your company name.
                            </div>
                        </div>
                    </div>
                `;
            }, 1000);
        });
    }
});
</script>
