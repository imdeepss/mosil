<?php
/**
 * Master Landing Page - Premium 2-Column Split Layout
 * Left: Eyebrow, Headline (with break), Subhead (wording fix), 3 CPC Checkmarks, Campaign Image
 * Right: Dark-themed Form Card with Side-by-Side Email/Phone Inputs
 */

if (!isset($landingData) || empty($landingData)) {
    echo "<div class='container mx-auto py-20 text-center'><h2 class='text-2xl font-bold text-slate-800'>Landing page data not found.</h2></div>";
    return;
}

// Extract variables with legacy fallbacks
$id = $landingData['id'] ?? 'campaign';
$seo = $landingData['seo'] ?? [];

$banner = $landingData['banner'] ?? [];
if (empty($banner) && !empty($landingData['hero'])) {
    $banner = $landingData['hero'];
}

$headline = $banner['headline'] ?? "The grease you apply on the component is a line item in your cost per component.\nWhen did you last challenge it?";
$sub_headline = $banner['sub_headline'] ?? "MOSIL works with component manufacturers to reduce the grease element of cost per component — without compromising performance approved by your OEM.";
$cta_text = 'Schedule CPC check';
$banner_image = !empty($banner['image']) ? $banner['image'] : 'assets/uploads/campaigns/cpc_6a68f90e1fb2c.png';
$banner_image_alt = $banner['image_alt'] ?? 'Automotive Component Grease Application';
$banner_image_pos = $banner['image_position'] ?? 'right';

$form_heading = 'Share your details so that Our Team can get back to you for discussion';
$form_intro = '';
$form_email_to = $form_data['email_to'] ?? '';
$form_success_msg = $form_data['success_message'] ?? 'Thank you! Your inquiry has been received. We will contact you shortly.';

$isNoIndex = !empty($seo['noindex']);

// Set headers for index.php to read
$pageTitle = !empty($seo['title']) ? $seo['title'] : ("Cost Per Component Campaign | " . SITE_NAME);
$metaDescription = !empty($seo['description']) ? $seo['description'] : substr(strip_tags($sub_headline), 0, 160);
?>

<?php if ($isNoIndex): ?>
    <meta name="robots" content="noindex, nofollow">
<?php endif; ?>

<!-- Inject Tailwind CSS for arbitrary style rendering -->
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
                    mosilGoldLight: '#FEF9E6',
                }
            }
        }
    }
</script>

<style>
    /* Hide only specific floating chat/search widgets, NOT the header or footer */
    .whatsapp-widget,
    #sarah-widget-container,
    .whatsapp-btn,
    #openMobileSearch,
    [class*="whatsapp"],
    [id*="whatsapp"],
    [class*="sarah"],
    [id*="sarah"] {
        display: none !important;
        visibility: hidden !important;
        height: 0 !important;
        overflow: hidden !important;
    }

    main#main-content {
        margin-top: 0 !important;
        padding-top: 60px !important;
        /* Offset for main website fixed header */
        background-color: #ffffff !important;
        /* White page background */
    }

    html {
        scroll-behavior: smooth;
    }

    /* Premium text gradient with solid fallback for light backgrounds */
    .gradient-text {
        background: linear-gradient(135deg, #1A3B1B 60%, #3a753e 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        color: #1A3B1B;
    }

    /* Force global site header to be solid, dark-colored, and fully visible on the landing page */
    body>header {
        background-color: #07140A !important;
        display: block !important;
        visibility: visible !important;
        height: 60px !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    /* Force global footer to be solid and fully visible */
    body>footer {
        background-color: #07140A !important;
        display: block !important;
        visibility: visible !important;
        border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
        color: #cbd5e1 !important;
        padding-top: 4rem !important;
        padding-bottom: 3rem !important;
    }

    body>footer a {
        color: #ffffff !important;
    }

    body>footer a:hover {
        color: #F4C300 !important;
    }
</style>

<div
    class="text-slate-900 min-h-[calc(100vh-60px)] flex flex-col justify-between selection:bg-mosilGold selection:text-slate-900">

    <main class="flex-grow">
        <!-- ================================================== -->
        <!-- 2-COLUMN SPLIT LANDING CONTAINER -->
        <!-- ================================================== -->
        <section class="relative py-12 md:py-20 px-6 overflow-hidden">
            <!-- Decorative Ambient Glows -->
            <div
                class="absolute -top-40 left-1/4 w-[600px] h-[600px] bg-mosilGold/10 rounded-full blur-[150px] pointer-events-none">
            </div>
            <div
                class="absolute -bottom-40 right-1/4 w-[500px] h-[500px] bg-mosilGreen/10 rounded-full blur-[130px] pointer-events-none">
            </div>
            <div
                class="absolute inset-0 bg-[radial-gradient(#1A3B1B_1.2px,transparent_1.2px)] [background-size:24px_24px] opacity-5 pointer-events-none">
            </div>

            <div class="container relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">

                    <!-- ================================================== -->
                    <!-- LEFT COLUMN: CAMPAIGN INFO, BULLETS, IMAGE -->
                    <!-- ================================================== -->
                    <div class="lg:col-span-7 space-y-8">

                        <!-- Eyebrow Badge -->
                        <div
                            class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-100 border border-slate-200/60 text-[11px] font-black text-mosilGreen uppercase tracking-widest">
                            <span class="relative flex h-2 w-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-mosilGreen opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-mosilGreen"></span>
                            </span>
                            <span>Spec-Matching Specialty Lubrication</span>
                        </div>

                        <!-- Main Headline (Allows break sequence via nl2br) -->
                        <h1
                            class="text-3xl sm:text-4xl lg:text-[46px] font-black leading-[1.2] tracking-tight gradient-text text-left max-w-2xl">
                            <?php echo nl2br(htmlspecialchars($headline)); ?>
                        </h1>

                        <!-- Subheadline (Wording Refined: removing "automotive" & focusing on compromise) -->
                        <?php if (!empty($sub_headline)): ?>
                            <p class="text-slate-600 text-sm sm:text-base leading-relaxed font-light text-left max-w-2xl">
                                <?php echo htmlspecialchars($sub_headline); ?>
                            </p>
                        <?php endif; ?>

                        <!-- Bullet points with custom SVGs -->
                        <div class="space-y-4 max-w-2xl pt-2">
                            <!-- Bullet 1 -->
                            <div
                                class="flex items-start gap-4 p-4 rounded-2xl bg-white border border-slate-200 shadow-sm transition-all hover:bg-slate-50/50 hover:shadow-md hover:border-slate-300">
                                <div
                                    class="w-9 h-9 rounded-xl bg-mosilGold/15 text-mosilGreen flex items-center justify-center shrink-0 border border-mosilGold/20 shadow-inner">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-extrabold text-mosilGreen">Specification-Matching
                                        Formulations
                                    </h4>
                                    <p class="text-slate-500 text-xs font-light mt-1">Products are formulated to match
                                        or exceed physical & performance OEM test requirements.</p>
                                </div>
                            </div>

                            <!-- Bullet 2 (Renamed to Documented Performance Validation) -->
                            <div
                                class="flex items-start gap-4 p-4 rounded-2xl bg-white border border-slate-200 shadow-sm transition-all hover:bg-slate-50/50 hover:shadow-md hover:border-slate-300">
                                <div
                                    class="w-9 h-9 rounded-xl bg-mosilGold/15 text-mosilGreen flex items-center justify-center shrink-0 border border-mosilGold/20 shadow-inner">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-extrabold text-mosilGreen">TriboIntel™ Documented</h4>
                                    <p class="text-slate-500 text-xs font-light mt-1">Validated within our
                                        state-of-the-art, NABL-accredited tribology performance testing center.</p>
                                </div>
                            </div>

                            <!-- Bullet 3 -->
                            <div
                                class="flex items-start gap-4 p-4 rounded-2xl bg-white border border-slate-200 shadow-sm transition-all hover:bg-slate-50/50 hover:shadow-md hover:border-slate-300">
                                <div
                                    class="w-9 h-9 rounded-xl bg-mosilGold/15 text-mosilGreen flex items-center justify-center shrink-0 border border-mosilGold/20 shadow-inner">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-extrabold text-mosilGreen">Zero Import & Logistics Delays
                                    </h4>
                                    <p class="text-slate-500 text-xs font-light mt-1">Eliminating long lead times,
                                        customs regulations, and high overseas freight margins.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Campaign image rendering (with correct path & border styling) -->
                        <?php if (!empty($banner_image)): ?>
                            <div class="pt-4 max-w-2xl">
                                <div
                                    class="border border-slate-200 rounded-2xl overflow-hidden bg-white p-2 shadow-md hover:border-slate-300 hover:shadow-lg transition-all duration-300">
                                    <img src="<?php echo SITE_URL . '/' . htmlspecialchars($banner_image); ?>"
                                        alt="<?php echo htmlspecialchars($banner_image_alt); ?>"
                                        class="w-full h-auto rounded-xl object-cover">
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>

                    <!-- ================================================== -->
                    <!-- RIGHT COLUMN: THE DARK FORM CARD -->
                    <!-- ================================================== -->
                    <div class="lg:col-span-5">
                        <div
                            class="bg-white border border-slate-200/80 rounded-[32px] p-8 sm:p-10 shadow-[0_30px_60px_rgba(0,0,0,0.05)] relative overflow-hidden">
                            <!-- Soft corner ambient glow -->
                            <div
                                class="absolute -top-12 -right-12 w-28 h-28 bg-mosilGreen/5 rounded-full blur-2xl pointer-events-none">
                            </div>

                            <!-- Form content wrapper -->
                            <div id="landingFormContent" class="space-y-6 relative z-10">
                                <div class="space-y-2">
                                    <h3 class="text-xl sm:text-2xl font-black text-mosilGreen tracking-tight">
                                        <?php echo htmlspecialchars($form_heading); ?>
                                    </h3>
                                    <p
                                        class="text-slate-500 text-xs leading-relaxed font-light border-l-2 border-mosilGold pl-2.5">
                                        <?php echo htmlspecialchars($form_intro); ?>
                                    </p>
                                </div>

                                <!-- Validation alert banner -->
                                <div id="formErrorBanner"
                                    class="hidden p-3 rounded-xl bg-red-50 border border-red-200/30 text-red-800 text-xs flex items-center gap-2.5">
                                    <svg class="w-4 h-4 shrink-0 text-red-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    <span id="formErrorMessage">Please check inputs.</span>
                                </div>

                                <form id="landingContactForm" class="space-y-4">
                                    <input type="hidden" name="landing_slug"
                                        value="<?php echo htmlspecialchars($id); ?>">
                                    <input type="hidden" name="landing_title"
                                        value="<?php echo htmlspecialchars($pageTitle); ?>">
                                    <input type="hidden" name="email_to"
                                        value="<?php echo htmlspecialchars($form_email_to); ?>">

                                    <!-- Full Name -->
                                    <div class="space-y-1">
                                        <label
                                            class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest">Full
                                            Name <span class="text-mosilGold">*</span></label>
                                        <div class="relative">
                                            <span
                                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                    </path>
                                                </svg>
                                            </span>
                                            <input type="text" name="name" required placeholder="Enter full name"
                                                class="w-full bg-slate-50/50 border border-slate-200 rounded-xl pl-10 pr-4 py-3.5 text-sm text-slate-950 placeholder-slate-400 focus:outline-none focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/10 focus:bg-white transition-all duration-300">
                                        </div>
                                    </div>


                                    <!-- Email -->
                                    <div class="space-y-1">
                                        <label
                                            class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest">Business
                                            Email <span class="text-mosilGold">*</span></label>
                                        <div class="relative">
                                            <span
                                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </span>
                                            <input type="email" name="email" required placeholder="name@company.com"
                                                class="w-full bg-slate-50/50 border border-slate-200 rounded-xl pl-10 pr-4 py-3.5 text-sm text-slate-950 placeholder-slate-400 focus:outline-none focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/10 focus:bg-white transition-all duration-300">
                                        </div>
                                    </div>

                                    <!-- Contact -->
                                    <div class="space-y-1">
                                        <label
                                            class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest">Contact
                                            Number <span class="text-mosilGold">*</span></label>
                                        <div class="relative">
                                            <span
                                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                    </path>
                                                </svg>
                                            </span>
                                            <input type="tel" name="contact" required placeholder="10-digit mobile"
                                                class="w-full bg-slate-50/50 border border-slate-200 rounded-xl pl-10 pr-4 py-3.5 text-sm text-slate-950 placeholder-slate-400 focus:outline-none focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/10 focus:bg-white transition-all duration-300">
                                        </div>
                                    </div>


                                    <!-- Company Name -->
                                    <div class="space-y-1">
                                        <label
                                            class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest">Company
                                            Name <span class="text-mosilGold">*</span></label>
                                        <div class="relative">
                                            <span
                                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                            </span>
                                            <input type="text" name="company_name" required placeholder="Company name"
                                                class="w-full bg-slate-50/50 border border-slate-200 rounded-xl pl-10 pr-4 py-3.5 text-sm text-slate-950 placeholder-slate-400 focus:outline-none focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/10 focus:bg-white transition-all duration-300">
                                        </div>
                                    </div>

                                    <!-- Requirement / Message -->
                                    <div class="space-y-1">
                                        <label
                                            class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest">Requirement
                                            / Message <span class="text-mosilGold">*</span></label>
                                        <div class="relative">
                                            <span class="absolute top-3.5 left-0 pl-3.5 text-slate-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                                    </path>
                                                </svg>
                                            </span>
                                            <textarea name="message" rows="3" required
                                                placeholder="Describe your technical requirements..."
                                                class="w-full bg-slate-50/50 border border-slate-200 rounded-xl pl-10 pr-4 py-3.5 text-sm text-slate-950 placeholder-slate-400 focus:outline-none focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/10 focus:bg-white transition-all duration-300"></textarea>
                                        </div>
                                    </div>

                                    <!-- Submit Button (Full Width yellow gradient) -->
                                    <div class="pt-3">
                                        <button type="submit" id="landingFormSubmitBtn"
                                            class="w-full bg-gradient-to-r from-mosilGold to-[#E0B200] text-mosilGreen font-black py-4 px-6 rounded-xl text-xs uppercase tracking-widest transition-all duration-300 shadow-md shadow-mosilGold/10 hover:shadow-[0_12px_30px_rgba(244,195,0,0.3)] hover:-translate-y-0.5 active:translate-y-0 active:scale-[0.99] flex items-center justify-center gap-2.5 group cursor-pointer border border-mosilGold/25">
                                            <span id="btnText"><?php echo htmlspecialchars($cta_text); ?></span>

                                            <!-- Spinner SVG (Hidden initially) -->
                                            <svg id="btnSpinner" class="hidden animate-spin h-4 w-4 text-mosilGreen"
                                                fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>

                                            <!-- Right arrow (Hidden during load) -->
                                            <svg id="btnArrow"
                                                class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Success transition container -->
                            <div id="landingFormSuccess"
                                class="hidden text-center py-12 px-4 space-y-6 opacity-0 transition-opacity duration-500">
                                <div
                                    class="relative inline-flex w-20 h-20 items-center justify-center rounded-full bg-emerald-50 border-2 border-emerald-500/35 text-emerald-600 mx-auto shadow-[0_0_35px_rgba(16,185,129,0.05)] animate-bounce">
                                    <span
                                        class="absolute inset-0 rounded-full border border-emerald-500/20 animate-ping"></span>
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="space-y-3">
                                    <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Thank You!</h3>
                                    <p id="successMessageText"
                                        class="text-slate-600 text-sm leading-relaxed max-w-sm mx-auto font-light">
                                        <?php echo htmlspecialchars($form_success_msg); ?>
                                    </p>
                                </div>
                                <div class="pt-4">
                                    <button type="button" onclick="resetLandingForm()"
                                        class="text-xs text-[#1A3B1B] hover:text-emerald-700 hover:underline transition-all uppercase tracking-wider font-bold">Submit
                                        Another Request</button>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

</div>

<!-- AJAX Submission Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("landingContactForm");
        if (!form) return;

        form.addEventListener("submit", function (e) {
            e.preventDefault();

            const btn = document.getElementById("landingFormSubmitBtn");
            const btnText = document.getElementById("btnText");
            const btnSpinner = document.getElementById("btnSpinner");
            const btnArrow = document.getElementById("btnArrow");
            const errorBanner = document.getElementById("formErrorBanner");
            const errorMessage = document.getElementById("formErrorMessage");

            // Basic front-end validation
            errorBanner.classList.add("hidden");
            const name = form.querySelector('[name="name"]').value.trim();
            const email = form.querySelector('[name="email"]').value.trim();
            const contact = form.querySelector('[name="contact"]').value.trim();
            const company = form.querySelector('[name="company_name"]').value.trim();
            const message = form.querySelector('[name="message"]').value.trim();

            if (!name || !email || !contact || !company || !message) {
                showError("Please fill out all required fields.");
                return;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showError("Please enter a valid business email address.");
                return;
            }

            if (contact.length < 8 || !/^[0-9+() -]+$/.test(contact)) {
                showError("Please enter a valid phone number.");
                return;
            }

            // Show loading state
            btn.disabled = true;
            btnText.textContent = "Sending...";
            btnSpinner.classList.remove("hidden");
            btnArrow.classList.add("hidden");

            // Prepare post payload
            const formData = new FormData(form);

            fetch("<?php echo SITE_URL; ?>/ajax/submit-landing.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Smooth transition to success card
                        const contentDiv = document.getElementById("landingFormContent");
                        const successDiv = document.getElementById("landingFormSuccess");

                        contentDiv.style.opacity = "0";
                        setTimeout(() => {
                            contentDiv.classList.add("hidden");
                            successDiv.classList.remove("hidden");
                            setTimeout(() => {
                                successDiv.style.opacity = "1";
                                successDiv.classList.remove("opacity-0");
                            }, 50);
                        }, 300);

                        form.reset();
                    } else {
                        showError(data.message || "Failed to submit enquiry. Please try again.");
                        resetButton();
                    }
                })
                .catch(err => {
                    console.error("Submission error:", err);
                    showError("A network error occurred. Please check your connection and try again.");
                    resetButton();
                });

            function showError(msg) {
                errorMessage.textContent = msg;
                errorBanner.classList.remove("hidden");
            }

            function resetButton() {
                btn.disabled = false;
                btnText.textContent = "<?php echo htmlspecialchars($cta_text); ?>";
                btnSpinner.classList.add("hidden");
                btnArrow.classList.remove("hidden");
            }
        });
    });

    function resetLandingForm() {
        const contentDiv = document.getElementById("landingFormContent");
        const successDiv = document.getElementById("landingFormSuccess");
        const btn = document.getElementById("landingFormSubmitBtn");
        const btnText = document.getElementById("btnText");
        const btnSpinner = document.getElementById("btnSpinner");
        const btnArrow = document.getElementById("btnArrow");

        successDiv.style.opacity = "0";
        setTimeout(() => {
            successDiv.classList.add("hidden");
            contentDiv.classList.remove("hidden");
            setTimeout(() => {
                contentDiv.style.opacity = "1";
            }, 50);
        }, 300);

        // Reset button states
        btn.disabled = false;
        btnText.textContent = "<?php echo htmlspecialchars($cta_text); ?>";
        btnSpinner.classList.add("hidden");
        btnArrow.classList.remove("hidden");
    }
</script>