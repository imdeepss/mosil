<?php
$pageTitle = 'Industry Category';

$industries = getCategoryByParent("2");
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


<section class="py-6 bg-white relative">
    <div class="container">
        <nav
            class="flex items-center breadcrumbs gap-1 text-[14px] md:text-[16px] leading-[150%] tracking-[0.015em] capitalize">
            <a href="<?php echo SITE_URL; ?>/" class="text-[#A3A3A3] font-light">Home</a>
            <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg></span>
            <a href="<?php echo SITE_URL; ?>/product-finder" class="text-[#A3A3A3] font-light">Product
                Finder</a>
            <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg></span>
            <a href="<?php echo SITE_URL; ?>/product-finder/industry-categories"
                class="text-[#575757] font-bold">Industry
                categories</a>
        </nav>
        <div class="py-3.5">
            <div class="border-b-2 border-primary pb-1">
                <h2
                    class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                    Industry categories
                </h2>
            </div>
        </div>

        <p
            class="md:pr-32 pr-0 font-light md:text-lg text-[12px] leading-[150%] leading-[140%] tracking-normal text-[var(--color-b100)] hidden md:block mb-9">
            We have solution for a broad spectrum of industries.
            We solve complex tribology challenges all over the
            world with our lubrication solutions for demanding
            industrial applications, from high-temperature greases
            for automotive components to solutions for cement
            plants, designed to enhance process efficiency.
        </p>
    </div>
</section>
<section class="bg-white relative z-10">
    <div class="container">
        <div class="grid md:gap-10 gap-4">
            <div id="industry-grid" class="grid grid-cols-1 md:grid-cols-4 md:gap-10 gap-4">
                <?php foreach ($industries as $industry): ?>
                    <div class="industry-item md:h-[260px] h-[224px] relative group overflow-hidden cursor-pointer">
                        <?php
                        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $industry['mcat_name'])));
                        ?>
                        <a href="<?php echo SITE_URL; ?>/product-finder/industry-categories/<?php echo $slug; ?>">
                            <div
                                class="absolute inset-0 z-10 w-full h-full transition-colors duration-500 group-hover:bg-main-green/80 rounded-[4px]">
                            </div>
                            <div class="relative w-full h-full overflow-hidden rounded-[4px]">
                                <img src="<?php echo SITE_URL; ?>/assets/uploads/main-category/<?php echo $industry['mcat_image']; ?>"
                                    alt="<?php echo $industry['mcat_name']; ?>"
                                    class="absolute inset-0 w-full h-full object-cover" loading="lazy" />

                                <div
                                    class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent via-[58.65%] to-black">
                                </div>
                            </div>
                            <div class="absolute inset-0 z-20 flex flex-col justify-end px-4 md:py-4 py-3">
                                <h2
                                    class="text-white font-base font-bold md:text-[18px] md:text-[14px] leading-[140%] tracking-[0.015em] capitalize mb-1 text-[16px] leading-[150%] ">
                                    <?php echo $industry['mcat_name']; ?>
                                </h2>
                                <div class="flex items-center gap-2 justify-between">
                                    <p
                                        class="text-white font-base font-normal text-[14px] leading-[150%] tracking-[0.015em]">
                                        <?php echo $industry['mcat_desc']; ?>
                                    </p>
                                    <button
                                        class="inline-flex shrink-0 origin-center will-change-transform transition-all duration-500 ease-in-out text-white group-hover:text-primary group-hover:-rotate-45">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                            fill="none">
                                            <path
                                                d="M11.6667 4.1665L17.5 9.99984M17.5 9.99984L11.6667 15.8332M17.5 9.99984L2.5 9.99984"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </button>

                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mx-auto">
                <button type="button" id="industry-load-more"
                    class="border border-[#1A3B1B] text-[#1A3B1B] font-base font-normal text-[14px] md:text-base leading-[150%] tracking-[0.015em] capitalize px-8 py-3 rounded-full inline-block button-hover-vertical cursor-pointer">
                    see more
                </button>

            </div>
        </div>
    </div>
</section>

<section class="md:py-6 py-12 bg-white relative
    after:content-[''] 
    after:absolute 
    after:inset-0
    after:z-20 
    after:pointer-events-none

    /* Mobile Background Image */
    after:bg-[url('<?php echo SITE_URL; ?>/assets/images/ui/high-performance-mb-bg.svg')] 
    after:bg-contain 
    after:bg-center 
    after:bg-no-repeat 
    
    /* Desktop Background Image */
    md:after:bg-[url('<?php echo SITE_URL; ?>/assets/images/ui/high-performance-bg.svg')] 
    md:after:bg-center
    md:after:bg-contain 
    ">

    <div class="container mx-auto">
        <div class="relative z-10 md:max-w-xl max-w-[310px] pb-18 pt-3 md:pb-[161px] md:pt-[177px]">
            <h2
                class="text-main-green font-base font-bold md:font-normal md:text-[32px] md:leading-[120%] md:tracking-normal capitalize mb-1 text-[20px] leading-[140%] tracking-[0.01em]">
                High-performance industrial lubrication
            </h2>
            <p
                class="text-[#757575] font-base font-normal md:text-[16px] md:leading-[150%] md:tracking-[0.015em] text-[12px] leading-[150%] tracking-[0.015em] md:pr-0 pr-18 ">
                Solving complex tribology challenges across global industries.
            </p>
        </div>
    </div>
</section>