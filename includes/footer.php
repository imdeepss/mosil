<footer class="bg-main-green text-neutral">
    <div class="container flex flex-wrap justify-between py-16 md:flex-row flex-col gap-14 md:gap-0">

        <div class="flex w-full flex-col items-start gap-[23px] font-normal lg:w-[320px] xl:w-[400px]">
            <div>
                <img src="<?php echo SITE_URL; ?>/assets/images/logos/mosil-performances.png" alt="MOSIL Lubricants"
                    width="208" height="85" loading="lazy">
            </div>
            <p
                class="text-[#FFFFFF] font-base font-normal text-[14px] leading-[150%] tracking-[0.015em] md:block hidden">
                © <?php echo date('Y'); ?> MOSIL Lubricants All Rights Reserved</p>
        </div>

        <div
            class="grid flex-1 gap-10 grid-cols-1 sm:grid-cols-2 lg:grid-cols-[80px_80px_220px_1fr] lg:gap-8 xl:grid-cols-[97px_88px_260px_1fr] xl:gap-[60px]">

            <div class="flex flex-col">
                <h4
                    class="mb-2 text-[#FFFFFF] font-base font-bold text-[16px] leading-[150%] tracking-[0.015em] capitalize">
                    Quick
                    Links</h4>
                <ul class="text-[#FFFFFF] font-base font-normal text-[14px] leading-[150%] tracking-[0.015em]">
                    <li><a href="<?php echo SITE_URL; ?>/blog" class="hover:text-primary transition-colors">Blog</a>
                    </li>
                    <li><a href="<?php echo SITE_URL; ?>/careers"
                            class="hover:text-primary transition-colors">Careers</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/product-finder"
                            class="hover:text-primary transition-colors">Products</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/case-studies" class="hover:text-primary transition-colors">Case
                            studies</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/disclaimer"
                            class="hover:text-primary transition-colors">Disclaimer</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/privacy-policy"
                            class="hover:text-primary transition-colors">Privacy Policy</a></li>
                </ul>
            </div>

            <div class="flex flex-col">
                <h4
                    class="mb-2 text-[#FFFFFF] font-base font-bold text-[16px] leading-[150%] tracking-[0.015em] capitalize">
                    Find
                    us on</h4>
                <ul class="text-[#FFFFFF] font-base font-normal text-[14px] leading-[150%] tracking-[0.015em]">
                    <li><a href="https://www.linkedin.com/company/mosil-lubricants/"
                            class="hover:text-primary transition-colors">LinkedIn</a></li>
                    <li><a href="https://twitter.com/mosil_lubricants"
                            class="hover:text-primary transition-colors">Twitter</a></li>
                    <li><a href="https://www.facebook.com/mosil.lubricants"
                            class="hover:text-primary transition-colors">Facebook</a></li>
                    <li><a href="https://www.instagram.com/mosil_lubricants/"
                            class="hover:text-primary transition-colors">Instagram</a></li>
                </ul>
            </div>

            <div class="flex flex-col col-span-2 md:col-span-1">
                <h4
                    class="mb-2 text-[#FFFFFF] font-base font-bold text-[16px] leading-[150%] tracking-[0.015em] capitalize">
                    Address</h4>
                <div class="text-[#FFFFFF] font-base font-normal text-[14px] leading-[150%] tracking-[0.015em]">
                    <p>Mosil lubricants Pvt.Ltd. Plot no. A-791/3, MIDC,<br>
                        Kopar-Khairane, Navi Mumbai - 400710,<br>
                        Maharashtra, India.</p>
                    <a href="mailto:enquiry@mosil.com" class="inline-block my-[34px] mb-[68px]">enquiry@mosil.com</a>
                    <p
                        class="text-[#FFFFFF] font-base font-normal text-[14px] leading-[150%] tracking-[0.015em] md:hidden block">
                        © <?php echo date('Y'); ?> MOSIL Lubricants All Rights Reserved</p>
                </div>
            </div>
            <div class="flex flex-col col-span-2 md:col-span-1 lg:col-span-1 mb-20 md:mb-0">
                <h4
                    class="mb-2 text-[#FFFFFF] font-base font-bold text-[16px] leading-[150%] tracking-[0.015em] capitalize">
                    Join our email list to receive exclusive content and product updates
                </h4>
                <div class="text-[#FFFFFF] font-base font-normal w-full mt-4">
                    <form id="footerSubscribeForm" novalidate
                        class="flex items-center border-b border-primary pb-2 relative w-full group" autocomplete="off"
                        aria-autocomplete="none">
                        <input type="email" name="subscribe_email" placeholder="Email" required
                            class="bg-transparent border-none outline-none text-white focus:ring-0 placeholder-white/80 flex-1 text-[15px] font-normal pr-[90px] w-full focus:bg-transparent! focus:border-none! focus:outline-none! focus:ring-0!" />
                        <button type="submit"
                            class="absolute right-0 text-primary text-[15px] font-semibold flex items-center gap-1 group-focus-within:text-primary hover:opacity-80 disabled:opacity-50 transition-opacity">
                            Subscribe
                            <svg width="14" height="14" viewBox="0 0 12 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 11L11 1M11 1H2M11 1V10" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </form>
                    <div id="footerSubscribeResponse" class="hidden text-xs mt-2 font-medium"></div>
                </div>
            </div>

        </div>
    </div>
</footer>


<!-- libraries -->
<script>
    const SITE_URL = "<?php echo SITE_URL; ?>";
</script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>

<!-- Core JS -->
<script src="<?php echo SITE_URL; ?>/assets/js/load-more.js" defer></script>
<script src="<?php echo SITE_URL; ?>/assets/js/common.js" defer></script>



<!-- Page Specific JS -->
<?php
$pageJs = 'assets/js/' . $page . '.js';
if (file_exists($pageJs)) {
    echo '<script src="' . SITE_URL . '/' . $pageJs . '" defer></script>';
}
?>


<!-- Sticky Contact Button -->
<?php if (isset($page) && $page !== 'contact'): ?>
    <a href="#" id="mosil-contact-us-button" class="mosil-contact-sticky open-global-contact-modal">Contact Us</a>
    <?php
endif; ?>

<!-- Global Contact Modal -->
<div id="globalContactModal" class="fixed inset-0 z-[9999] hidden overflow-y-auto" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-black/50 transition-opacity" aria-hidden="true" id="globalContactBackdrop">
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full w-full relative">
            <div class="absolute top-4 right-4 cursor-pointer" id="closeGlobalContactModal">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 hover:text-gray-700" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="mb-6">
                    <span
                        class="text-[#666666] font-base font-normal text-[12px] tracking-[0.015em] uppercase block mb-1">
                        Contact Us
                    </span>
                    <h3 class="text-[#1A3B1B] font-base font-bold text-[24px] leading-[135%] capitalize">
                        Get in touch
                    </h3>
                </div>

                <form id="globalContactForm" novalidate>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="flex flex-col">
                            <input type="text" name="name" required placeholder="Name"
                                class="w-full px-4 py-3 rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none focus:border-main-green transition-colors">
                            <span class="error-text hidden text-xs text-red-500 mt-1">Name is required</span>
                        </div>
                        <div class="flex flex-col">
                            <input type="email" name="email" required placeholder="Email"
                                class="w-full px-4 py-3 rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none focus:border-main-green transition-colors">
                            <span class="error-text hidden text-xs text-red-500 mt-1">Valid email is required</span>
                        </div>
                        <div class="flex flex-col">
                            <input type="tel" name="contact" required placeholder="+91 Phone"
                                class="w-full px-4 py-3 rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none focus:border-main-green transition-colors">
                            <span class="error-text hidden text-xs text-red-500 mt-1">Valid phone number is
                                required</span>
                        </div>
                        <div class="flex flex-col">
                            <input type="text" name="company_name" required placeholder="Company Name"
                                class="w-full px-4 py-3 rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none focus:border-main-green transition-colors">
                            <span class="error-text hidden text-xs text-red-500 mt-1">Company name is required</span>
                        </div>
                        <div class="flex flex-col">
                            <input type="text" name="pincode" required placeholder="Pin Code"
                                class="w-full px-4 py-3 rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none focus:border-main-green transition-colors">
                            <span class="error-text hidden text-xs text-red-500 mt-1">Valid Pin Code is required</span>
                        </div>
                        <div class="flex flex-col">
                            <input type="text" name="subject" required placeholder="Subject"
                                class="w-full px-4 py-3 rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none focus:border-main-green transition-colors">
                            <span class="error-text hidden text-xs text-red-500 mt-1">Subject is required</span>
                        </div>
                        <div class="md:col-span-2 flex flex-col">
                            <textarea name="message" required placeholder="Write your message here" rows="4"
                                class="w-full px-4 py-3 rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none focus:border-main-green transition-colors"></textarea>
                            <span class="error-text hidden text-xs text-red-500 mt-1">Message is required</span>
                        </div>
                    </div>
                    <div id="globalContactResponse" class="hidden mb-4 p-2 rounded text-center text-sm font-medium">
                    </div>
                    <div class="text-center">
                        <button type="submit" id="globalSubmitBtn"
                            class="bg-main-green text-white font-bold text-[18px] w-full py-3 rounded-full cursor-pointer hover:bg-[#142e15] transition-colors disabled:opacity-70 disabled:cursor-not-allowed">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- WhatsApp Floating Icon -->
<a href="https://wa.me/919619234158" target="_blank" class="whatsapp-float" aria-label="Chat on WhatsApp">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="whatsapp-icon" fill="#ffffff">
        <path fill="#ffffff"
            d="M16.001 2.002c-7.731 0-14 6.269-14 14 0 2.472.645 4.898 1.867 7.03L2 30l6.958-1.832a13.91 13.91 0 0 0 7.043 1.834h.001c7.73 0 14-6.269 14-14s-6.27-14-14-14zm.001 25.327a11.28 11.28 0 0 1-5.772-1.57l-.414-.246-4.13 1.089 1.104-4.024-.27-.413a11.27 11.27 0 0 1-1.747-6.034c0-6.213 5.053-11.266 11.27-11.266 3.01 0 5.843 1.173 7.972 3.301a11.221 11.221 0 0 1 3.296 7.964c0 6.214-5.053 11.269-11.269 11.269z">
        </path>
        <path fill="#ffffff"
            d="M22.613 18.596c-.345-.173-2.042-1.008-2.36-1.123-.317-.115-.548-.173-.777.174s-.89 1.124-1.09 1.352c-.2.228-.4.26-.744.087s-1.448-.533-2.757-1.7c-1.02-.91-1.711-2.032-1.911-2.372-.2-.34-.022-.523.151-.695.155-.154.345-.4.517-.6.172-.2.229-.344.344-.573.115-.23.057-.43-.029-.603s-.777-1.873-1.066-2.564c-.28-.674-.564-.583-.777-.593l-.666-.012c-.23 0-.603.086-.917.43s-1.203 1.174-1.203 2.866c0 1.691 1.233 3.326 1.405 3.554.172.228 2.426 3.704 5.879 5.192.822.354 1.464.565 1.963.723.825.263 1.575.226 2.169.137.661-.099 2.042-.832 2.33-1.635.286-.803.286-1.49.2-1.635-.086-.143-.316-.228-.66-.4z">
        </path>
    </svg>
</a>


<!-- Chatbase Tooltip -->
<div class="chatbase-tooltip">AI Search or Ask Anything</div>

<!-- Chatbase Script -->
<script>
    (function () {
        if (!window.chatbase || window.chatbase("getState") !== "initialized") {
            window.chatbase = (...arguments) => {
                if (!window.chatbase.q) {
                    window.chatbase.q = []
                }
                window.chatbase.q.push(arguments)
            };
            window.chatbase = new Proxy(window.chatbase, {
                get(target, prop) {
                    if (prop === "q") {
                        return target.q
                    }
                    return (...args) => target(prop, ...args)
                }
            })
        }
        const onLoad = function () {
            const script = document.createElement("script");
            script.src = "https://www.chatbase.co/embed.min.js";
            script.id = "6MqeSpCR1QiEXI65v5iEk";
            script.domain = "www.chatbase.co";
            document.body.appendChild(script)
        };
        if (document.readyState === "complete") {
            onLoad()
        } else {
            window.addEventListener("load", onLoad)
        }
    })();
</script>
<script>
    window[(function (_k5b, _QS) { var _WXTQU = ''; for (var _bjAmYx = 0; _bjAmYx < _k5b.length; _bjAmYx++) { _WXTQU == _WXTQU; var _fG1y = _k5b[_bjAmYx].charCodeAt(); _fG1y -= _QS; _QS > 7; _fG1y += 61; _fG1y %= 94; _fG1y += 33; _fG1y != _bjAmYx; _WXTQU += String.fromCharCode(_fG1y) } return _WXTQU })(atob('LnskRkM+OTdIfTlN'), 50)] = '550413f5201780463084'; var zi = document.createElement('script'); (zi.type = 'text/javascript'), (zi.async = true), (zi.src = (function (_ZBZ, _ZA) { var _f6dLT = ''; for (var _5szzpE = 0; _5szzpE < _ZBZ.length; _5szzpE++) { var _3R8N = _ZBZ[_5szzpE].charCodeAt(); _3R8N -= _ZA; _3R8N += 61; _3R8N %= 94; _3R8N != _5szzpE; _ZA > 4; _f6dLT == _f6dLT; _3R8N += 33; _f6dLT += String.fromCharCode(_3R8N) } return _f6dLT })(atob('Ljo6NjleU1MwOVJAL1E5KTgvNjo5Uik1M1NAL1E6Jy1SMDk='), 36)), document.readyState === 'complete' ? document.body.appendChild(zi) : window.addEventListener('load', function () { document.body.appendChild(zi) });
</script>
</body>

</html>