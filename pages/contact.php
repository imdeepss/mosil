<?php
// pages/contact.php
$pageTitle = 'Contact Us';
?>
<section class="h-[60px] sticky top-0 z-10 bg-white"></section>

<section class="container">
    <nav
        class="flex items-center breadcrumbs gap-1 text-[14px] md:text-[16px] leading-[150%] tracking-[0.015em] capitalize flex-wrap py-6">
        <a href="<?php echo SITE_URL; ?>/" class="text-[#A3A3A3] font-light">Home</a>
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </span>
        <a href="<?php echo SITE_URL; ?>/product-finder" class="text-[#575757] font-bold">Contact Us</a>
    </nav>
    <div class="flex flex-col md:flex-row flex-col-reverse items-stretch -mx-4">
        <div
            class="md:py-6 md:px-12 px-4 py-4 flex flex-col md:gap-6 gap-4 bg-[#F5F5F5] relative z-0 flex-1 md:pb-6 pb-7">
            <div class="absolute inset-0 opacity-50 pointer-events-none w-full h-full -z-10">
                <img src="<?php echo SITE_URL ?>/assets/images/ui/Vector.png" class="w-full h-full object-contain"
                    alt="" loading="lazy">
            </div>

            <div class="py-3.5">
                <span
                    class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                    Contact Us
                </span>
                <div class="border-b border-primary pb-1">
                    <h2
                        class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap md:whitespace-nowrap">
                        Can't find what you are looking for?
                    </h2>
                </div>
            </div>

            <form id="contactForm" method="POST" action="" class="scroll-mt-20">
                <div id="contactResponse" class="hidden mb-4 p-4 rounded text-center text-sm font-medium"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4 gap-2 mb-4">
                    <input type="text" name="name" required placeholder="Name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-main-green text-gray-700 placeholder-gray-400 bg-white">
                    <input type="email" name="email" required placeholder="Email"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-main-green text-gray-700 placeholder-gray-400 bg-white">
                    <input type="tel" name="contact" required placeholder="+91 Phone"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-main-green text-gray-700 placeholder-gray-400 bg-white">
                    <input type="text" name="company_name" required placeholder="Company Name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-main-green text-gray-700 placeholder-gray-400 bg-white">

                    <div class="md:col-span-2">
                        <input type="text" name="subject" required placeholder="Subject"
                            value="<?= htmlspecialchars($product['name'] ?? '') ?>"
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-main-green text-gray-700 placeholder-gray-400 bg-white">
                    </div>

                    <div class="md:col-span-2">
                        <textarea name="message" required placeholder="Write your message here" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-main-green text-gray-700 placeholder-gray-400 bg-white"></textarea>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" id="submitBtn"
                        class="px-8 py-3 bg-main-green text-white font-medium rounded-full hover:bg-opacity-90 transition-colors w-full disabled:bg-gray-400 disabled:cursor-not-allowed">
                        Send
                    </button>
                </div>
            </form>

            <script>
                document.getElementById('contactForm').addEventListener('submit', function (e) {
                    e.preventDefault();

                    const form = this;
                    const btn = document.getElementById('submitBtn');
                    const responseDiv = document.getElementById('contactResponse');

                    // Basic JS Validation
                    const name = form.name.value.trim();
                    const email = form.email.value.trim();
                    const contact = form.contact.value.trim();
                    const message = form.message.value.trim();

                    if (!name || !email || !contact || !message) {
                        showResponse('Please fill in all required fields.', 'error');
                        return;
                    }

                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        showResponse('Please enter a valid email address.', 'error');
                        return;
                    }

                    const phoneRegex = /^[0-9+\-\s]{10,}$/;
                    if (!phoneRegex.test(contact)) {
                        showResponse('Please enter a valid phone number (at least 10 digits).', 'error');
                        return;
                    }

                    // Prepare Data
                    const formData = new FormData(form);

                    // Disable UI
                    btn.disabled = true;
                    btn.textContent = 'Sending...';
                    responseDiv.classList.add('hidden');

                    fetch('<?php echo SITE_URL; ?>/ajax/contact.php', {
                        method: 'POST',
                        body: formData
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                showResponse(data.message === 'success' ? 'Thank you! Your message has been sent successfully.' : data.message, 'success');
                                form.reset();
                            } else {
                                showResponse(data.message || 'Something went wrong. Please try again.', 'error');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            showResponse('An unexpected error occurred. Please try again later.', 'error');
                        })
                        .finally(() => {
                            btn.disabled = false;
                            btn.textContent = 'Send';
                        });

                    function showResponse(msg, type) {
                        responseDiv.textContent = msg;
                        responseDiv.classList.remove('hidden', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700');

                        if (type === 'success') {
                            responseDiv.classList.add('bg-green-100', 'text-green-700');
                        } else {
                            responseDiv.classList.add('bg-red-100', 'text-red-700');
                        }
                    }
                });
            </script>
        </div>

        <div class="md:w-[526px] md:h-[578px] w-full h-[404px] shrink-0 overflow-hidden">
            <img src="<?php echo SITE_URL ?>/assets/images/ui/get-it-touch-banner.png"
                class="w-full h-full object-cover transition-transform duration-500 ease-in-out hover:scale-110"
                alt="Get in touch" loading="lazy">
        </div>
    </div>

</section>

<section>
    <div class="container md:py-20 py-12">
        <div class="py-3.5">
            <span
                class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                Our locations
            </span>
            <div class="border-b border-primary pb-1">
                <h2
                    class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                    Where we operate from
                </h2>
            </div>
        </div>

        <div
            class="grid grid-cols-1 md:grid-cols-2 md:mt-8 mt-2 bg-[#F5F5F5] items-center relative rounded-tr-[80px] md:rounded-tr-[0]">
            <div class="absolute bottom-[84px] left-1/2 -translate-x-1/2 z-10 hidden md:block">
                <img src="<?php echo SITE_URL ?>/assets/images/ui/drop-with-bg.svg" alt="Decorative Drop">
            </div>
            <div
                class="w-full md:h-full h-[346px] overflow-hidden relative group rounded-[2px] md:rounded-[4px] rounded-tr-[80px] md:rounded-tr-[120px]">
                <img src="<?php echo SITE_URL ?>/assets/images/ui/mumbai-v2.png"
                    class="absolute inset-4 md:inset-0 w-full h-full object-cover rounded-[2px] md:rounded-[4px] rounded-tr-[80px] md:rounded-tr-[120px] transition-transform duration-700 ease-in-out group-hover:scale-110"
                    alt="Mumbai Head Office" loading="lazy">
                <div class="flex items-start justify-end px-6 py-4 z-10 relative h-full w-full flex-col">
                    <p class="text-[#FFFFFF] font-base font-normal text-[24px] leading-[135%] tracking-[0.01em] mb-1">
                        Navi Mumbai,
                    </p>
                    <h3 class="text-[#FFFFFF] font-base font-normal text-[40px] leading-[135%] tracking-[0.01em]">
                        India
                    </h3>
                </div>

            </div>
            <div class="flex flex-col justify-center h-full relative">
                <div class="absolute -top-15 right-0 z-10 w-[100px] h-[100px] md:hidden block">
                    <img src="<?php echo SITE_URL ?>/assets/images/ui/drop-with-bg.svg" alt="Decorative Drop"
                        class="w-full h-full object-contain">
                </div>
                <div class="md:pt-15 md:pl-26 md:pr-20 md:pb-19 py-4 px-4">

                    <h2
                        class="text-[#1A3B1B] font-base font-normal md:text-[40px] md:leading-[120%] text-[28px] leading-[135%] capitalize md:mb-4 mb-6.5">
                        MOSIL head office
                    </h2>

                    <p
                        class="text-[#666666] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em] md:mb-8 mb-6 md:max-w-md">
                        Headquartered in fast paced and innovative Mumbai, we cater to our customer's specific needs
                        globally.
                    </p>

                    <ul
                        class="text-[#666666] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em] flex flex-col gap-4 md:mb-11 mb-6">
                        <li class="flex gap-4 items-start">
                            <img src="<?php echo SITE_URL ?>/assets/icons/svg/location.svg" alt="Location" class="mt-1">
                            <span class="flex-1 lg:pr-8">
                                Address: Mosil lubricants Pvt.Ltd. Plot no. A-791/3, MIDC, Kopar-Khairane, Navi Mumbai -
                                400710, Maharashtra, India.
                            </span>
                        </li>
                        <li class="flex gap-4 items-center">
                            <img src="<?php echo SITE_URL ?>/assets/icons/svg/contact.svg" alt="Phone">
                            <a href="tel:+918942414355" class="hover:text-main-green transition-colors">+91 8942414355 |
                                +91 7453423151</a>
                        </li>
                        <li class="flex gap-4 items-center">
                            <img src="<?php echo SITE_URL ?>/assets/icons/svg/email.svg" alt="Email">
                            <a href="mailto:enquiry@mosil.com"
                                class="hover:text-main-green transition-colors">enquiry@mosil.com</a>
                        </li>
                    </ul>

                    <ul
                        class="flex gap-4 items-center [&_li]:w-[42px] [&_li]:h-[42px] [&_li]:p-[9px] [&_li]:rounded-full [&_li]:flex [&_li]:items-center [&_li]:justify-center [&_li]:bg-main-green [&_li]:transition-transform [&_li]:duration-300 hover:[&_li]:scale-110">
                        <li><a href="#"><img src="<?php echo SITE_URL ?>/assets/icons/svg/x.svg" alt="X"></a></li>
                        <li><a href="#"><img src="<?php echo SITE_URL ?>/assets/icons/svg/facebook.svg"
                                    alt="Facebook"></a></li>
                        <li><a href="#"><img src="<?php echo SITE_URL ?>/assets/icons/svg/instagram.svg"
                                    alt="Instagram"></a></li>
                        <li><a href="#"><img src="<?php echo SITE_URL ?>/assets/icons/svg/youtube.svg"
                                    alt="YouTube"></a></li>
                        <li><a href="#"><img src="<?php echo SITE_URL ?>/assets/icons/svg/linkedin.svg"
                                    alt="LinkedIn"></a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</section>
<section>
    <div class="container">
        <div class="py-3.5">
            <span
                class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                on the world map
            </span>
            <div class="border-b border-primary pb-1">
                <h2
                    class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                    Find us all over the world
                </h2>
            </div>
        </div>
    </div>
    <div class="bg-primary relative overflow-hidden md:min-h-[800.077px] min-h-[240px] flex items-center">

        <div class="absolute inset-0 z-0">
            <img src="<?php echo SITE_URL ?>/assets/images/ui/linear-box-bg.svg"
                class="w-full h-full object-cover opacity-50" alt="">
        </div>

        <div class="container relative z-10 md:py-6">
            <div class="w-full h-[240px] lg:h-[700px]"> <img src="<?php echo SITE_URL ?>/assets/images/ui/world-map.svg"
                    alt="World Map" class="w-full h-full object-contain">
            </div>
        </div>

    </div>
</section>