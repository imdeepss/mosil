<?php
// pages/lead-enquiry.php
$pageTitle = 'Salesforce Lead Submission Portal | MOSIL Lubricants';
$metaDescription = 'Log and submit customer leads to Salesforce with source attribution and tracking.';

$selectedSource = isset($_GET['source']) ? trim($_GET['source']) : '';

$sourcesList = [
    ['id' => 'WhatsApp', 'name' => 'WhatsApp', 'icon' => '💬', 'badge' => 'Quick Lead'],
    ['id' => 'DM - LinkedIN', 'name' => 'DM - LinkedIn', 'icon' => '🔗', 'badge' => 'Social'],
    ['id' => 'Telephonic', 'name' => 'Telephonic Call', 'icon' => '📞', 'badge' => 'Direct'],
    ['id' => 'Exhibitions', 'name' => 'Exhibitions / Expo', 'icon' => '🏢', 'badge' => 'Event'],
    ['id' => 'Lead Generation - Outbound', 'name' => 'Outbound Lead Gen', 'icon' => '🎯', 'badge' => 'Sales'],
    ['id' => 'DM - Website Enquiry', 'name' => 'Website Enquiry', 'icon' => '🌐', 'badge' => 'Digital'],
    ['id' => 'DM - Paid Leads', 'name' => 'DM - Paid Leads', 'icon' => '💰', 'badge' => 'Campaign'],
    ['id' => 'DM - TDS', 'name' => 'DM - TDS Download', 'icon' => '📄', 'badge' => 'Technical'],
    ['id' => 'DM - Email Marketing', 'name' => 'Email Marketing', 'icon' => '✉️', 'badge' => 'Outreach']
];
?>

<h1 class="sr-only"><?php echo htmlspecialchars($pageTitle); ?></h1>
<section class="h-[100px] sticky top-0 z-10 bg-white"></section>

<section class="container max-w-4xl mx-auto px-4 py-6">
    <!-- Breadcrumbs -->
    <nav class="flex items-center breadcrumbs gap-1 text-[14px] md:text-[15px] leading-[150%] tracking-[0.015em] capitalize flex-wrap pb-4">
        <a href="<?php echo SITE_URL; ?>/" class="text-[#A3A3A3] hover:text-[#1A3B1B] transition-colors font-light">Home</a>
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 20 20" fill="none">
                <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </span>
        <span class="text-[#1A3B1B] font-semibold">Lead Submission Portal</span>
    </nav>

    <!-- Main Card -->
    <div class="bg-white border border-[#E5E7EB] rounded-2xl shadow-xl overflow-hidden relative">
        <!-- Card Header with Subtle Gradient -->
        <div class="bg-gradient-to-r from-[#1A3B1B] to-[#2D5A2E] text-white p-6 md:p-8 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none w-64 h-64">
                <img src="<?php echo SITE_URL; ?>/assets/images/ui/Vector.png" class="w-full h-full object-contain" alt="" role="presentation">
            </div>
            
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 relative z-10">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#F4C300] text-[#1A3B1B] mb-2 tracking-wide uppercase">
                        <span class="w-2 h-2 rounded-full bg-[#1A3B1B] animate-pulse"></span>
                        Salesforce CRM Integration
                    </span>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-white">
                        Submit Lead to Salesforce
                    </h2>
                    <p class="text-green-100 text-sm mt-1">
                        Log customer enquiries & opportunities directly into Salesforce CRM in 2 simple steps.
                    </p>
                </div>

                <!-- Step Tracker Pill -->
                <div class="flex items-center gap-2 bg-black/20 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/10 self-start md:self-auto">
                    <div id="stepPill1" class="flex items-center gap-2 text-white font-medium text-xs md:text-sm">
                        <span class="w-6 h-6 rounded-full bg-[#F4C300] text-[#1A3B1B] font-bold flex items-center justify-center text-xs shadow-sm">1</span>
                        <span>Source</span>
                    </div>
                    <span class="text-white/40 text-xs">➔</span>
                    <div id="stepPill2" class="flex items-center gap-2 text-white/50 font-medium text-xs md:text-sm">
                        <span class="w-6 h-6 rounded-full bg-white/20 text-white font-bold flex items-center justify-center text-xs">2</span>
                        <span>Prospect</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="p-6 md:p-8">
            <form id="leadEnquiryForm" method="POST" action="" novalidate>
                
                <!-- ================= STEP 1: SUBMITTER & SOURCE ================= -->
                <div id="stepSection1" class="transition-all duration-300">
                    <div class="mb-6">
                        <div class="flex items-center justify-between border-b border-[#F0F0F0] pb-3 mb-5">
                            <div>
                                <h3 class="text-lg font-bold text-[#1A3B1B] flex items-center gap-2">
                                    <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-[#1A3B1B] text-white text-xs font-bold">1</span>
                                    Your Info & Lead Source
                                </h3>
                                <p class="text-xs text-[#737373] mt-0.5">Tell us who is submitting this lead and where it was acquired.</p>
                            </div>
                            <span class="text-xs font-semibold px-2.5 py-1 bg-amber-50 text-amber-800 rounded-md border border-amber-200">Step 1 of 2</span>
                        </div>

                        <!-- Submitter Name & Role Fields -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-xs font-bold text-[#404040] uppercase tracking-wider mb-1.5">
                                    Logged By (Your Full Name) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="submitted_by" id="submitted_by" required placeholder="e.g. Rohit Sharma"
                                        class="w-full px-4 py-3 rounded-lg border border-[#D1D5DB] bg-[#FAFAFA] focus:bg-white text-[#1F2937] placeholder:text-[#9CA3AF] focus:outline-none focus:ring-2 focus:ring-[#1A3B1B]/20 focus:border-[#1A3B1B] transition-all text-sm font-medium">
                                </div>
                                <span class="error-text hidden text-xs text-red-500 mt-1 block">Your name is required</span>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-[#404040] uppercase tracking-wider mb-1.5">
                                    Your Role / Department <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="submitter_role" id="submitter_role" required placeholder="e.g. Sales Executive / BDE"
                                        class="w-full px-4 py-3 rounded-lg border border-[#D1D5DB] bg-[#FAFAFA] focus:bg-white text-[#1F2937] placeholder:text-[#9CA3AF] focus:outline-none focus:ring-2 focus:ring-[#1A3B1B]/20 focus:border-[#1A3B1B] transition-all text-sm font-medium">
                                </div>
                                <span class="error-text hidden text-xs text-red-500 mt-1 block">Your role is required</span>
                            </div>
                        </div>

                        <!-- Lead Source Selection (Visual Cards) -->
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-[#404040] uppercase tracking-wider mb-2">
                                Select Lead Source Channel <span class="text-red-500">*</span>
                            </label>
                            
                            <!-- Hidden input for form submission -->
                            <input type="hidden" name="source" id="sourceInput" value="<?php echo htmlspecialchars($selectedSource); ?>" required>

                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5" id="sourceCardsContainer">
                                <?php foreach ($sourcesList as $src): 
                                    $isSelected = ($selectedSource === $src['id']);
                                ?>
                                    <button type="button" 
                                        data-source-id="<?php echo htmlspecialchars($src['id']); ?>"
                                        class="source-card flex flex-col items-start p-3 rounded-xl border text-left transition-all cursor-pointer relative overflow-hidden group <?php echo $isSelected ? 'bg-[#1A3B1B] text-white border-[#1A3B1B] shadow-md ring-2 ring-[#F4C300]' : 'bg-[#FAFAFA] hover:bg-[#F3F4F6] text-[#374151] border-[#E5E7EB] hover:border-[#1A3B1B]/30'; ?>">
                                        
                                        <div class="flex items-center justify-between w-full mb-1">
                                            <span class="text-xl group-hover:scale-110 transition-transform"><?php echo $src['icon']; ?></span>
                                            <span class="text-[10px] font-semibold uppercase px-1.5 py-0.5 rounded <?php echo $isSelected ? 'bg-white/20 text-[#F4C300]' : 'bg-gray-200 text-gray-600'; ?> tracking-wider">
                                                <?php echo htmlspecialchars($src['badge']); ?>
                                            </span>
                                        </div>
                                        
                                        <span class="text-xs font-bold tracking-tight mt-1 line-clamp-1 <?php echo $isSelected ? 'text-white' : 'text-[#1F2937]'; ?>">
                                            <?php echo htmlspecialchars($src['name']); ?>
                                        </span>
                                        
                                        <!-- Active Indicator Check -->
                                        <div class="check-icon absolute top-2 right-2 <?php echo $isSelected ? 'block' : 'hidden'; ?>">
                                            <span class="w-4 h-4 rounded-full bg-[#F4C300] text-[#1A3B1B] text-[10px] font-bold flex items-center justify-center">✓</span>
                                        </div>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                            <span id="sourceErrorText" class="error-text hidden text-xs text-red-500 mt-2 block">Please select a lead source channel</span>
                        </div>
                    </div>

                    <!-- Step 1 Actions -->
                    <div class="flex justify-end pt-4 border-t border-[#F0F0F0]">
                        <button type="button" id="goToStep2Btn"
                            class="bg-[#1A3B1B] hover:bg-[#132d14] text-white font-bold text-sm md:text-base px-8 py-3.5 rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center gap-2 cursor-pointer group">
                            <span>Proceed to Prospect Details</span>
                            <span class="text-lg group-hover:translate-x-1 transition-transform">→</span>
                        </button>
                    </div>
                </div>


                <!-- ================= STEP 2: PROSPECT / CUSTOMER DETAILS ================= -->
                <div id="stepSection2" class="hidden transition-all duration-300">
                    <div class="mb-6">
                        <!-- Step Header with Active Summary Badge -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-[#F0F0F0] pb-3 mb-5 gap-2">
                            <div>
                                <h3 class="text-lg font-bold text-[#1A3B1B] flex items-center gap-2">
                                    <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-[#1A3B1B] text-white text-xs font-bold">2</span>
                                    Prospect & Requirement Details
                                </h3>
                                <p class="text-xs text-[#737373] mt-0.5">Enter the customer's contact information and discussion requirements.</p>
                            </div>

                            <div class="flex items-center gap-2">
                                <span id="summaryBadge" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    <span>📍</span>
                                    <span id="summaryText">Source: Selected</span>
                                </span>
                            </div>
                        </div>

                        <!-- 2-Column Responsive Form Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Lead / Customer Name -->
                            <div>
                                <label class="block text-xs font-bold text-[#404040] uppercase tracking-wider mb-1.5">
                                    Customer / Contact Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="lead_name" required placeholder="e.g. Rahul Verma"
                                    class="w-full px-4 py-2.5 rounded-lg border border-[#D1D5DB] bg-[#FAFAFA] focus:bg-white text-[#1F2937] placeholder:text-[#9CA3AF] focus:outline-none focus:ring-2 focus:ring-[#1A3B1B]/20 focus:border-[#1A3B1B] transition-all text-sm font-medium">
                                <span class="error-text hidden text-xs text-red-500 mt-1 block">Customer name is required</span>
                            </div>

                            <!-- Company Name -->
                            <div>
                                <label class="block text-xs font-bold text-[#404040] uppercase tracking-wider mb-1.5">
                                    Company / Organization <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="company_name" id="lead_company" required placeholder="e.g. Tata Steel Processing Ltd"
                                    class="w-full px-4 py-2.5 rounded-lg border border-[#D1D5DB] bg-[#FAFAFA] focus:bg-white text-[#1F2937] placeholder:text-[#9CA3AF] focus:outline-none focus:ring-2 focus:ring-[#1A3B1B]/20 focus:border-[#1A3B1B] transition-all text-sm font-medium">
                                <span class="error-text hidden text-xs text-red-500 mt-1 block">Company name is required</span>
                            </div>

                            <!-- Email Address -->
                            <div>
                                <label class="block text-xs font-bold text-[#404040] uppercase tracking-wider mb-1.5">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="lead_email" required placeholder="e.g. rahul.verma@example.com"
                                    class="w-full px-4 py-2.5 rounded-lg border border-[#D1D5DB] bg-[#FAFAFA] focus:bg-white text-[#1F2937] placeholder:text-[#9CA3AF] focus:outline-none focus:ring-2 focus:ring-[#1A3B1B]/20 focus:border-[#1A3B1B] transition-all text-sm font-medium">
                                <span class="error-text hidden text-xs text-red-500 mt-1 block">Valid email is required</span>
                            </div>

                            <!-- Phone / Contact Number -->
                            <div>
                                <label class="block text-xs font-bold text-[#404040] uppercase tracking-wider mb-1.5">
                                    Phone / WhatsApp Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="contact" id="lead_contact" required placeholder="e.g. +91 9876543210"
                                    class="w-full px-4 py-2.5 rounded-lg border border-[#D1D5DB] bg-[#FAFAFA] focus:bg-white text-[#1F2937] placeholder:text-[#9CA3AF] focus:outline-none focus:ring-2 focus:ring-[#1A3B1B]/20 focus:border-[#1A3B1B] transition-all text-sm font-medium">
                                <span class="error-text hidden text-xs text-red-500 mt-1 block">Valid phone number is required</span>
                            </div>

                            <!-- Pin Code -->
                            <div>
                                <label class="block text-xs font-bold text-[#404040] uppercase tracking-wider mb-1.5">
                                    Pin Code / Location <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="pincode" id="lead_pincode" required placeholder="e.g. 400001"
                                    class="w-full px-4 py-2.5 rounded-lg border border-[#D1D5DB] bg-[#FAFAFA] focus:bg-white text-[#1F2937] placeholder:text-[#9CA3AF] focus:outline-none focus:ring-2 focus:ring-[#1A3B1B]/20 focus:border-[#1A3B1B] transition-all text-sm font-medium">
                                <span class="error-text hidden text-xs text-red-500 mt-1 block">Valid pin code is required</span>
                            </div>

                            <!-- Product Subject -->
                            <div>
                                <label class="block text-xs font-bold text-[#404040] uppercase tracking-wider mb-1.5">
                                    Product / Requirement Subject
                                </label>
                                <input type="text" name="subject" id="lead_subject" placeholder="e.g. High Temperature Bearing Grease"
                                    class="w-full px-4 py-2.5 rounded-lg border border-[#D1D5DB] bg-[#FAFAFA] focus:bg-white text-[#1F2937] placeholder:text-[#9CA3AF] focus:outline-none focus:ring-2 focus:ring-[#1A3B1B]/20 focus:border-[#1A3B1B] transition-all text-sm font-medium">
                            </div>

                            <!-- Requirement Notes / Chat Summary -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-[#404040] uppercase tracking-wider mb-1.5">
                                    Requirement Details / Discussion Notes <span class="text-red-500">*</span>
                                </label>
                                <textarea name="message" id="lead_message" required rows="3" placeholder="Paste discussion summary, customer requirement details, operating temperature, application specifications, etc."
                                    class="w-full px-4 py-2.5 rounded-lg border border-[#D1D5DB] bg-[#FAFAFA] focus:bg-white text-[#1F2937] placeholder:text-[#9CA3AF] focus:outline-none focus:ring-2 focus:ring-[#1A3B1B]/20 focus:border-[#1A3B1B] transition-all text-sm font-medium"></textarea>
                                <span class="error-text hidden text-xs text-red-500 mt-1 block">Requirement notes are required</span>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 Actions -->
                    <div class="flex items-center justify-between pt-4 border-t border-[#F0F0F0] gap-4">
                        <button type="button" id="backToStep1Btn"
                            class="px-5 py-3 rounded-xl border border-[#D1D5DB] text-[#4B5563] hover:bg-[#F3F4F6] font-semibold text-sm transition-all flex items-center gap-2 cursor-pointer">
                            <span>← Back</span>
                        </button>

                        <button type="submit" id="submitBtn"
                            class="bg-[#1A3B1B] hover:bg-[#132d14] text-white font-bold text-sm md:text-base px-8 py-3.5 rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2 cursor-pointer btn-gradient-hover flex-1 sm:flex-none">
                            <span id="btnText">Submit Lead to Salesforce</span>
                            <span id="btnSpinner" class="hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                        </button>
                    </div>
                </div>

            </form>

            <!-- Server Response Message Box -->
            <div id="formResponse" class="hidden my-4 p-4 rounded-xl text-center text-sm font-medium"></div>

            <!-- ================= SUCCESS CELEBRATION STATE ================= -->
            <div id="successState" class="hidden py-8 px-4 text-center">
                <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-4 shadow-sm animate-bounce">
                    ✓
                </div>
                <h3 class="text-2xl font-bold text-[#1A3B1B] mb-2">Lead Successfully Submitted!</h3>
                <p class="text-sm text-[#4B5563] max-w-md mx-auto mb-6">
                    The lead has been recorded in the database, synchronized with Salesforce CRM, and notification alerts have been dispatched.
                </p>

                <!-- Lead Summary Snapshot Card -->
                <div id="successSummaryCard" class="bg-[#F9FAFB] border border-[#E5E7EB] rounded-xl p-4 max-w-md mx-auto text-left mb-6 text-xs text-[#374151] space-y-1.5">
                    <div class="flex justify-between border-b border-gray-200 pb-1.5">
                        <span class="text-gray-500">Lead Name:</span>
                        <span id="resLeadName" class="font-bold text-[#1A3B1B]">--</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-200 pb-1.5">
                        <span class="text-gray-500">Company:</span>
                        <span id="resCompany" class="font-semibold">--</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-200 pb-1.5">
                        <span class="text-gray-500">Lead Source:</span>
                        <span id="resSource" class="font-semibold text-amber-800">--</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Logged By:</span>
                        <span id="resLoggedBy" class="font-semibold">--</span>
                    </div>
                </div>

                <button type="button" id="submitAnotherBtn"
                    class="bg-[#1A3B1B] hover:bg-[#132d14] text-white font-bold text-sm px-6 py-3 rounded-xl shadow-md hover:shadow-lg transition-all cursor-pointer">
                    + Submit Another Lead
                </button>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var step1 = document.getElementById('stepSection1');
    var step2 = document.getElementById('stepSection2');
    var stepPill1 = document.getElementById('stepPill1');
    var stepPill2 = document.getElementById('stepPill2');
    
    var goToStep2Btn = document.getElementById('goToStep2Btn');
    var backToStep1Btn = document.getElementById('backToStep1Btn');
    var form = document.getElementById('leadEnquiryForm');
    var responseBox = document.getElementById('formResponse');
    var submitBtn = document.getElementById('submitBtn');
    var btnText = document.getElementById('btnText');
    var btnSpinner = document.getElementById('btnSpinner');

    var successState = document.getElementById('successState');
    var submitAnotherBtn = document.getElementById('submitAnotherBtn');

    var sourceInput = document.getElementById('sourceInput');
    var sourceCards = document.querySelectorAll('.source-card');
    var sourceError = document.getElementById('sourceErrorText');
    var summaryText = document.getElementById('summaryText');

    // Validation patterns
    var validators = {
        email: function (val) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val); },
        tel: function (val) { return /^[0-9+\-\s]{8,}$/.test(val.trim()); },
        pincode: function (val) { return /^[0-9]{4,10}$/.test(val.trim()); },
        default: function (val) { return val.trim().length > 0; }
    };

    function validateField(input) {
        if (!input.hasAttribute('required')) return true;

        var type = 'default';
        if (input.type === 'email') type = 'email';
        else if (input.type === 'tel' || input.name === 'contact') type = 'tel';
        else if (input.name === 'pincode') type = 'pincode';

        var isValid = validators[type](input.value);
        var errorMsg = input.parentNode.querySelector('.error-text') || input.closest('div').querySelector('.error-text');

        if (!isValid) {
            input.classList.add('border-red-500', 'bg-red-50/20');
            if (errorMsg) errorMsg.classList.remove('hidden');
        } else {
            input.classList.remove('border-red-500', 'bg-red-50/20');
            if (errorMsg) errorMsg.classList.add('hidden');
        }
        return isValid;
    }

    // Step 1 Source Pill Click handler
    sourceCards.forEach(function (card) {
        card.addEventListener('click', function () {
            var srcId = this.getAttribute('data-source-id');
            sourceInput.value = srcId;

            // Reset all cards
            sourceCards.forEach(function (c) {
                c.className = 'source-card flex flex-col items-start p-3 rounded-xl border text-left transition-all cursor-pointer relative overflow-hidden group bg-[#FAFAFA] hover:bg-[#F3F4F6] text-[#374151] border-[#E5E7EB] hover:border-[#1A3B1B]/30';
                var badge = c.querySelector('span:nth-child(2)');
                if (badge) badge.className = 'text-[10px] font-semibold uppercase px-1.5 py-0.5 rounded bg-gray-200 text-gray-600 tracking-wider';
                var title = c.querySelector('span.line-clamp-1');
                if (title) title.className = 'text-xs font-bold tracking-tight mt-1 line-clamp-1 text-[#1F2937]';
                var check = c.querySelector('.check-icon');
                if (check) check.classList.add('hidden');
            });

            // Activate clicked card
            this.className = 'source-card flex flex-col items-start p-3 rounded-xl border text-left transition-all cursor-pointer relative overflow-hidden group bg-[#1A3B1B] text-white border-[#1A3B1B] shadow-md ring-2 ring-[#F4C300]';
            var activeBadge = this.querySelector('span:nth-child(2)');
            if (activeBadge) activeBadge.className = 'text-[10px] font-semibold uppercase px-1.5 py-0.5 rounded bg-white/20 text-[#F4C300] tracking-wider';
            var activeTitle = this.querySelector('span.line-clamp-1');
            if (activeTitle) activeTitle.className = 'text-xs font-bold tracking-tight mt-1 line-clamp-1 text-white';
            var activeCheck = this.querySelector('.check-icon');
            if (activeCheck) activeCheck.classList.remove('hidden');

            sourceError.classList.add('hidden');
        });
    });

    // Real-time input validation listeners
    form.querySelectorAll('input, select, textarea').forEach(function (input) {
        input.addEventListener('input', function () { validateField(this); });
        input.addEventListener('change', function () { validateField(this); });
        input.addEventListener('blur', function () { validateField(this); });
    });

    // Switch to Step 2
    goToStep2Btn.addEventListener('click', function () {
        var subName = document.getElementById('submitted_by');
        var subRole = document.getElementById('submitter_role');

        var isNameValid = validateField(subName);
        var isRoleValid = validateField(subRole);
        var isSourceValid = sourceInput.value.trim() !== '';

        if (!isSourceValid) {
            sourceError.classList.remove('hidden');
        } else {
            sourceError.classList.add('hidden');
        }

        if (isNameValid && isRoleValid && isSourceValid) {
            // Update Summary Badge
            summaryText.innerText = sourceInput.value + ' (by ' + subName.value + ')';

            // Transition Step 1 to Step 2
            step1.classList.add('hidden');
            step2.classList.remove('hidden');

            // Update Progress Pills
            stepPill1.className = 'flex items-center gap-2 text-white/70 font-medium text-xs md:text-sm cursor-pointer';
            stepPill1.innerHTML = '<span class="w-6 h-6 rounded-full bg-emerald-500 text-white font-bold flex items-center justify-center text-xs">✓</span><span>Source</span>';
            
            stepPill2.className = 'flex items-center gap-2 text-white font-bold text-xs md:text-sm';
            stepPill2.innerHTML = '<span class="w-6 h-6 rounded-full bg-[#F4C300] text-[#1A3B1B] font-bold flex items-center justify-center text-xs shadow-sm">2</span><span>Prospect</span>';

            window.scrollTo({ top: form.offsetTop - 120, behavior: 'smooth' });
        }
    });

    // Back to Step 1
    backToStep1Btn.addEventListener('click', function () {
        step2.classList.add('hidden');
        step1.classList.remove('hidden');

        // Update Progress Pills
        stepPill1.className = 'flex items-center gap-2 text-white font-bold text-xs md:text-sm';
        stepPill1.innerHTML = '<span class="w-6 h-6 rounded-full bg-[#F4C300] text-[#1A3B1B] font-bold flex items-center justify-center text-xs shadow-sm">1</span><span>Source</span>';

        stepPill2.className = 'flex items-center gap-2 text-white/50 font-medium text-xs md:text-sm';
        stepPill2.innerHTML = '<span class="w-6 h-6 rounded-full bg-white/20 text-white font-bold flex items-center justify-center text-xs">2</span><span>Prospect</span>';
    });

    // Step 1 Pill Click to go back
    stepPill1.addEventListener('click', function () {
        if (!step2.classList.contains('hidden')) {
            backToStep1Btn.click();
        }
    });

    // Form Submission
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Validate all Step 2 inputs
        var step2Inputs = step2.querySelectorAll('input, select, textarea');
        var isStep2Valid = true;

        step2Inputs.forEach(function (input) {
            if (!validateField(input)) isStep2Valid = false;
        });

        if (!isStep2Valid) return;

        // UI Loading State
        submitBtn.disabled = true;
        btnText.innerText = 'Submitting to Salesforce...';
        btnSpinner.classList.remove('hidden');
        responseBox.classList.add('hidden');

        var formData = new FormData(form);

        fetch('<?php echo SITE_URL; ?>/ajax/submit-lead.php', {
            method: 'POST',
            body: formData
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            submitBtn.disabled = false;
            btnText.innerText = 'Submit Lead to Salesforce';
            btnSpinner.classList.add('hidden');

            if (data.success) {
                // Populate Success Summary
                document.getElementById('resLeadName').innerText = document.getElementById('lead_name').value;
                document.getElementById('resCompany').innerText = document.getElementById('lead_company').value;
                document.getElementById('resSource').innerText = sourceInput.value;
                document.getElementById('resLoggedBy').innerText = document.getElementById('submitted_by').value + ' (' + document.getElementById('submitter_role').value + ')';

                // Show Celebration State
                form.classList.add('hidden');
                successState.classList.remove('hidden');
                window.scrollTo({ top: successState.offsetTop - 100, behavior: 'smooth' });
            } else {
                responseBox.classList.remove('hidden');
                responseBox.className = 'my-4 p-4 rounded-xl text-center text-sm font-medium bg-red-100 text-red-800 border border-red-200 block';
                responseBox.innerText = data.message || 'An error occurred while submitting the lead.';
            }
        })
        .catch(function () {
            submitBtn.disabled = false;
            btnText.innerText = 'Submit Lead to Salesforce';
            btnSpinner.classList.add('hidden');
            responseBox.classList.remove('hidden');
            responseBox.className = 'my-4 p-4 rounded-xl text-center text-sm font-medium bg-red-100 text-red-800 border border-red-200 block';
            responseBox.innerText = 'Server error. Please check your network connection and try again.';
        });
    });

    // Reset & Submit Another Lead
    submitAnotherBtn.addEventListener('click', function () {
        var subName = document.getElementById('submitted_by').value;
        var subRole = document.getElementById('submitter_role').value;

        // Reset step 2 inputs
        step2.querySelectorAll('input, select, textarea').forEach(function (i) { i.value = ''; });
        
        // Retain submitter name and role for convenience
        document.getElementById('submitted_by').value = subName;
        document.getElementById('submitter_role').value = subRole;

        successState.classList.add('hidden');
        form.classList.remove('hidden');
        backToStep1Btn.click();
    });
});
</script>
