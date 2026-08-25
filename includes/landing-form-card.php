<?php
/**
 * Senior SaaS-Grade Split-Card Contact Form Layout
 * Fully independent of external FontAwesome files (utilizes inline SVGs).
 * Left: Solid brand-colored info panel (Heritage, Certifications, Trust)
 * Right: Crisp, professional form fields with gold call to actions
 */
?>
<div id="landingFormCard" class="w-full max-w-4xl mx-auto rounded-3xl overflow-hidden border border-slate-200 bg-white shadow-[0_20px_50px_rgba(0,0,0,0.04)] flex flex-col md:flex-row transition-all duration-500 hover:shadow-[0_30px_70px_rgba(0,0,0,0.08)]">
    
    <!-- ================================================== -->
    <!-- LEFT PANEL: BRAND INFO & CREDENTIALS -->
    <!-- ================================================== -->
    <div class="md:w-1/2 bg-[#1A3B1B] text-white p-8 sm:p-12 flex flex-col justify-between gap-8 relative overflow-hidden">
        <!-- Abstract Tech Overlays -->
        <div class="absolute inset-0 bg-[radial-gradient(#255527_1px,transparent_1px)] [background-size:24px_24px] opacity-35"></div>
        <div class="absolute -top-24 -left-24 w-56 h-56 bg-[#F4C300]/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-56 h-56 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="space-y-8 relative z-10 my-auto">
            <div class="space-y-3.5">
                <span class="text-[10px] font-black text-[#F4C300] uppercase tracking-[0.25em] bg-white/10 px-3.5 py-1.5 rounded-full inline-block border border-white/5">Let's Consult</span>
                <h3 class="text-3xl sm:text-4xl font-extrabold text-white leading-[1.15] tracking-tight">
                    Solve Your Lubrication Challenges
                </h3>
            </div>
            <p class="text-slate-300 text-sm leading-relaxed font-light">
                Our tribology engineers are ready to analyze your application requirements and formulate lubricants matching your precise OEM parameters.
            </p>

            <!-- Brand credentials check list using inline SVGs for 100% reliable rendering -->
            <div class="space-y-4 pt-4">
                
                <!-- Trust Item 1 -->
                <div class="flex items-start gap-4 p-3.5 rounded-2xl bg-white/5 border border-white/5 backdrop-blur-sm transition-all hover:bg-white/10 hover:border-white/10">
                    <div class="w-9 h-9 rounded-xl bg-[#F4C300]/10 text-[#F4C300] flex items-center justify-center shrink-0 border border-[#F4C300]/20 shadow-inner">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Heritage</div>
                        <span class="text-xs font-semibold text-slate-200">40+ Years of Indian Industrial Trust</span>
                    </div>
                </div>
                
                <!-- Trust Item 2 -->
                <div class="flex items-start gap-4 p-3.5 rounded-2xl bg-white/5 border border-white/5 backdrop-blur-sm transition-all hover:bg-white/10 hover:border-white/10">
                    <div class="w-9 h-9 rounded-xl bg-[#F4C300]/10 text-[#F4C300] flex items-center justify-center shrink-0 border border-[#F4C300]/20 shadow-inner">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Certification</div>
                        <span class="text-xs font-semibold text-slate-200">In-house NABL Accredited Laboratory</span>
                    </div>
                </div>
                
                <!-- Trust Item 3 -->
                <div class="flex items-start gap-4 p-3.5 rounded-2xl bg-white/5 border border-white/5 backdrop-blur-sm transition-all hover:bg-white/10 hover:border-white/10">
                    <div class="w-9 h-9 rounded-xl bg-[#F4C300]/10 text-[#F4C300] flex items-center justify-center shrink-0 border border-[#F4C300]/20 shadow-inner">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Accuracy</div>
                        <span class="text-xs font-semibold text-slate-200">100% Spec-Matching Synthetic Oils</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-[9px] text-slate-400 font-mono tracking-widest relative z-10 border-t border-white/10 pt-4 flex justify-between items-center">
            <span>MOSIL LUBRICANTS</span>
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
        </div>
    </div>

    <!-- ================================================== -->
    <!-- RIGHT PANEL: THE INPUT FORM -->
    <!-- ================================================== -->
    <div class="md:w-1/2 bg-white p-8 sm:p-12 flex flex-col justify-center relative">
        
        <!-- Form Content Section -->
        <div id="landingFormContent" class="space-y-6 transition-opacity duration-300">
            <div class="space-y-1.5">
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Contact</h3>
                <p class="text-slate-500 text-xs leading-relaxed font-light">Please fill out the form below. <span class="text-emerald-600 font-medium">* Required</span></p>
            </div>

            <!-- Error Alert Banner -->
            <div id="formErrorBanner" class="hidden p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs flex items-center gap-2.5">
                <svg class="w-4 h-4 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span id="formErrorMessage">Please check inputs.</span>
            </div>

            <!-- The Form -->
            <form id="landingContactForm" class="space-y-4">
                <input type="hidden" name="landing_slug" value="<?php echo htmlspecialchars($id); ?>">
                <input type="hidden" name="landing_title" value="<?php echo htmlspecialchars($pageTitle); ?>">
                <input type="hidden" name="email_to" value="<?php echo htmlspecialchars($form_email_to); ?>">

                <!-- Input: Name -->
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Full Name <span class="text-emerald-600">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </span>
                        <input type="text" name="name" required placeholder="John Doe" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl pl-10 pr-4.5 py-3 text-sm text-slate-950 placeholder-slate-400 focus:outline-none focus:border-[#F4C300] focus:ring-4 focus:ring-[#F4C300]/10 focus:bg-white transition-all duration-300">
                    </div>
                </div>

                <!-- Input: Email -->
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Business Email <span class="text-emerald-600">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </span>
                        <input type="email" name="email" required placeholder="john@company.com" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl pl-10 pr-4.5 py-3 text-sm text-slate-950 placeholder-slate-400 focus:outline-none focus:border-[#F4C300] focus:ring-4 focus:ring-[#F4C300]/10 focus:bg-white transition-all duration-300">
                    </div>
                </div>

                <!-- Input: Company -->
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Company Name <span class="text-emerald-600">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </span>
                        <input type="text" name="company_name" required placeholder="Enter company name" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl pl-10 pr-4.5 py-3 text-sm text-slate-950 placeholder-slate-400 focus:outline-none focus:border-[#F4C300] focus:ring-4 focus:ring-[#F4C300]/10 focus:bg-white transition-all duration-300">
                    </div>
                </div>

                <!-- Input: Contact -->
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Contact Number <span class="text-emerald-600">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </span>
                        <input type="tel" name="contact" required placeholder="e.g. +91 99999 99999" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl pl-10 pr-4.5 py-3 text-sm text-slate-950 placeholder-slate-400 focus:outline-none focus:border-[#F4C300] focus:ring-4 focus:ring-[#F4C300]/10 focus:bg-white transition-all duration-300">
                    </div>
                </div>

                <!-- Input: Message -->
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Requirements / Message <span class="text-emerald-600">*</span></label>
                    <div class="relative">
                        <span class="absolute top-3.5 left-0 pl-3.5 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </span>
                        <textarea name="message" rows="3" required placeholder="Please write application details..." class="w-full bg-slate-50/50 border border-slate-200 rounded-xl pl-10 pr-4.5 py-3 text-sm text-slate-950 placeholder-slate-400 focus:outline-none focus:border-[#F4C300] focus:ring-4 focus:ring-[#F4C300]/10 focus:bg-white transition-all duration-300"></textarea>
                    </div>
                </div>

                <!-- Submit Button (Full Width, Command Bar Style) -->
                <div class="pt-4">
                    <button type="submit" id="landingFormSubmitBtn" class="w-full bg-gradient-to-r from-[#F4C300] to-[#E0B200] text-slate-950 font-bold py-4 px-6 rounded-xl text-xs uppercase tracking-widest transition-all duration-300 shadow-md shadow-[#F4C300]/10 hover:shadow-[0_12px_30px_rgba(244,195,0,0.3)] hover:-translate-y-0.5 active:translate-y-0 active:scale-[0.99] flex items-center justify-center gap-2.5 group cursor-pointer border border-[#F4C300]/25">
                        <span id="btnText">Submit Request</span>
                        
                        <!-- Spinner SVG (Hidden initially) -->
                        <svg id="btnSpinner" class="hidden animate-spin h-4 w-4 text-slate-950" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        
                        <!-- Right arrow (Hidden during load) -->
                        <svg id="btnArrow" class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Animated Success State (Hidden initially) -->
        <div id="landingFormSuccess" class="hidden text-center py-10 px-4 space-y-6 opacity-0 transition-opacity duration-500">
            <div class="relative inline-flex w-20 h-20 items-center justify-center rounded-full bg-emerald-50 border-2 border-emerald-500/35 text-emerald-600 mx-auto shadow-[0_0_30px_rgba(16,185,129,0.05)] animate-bounce">
                <span class="absolute inset-0 rounded-full border border-emerald-500/20 animate-ping"></span>
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div class="space-y-3">
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Thank You!</h3>
                <p id="successMessageText" class="text-slate-600 text-sm leading-relaxed max-w-sm mx-auto font-light">
                    <?php echo htmlspecialchars($form_success_msg); ?>
                </p>
            </div>
            <div class="pt-4">
                <button type="button" onclick="resetLandingForm()" class="text-xs text-[#1A3B1B] hover:text-emerald-700 hover:underline transition-all uppercase tracking-wider font-bold">Submit Another Request</button>
            </div>
        </div>
        
    </div>
</div>

<!-- AJAX Submission Script -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("landingContactForm");
    if (!form) return;

    form.addEventListener("submit", function(e) {
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
            btnText.textContent = "Submit Request";
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
    btnText.textContent = "Submit Request";
    btnSpinner.classList.add("hidden");
    btnArrow.classList.remove("hidden");
}
</script>
