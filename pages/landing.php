<?php
/**
 * Master Landing Page - Premium 2-Column Split Layout
 * Theme: Brand Primary Green Leading Style
 */

if (!isset($landingData) || empty($landingData)) {
    echo "<div class='container mx-auto py-20 text-center'><h2 class='text-2xl font-bold text-slate-800'>Landing page data not found.</h2></div>";
    return;
}

// Extract variables with fallbacks
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

$form_heading = 'Share your details so that our team can get back to you for discussion';
$form_intro = '';
$form_email_to = $form_data['email_to'] ?? '';
$form_success_msg = $form_data['success_message'] ?? 'Thank you! Your inquiry has been received. We will contact you shortly.';

$isNoIndex = !empty($seo['noindex']);
$pageTitle = !empty($seo['title']) ? $seo['title'] : ("Cost Per Component Campaign | " . (defined('SITE_NAME') ? SITE_NAME : 'MOSIL'));
?>

<?php if ($isNoIndex): ?>
    <meta name="robots" content="noindex, nofollow">
<?php endif; ?>

<!-- Tailwind CDN with unified Brand Palette -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    mosilGreen: {
                        50: 'oklch(98.2% 0.018 155.826)',
                        100: 'oklch(96.2% 0.044 156.743)',
                        600: 'oklch(62.7% 0.194 149.214)',
                        700: 'oklch(52.7% 0.154 150.069)',
                        DEFAULT: '#143317',      /* Primary Main Green */
                        dark: '#0D2010',         /* Deeper Green Hover */
                        deep: '#07140A'          /* Ultra Dark Green for Text */
                    },
                    mosilGold: {
                        50: '#FEF9E6',
                        100: '#FDF0B8',
                        400: 'oklch(85.2% 0.199 91.936)',
                        DEFAULT: '#E5AC00',
                        hover: '#C99600'
                    }
                }
            }
        }
    }
</script>

<div
    class="text-mosilGreen-deep min-h-[calc(100vh-60px)] flex flex-col justify-between selection:bg-mosilGreen selection:text-white font-sans antialiased">

    <main class="flex-grow">
        <section
            class="relative py-12 md:py-20 px-4 sm:px-6 lg:px-8 overflow-hidden bg-gradient-to-b from-mosilGreen-50/40 via-white to-slate-50/50">
            <!-- Decorative Green Glows -->
            <div
                class="absolute -top-40 left-1/4 w-[600px] h-[600px] bg-mosilGreen/10 rounded-full blur-[140px] pointer-events-none">
            </div>
            <div
                class="absolute -bottom-40 right-1/4 w-[500px] h-[500px] bg-mosilGold/10 rounded-full blur-[130px] pointer-events-none">
            </div>
            <div
                class="absolute inset-0 bg-[radial-gradient(#143317_1.2px,transparent_1.2px)] [background-size:24px_24px] opacity-[0.04] pointer-events-none">
            </div>

            <div class="max-w-7xl mx-auto relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">

                    <!-- ================================================== -->
                    <!-- LEFT COLUMN: MAIN GREEN TYPOGRAPHY & HIGHLIGHTS    -->
                    <!-- ================================================== -->
                    <div class="lg:col-span-7 space-y-8">

                        <!-- Eyebrow Badge (Main Green Theme) -->
                        <div
                            class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-mosilGreen text-white text-[11px] font-bold uppercase tracking-widest shadow-sm">
                            <span class="relative flex h-2 w-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-mosilGold opacity-90"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-mosilGold"></span>
                            </span>
                            <span>Spec-Matching Specialty Lubrication</span>
                        </div>

                        <!-- Main Headline in Primary Green -->
                        <h1
                            class="text-3xl sm:text-4xl lg:text-[44px] font-black leading-[1.18] tracking-tight text-mosilGreen text-left max-w-2xl">
                            <?php echo nl2br(htmlspecialchars($headline)); ?>
                        </h1>

                        <!-- Subheadline -->
                        <?php if (!empty($sub_headline)): ?>
                            <p class="text-slate-700 text-base sm:text-lg leading-relaxed font-normal text-left max-w-2xl">
                                <?php echo htmlspecialchars($sub_headline); ?>
                            </p>
                        <?php endif; ?>

                        <!-- Feature Checklist with Primary Green Focus -->
                        <div class="space-y-3.5 max-w-2xl pt-2">
                            <!-- Bullet 1 -->
                            <div
                                class="flex items-start gap-4 p-4 rounded-2xl bg-white border border-slate-200 shadow-sm transition-all hover:border-mosilGreen/40 hover:shadow-md">
                                <div
                                    class="w-10 h-10 rounded-xl bg-mosilGreen text-white flex items-center justify-center shrink-0 shadow-sm">
                                    <svg class="w-5 h-5 text-mosilGold" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-mosilGreen">Specification-Matching Formulations
                                    </h4>
                                    <p class="text-slate-600 text-xs font-normal mt-0.5 leading-relaxed">Formulated to
                                        match or exceed physical & performance OEM test requirements.</p>
                                </div>
                            </div>

                            <!-- Bullet 2 -->
                            <div
                                class="flex items-start gap-4 p-4 rounded-2xl bg-white border border-slate-200 shadow-sm transition-all hover:border-mosilGreen/40 hover:shadow-md">
                                <div
                                    class="w-10 h-10 rounded-xl bg-mosilGreen text-white flex items-center justify-center shrink-0 shadow-sm">
                                    <svg class="w-5 h-5 text-mosilGold" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-mosilGreen">TriboIntel™ Documented Validation</h4>
                                    <p class="text-slate-600 text-xs font-normal mt-0.5 leading-relaxed">Validated
                                        within our state-of-the-art, NABL-accredited tribology testing center.</p>
                                </div>
                            </div>

                            <!-- Bullet 3 -->
                            <div
                                class="flex items-start gap-4 p-4 rounded-2xl bg-white border border-slate-200 shadow-sm transition-all hover:border-mosilGreen/40 hover:shadow-md">
                                <div
                                    class="w-10 h-10 rounded-xl bg-mosilGreen text-white flex items-center justify-center shrink-0 shadow-sm">
                                    <svg class="w-5 h-5 text-mosilGold" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-mosilGreen">Zero Import & Logistics Delays</h4>
                                    <p class="text-slate-600 text-xs font-normal mt-0.5 leading-relaxed">Eliminates long
                                        lead times, customs bottlenecks, and steep overseas freight margins.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Campaign Image Container -->
                        <?php if (!empty($banner_image)): ?>
                            <div class="pt-4 max-w-2xl">
                                <div
                                    class="border border-slate-200 rounded-2xl overflow-hidden bg-white p-2 shadow-md hover:border-mosilGreen/30 hover:shadow-lg transition-all duration-300">
                                    <div class="relative w-full aspect-[16/9] rounded-xl overflow-hidden bg-slate-100">
                                        <img src="<?php echo (defined('SITE_URL') ? SITE_URL : '') . '/' . htmlspecialchars($banner_image); ?>"
                                            alt="<?php echo htmlspecialchars($banner_image_alt); ?>"
                                            class="absolute inset-0 w-full h-full object-cover">
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>

                    <!-- ================================================== -->
                    <!-- RIGHT COLUMN: FORM CARD (MAIN GREEN ACCENTS)       -->
                    <!-- ================================================== -->
                    <div class="lg:col-span-5">
                        <div
                            class="bg-white border-2 border-mosilGreen/15 rounded-3xl p-6 sm:p-8 shadow-2xl shadow-mosilGreen/10 relative overflow-hidden">
                            <!-- Background Subtle Green Glow -->
                            <div
                                class="absolute -top-12 -right-12 w-36 h-36 bg-mosilGreen-50 rounded-full blur-2xl pointer-events-none">
                            </div>

                            <!-- Form View -->
                            <div id="landingFormContent" class="space-y-6 relative z-10">
                                <div class="space-y-2">
                                    <h3 class="text-xl sm:text-2xl font-black text-mosilGreen tracking-tight">
                                        <?php echo htmlspecialchars($form_heading); ?>
                                    </h3>
                                    <?php if (!empty($form_intro)): ?>
                                        <p
                                            class="text-slate-600 text-xs leading-relaxed border-l-2 border-mosilGreen pl-2.5">
                                            <?php echo htmlspecialchars($form_intro); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <!-- Error Alert Banner -->
                                <div id="formErrorBanner"
                                    class="hidden p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs flex items-center gap-2.5">
                                    <svg class="w-4 h-4 shrink-0 text-red-500" fill="none" stroke="currentColor"
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
                                            class="block text-[11px] font-bold text-mosilGreen uppercase tracking-wider">Full
                                            Name <span class="text-mosilGold font-bold">*</span></label>
                                        <div class="relative">
                                            <span
                                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-mosilGreen/60">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                    </path>
                                                </svg>
                                            </span>
                                            <input type="text" name="name" required placeholder="Enter full name"
                                                class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/15 focus:bg-white transition-all">
                                        </div>
                                    </div>

                                    <!-- Email & Contact Grid -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                        <!-- Email -->
                                        <div class="space-y-1">
                                            <label
                                                class="block text-[11px] font-bold text-mosilGreen uppercase tracking-wider">Business
                                                Email <span class="text-mosilGold font-bold">*</span></label>
                                            <div class="relative">
                                                <span
                                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-mosilGreen/60">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <input type="email" name="email" required placeholder="name@company.com"
                                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-3 py-3 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/15 focus:bg-white transition-all">
                                            </div>
                                        </div>

                                        <!-- Contact -->
                                        <div class="space-y-1">
                                            <label
                                                class="block text-[11px] font-bold text-mosilGreen uppercase tracking-wider">Contact
                                                Number <span class="text-mosilGold font-bold">*</span></label>
                                            <div class="relative">
                                                <span
                                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-mosilGreen/60">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <input type="tel" name="contact" required placeholder="10-digit mobile"
                                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-3 py-3 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/15 focus:bg-white transition-all">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Company Name -->
                                    <div class="space-y-1">
                                        <label
                                            class="block text-[11px] font-bold text-mosilGreen uppercase tracking-wider">Company
                                            Name <span class="text-mosilGold font-bold">*</span></label>
                                        <div class="relative">
                                            <span
                                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-mosilGreen/60">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                            </span>
                                            <input type="text" name="company_name" required
                                                placeholder="Your company name"
                                                class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/15 focus:bg-white transition-all">
                                        </div>
                                    </div>

                                    <!-- Component Manufactured -->
                                    <div class="space-y-1">
                                        <label
                                            class="block text-[11px] font-bold text-mosilGreen uppercase tracking-wider">Component
                                            Manufactured <span class="text-mosilGold font-bold">*</span></label>
                                        <div class="relative">
                                            <span
                                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-mosilGreen/60">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </span>
                                            <input type="text" name="component_manufactured" required
                                                placeholder="e.g., Bearings, Valves, Actuators"
                                                class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/15 focus:bg-white transition-all">
                                        </div>
                                    </div>

                                    <!-- Requirement / Message -->
                                    <div class="space-y-1">
                                        <label
                                            class="block text-[11px] font-bold text-mosilGreen uppercase tracking-wider">Requirement
                                            / Message <span class="text-mosilGold font-bold">*</span></label>
                                        <div class="relative">
                                            <span class="absolute top-3.5 left-0 pl-3.5 text-mosilGreen/60">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                                    </path>
                                                </svg>
                                            </span>
                                            <textarea name="message" rows="3" required
                                                placeholder="Describe current lubricant spec or operating challenge..."
                                                class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-mosilGreen focus:ring-4 focus:ring-mosilGreen/15 focus:bg-white transition-all"></textarea>
                                        </div>
                                    </div>

                                    <!-- Submit Button in Solid Primary Green -->
                                    <div class="pt-2">
                                        <button type="submit" id="landingFormSubmitBtn"
                                            class="w-full bg-mosilGreen hover:bg-mosilGreen-dark active:bg-mosilGreen-deep text-white font-extrabold py-4 px-6 rounded-xl text-sm uppercase tracking-wider transition-all duration-200 shadow-lg shadow-mosilGreen/25 hover:shadow-xl hover:shadow-mosilGreen/30 flex items-center justify-center gap-2.5 group cursor-pointer border-0">
                                            <span id="btnText"><?php echo htmlspecialchars($cta_text); ?></span>

                                            <!-- Spinner SVG -->
                                            <svg id="btnSpinner" class="hidden animate-spin h-4 w-4 text-white"
                                                fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>

                                            <!-- Right Arrow -->
                                            <svg id="btnArrow"
                                                class="w-4 h-4 text-mosilGold transition-transform group-hover:translate-x-1"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Success State View -->
                            <div id="landingFormSuccess"
                                class="hidden text-center py-10 px-4 space-y-6 opacity-0 transition-opacity duration-300">
                                <div
                                    class="relative inline-flex w-16 h-16 items-center justify-center rounded-full bg-mosilGreen text-white mx-auto shadow-md">
                                    <svg class="w-8 h-8 text-mosilGold" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="space-y-2">
                                    <h3 class="text-2xl font-black text-mosilGreen tracking-tight">Request Received</h3>
                                    <p id="successMessageText"
                                        class="text-slate-600 text-sm leading-relaxed max-w-sm mx-auto font-normal">
                                        <?php echo htmlspecialchars($form_success_msg); ?>
                                    </p>
                                </div>
                                <div class="pt-2">
                                    <button type="button" onclick="resetLandingForm()"
                                        class="text-xs text-mosilGreen hover:text-mosilGreen-dark underline uppercase tracking-wider font-bold">
                                        Submit Another Request
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

</div>

<!-- Client-side Validation and AJAX Handler -->
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

            errorBanner.classList.add("hidden");
            const name = form.querySelector('[name="name"]').value.trim();
            const email = form.querySelector('[name="email"]').value.trim();
            const contact = form.querySelector('[name="contact"]').value.trim();
            const company = form.querySelector('[name="company_name"]').value.trim();
            const component = form.querySelector('[name="component_manufactured"]').value.trim();
            const message = form.querySelector('[name="message"]').value.trim();

            if (!name || !email || !contact || !company || !component || !message) {
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

            // Loading state
            btn.disabled = true;
            btnText.textContent = "Sending...";
            btnSpinner.classList.remove("hidden");
            btnArrow.classList.add("hidden");

            const formData = new FormData(form);
            const submitUrl = "<?php echo (defined('SITE_URL') ? SITE_URL : '') . '/ajax/submit-landing.php'; ?>";

            fetch(submitUrl, {
                method: "POST",
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const contentDiv = document.getElementById("landingFormContent");
                        const successDiv = document.getElementById("landingFormSuccess");

                        contentDiv.classList.add("hidden");
                        successDiv.classList.remove("hidden");
                        setTimeout(() => {
                            successDiv.classList.remove("opacity-0");
                            successDiv.classList.add("opacity-100");
                        }, 50);

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

        successDiv.classList.add("opacity-0");
        successDiv.classList.remove("opacity-100");
        setTimeout(() => {
            successDiv.classList.add("hidden");
            contentDiv.classList.remove("hidden");
        }, 200);

        btn.disabled = false;
        btnText.textContent = "<?php echo htmlspecialchars($cta_text); ?>";
        btnSpinner.classList.add("hidden");
        btnArrow.classList.remove("hidden");
    }
</script>