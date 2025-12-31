<footer class="bg-[var(--color-main-green)] text-[var(--color-neutral)]">
    <div class="container flex flex-wrap justify-between py-16 md:flex-row flex-col gap-14 md:gap-0">

        <div class="flex w-full flex-col items-start gap-[23px] font-normal lg:w-[480px]">
            <div>
                <img src="<?php echo SITE_URL; ?>/assets/images/logos/mosil-performances.png" alt="MOSIL Lubricants"
                    width="208" height="85" loading="lazy">
            </div>
            <p class="text-sm md:block hidden">© 2025 MOSIL Lubricants All Rights Reserved</p>
        </div>

        <div class="grid flex-1 gap-12 grid-cols-2 md:grid-cols-[97px_84px_320px] md:gap-[97px]">

            <div class="flex flex-col">
                <h4 class="mb-[var(--spacing-sm)] text-base font-bold leading-normal">Quick
                    Links</h4>
                <ul class="text-sm font-normal leading-normal">
                    <li><a href="<?php echo SITE_URL; ?>/blog"
                            class="hover:text-[var(--color-primary)] transition-colors">Blog</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/careers"
                            class="hover:text-[var(--color-primary)] transition-colors">Careers</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/product-finder"
                            class="hover:text-[var(--color-primary)] transition-colors">Products</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/case-studies"
                            class="hover:text-[var(--color-primary)] transition-colors">Case studies</a></li>
                </ul>
            </div>

            <div class="flex flex-col">
                <h4 class="mb-[var(--spacing-sm)] text-base font-bold leading-normal">Find
                    us on</h4>
                <ul class="text-sm font-normal leading-normal">
                    <li><a href="https://www.linkedin.com/company/mosil-lubricants/"
                            class="hover:text-[var(--color-primary)] transition-colors">LinkedIn</a></li>
                    <li><a href="https://twitter.com/mosil_lubricants"
                            class="hover:text-[var(--color-primary)] transition-colors">Twitter</a></li>
                    <li><a href="https://www.facebook.com/mosil.lubricants"
                            class="hover:text-[var(--color-primary)] transition-colors">Facebook</a></li>
                    <li><a href="https://www.instagram.com/mosil_lubricants/"
                            class="hover:text-[var(--color-primary)] transition-colors">Instagram</a></li>
                </ul>
            </div>

            <div class="flex flex-col col-span-2 md:col-span-1">
                <h4 class="mb-[var(--spacing-sm)] text-base font-bold leading-normal">
                    Address</h4>
                <div class="text-sm font-normal leading-normal">
                    <p>Mosil lubricants Pvt.Ltd. Plot no. A-791/3, MIDC,<br>
                        Kopar-Khairane, Navi Mumbai - 400710,<br>
                        Maharashtra, India.</p>
                    <a href="mailto:enquiry@mosil.com" class="inline-block my-[34px] mb-[68px]">enquiry@mosil.com</a>
                    <p class="text-sm md:hidden block">© 2025 MOSIL Lubricants All Rights Reserved</p>
                </div>
            </div>

        </div>
    </div>
</footer>


<!-- libraries -->
<script>
    const SITE_URL = "<?php echo SITE_URL; ?>";
</script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Core JS -->
<script src="<?php echo SITE_URL; ?>/assets/js/load-more.js"></script>
<script src="<?php echo SITE_URL; ?>/assets/js/common.js"></script>



<!-- Page Specific JS -->
<?php
$pageJs = 'assets/js/' . $page . '.js';
if (file_exists($pageJs)) {
    echo '<script src="' . SITE_URL . '/' . $pageJs . '"></script>';
}
?>

</body>

</html>