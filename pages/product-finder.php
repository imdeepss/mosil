<?php
$pageTitle = 'Product Finder';
?>

<!-- Hero Section -->
<section class="relative w-full h-[748px] md:h-[480px] overflow-hidden">
    <div class="container relative z-20 flex items-end justify-start w-full h-full pb-4 md:pb-10">
        <h2
            class="text-white font-base font-normal text-[32px] md:text-[48px] leading-[120%] tracking-normal capitalize max-w-md">
            Product Finder
        </h2>
    </div>

    <div class="absolute inset-0 z-10 bg-gradient-to-tr from-black/60 via-black/20 to-transparent"></div>

    <div class="absolute inset-0 z-0">
        <img src="<?php echo SITE_URL; ?>/assets/images/banners/product-finder.png" alt="Product Finder Desktop"
            class="hidden md:block w-full h-full object-cover object-center" loading="lazy">

        <img src="<?php echo SITE_URL; ?>/assets/images/banners/mb_finder.png" alt="Product Finder Mobile"
            class="block md:hidden w-full h-full object-cover object-center" loading="lazy">
    </div>
</section>



<!-- Product Categories Section -->
<?php
$categories = [
    [
        'title_line1' => 'Browse by',
        'title_line2' => 'Industry',
        'image' => SITE_URL . '/assets/images/products/browse-by-industry.png',
        'link' => SITE_URL . '/product-finder/industry-categories',
    ],
    [
        'title_line1' => 'Browse by',
        'title_line2' => 'Product',
        'image' => SITE_URL . '/assets/images/products/browse-by-products.png',
        'link' => SITE_URL . '/product-finder/product-categories',
    ],
];
?>

<section class="bg-white font-base">
    <div class="container md:pt-18 pt-16 md:pb-20 pb-12 relative">
        <nav
            class="absolute top-6 left-4 flex items-center breadcrumbs gap-1 text-[14px] md:text-[16px] leading-[150%] tracking-[0.015em] capitalize">
            <a href="<?php echo SITE_URL; ?>" class="text-[#A3A3A3] font-light">Home</a>
            <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg></span>
            <a href="<?php echo SITE_URL; ?>/product-finder" class="text-[#575757] font-bold">Product
                Finder</a>
        </nav>
        <div class="py-3.5">
            <div class="border-b-2 border-primary pb-1">
                <h2
                    class="text-main-green font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize">
                    Categories
                </h2>
            </div>
        </div>

        <p
            class="md:pr-28 pr-0 font-light md:text-lg text-[12px] leading-[150%] leading-[140%] tracking-normal text-[var(--color-b100)] hidden md:block">
            We offer a diverse range of products tailored to meet the needs of various industries. From innovative tech
            solutions to essential manufacturing tools, we cater to every sector's unique requirements.
        </p>

        <div class="md:mt-10 mt-4.5 grid grid-cols-2 md:gap-11 gap-3">
            <?php foreach ($categories as $item): ?>
                <div class="relative group">
                    <div class="w-full md:h-[460px] h-[151px] overflow-hidden">
                        <img src="<?php echo $item['image']; ?>" alt=""
                            class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-120"
                            loading="lazy">
                    </div>

                    <div
                        class="w-full bg-primary text-mid-green py-2.5 md:py-7 md:px-9 px-2.5 flex justify-between items-center">
                        <h2
                            class="font-base font-normal md:text-[32px] md:leading-[120%] text-[16px] leading-[150%] tracking-normal capitalize flex flex-col pb-2 text-main-green">
                            <?php echo $item['title_line1']; ?>
                            <span><?php echo $item['title_line2']; ?></span>
                        </h2>

                        <a href="<?php echo $item['link']; ?>"
                            class="transition-all duration-500 transform group-hover:-rotate-45 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" fill="none"
                                class="w-5 h-5 md:w-10 md:h-10 transition-all duration-500">
                                <path d="M23.3333 8.3335L35 20.0002M35 20.0002L23.3333 31.6668M35 20.0002L5 20.0002"
                                    stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- Contact section -->
<section class="relative w-full overflow-hidden md:h-[450px] h-[280px] bg-white">
    <div class="container relative z-10 w-full h-full">
        <div class="max-w-[720px] md:pt-18 pt-12 relative z-1 text-center md:text-left">
            <h2
                class="text-main-green font-base font-normal md:text-[40px] text-[18px] leading-[140%] md:leading-[120%] tracking-normal capitalize mb-2">
                Cant
                find
                what you are looking for?</h2>
            <p
                class="font-base font-normal md:text-[18px] md:leading-[140%] text-[12px] leading-[150%] tracking-normal mb-6 md:px-0 px-10 text-[#757575]">
                Our expert team will
                support
                you in
                finding systems best suited for your needs.</p>
            <a href="<?php echo SITE_URL; ?>/contact"
                class="bg-main-green text-white font-base font-normal md:text-base text-[14px] leading-[150%] tracking-[0.015em] capitalize px-12 py-3 rounded-full inline-block">Contact
                us</a>
        </div>
        <div class="absolute left-0 bottom-0 w-full h-auto">
            <img src="<?php echo SITE_URL; ?>/assets/images/banners/contact-us-v2.svg" alt="Contact Us"
                class="block h-full w-full object-contain object-center" loading="lazy">
        </div>
    </div>
</section>