<?php
// pages/contact.php
$pageTitle = 'Contact Us';
?>
<!-- Hero Section -->
<section class="relative w-full h-[748px] md:h-[480px] overflow-hidden">
    <div class="container relative z-20 flex items-end justify-start w-full h-full pb-4 md:pb-10">
        <h2
            class="text-white font-base font-normal text-[32px] md:text-[48px] leading-[120%] tracking-normal capitalize">
            We keep industries moving
        </h2>
    </div>

    <!-- <div class="absolute inset-0 z-10 bg-gradient-to-tr from-black/60 via-black/20 to-transparent"></div> -->

    <div class="absolute inset-0 z-0 w-full h-full">
        <img src="<?php echo SITE_URL; ?>/assets/images/banners/industry-categories.png" alt="Product Finder Desktop"
            class="hidden md:block w-full h-full object-cover object-[50%_75%]" fetchpriority="high">

        <img src="<?php echo SITE_URL; ?>/assets/images/banners/industry-categories-mb4.png" alt="Product Finder Mobile"
            class="block md:hidden w-full h-full object-cover object-center" fetchpriority="high">
    </div>
</section>