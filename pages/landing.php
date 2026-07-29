<?php
/**
 * Dynamic Landing Page Master Template - MOSIL Brand Edition
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

<!-- Tailwind CSS Engine Injector with MOSIL Official Brand Palette -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          mosilGreen: '#1A3B1B',
          mosilGreenDark: '#0D2010',
          mosilGreenDeep: '#07140A',
          mosilGold: '#F4C300',
          mosilGoldHover: '#E0B200',
        }
      }
    }
  }
</script>

<div class="bg-slate-50 text-slate-900 font-sans antialiased selection:bg-mosilGold selection:text-mosilGreenDeep">

    <!-- ================================================== -->
    <!-- SECTION 1: HERO / BANNER                           -->
    <!-- ================================================== -->
    <?php if (!empty($hero['headline'])): ?>
        <?php 
            $heroImg = !empty($hero['image']) ? $hero['image'] : 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=1200&q=80';
            $heroAlt = !empty($hero['image_alt']) ? $hero['image_alt'] : 'Precision Automotive Component Grease Application';
            $heroPos = $hero['image_position'] ?? 'right';
        ?>
    <header id="hero" class="bg-mosilGreenDeep text-white pt-24 pb-20 px-6 relative overflow-hidden border-b border-mosilGreen/40">
        
        <!-- Ambient Grid Background Pattern -->
        <div class="absolute inset-0 bg-[radial-gradient(#1A3B1B_1px,transparent_1px)] [background-size:32px_32px] opacity-35 pointer-events-none"></div>
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-[800px] h-[350px] bg-mosilGold/10 blur-[140px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            
            <?php if ($heroPos === 'background'): ?>
                <!-- Hero Full Background Banner Layout -->
                <div class="relative rounded-3xl overflow-hidden border border-white/10 p-8 sm:p-14 text-center max-w-4xl mx-auto bg-cover bg-center shadow-2xl" style="background-image: linear-gradient(to bottom, rgba(7,20,10,0.85), rgba(7,20,10,0.95)), url('<?php echo htmlspecialchars($heroImg); ?>');">
                    <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-mosilGreen/80 border border-mosilGold/30 shadow-md mb-6">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-mosilGold opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-mosilGold"></span>
                        </span>
                        <span class="font-mono text-xs font-bold uppercase tracking-wider text-mosilGold">
                            AUTOMOTIVE COMPONENT LUBRICATION
                        </span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-[1.15] mb-6">
                        <?php echo htmlspecialchars($hero['headline']); ?>
                    </h1>

                    <?php if (!empty($hero['sub_headline'])): ?>
                        <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl mx-auto mb-8 font-normal">
                            <?php echo htmlspecialchars($hero['sub_headline']); ?>
                        </p>
                    <?php endif; ?>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="#cpc-form" class="bg-mosilGold hover:bg-mosilGoldHover text-mosilGreenDeep font-bold px-8 py-4 rounded-xl shadow-lg hover:-translate-y-0.5 transition-all flex items-center gap-3 text-base sm:text-lg group">
                            <span><?php echo htmlspecialchars($hero['cta_text'] ?? 'Start the CPC Check — 5 minutes'); ?></span>
                            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                    <?php if (!empty($hero['micro_line'])): ?>
                        <div class="text-xs sm:text-sm text-slate-400 flex items-center justify-center gap-2 pt-3">
                            <svg class="w-4 h-4 text-mosilGold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            <span><?php echo htmlspecialchars($hero['micro_line']); ?></span>
                        </div>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <!-- Hero 2-Column Asymmetric Bento Grid (Right vs Left Image) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center <?php echo $heroPos === 'left' ? 'lg:flex-row-reverse' : ''; ?>">
                    
                    <!-- Text Column -->
                    <div class="lg:col-span-7 space-y-6 text-left <?php echo $heroPos === 'left' ? 'lg:order-2' : ''; ?>">
                        
                        <!-- Eyebrow Pill Tag -->
                        <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-mosilGreenDark border border-mosilGreen/60 shadow-md">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-mosilGold opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-mosilGold"></span>
                            </span>
                            <span class="font-mono text-xs font-bold uppercase tracking-wider text-mosilGold">
                                AUTOMOTIVE COMPONENT LUBRICATION
                            </span>
                        </div>

                        <!-- Main Headline (H1) -->
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-[1.15]">
                            <?php echo htmlspecialchars($hero['headline']); ?>
                        </h1>

                        <!-- Subheadline -->
                        <?php if (!empty($hero['sub_headline'])): ?>
                            <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl font-normal">
                                <?php echo htmlspecialchars($hero['sub_headline']); ?>
                            </p>
                        <?php endif; ?>

                        <!-- CTA Button Stack -->
                        <div class="pt-2 space-y-3">
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                                <a href="#cpc-form" class="bg-mosilGold hover:bg-mosilGoldHover text-mosilGreenDeep font-bold px-8 py-4 rounded-xl shadow-lg hover:-translate-y-0.5 transition-all flex items-center justify-center gap-3 text-base sm:text-lg group">
                                    <span><?php echo htmlspecialchars($hero['cta_text'] ?? 'Start the CPC Check — 5 minutes'); ?></span>
                                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>

                            <!-- Micro-line -->
                            <?php if (!empty($hero['micro_line'])): ?>
                                <div class="text-xs sm:text-sm text-slate-400 flex items-center gap-2 pt-1">
                                    <svg class="w-4 h-4 text-mosilGold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                    <span><?php echo htmlspecialchars($hero['micro_line']); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- KPI Bar -->
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

                    <!-- Image Column -->
                    <div class="lg:col-span-5 relative <?php echo $heroPos === 'left' ? 'lg:order-1' : ''; ?>">
                        <div class="relative rounded-2xl overflow-hidden border border-mosilGreen/60 shadow-2xl bg-mosilGreenDark aspect-[4/3] group">
                            <img src="<?php echo htmlspecialchars($heroImg); ?>" alt="<?php echo htmlspecialchars($heroAlt); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-mosilGreenDeep via-mosilGreenDeep/40 to-transparent"></div>

                            <!-- Floating Glassmorphic Overlay Badge -->
                            <div class="absolute bottom-4 left-4 right-4 bg-mosilGreenDeep/90 backdrop-blur-md p-4 rounded-xl border border-white/10 text-xs text-slate-200 flex items-center gap-3.5 shadow-2xl">
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
    <!-- SECTION 2: COST LEVERS                             -->
    <!-- ================================================== -->
    <?php if (!empty($levers['formula']) || (!empty($levers['items']) && count($levers['items']) > 0)): ?>
    <section id="cost-levers" class="bg-slate-50 py-20 px-6 border-b border-slate-200">
        <div class="max-w-7xl mx-auto">
            
            <div class="text-center max-w-3xl mx-auto mb-3">
                <span class="text-xs font-bold uppercase tracking-widest text-mosilGreen bg-mosilGreen/10 px-3.5 py-1 rounded-full border border-mosilGreen/20">CPC Arithmetic</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3 mb-2">
                    <?php echo htmlspecialchars($levers['intro_1'] ?? 'Where the Grease Cost Actually Sits'); ?>
                </h2>
                <?php if (!empty($levers['intro_2'])): ?>
                    <p class="text-slate-600 text-base sm:text-lg">
                        <?php echo htmlspecialchars($levers['intro_2']); ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Highlighted Formula Band -->
            <?php if (!empty($levers['formula'])): ?>
            <div class="max-w-3xl mx-auto my-8 p-6 sm:p-8 bg-mosilGreenDeep rounded-2xl border-l-4 border-mosilGold shadow-xl text-mosilGold font-mono text-sm sm:text-base md:text-lg leading-relaxed text-center overflow-x-auto">
                <span class="text-xs uppercase tracking-widest text-slate-400 font-sans block mb-2">Cost Per Component Equation</span>
                <?php echo htmlspecialchars($levers['formula']); ?>
            </div>
            <?php endif; ?>

            <!-- 3-Card Grid for Value Levers -->
            <?php if (!empty($levers['items']) && count($levers['items']) > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 mb-12 mt-8">
                <?php foreach ($levers['items'] as $index => $item): ?>
                <div class="bg-white p-6 sm:p-8 rounded-2xl border <?php echo $index === 1 ? 'border-2 border-mosilGold shadow-md' : 'border-slate-200 shadow-sm'; ?> hover:shadow-xl transition-all duration-200 hover:-translate-y-1 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-mosilGreen/10 text-mosilGreen font-mono font-bold text-base flex items-center justify-center mb-5">
                            0<?php echo $index + 1; ?>
                        </div>
                        <h3 class="text-xl font-bold <?php echo $index === 1 ? 'text-mosilGreen' : 'text-slate-900'; ?> mb-3 uppercase tracking-wide">
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

            <!-- Footer Line -->
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
    <!-- SECTION 3: ON SPECIFICATIONS — TRUST BLOCK        -->
    <!-- ================================================== -->
    <?php if (!empty($trust['heading']) || !empty($trust['body_1'])): ?>
        <?php
            $trustPos = $trust['image_position'] ?? 'right';
            $trustImg = $trust['image'] ?? '';
            $trustAlt = $trust['image_alt'] ?? 'MOSIL Specification Match';
        ?>
    <section class="bg-white py-16 px-6 border-b border-slate-200">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left Content -->
                <div class="lg:col-span-6 space-y-5 <?php echo $trustPos === 'left' ? 'lg:order-2' : ''; ?>">
                    <span class="text-xs font-mono font-semibold text-mosilGreen uppercase tracking-wider bg-mosilGreen/10 px-3 py-1 rounded-full border border-mosilGreen/20 inline-block">COMPLIANCE FIRST</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
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

                    <!-- Callout Box -->
                    <?php if (!empty($trust['sub_line'])): ?>
                    <div class="bg-amber-50 border-l-4 border-mosilGold p-4 rounded-r-xl text-sm text-slate-900 font-semibold">
                        <?php echo htmlspecialchars($trust['sub_line']); ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Right Side Image or Spec Matrix Card -->
                <div class="lg:col-span-6 <?php echo $trustPos === 'left' ? 'lg:order-1' : ''; ?>">
                    <?php if (!empty($trustImg)): ?>
                        <div class="relative rounded-2xl overflow-hidden border border-slate-200 shadow-lg">
                            <img src="<?php echo htmlspecialchars($trustImg); ?>" alt="<?php echo htmlspecialchars($trustAlt); ?>" class="w-full h-auto object-cover">
                        </div>
                    <?php else: ?>
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-md">
                            <div class="flex items-center justify-between border-b border-slate-200 pb-3 mb-4">
                                <span class="text-xs font-mono font-bold uppercase text-slate-900">OEM Spec Match Matrix</span>
                                <span class="text-xs font-bold text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full">100% Parameter Match</span>
                            </div>
                            <div class="space-y-3 font-mono text-xs sm:text-sm">
                                <div class="grid grid-cols-3 gap-2 bg-white p-3 rounded-lg border border-slate-200 font-bold text-slate-800">
                                    <span>Test Parameter</span>
                                    <span class="text-center">OEM Target</span>
                                    <span class="text-right text-emerald-600">MOSIL Match</span>
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
    <!-- SECTION 4: DIAGNOSTIC FORM HEADER & FORM           -->
    <!-- ================================================== -->
    <?php if (!empty($form['heading'])): ?>
    <section id="cpc-form" class="bg-slate-50 pt-20 pb-24 px-6 border-b border-slate-200">
        <div class="max-w-3xl mx-auto">
            
            <div class="text-center mb-10">
                <span class="text-xs font-bold uppercase tracking-widest text-mosilGreen bg-mosilGreen/10 px-3.5 py-1 rounded-full border border-mosilGreen/20">Enterprise Diagnostic</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3 mb-3 text-center">
                    <?php echo htmlspecialchars($form['heading']); ?>
                </h2>
                <?php if (!empty($form['intro'])): ?>
                    <p class="text-slate-600 text-center text-base sm:text-lg mb-6">
                        <?php echo htmlspecialchars($form['intro']); ?>
                    </p>
                <?php endif; ?>

                <!-- Confidentiality Banner -->
                <?php if (!empty($form['confidentiality'])): ?>
                <div class="bg-sky-50 border border-sky-200 p-4 rounded-xl text-xs sm:text-sm text-sky-900 flex items-start gap-3 shadow-sm text-left">
                    <svg class="w-5 h-5 text-sky-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <span><?php echo htmlspecialchars($form['confidentiality']); ?></span>
                </div>
                <?php endif; ?>
            </div>

            <!-- Form Card Container -->
            <div class="bg-white p-6 sm:p-10 rounded-2xl border border-slate-200 shadow-xl relative">
                <form action="ajax/submit-cpc.php" method="POST" id="cpcDiagnosticForm" class="space-y-8">
                    <input type="hidden" name="landing_id" value="<?php echo htmlspecialchars($id); ?>">
                    
                    <!-- Part A: Direction -->
                    <div class="bg-slate-50 p-6 rounded-xl border border-slate-200">
                        <h4 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-200 pb-2">Part A — Direction (All Respondents)</h4>
                        <div class="space-y-4">
                            <div>
                                <label class="block font-semibold text-slate-800 text-sm mb-1.5">Q1. Are you currently working on reducing your cost per component?</label>
                                <select name="working_on_reduction" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:ring-2 focus:ring-mosilGreen/20 focus:outline-none">
                                    <option value="">Select an option...</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="Not formally, but there is pressure to">Not formally, but there is pressure to</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-800 text-sm mb-1.5">Q2. What is your primary route to reducing CPC?</label>
                                <select name="reduction_route" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:ring-2 focus:ring-mosilGreen/20 focus:outline-none">
                                    <option value="">Select an option...</option>
                                    <option value="Grease cost">Grease cost</option>
                                    <option value="Inventory and working capital">Inventory and working capital</option>
                                    <option value="Both">Both</option>
                                    <option value="Not decided yet">Not decided yet</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-800 text-sm mb-1.5">Q3. Approximately what is your annual spend on assembly greases?</label>
                                <select name="annual_spend" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:ring-2 focus:ring-mosilGreen/20 focus:outline-none">
                                    <option value="">Select an option...</option>
                                    <option value="Under ₹10 lakh">Under ₹10 lakh</option>
                                    <option value="₹10–50 lakh">₹10–50 lakh</option>
                                    <option value="₹50 lakh – ₹2 crore">₹50 lakh – ₹2 crore</option>
                                    <option value="Above ₹2 crore">Above ₹2 crore</option>
                                    <option value="Prefer not to disclose">Prefer not to disclose</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Part B: Contact Details -->
                    <div class="bg-slate-50 p-6 rounded-xl border border-slate-200">
                        <h4 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-200 pb-2">Part B — Before we go further: Who should we revert to?</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block font-semibold text-slate-800 text-xs mb-1">Full Name *</label><input type="text" name="full_name" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:ring-2 focus:ring-mosilGreen/20 focus:outline-none" placeholder="Rajesh Kumar" required></div>
                            <div><label class="block font-semibold text-slate-800 text-xs mb-1">Designation *</label><input type="text" name="designation" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:ring-2 focus:ring-mosilGreen/20 focus:outline-none" placeholder="GM Procurement" required></div>
                            <div>
                                <label class="block font-semibold text-slate-800 text-xs mb-1">Function *</label>
                                <select name="function" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:ring-2 focus:ring-mosilGreen/20 focus:outline-none" required>
                                    <option value="">Select Function...</option>
                                    <option value="Procurement">Procurement</option>
                                    <option value="Vendor development">Vendor development</option>
                                    <option value="Design">Design</option>
                                    <option value="R&D">R&D</option>
                                    <option value="Quality">Quality</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div><label class="block font-semibold text-slate-800 text-xs mb-1">Company *</label><input type="text" name="company" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:ring-2 focus:ring-mosilGreen/20 focus:outline-none" placeholder="AutoComp Industries" required></div>
                            <div><label class="block font-semibold text-slate-800 text-xs mb-1">Plant Location (City) *</label><input type="text" name="city" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:ring-2 focus:ring-mosilGreen/20 focus:outline-none" placeholder="Pune" required></div>
                            <div><label class="block font-semibold text-slate-800 text-xs mb-1">Work Email *</label><input type="email" name="work_email" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:ring-2 focus:ring-mosilGreen/20 focus:outline-none" placeholder="r.kumar@autocomp.com" required></div>
                            <div class="md:col-span-2"><label class="block font-semibold text-slate-800 text-xs mb-1">Mobile Number *</label><input type="tel" name="mobile_number" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:ring-2 focus:ring-mosilGreen/20 focus:outline-none" placeholder="10-digit mobile number" pattern="[0-9]{10}" required></div>
                        </div>
                    </div>

                    <!-- Part C: Grease Cost Route -->
                    <div class="bg-slate-50 p-6 rounded-xl border border-slate-200">
                        <div class="bg-slate-200 text-slate-700 text-xs font-bold px-3 py-1.5 rounded mb-4 text-center tracking-wider uppercase">Skip this section if grease cost is not one of your routes.</div>
                        <h4 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-200 pb-2">Part C — Grease Cost Route</h4>
                        <div class="space-y-4">
                            <div><label class="block font-semibold text-slate-800 text-sm mb-1.5">Q4. Have you already identified a specific grease you want an alternate for?</label><select name="q4" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:outline-none"><option value="">Select...</option><option value="Yes">Yes</option><option value="No">No</option></select></div>
                            <div><label class="block font-semibold text-slate-800 text-sm mb-1.5">Q5. Which grease carries the largest annual budget allocation in your plant?</label><input type="text" name="q5" placeholder="Application or component name (e.g. CV joint grease)" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:outline-none"></div>
                            <div><label class="block font-semibold text-slate-800 text-sm mb-1.5">Q6. Would you like MOSIL to evaluate that grease for a CPC reduction project?</label><select name="q6" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:outline-none"><option value="">Select...</option><option value="Yes">Yes</option><option value="No">No</option><option value="Later in the year">Later in the year</option></select></div>
                            <div><label class="block font-semibold text-slate-800 text-sm mb-1.5">Q7. Which component is the grease applied on, and at what stage of assembly?</label><textarea name="q7" rows="2" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:outline-none"></textarea></div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div><label class="block font-semibold text-slate-800 text-xs mb-1">Q8. Physio-chemical specs specified?</label><select name="q8" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:outline-none"><option value="">Select...</option><option value="Yes">Yes</option><option value="No">No</option><option value="Not sure">Not sure</option></select></div>
                                <div><label class="block font-semibold text-slate-800 text-xs mb-1">Q9. Performance specs specified?</label><select name="q9" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:outline-none"><option value="">Select...</option><option value="Yes">Yes</option><option value="No">No</option><option value="Not sure">Not sure</option></select></div>
                            </div>
                            <div><label class="block font-semibold text-slate-800 text-sm mb-1.5">Q10. Approximately how much grease is applied per component?</label>
                                <div class="flex gap-2">
                                    <input type="text" name="q10_amount" placeholder="Amount (e.g. 2.5)" class="w-2/3 p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:outline-none">
                                    <select name="q10_unit" class="w-1/3 p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:outline-none"><option value="">Unit...</option><option value="grams">grams</option><option value="millilitres">ml</option><option value="Not measured">Not measured</option></select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Part D: Validation Preference -->
                    <div class="bg-slate-50 p-6 rounded-xl border border-slate-200">
                        <div class="bg-slate-200 text-slate-700 text-xs font-bold px-3 py-1.5 rounded mb-4 text-center tracking-wider uppercase">Answer only if you completed Part C.</div>
                        <h4 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-200 pb-2">Part D — Validation Preference</h4>
                        <div>
                            <label class="block font-semibold text-slate-800 text-sm mb-1.5">Q11. If MOSIL proposes an alternate built to your OEM spec, how would you want it validated?</label>
                            <select name="q11" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:outline-none">
                                <option value="">Select Route...</option>
                                <option value="Validation at MOSIL's NABL-accredited TriboIntel laboratory">Validation at MOSIL's NABL-accredited TriboIntel laboratory (report shared with you)</option>
                                <option value="Validation at a third-party laboratory">Validation at a third-party laboratory we nominate (testing cost to our account)</option>
                                <option value="Both">Both — MOSIL testing first, third-party confirmation before changeover</option>
                                <option value="We will decide after seeing the proposal">We will decide after seeing the proposal</option>
                                <option value="Not looking at validation at this stage">Not looking at validation at this stage</option>
                            </select>
                        </div>
                    </div>

                    <!-- Part E: Inventory Route -->
                    <div class="bg-slate-50 p-6 rounded-xl border border-slate-200">
                        <div class="bg-slate-200 text-slate-700 text-xs font-bold px-3 py-1.5 rounded mb-4 text-center tracking-wider uppercase">Skip this section if inventory is not one of your routes.</div>
                        <h4 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-200 pb-2">Part E — Inventory & Working Capital Route</h4>
                        <div class="space-y-4">
                            <div><label class="block font-semibold text-slate-800 text-sm mb-1.5">Q12. What is your current lead time from grease order to receipt?</label><select name="q12" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:outline-none"><option value="">Select...</option><option value="Under 2 weeks">Under 2 weeks</option><option value="2-4 weeks">2–4 weeks</option><option value="1-2 months">1–2 months</option><option value="Over 2 months">Over 2 months</option><option value="Varies widely">Varies widely</option></select></div>
                            <div><label class="block font-semibold text-slate-800 text-sm mb-1.5">Q13. How many days of grease stock do you currently hold?</label><input type="number" name="q13" placeholder="Days (e.g. 45)" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:outline-none"></div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div><label class="block font-semibold text-slate-800 text-xs mb-1">Q14a. Target lead time?</label><input type="text" name="q14a" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:outline-none"></div>
                                <div><label class="block font-semibold text-slate-800 text-xs mb-1">Q14b. Target days of stock?</label><input type="text" name="q14b" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:outline-none"></div>
                            </div>
                            <div><label class="block font-semibold text-slate-800 text-sm mb-1.5">Q15. Is any part of your grease requirement currently imported?</label><select name="q15" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:outline-none"><option value="">Select...</option><option value="Yes, fully">Yes, fully</option><option value="Yes, partly">Yes, partly</option><option value="No">No</option><option value="Not sure">Not sure</option></select></div>
                        </div>
                    </div>

                    <!-- Part F: Design Route -->
                    <div class="bg-slate-50 p-6 rounded-xl border border-slate-200">
                        <div class="bg-slate-200 text-slate-700 text-xs font-bold px-3 py-1.5 rounded mb-4 text-center tracking-wider uppercase">For design & R&D teams, or anyone who answered No at Q1.</div>
                        <h4 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-200 pb-2">Part F — Design & New Projects (Nurture Route)</h4>
                        <div class="space-y-4">
                            <div><label class="block font-semibold text-slate-800 text-sm mb-1.5">Q16. Are there new components in development where grease is not yet finalised?</label><select name="q16" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:outline-none"><option value="">Select...</option><option value="Yes">Yes</option><option value="No">No</option><option value="Cannot disclose">Cannot disclose at this stage</option></select></div>
                            <div><label class="block font-semibold text-slate-800 text-sm mb-1.5">Q17. What are those components or programmes, broadly?</label><input type="text" name="q17" placeholder="Component type and expected SOP timing..." class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:outline-none"></div>
                            <div><label class="block font-semibold text-slate-800 text-sm mb-1.5">Q18. At what stage would you want a grease supplier involved?</label><select name="q18" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:outline-none"><option value="">Select...</option><option value="Concept and specification stage">Concept and specification stage</option><option value="Prototype and validation">Prototype and validation</option><option value="Pre-production">Pre-production</option><option value="Only after OEM approval">Only after OEM approval</option></select></div>
                            <div><label class="block font-semibold text-slate-800 text-sm mb-1.5">Q19. Anything else we should know before we revert?</label><textarea name="q19" rows="2" class="w-full p-3 text-sm rounded-lg border border-slate-300 bg-white focus:border-mosilGreen focus:outline-none"></textarea></div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center pt-4">
                        <button type="submit" class="bg-mosilGold hover:bg-mosilGoldHover text-mosilGreenDeep font-bold px-10 py-4 rounded-xl shadow-lg hover:-translate-y-0.5 transition-all inline-flex items-center justify-center gap-2 text-lg w-full sm:w-auto">
                            <span>Submit My CPC Check</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================================================== -->
    <!-- SECTION 5: THE QUADRA APPROACH®                   -->
    <!-- ================================================== -->
    <?php if (!empty($approach['stages']) && count($approach['stages']) > 0): ?>
    <section class="bg-white py-20 px-6 border-b border-slate-200">
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="text-xs font-bold uppercase tracking-widest text-mosilGreen bg-mosilGreen/10 px-3.5 py-1 rounded-full border border-mosilGreen/20">Our Methodology</span>
                <h2 class="text-3xl font-bold text-slate-900 mt-3 mb-3">
                    How We Work: The Quadra Approach®
                </h2>
                <?php if (!empty($approach['intro'])): ?>
                    <p class="text-slate-600">
                        <?php echo htmlspecialchars($approach['intro']); ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Dynamic Stages Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($approach['stages'] as $stage): ?>
                <div class="bg-white border border-slate-200 border-t-4 border-t-mosilGold p-6 rounded-xl shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div>
                        <div class="font-mono text-xs font-bold text-mosilGreen mb-2 uppercase tracking-wider">
                            Stage 0<?php echo htmlspecialchars($stage['number'] ?? 1); ?>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 uppercase tracking-wide mb-3">
                            <?php echo htmlspecialchars($stage['title']); ?>
                        </h3>
                        <p class="text-slate-600 text-xs leading-relaxed">
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
    <!-- SECTION 6: PROOF & TRIBOINTEL™ LAB (Dark Theme)    -->
    <!-- ================================================== -->
    <?php if (!empty($proof['heading']) || !empty($proof['body_1'])): ?>
        <?php 
            $proofPos = $proof['image_position'] ?? 'right';
            $proofImg = $proof['image'] ?? '';
            $proofAlt = $proof['image_alt'] ?? 'MOSIL TriboIntel Laboratory';
        ?>
    <section class="bg-mosilGreenDeep py-20 px-6 border-b border-mosilGreen/40 text-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left Column -->
                <div class="lg:col-span-7 space-y-6 <?php echo $proofPos === 'left' ? 'lg:order-2' : ''; ?>">
                    <span class="text-xs font-mono font-semibold text-mosilGold bg-mosilGreenDark px-3.5 py-1 rounded-full border border-mosilGreen/60 uppercase tracking-wider">NABL ACCREDITED LAB</span>
                    <h2 class="text-3xl font-bold text-white mb-4">
                        <?php echo htmlspecialchars($proof['heading']); ?>
                    </h2>
                    
                    <?php if (!empty($proof['body_1'])): ?>
                        <p class="text-slate-300 leading-relaxed mb-4">
                            <?php echo htmlspecialchars($proof['body_1']); ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($proof['body_2'])): ?>
                        <p class="text-slate-300 leading-relaxed mb-8">
                            <?php echo htmlspecialchars($proof['body_2']); ?>
                        </p>
                    <?php endif; ?>

                    <!-- Dynamic Trust Badges / Chips -->
                    <?php if (!empty($proof['badges']) && count($proof['badges']) > 0): ?>
                        <div class="flex flex-wrap gap-2 text-xs font-mono">
                            <?php foreach ($proof['badges'] as $badgeText): ?>
                                <span class="bg-mosilGreenDark text-mosilGold border border-mosilGreen/60 px-3.5 py-1.5 rounded-full flex items-center gap-1.5">
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
                        <div class="bg-mosilGreenDark/80 backdrop-blur-md border border-mosilGreen/60 p-8 rounded-2xl shadow-2xl relative overflow-hidden text-center">
                            <div class="w-14 h-14 rounded-2xl bg-mosilGold/20 text-mosilGold flex items-center justify-center mx-auto mb-4">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-1">TriboIntel™ Laboratory</h3>
                            <div class="font-mono text-xs text-mosilGold font-bold mb-3 uppercase">ISO/IEC 17025 ACCREDITED</div>
                            <p class="text-xs text-slate-400 leading-relaxed">
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
    <!-- SECTION 7: POST-SUBMISSION PROCESS                 -->
    <!-- ================================================== -->
    <?php if (!empty($process['steps']) && count($process['steps']) > 0): ?>
    <section class="bg-slate-50 py-16 px-6 border-b border-slate-200">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-900 mb-2">
                    <?php echo htmlspecialchars($process['heading'] ?? 'What Happens After You Submit'); ?>
                </h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-<?php echo min(count($process['steps']), 4); ?> gap-6">
                <?php foreach ($process['steps'] as $idx => $step): ?>
                    <?php $stepText = is_array($step) ? ($step['description'] ?? '') : $step; ?>
                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="w-10 h-10 rounded-lg bg-mosilGreen/10 text-mosilGreen font-mono font-bold flex items-center justify-center mb-4">
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
    <!-- SECTION 9: FREQUENTLY ASKED QUESTIONS             -->
    <!-- ================================================== -->
    <?php if (!empty($faq) && count($faq) > 0): ?>
    <section class="bg-white py-20 px-6">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-slate-900 mb-12">Frequently Asked Questions</h2>
            
            <div class="space-y-4">
                <?php foreach ($faq as $idx => $item): ?>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 mb-4 space-y-2">
                        <div class="font-bold text-base text-slate-900 flex items-center gap-2">
                            <span class="text-mosilGreen font-mono">Q.</span>
                            <span><?php echo htmlspecialchars($item['q']); ?></span>
                        </div>
                        <div class="text-slate-600 text-sm leading-relaxed pl-6"><?php echo htmlspecialchars($item['a']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================================================== -->
    <!-- SECTION 10: FOOTER & METADATA ZONE                -->
    <!-- ================================================== -->
    <footer class="bg-mosilGreenDeep text-slate-400 py-12 px-6 border-t border-mosilGreen/40 text-xs">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="space-y-1 text-center md:text-left">
                <div class="font-bold text-white text-base">MOSIL LUBRICANTS PVT. LTD.</div>
                <div>Cost Per Component (CPC) Landing Page</div>
                <div class="text-slate-500 text-[11px]">Specialized Landing Page • Not for general navigation</div>
            </div>
            <div class="flex items-center gap-6">
                <a href="#hero" class="hover:text-white transition">Hero</a>
                <a href="#cost-levers" class="hover:text-white transition">Value Levers</a>
                <a href="#cpc-form" class="hover:text-white transition">CPC Check</a>
            </div>
            <div class="text-center md:text-right space-y-1">
                <div class="font-bold text-slate-200">Indian Specialty Lubricant Manufacturer</div>
                <div>ISO 9001 & NABL ISO/IEC 17025 Certified</div>
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
                    <div class="max-w-xl mx-auto bg-emerald-50 border border-emerald-200 p-6 rounded-2xl shadow-lg flex items-start gap-4 text-emerald-950 text-sm leading-relaxed">
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
