<?php
$pageTitle = 'Custom & Specialty Lubricants Manufacturer | MOSIL Lubricants';
$metaDescription = 'MOSIL Lubricants Pvt. Ltd. is a specialty industrial lubricant manufacturer focused on reducing friction and improving efficiency with custom greases, oils, and coatings.';
$industries = getSpecificIndustries();
$products = getCategoryByParent("3", "4");
$caseStudies = getHomeFixedCaseStudies();
$blogs = getHomeFeaturedBlogs();

?>
<!-- Hero Section -->
<h1 class="sr-only">Custom & Specialty Lubricants Manufacturer | MOSIL Lubricants</h1>
<section class="relative h-[720px] w-full overflow-hidden">
    <video autoplay muted loop playsinline class="block h-full w-full object-cover object-center md:block hidden"
        poster="<?php echo SITE_URL; ?>/assets/images/banners/home-banner-poster.webp" fetchpriority="high">
        <source src="<?php echo SITE_URL; ?>/assets/images/banners/home-banner.mp4" type="video/mp4"
            media="(min-width: 768px)">
        <img decoding="async" src="<?php echo SITE_URL; ?>/assets/images/banners/home-banner-poster.webp"
            alt="Hero Image" class="h-full w-full object-cover object-center">
    </video>

    <video autoplay muted loop playsinline class="block h-full w-full object-cover object-center block md:hidden"
        poster="<?php echo SITE_URL; ?>/assets/images/banners/mb-home-banner-poster.webp">
        <source src="<?php echo SITE_URL; ?>/assets/images/banners/mb-home-banner.mp4" type="video/mp4"
            media="(max-width: 767px)">
        <img decoding="async" src="<?php echo SITE_URL; ?>/assets/images/banners/mb-home-banner-poster.webp"
            alt="Hero Image" class="h-full w-full object-cover object-center">
    </video>
</section>


<!-- Lubricant solutions for every industry -->
<section class="bg-white">
    <div class="container relative md:py-20 py-12">
        <div class="py-3.5">
            <span
                class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                Industries we serve
            </span>
            <div class="border-b-2 border-primary pb-1 flex md:items-center items-end justify-between gap-13">
                <h2
                    class="text-main-green font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                    Lubricant solutions for every industry
                </h2>
                <a href="<?php echo SITE_URL; ?>/product-finder/industry-categories/"
                    class="text-[#1A3B1B] font-base font-normal text-[18px] leading-[140%] md:text-[24px] md:font-bold md:leading-[120%] md:tracking-[0.01em] shrink-0"
                    aria-label="See all industries we serve">
                    See all
                </a>
            </div>
        </div>
        <div class="md:mt-8 mt-6 flex flex-col flex-col-reverse lg:flex-row md:gap-5 items-stretch">

            <div
                class="hidden w-full lg:w-[433px] lg:h-[480px] bg-[#F5F5F5] rounded-[4px] relative lg:flex flex-col justify-between py-16 px-8.5 flex-col gap-4 bg-[#F5F5F5] z-20 shrink-0">

                <div class="absolute inset-0 opacity-50 pointer-events-none select-none">
                    <img decoding="async" src="<?php echo SITE_URL; ?>/assets/images/ui/Vector.png"
                        class="w-full h-full object-contain" alt="Decorative background pattern" role="presentation">
                </div>

                <div
                    class="swiper contentSwiper w-full h-full !m-0 pointer-events-none relative z-10 [&_.swiper-slide]:!opacity-0 [&_.swiper-slide]:transition-opacity [&_.swiper-slide]:duration-300 [&_.swiper-slide]:ease-out [&_.swiper-slide-active]:!opacity-100">
                    <div class="swiper-wrapper">
                        <?php foreach ($industries as $industry): ?>
                            <div class="swiper-slide !flex flex-col items-start h-full bg-transparent gap-4">
                                <div>
                                    <h2
                                        class="text-[#1A3B1B] text-[28px] md:text-[32px] leading-[1.2] font-normal capitalize">
                                        <?php echo $industry['mcat_name']; ?>
                                    </h2>
                                    <p class="text-[#575757] text-[13px] captalize tracking-wider font-medium">
                                        <?php echo $industry['mcat_desc']; ?>
                                    </p>

                                </div>
                                <div
                                    class="text-[#575757] font-base font-normal text-[12px] leading-[150%] tracking-[0.015em] md:text-[18px] md:leading-[140%] md:tracking-normal industry-desc min-h-[150px] overflow-hidden">
                                    <?php echo clean_content($industry['meta_description']); ?>
                                </div>
                                <div class="">
                                    <a href="<?php echo SITE_URL; ?>/product-finder/industry-categories/<?php echo $industry['slug']; ?>"
                                        class="industry-link inline-flex items-center justify-center bg-main-green px-10 h-[48px] rounded-full transition-all w-[124px] button-hover border-2 border-transparent text-[#FFFFFF] text-center font-base font-normal text-[16px] leading-none tracking-[0.015em]">
                                        View
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="flex gap-4 relative z-10 pointer-events-auto">
                    <button class="nav-prev nav-btn w-12 h-12 flex items-center justify-center cursor-pointer group"
                        aria-label="Previous Slide">
                        <svg class="w-12 h-12 transition-transform group-active:scale-90" viewBox="0 0 48 48">
                            <circle cx="24" cy="24" r="23" stroke="#1A3B1B" stroke-width="2" fill="none"
                                class="transition-all duration-300 group-hover:fill-[#1A3B1B] group-hover:stroke-[#1A3B1B]" />
                            <path d="M34 24L14 24M14 24L20 18M14 24L20 30" stroke="#1A3B1B" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="transition-all duration-300 group-hover:stroke-white" />
                        </svg>
                    </button>
                    <button class="nav-next nav-btn w-12 h-12 flex items-center justify-center cursor-pointer group"
                        aria-label="Next Slide">
                        <svg class="w-12 h-12 transition-transform group-active:scale-90" viewBox="0 0 48 48">
                            <circle cx="24" cy="24" r="23" stroke="#1A3B1B" stroke-width="2" fill="none"
                                class="transition-all duration-300 group-hover:fill-[#1A3B1B] group-hover:stroke-[#1A3B1B]" />
                            <path d="M14 24L34 24M34 24L28 18M34 24L28 30" stroke="#1A3B1B" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="transition-all duration-300 group-hover:stroke-white" />
                        </svg>
                    </button>
                </div>

            </div>

            <div class="w-full min-w-0 lg:flex-1 relative z-10">
                <div class="swiper imageSwiper w-full h-[500px] md:h-[480px] !overflow-visible"
                    style="clip-path: inset(0 -100% 0 0);">
                    <div class="swiper-wrapper">
                        <?php foreach ($industries as $industry): ?>
                            <div
                                class="swiper-slide industry-image-slide rounded-[4px] overflow-hidden relative group cursor-grab active:cursor-grabbing !w-[85vw] !h-[500px] shrink-0 !opacity-100 transition-[width,opacity,filter] duration-300 ease-out lg:!w-[270px] lg:!h-[480px] lg:!opacity-30 lg:[&.is-expanded]:!w-[426px] lg:[&.is-expanded]:!opacity-100 lg:[&.is-expanded]:z-10">
                                <img decoding="async"
                                    src="<?php echo SITE_URL; ?>/assets/uploads/main-category/<?php echo str_replace(['.png', '.jpg', '.jpeg'], '.webp', $industry['mcat_image']); ?>"
                                    class="w-full !h-[214px] md:!h-[480px] object-cover transform transition-transform duration-300 ease-out"
                                    alt="<?php echo $industry['mcat_name']; ?>" loading="lazy">
                                <div class="lg:hidden h-[286px] p-4 !flex flex-col gap-4 bg-[#F5F5F5]">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <h2 class="text-main-green font-base font-normal text-[18px] leading-[140%]">
                                                <?php echo $industry['mcat_name']; ?>
                                            </h2>
                                            <p
                                                class="text-[#575757] font-base font-normal text-[12px] leading-[150%] tracking-[0.015em] line-clamp-3">
                                                <?php echo $industry['mcat_desc']; ?>
                                            </p>
                                        </div>
                                        <p
                                            class="text-[#575757] font-base font-normal text-[14px] leading-[150%] tracking-[0.015em] empty:hidden min-h-[125px]">
                                            <?php echo clean_content($industry['meta_description']); ?>
                                        </p>
                                        <div
                                            class="flex items-center justify-between gap-4 swiper-no-swiping relative z-50 mt-auto">
                                            <a href="<?php echo SITE_URL; ?>/product-finder/industry-categories/<?php echo $industry['slug']; ?>"
                                                class="inline-block bg-main-green text-white px-10 py-3 rounded-full hover:bg-black transition-all w-[150px] text-[16px] leading-[150%] tracking-[0.015em] text-center">
                                                View
                                            </a>
                                            <div class="flex gap-2">
                                                <button
                                                    class="nav-prev nav-btn w-12 h-12 flex items-center justify-center cursor-pointer group"
                                                    aria-label="Previous Slide">
                                                    <svg class="w-12 h-12 transition-transform group-active:scale-90"
                                                        viewBox="0 0 48 48">
                                                        <circle cx="24" cy="24" r="23" stroke="#1A3B1B" stroke-width="2"
                                                            fill="none" />
                                                        <path d="M34 24L14 24M14 24L20 18M14 24L20 30" stroke="#1A3B1B"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </button>
                                                <button
                                                    class="nav-next nav-btn w-12 h-12 flex items-center justify-center cursor-pointer group"
                                                    aria-label="Next Slide">
                                                    <svg class="w-12 h-12 transition-transform group-active:scale-90"
                                                        viewBox="0 0 48 48">
                                                        <circle cx="24" cy="24" r="23" stroke="#1A3B1B" stroke-width="2"
                                                            fill="none" />
                                                        <path d="M14 24L34 24M34 24L28 18M34 24L28 30" stroke="#1A3B1B"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- Products engineered for performance -->
<section class="bg-b10">
    <div class="container relative py-6">
        <div class="py-3.5">
            <span
                class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                Our Product range
            </span>
            <div class="border-b-2 border-primary pb-1 flex md:items-center items-end justify-between">
                <h2
                    class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                    Products engineered for performance</h2>
                <a href="<?php echo SITE_URL; ?>/product-finder/product-categories"
                    class="text-[#1A3B1B] font-base font-normal text-[18px] leading-[140%] md:text-[24px] md:font-bold md:leading-[120%] md:tracking-[0.01em] shrink-0"
                    aria-label="See all product categories">See
                    all</a>
            </div>
        </div>
        <div class="mt-8 flex flex-col lg:flex-row items-stretch gap-0 w-full overflow-hidden">
            <?php foreach ($products as $product) { ?>
                <div onclick="this.classList.toggle('active')"
                    class="group relative flex-1 hover:flex-[1.4] [&.active]:flex-[1.4] transition-all duration-700 ease-in-out md:min-h-[480px] min-h-[300px] overflow-hidden flex flex-col cursor-pointer">

                    <div class="absolute inset-0 w-full h-full z-0 overflow-hidden">
                        <img decoding="async"
                            src="<?php echo SITE_URL; ?>/assets/uploads/main-category/<?php echo str_replace(['.png', '.jpg', '.jpeg'], '.webp', $product['mcat_image']); ?>"
                            alt="Product Image" class="w-full h-full object-cover object-center" loading="lazy">
                    </div>
                    <div class="relative z-10 flex flex-col items-stretch h-full text-white">
                        <div
                            class="absolute inset-0 bg-[linear-gradient(to_bottom_right,rgba(0,0,0,0.5),transparent_50%)] -translate-x-full group-hover:translate-x-0 [.active_&]:translate-x-0 transition-transform duration-500 ease-in-out z-0">
                        </div>
                        <div class="relative overflow-hidden border-b border-white transition-colors duration-500 h-[70px]">
                            <div
                                class="absolute inset-0 bg-primary -translate-x-full group-hover:translate-x-0 [.active_&]:translate-x-0 transition-transform duration-500 ease-in-out z-0">
                            </div>
                            <a
                                href="<?php echo SITE_URL; ?>/product-finder/product-categories/<?php echo $product['slug']; ?>">
                                <div class="relative z-10 flex items-center justify-between px-6 py-4">
                                    <p
                                        class="text-white group-hover:text-main-green [.active_&]:text-main-green font-normal text-base leading-[120%] tracking-[0.015em] transition-all duration-500 opacity-0 translate-x-[-10px] group-hover:opacity-100 [.active_&]:opacity-100 group-hover:translate-x-0 [.active_&]:translate-x-0">
                                        <?php echo $product['mcat_desc']; ?>
                                    </p>

                                    <button aria-label="View <?php echo htmlspecialchars($product['mcat_name']); ?> details"
                                        class="transition-all duration-500 transform group-hover:-rotate-45 [.active_&]:-rotate-45">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none">
                                            <path d="M14 5L21 12M21 12L14 19M21 12L3 12" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="text-white group-hover:text-main-green [.active_&]:text-main-green transition-colors duration-500" />
                                        </svg>
                                    </button>
                                    </svg>
                                </div>
                            </a>
                        </div>

                        <div class="relative overflow-hidden w-full h-full">
                            <h6
                                class="relative z-10 px-6 py-4 font-light text-lg md:text-[20px] leading-[150%] tracking-[0.01em] group-hover:text-primary [.active_&]:text-primary transition-colors duration-500 max-w-[250px]">
                                <?php echo $product['mcat_name']; ?>
                            </h6>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- Pushing the boundaries of your performance -->
<section class="bg-white relative overflow-hidden">
    <div class="container relative z-10 md:pt-7 pt-8">
        <div class="reveal-up py-3.5">
            <p
                class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                the mosil edge
            </p>
            <div class="border-b-2 border-primary pb-1">
                <h2
                    class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                    Pushing the boundaries of your performance
                </h2>
            </div>
        </div>

        <div class="md:mt-8 mt-6 flex flex-col lg:flex-row">
            <div class="w-full lg:w-[820px] swiper edgeSwiper relative overflow-hidden">
                <div class="swiper-wrapper relative">
                    <?php
                    foreach ($caseStudies as $study) { ?>
                        <div class="swiper-slide w-full relative md:min-h-[506px] min-h-[360px] group overflow-hidden">
                            <a href="<?php echo SITE_URL; ?>/case-studies/<?php echo $study['slug']; ?>" class="block">
                                <img decoding="async"
                                    src="<?php echo SITE_URL; ?>/assets/uploads/case_studies/<?php echo $study['image']; ?>"
                                    alt="Case Study Image"
                                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-120"
                                    loading="lazy">
                                <!-- <div
                                class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent w-full h-full">
                            </div> -->
                                <div class="absolute inset-0 flex flex-col justify-end text-white pb-22">
                                    <div class="md:p-8 p-4">
                                        <h3
                                            class="md:text-[20px] text-[16px] font-normal leading-[140%] tracking-[0.01em] md:mb-3.5 mb-2">
                                            <?php echo $study['title']; ?>
                                        </h3>
                                        <p
                                            class="md:text-[14px] text-[12px] font-normal leading-[150%] tracking-[0.015em] text-white/90 line-clamp-4 max-w-xl">
                                            <?php echo cleanText($study['solution']); ?>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="absolute bottom-0 left-0 w-full z-20 flex flex-col">
                    <div class="swiper-pagination-custom relative md:p-8 p-4 flex">
                        <div class="swiper-pagination !inset-auto !relative !w-auto flex"></div>
                    </div>
                    <a href="<?php echo SITE_URL; ?>/case-studies"
                        class="text-white text-[#FFFFFF] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em] md:text-[18px] md:leading-[140%] md:tracking-normal border-t-2 border-white block w-full text-center py-4 cursor-pointer">
                        See all case studies
                    </a>
                </div>
            </div>

            <div
                class="animate-slide-right w-full lg:w-[460px] bg-main-green text-white md:px-7 px-5 md:py-10 py-4 relative overflow-hidden">
                <img decoding="async" src="<?php echo SITE_URL; ?>/assets/images/ui/mosil-adv-bg.png"
                    class="absolute inset-0 w-full h-full object-cover pointer-events-none" alt="Background pattern"
                    loading="lazy" />

                <div class="relative z-10">
                    <h2
                        class="font-light text-lg md:text-[40px] leading-[120%] capitalize mb-2 md:mb-5 whitespace-nowrap">
                        MOSIL's Advantages
                    </h2>

                    <div class="grid grid-cols-2 gap-2 md:gap-6 text-cursor-hover-effect">
                        <?php
                        $stats = [
                            ['num' => 50, 'label' => 'Years of expertise in the industry'],
                            ['num' => 60, 'label' => 'Strong channel partners network'],
                            ['num' => 2, 'label' => 'Smart manufacturing plants'],
                            ['num' => 2, 'label' => 'In-house R&D and performance testing facility'],
                            ['num' => 5, 'label' => 'Global continents covered'],
                            ['num' => 200, 'label' => 'Application solutions']
                        ];
                        foreach ($stats as $stat) { ?>
                            <div>
                                <h3
                                    class="text-4xl md:text-[54px] font-normal text-[54px] leading-[120%] tracking-[0.01em] text-primary mb-2">
                                    <span class="counter" data-target="<?php echo $stat['num']; ?>">0</span>+
                                </h3>
                                <p class="text-b20 font-light md:text-[14px] text-[12px] leading-[150%] md:pr-0 pr-5">
                                    <?php echo $stat['label']; ?>
                                </p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Infrastructure that powers precision -->
<section class="bg-white relative overflow-hidden">
    <div class="container relative z-10 md:py-20 py-6">
        <div class="py-3.5">
            <p
                class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                Our Infrastructure
            </p>
            <div class="border-b-2 border-primary pb-1">
                <h2
                    class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                    Infrastructure that powers precision
                </h2>
            </div>
        </div>

        <div class="md:mt-8 mt-6 grid grid-cols-1 lg:grid-cols-2 md:gap-8 gap-5">
            <div class="flex flex-col bg-[#F5F5F5] overflow-hidden">
                <div class="h-[153px] md:h-[256px] w-full overflow-hidden">
                    <img decoding="async" src="<?php echo SITE_URL; ?>/assets/images/ui/manufacturing-plant.png"
                        alt="Manufacturing Plant" class="w-full h-full object-cover transition-transform duration-700"
                        loading="lazy">
                </div>
                <div
                    class="md:px-4.5 px-2.5 md:py-6 py-4 border-l-4 border-transparent transition-all duration-300 flex-1">
                    <h3
                        class="font-bold md:text-[18px] text-[16px] leading-[140%] tracking-[0.015em] capitalize text-main-green md:mb-2 mb-1">
                        Manufacturing Plant
                    </h3>
                    <p class="font-normal text-[14px]  leading-[150%] tracking-[0.015em] text-[#575757]">
                        At MOSIL, every solution is backed by strong infrastructure designed for consistency and scale.
                        Our three advanced manufacturing units two in Navi Mumbai and one in Palghar provides flexible
                        production lines and integrated quality control systems.
                    </p>
                </div>
            </div>

            <div class="flex flex-col md:gap-6 gap-5">
                <div class="flex flex-col sm:flex-row bg-[#F5F5F5] overflow-hidden min-h-[192px]">
                    <div class="w-full sm:w-2/5 shrink-0 overflow-hidden h-[153px] md:h-[193px]">
                        <img decoding="async" src="<?php echo SITE_URL; ?>/assets/images/ui/warehouse.png"
                            alt="Warehouse" class="w-full h-full object-cover transition-transform duration-700"
                            loading="lazy">
                    </div>
                    <div
                        class="p-6 flex flex-col justify-center border-l-0 sm:border-l-4 border-transparent transition-all duration-300">
                        <h3
                            class="font-bold md:text-[18px] text-[16px] leading-[140%] tracking-[0.015em] capitalize text-main-green md:mb-2 mb-1">
                            Warehouse
                        </h3>
                        <p class="font-normal text-[14px] leading-[150%] tracking-[0.015em] text-[#575757]">
                            MOSIL warehouse ensures seamless inventory management with precision tracking and real-time
                            optimization.Efficiently stocked and strategically organized, we deliver lubricants and
                            greases right when you need them with reliability.
                        </p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row bg-[#F5F5F5] overflow-hidden min-h-[192px]">
                    <div class="w-full sm:w-2/5 shrink-0 overflow-hidden h-[153px] md:h-[193px]">
                        <img decoding="async" src="<?php echo SITE_URL; ?>/assets/images/ui/resreach-development.png"
                            alt="R&D Lab" class="w-full h-full object-cover transition-transform duration-700"
                            loading="lazy">
                    </div>
                    <div
                        class="p-6 flex flex-col justify-center border-l-0 sm:border-l-4 border-transparent transition-all duration-300">
                        <h3
                            class="font-bold text-[18px] leading-[140%] tracking-[0.015em] capitalize text-main-green mb-2">
                            Research & Development & QA Lab
                        </h3>
                        <p class="font-normal text-[14px] leading-[150%] tracking-[0.015em] text-[#575757]">
                            At MOSIL, R&D is the engine driving every innovation we deliver. Leveraging our operating
                            intelligence & advanced scientific methods, state-of-the-art facilities, we develop products
                            that consistently performs.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Four angles of every lubrication decision -->
<?php
$lubricationItems = [
    [
        "title" => "Identify Painpoints",
        "desc" => "Understand deeply unique challenges",
        "image" => "/assets/images/ui/IdentifyPainpoints.webp"
    ],
    [
        "title" => "Expectation Mapping",
        "desc" => "Actively validate not assume",
        "image" => "/assets/images/ui/ExpectationMapping.webp"
    ],
    [
        "title" => "TriboIntel",
        "desc" => "Tribology based performance documentation",
        "image" => "/assets/images/ui/TriboIntel.webp"
    ],
    [
        "title" => "Delivering Success",
        "desc" => "We don’t sell. We solve",
        "image" => "/assets/images/ui/DeliveringSuccess.webp"
    ]
];
?>

<section class="bg-primary relative">
    <div class="absolute bottom-0 left-0">
        <img decoding="async" src="<?php echo SITE_URL; ?>/assets/images/ui/bg_lubi_drop_left_light.webp"
            alt="lubrication decision" class="block h-full w-full object-cover object-center" loading="lazy">
    </div>
    <div class="container relative z-10 md:pt-10.5 md:pb-13 pt-6 pb-6">


        <div class="py-3.5">
            <p
                class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                How we help
            </p>
            <div class="border-b-2 border-white pb-1">
                <h2
                    class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                    Four angles of every lubrication decision
                </h2>
            </div>
        </div>
        <p class="md:pr-28 pr-0 font-normal text-lg leading-[140%] tracking-normal text-[#575757] hidden md:block">
            Quadra
            Thinking is
            MOSIL’s way of solving
            every lubrication challenge by looking at performance,
            application, environment, and customer reality together</p>
        <div class="md:mt-8 mt-6 grid grid-cols-2 lg:grid-cols-4 md:gap-10 gap-4">
            <?php foreach ($lubricationItems as $index => $item) { ?>
                <div onclick="this.classList.toggle('active')"
                    class="group bg-y100 h-[208px] px-3 pt-2 md:pb-6 pb-3 relative flex flex-col justify-between overflow-hidden transition-all duration-300 ease-out hover:-translate-y-2 [&.active]:-translate-y-2 cursor-pointer">
                    <div class="w-[72px] h-[72px] ml-auto relative z-10">
                        <img decoding="async" src="<?php echo SITE_URL; ?><?php echo $item['image']; ?>"
                            alt="<?php echo $item['title']; ?>" class="block h-full w-full object-cover object-center"
                            loading="lazy">
                    </div>

                    <div class="relative z-10">
                        <h6
                            class="font-normal md:text-2xl text-lg leading-[135%] tracking-[0.015em] capitalize text-main-green mb-1">
                            <?php echo $item['title']; ?>
                        </h6>
                        <p class="font-normal text-xm md:text-xs leading-[150%] tracking-[0.015em] text-[#1A3B1B]">
                            <?php echo $item['desc']; ?>
                        </p>
                    </div>

                    <div
                        class="absolute bottom-0 left-0 h-1 w-0 bg-main-green transition-all duration-300 group-hover:w-full [.active_&]:w-full">
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
    <div class="absolute top-0 right-0 h-full">
        <img decoding="async" src="<?php echo SITE_URL; ?>/assets/images/ui/bg_lubi_drop_right_light.webp"
            alt="lubrication decision" class="block h-full w-full object-cover object-center" loading="lazy">
    </div>
</section>


<!-- MOSIL newsroom -->
<section>
    <div class="container md:py-20 py-6">
        <span
            class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
            In the Spotlight
        </span>
        <div class="mb-3.5 border-b-2 border-primary pb-1 flex items-center justify-between">
            <h2
                class="text-main-green font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize">
                MOSIL Newsroom</h2>
            <a href="<?php echo SITE_URL; ?>/newsroom"
                class="text-[#1A3B1B] font-base font-normal text-[18px] leading-[140%] md:text-[24px] md:font-bold md:leading-[120%] md:tracking-[0.01em] shrink-0"
                aria-label="See all MOSIL newsroom articles">See
                all</a>
        </div>

        <div class="md:mt-8 mt-6 swiper newsSwiper">
            <div class="swiper-wrapper md:!grid md:grid-cols-3 md:gap-8">
                <?php foreach ($blogs as $blog) { ?>

                    <div class="swiper-slide !grid !grid-rows-[auto_1fr_auto] group">

                        <div class="relative h-[240px] w-full rounded-[4px] overflow-hidden shrink-0">
                            <img decoding="async"
                                src="<?php echo SITE_URL; ?>/assets/uploads/blog/<?php echo str_replace(['.png', '.jpg', '.jpeg'], '.webp', $blog['image']); ?>"
                                alt="Hero Image"
                                class="block h-full w-full object-center rounded-[4px] group-hover:scale-120 transition-transform duration-500"
                                loading="lazy">

                            <div
                                class="absolute bottom-2 left-2 px-2 py-1 bg-primary text-main-green font-bold text-[10px] leading-[135%] tracking-[0.01em]">
                                <h2><?php echo $blog['category_name'] === "Discover" ? "Blog" : $blog['category_name']; ?>
                                </h2>
                            </div>
                        </div>

                        <div class="my-4 flex flex-col flex-1">
                            <h2
                                class="font-bold text-lg leading-[140%] tracking-[0.015em] capitalize text-[#3B3B3B] mb-3 line-clamp-2">
                                <?php echo $blog['title']; ?>
                            </h2>
                            <p
                                class="font-normal text-[16px] leading-[150%] tracking-[0.015em] text-[#757575] mb-2 line-clamp-3">
                                <?php
                                $content = trim(preg_replace('/\s+/', ' ', strip_tags($blog['content'])));
                                echo substr($content, 0, 500);
                                ?>
                            </p>
                            <p class="font-normal text-[14px] leading-[150%] tracking-[0.015em] text-[#A3A3A3] mt-auto">
                                <?php echo $blog['category_name']; ?> |
                                <?php echo formatDateWithCurrentYear($blog['created_at'], 'F d'); ?>
                            </p>
                        </div>
                        <a href="<?php echo SITE_URL; ?>/blog/<?= $blog["slug"] ?? '' ?>"
                            class="group/btn relative font-bold text-[18px] text-[#415C42] pb-2 inline-block w-fit capitalize hover:text-main-green">
                            Read <?php echo $blog['category_name'] === "Discover" ? "Blog" : $blog['category_name']; ?>
                            <span
                                class="absolute bottom-0 left-0 w-full h-[2px] bg-primary transform scale-x-100 md:scale-x-0 md:group-hover/btn:scale-x-100 transition-transform duration-300 origin-left"></span>
                        </a>

                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="flex items-center gap-4 relative z-10 justify-end pt-4">
            <button class="news-prev group cursor-pointer" aria-label="Previous News Slide">
                <svg class="w-12 h-12 transition-transform group-active:scale-90" viewBox="0 0 48 48">
                    <circle cx="24" cy="24" r="23" stroke="#1A3B1B" stroke-width="2" fill="none" />
                    <path d="M34 24L14 24M14 24L20 18M14 24L20 30" stroke="#1A3B1B" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <button class="news-next group cursor-pointer" aria-label="Next News Slide">
                <svg class="w-12 h-12 transition-transform group-active:scale-90" viewBox="0 0 48 48">
                    <circle cx="24" cy="24" r="23" stroke="#1A3B1B" stroke-width="2" fill="none" />
                    <path d="M14 24L34 24M34 24L28 18M34 24L28 30" stroke="#1A3B1B" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>

    </div>
</section>

<!-- Mobilise your profit with MOSIL -->
<section class="bg-[#F5F5F5]">
    <div class="container md:py-10 py-6">

        <div class="py-3.5">
            <div class="border-b-2 border-primary pb-1 ">
                <h2
                    class="text-main-green font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize">
                    Mobilise your profit
                    with MOSIL</h2>

            </div>
        </div>

        <div class="md:mt-8 mt-6 swiper logoSwiper">
            <div class="swiper-wrapper flex items-center" style="transition-timing-function: linear !important;">
                <?php
                $brands = [
                    'Bonfiglioli.png',
                    'Daikin.png',
                    'Daimler Truck Asia.png',
                    'Epiroc.png',
                    'Funskool.png',
                    "Haldiram's.png",
                    'Hyundai.png',
                    'ITC Limites.png',
                    'Jindal Stainless.png',
                    'Sail.png',
                    'Suzuki.png',
                    'Tata Steel.png',
                ];

                foreach ($brands as $brand) { ?>
                    <div class="swiper-slide !w-auto">
                        <div
                            class="w-[112px] h-[56px] md:w-[264.33px] md:h-[107.86px] aspect-[264.33/107.86] flex-shrink-0 bg-white p-2 flex items-center justify-center overflow-hidden">
                            <img decoding="async" src="<?php echo SITE_URL; ?>/assets/images/brand/<?php echo str_replace(['.png', '.jpg', '.jpeg'], '.webp', $brand); ?>"
                                alt="Brand Logo" class="max-h-full max-w-full object-contain" loading="lazy">
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

</section>
<section>
    <div class="container md:mt-20 mt-10">
        <div class="py-3.5">
            <span
                class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                on the world map
            </span>
            <div class="border-b-2 border-primary pb-1">
                <h2
                    class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                    Global presence
                </h2>
            </div>
        </div>
    </div>
    <div
        class="bg-primary relative overflow-hidden md:min-h-[800.077px] min-h-[240px] flex items-center md:mt-5 mt-4 container md:mb-20 mb-10">
        <div class="w-full h-full flex justify-center items-center" id="world-map-container">
            <!-- Map will be loaded asynchronously to keep HTML size small but allow zooming -->
            <style>
                #world-map-svg g[filter] {
                    cursor: pointer;
                    /* No opacity change on hover as requested */
                }
            </style>
            <script>
                (function () {
                    function initMap() {
                        const svg = document.getElementById('world-map-svg');
                        if (!svg) {
                            return; // Should be loaded via fetch first
                        }

                        // Optimization for touch devices
                        svg.style.touchAction = 'manipulation';

                        // Make SVG responsive by removing fixed dimensions and relying on viewBox + CSS
                        svg.removeAttribute('width');
                        svg.removeAttribute('height');
                        svg.style.width = '100%';
                        svg.style.height = 'auto';
                        svg.style.maxHeight = '100%';

                        const markers = svg.querySelectorAll('g[filter]');
                        if (markers.length === 0) return;

                        // Store original viewBox
                        let initialViewBox = svg.getAttribute('viewBox');
                        if (!initialViewBox) {
                            initialViewBox = "0 0 1440 862";
                            svg.setAttribute('viewBox', initialViewBox);
                        }
                        const initialVBValues = initialViewBox.split(' ').map(parseFloat);

                        // State
                        let isZoomed = false;
                        let currentAnimation = null;

                        // Helper to add robust click/touch listeners
                        function addInteractionListener(element, handler) {
                            // We use 'click' which is generally universally supported now, 
                            // but ensuring it works on mobile sometimes 'touchend' is more responsive.
                            // However, mixing them can cause ghost clicks. 
                            // Standard practice: just use click, but ensure the element has pointer cursor
                            // and is clickable. if issues persist, we handle touchend specifically.

                            // For this specific request, the user says click/tap isn't triggering. 
                            // We will listen to 'click' but also 'touchend' carefully.

                            let handled = false;
                            const wrappedHandler = (e) => {
                                if (e.type === 'touchend') handled = true;
                                if (e.type === 'click' && handled) return; // Prevent double fire from ghost click

                                handler(e);
                            };

                            element.addEventListener('click', wrappedHandler);
                            element.addEventListener('touchend', wrappedHandler);
                        }

                        // Events
                        markers.forEach(marker => {
                            addInteractionListener(marker, (e) => {
                                e.preventDefault();
                                e.stopPropagation();
                                zoomToMarker(marker);
                            });
                        });

                        addInteractionListener(svg, (e) => {
                            if (isZoomed) {
                                // If the user taps the background, reset
                                animateViewBox(initialVBValues, 800);
                                isZoomed = false;
                            }
                        });


                        function zoomToMarker(el) {
                            const bbox = el.getBBox();

                            // High-quality zoom settings
                            const zoomLevel = 0.25;
                            const targetWidth = initialVBValues[2] * zoomLevel;
                            const aspectRatio = initialVBValues[2] / initialVBValues[3];
                            const targetHeight = targetWidth / aspectRatio;

                            // Center calculation
                            const cx = bbox.x + bbox.width / 2;
                            const cy = bbox.y + bbox.height / 2;

                            let x = cx - targetWidth / 2;
                            let y = cy - targetHeight / 2;

                            // Boundary clamping
                            if (x < initialVBValues[0]) x = initialVBValues[0];
                            if (y < initialVBValues[1]) y = initialVBValues[1];
                            if (x + targetWidth > initialVBValues[0] + initialVBValues[2]) x = initialVBValues[0] + initialVBValues[2] - targetWidth;
                            if (y + targetHeight > initialVBValues[1] + initialVBValues[3]) y = initialVBValues[1] + initialVBValues[3] - targetHeight;

                            animateViewBox([x, y, targetWidth, targetHeight], 1000);
                            isZoomed = true;
                        }

                        function animateViewBox(targetValues, duration) {
                            if (currentAnimation) cancelAnimationFrame(currentAnimation);

                            const currentVB = svg.getAttribute('viewBox').split(' ').map(parseFloat);
                            const startTime = performance.now();

                            function step(currentTime) {
                                const elapsed = currentTime - startTime;
                                const progress = Math.min(elapsed / duration, 1);

                                // EaseInOutCubic
                                const ease = progress < 0.5
                                    ? 4 * progress * progress * progress
                                    : 1 - Math.pow(-2 * progress + 2, 3) / 2;

                                const nextValues = currentVB.map((start, i) => {
                                    return start + (targetValues[i] - start) * ease;
                                });

                                svg.setAttribute('viewBox', nextValues.join(' '));

                                if (progress < 1) {
                                    currentAnimation = requestAnimationFrame(step);
                                } else {
                                    currentAnimation = null;
                                }
                            }
                            currentAnimation = requestAnimationFrame(step);
                        }
                    }

                    function loadMap() {
                        fetch('<?php echo SITE_URL; ?>/assets/images/ui/world-map.svg')
                            .then(response => response.text())
                            .then(svgText => {
                                const container = document.getElementById('world-map-container');
                                if (container) {
                                    container.innerHTML = svgText;
                                    initMap();
                                }
                            })
                            .catch(error => console.error('Error loading map:', error));
                    }

                    // Load map when it comes into view or after initial page load
                    if (window.IntersectionObserver) {
                        const observer = new IntersectionObserver((entries) => {
                            if (entries[0].isIntersecting) {
                                loadMap();
                                observer.disconnect();
                            }
                        });
                        observer.observe(document.getElementById('world-map-container'));
                    } else {
                        if (document.readyState === 'loading') {
                            document.addEventListener('DOMContentLoaded', loadMap);
                        } else {
                            loadMap();
                        }
                    }
                })();
            </script>

        </div>
</section>

<!-- SEO & Knowledge Section -->
<section class="bg-white">
    <div class="container md:pb-20 pb-10">
        <!-- Conversational Heading -->
        <div class="py-3.5 mb-8">
            <span class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                Knowledge & Resources
            </span>
            <div class="border-b-2 border-primary pb-1">
                <h2 class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                    How we help you solve lubrication challenges
                </h2>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 text-[#666666] text-[16px] leading-[150%]">
            
            <!-- Direct Answer / List Section -->
            <div>
                <h3 class="text-[#1A3B1B] text-[20px] font-bold mb-4">What is MOSIL Lubricants?</h3>
                <p class="mb-4"><strong>MOSIL Lubricants Pvt. Ltd.</strong> is a specialty industrial lubricant manufacturer focused on reducing friction and improving efficiency. We offer a comprehensive range of solutions including:</p>
                <ul class="list-disc pl-5 mb-6 space-y-2">
                    <li>Synthetic &amp; Specialty Greases</li>
                    <li>Performance Industrial Oils</li>
                    <li>Anti-Friction Coatings (AFC)</li>
                    <li>MRO (Maintenance, Repair, and Operations) Aerosols</li>
                </ul>

                <h3 class="text-[#1A3B1B] text-[20px] font-bold mb-4">How to choose the right lubricant?</h3>
                <ol class="list-decimal pl-5 mb-6 space-y-2">
                    <li><strong>Identify the application:</strong> Determine if you need a grease, oil, or coating based on the component.</li>
                    <li><strong>Check operating conditions:</strong> Evaluate temperature, load, speed, and environment.</li>
                    <li><strong>Consult our Product Finder:</strong> Use our advanced search tool to filter by industry or product category.</li>
                    <li><strong>Contact our experts:</strong> Reach out for custom formulation requirements.</li>
                </ol>
            </div>

            <!-- Table Section -->
            <div>
                <h3 class="text-[#1A3B1B] text-[20px] font-bold mb-4">MOSIL vs Conventional Lubricants</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse border border-[#E5E5E5]">
                        <thead>
                            <tr class="bg-[#F5F5F5] text-[#1A3B1B]">
                                <th class="border border-[#E5E5E5] px-4 py-3 font-semibold">Feature</th>
                                <th class="border border-[#E5E5E5] px-4 py-3 font-semibold">MOSIL Specialty Lubricants</th>
                                <th class="border border-[#E5E5E5] px-4 py-3 font-semibold">Conventional Lubricants</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border border-[#E5E5E5] px-4 py-3">Operating Temperatures</td>
                                <td class="border border-[#E5E5E5] px-4 py-3">Extreme High/Low (-70°C to +1000°C)</td>
                                <td class="border border-[#E5E5E5] px-4 py-3">Standard (-20°C to +120°C)</td>
                            </tr>
                            <tr class="bg-[#FAFAFA]">
                                <td class="border border-[#E5E5E5] px-4 py-3">Equipment Lifespan</td>
                                <td class="border border-[#E5E5E5] px-4 py-3">Significantly Extended</td>
                                <td class="border border-[#E5E5E5] px-4 py-3">Average</td>
                            </tr>
                            <tr>
                                <td class="border border-[#E5E5E5] px-4 py-3">Maintenance Frequency</td>
                                <td class="border border-[#E5E5E5] px-4 py-3">Reduced downtime</td>
                                <td class="border border-[#E5E5E5] px-4 py-3">Frequent re-lubrication</td>
                            </tr>
                            <tr class="bg-[#FAFAFA]">
                                <td class="border border-[#E5E5E5] px-4 py-3">Application Focus</td>
                                <td class="border border-[#E5E5E5] px-4 py-3">Tailor-made for specific challenges</td>
                                <td class="border border-[#E5E5E5] px-4 py-3">General purpose</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- JSON-LD FAQ & HowTo Schemas -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [{
    "@type": "Question",
    "name": "What is MOSIL Lubricants?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "MOSIL Lubricants Pvt. Ltd. is a specialty industrial lubricant manufacturer focused on reducing friction and improving efficiency. We offer a comprehensive range of solutions including Synthetic & Specialty Greases, Performance Industrial Oils, Anti-Friction Coatings (AFC), and MRO Aerosols."
    }
  }, {
    "@type": "Question",
    "name": "How to choose the right lubricant?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "To choose the right lubricant: 1. Identify the application. 2. Check operating conditions (temperature, load, speed). 3. Consult our Product Finder. 4. Contact our experts for custom formulations."
    }
  }]
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "HowTo",
  "name": "How to choose the right industrial lubricant",
  "description": "A step-by-step guide to selecting the perfect specialty lubricant for your industrial application.",
  "step": [{
    "@type": "HowToStep",
    "name": "Identify the application",
    "text": "Determine if you need a grease, oil, or coating based on the component.",
    "url": "https://mosil.com/product-finder"
  },{
    "@type": "HowToStep",
    "name": "Check operating conditions",
    "text": "Evaluate temperature, load, speed, and environment.",
    "url": "https://mosil.com/product-finder"
  },{
    "@type": "HowToStep",
    "name": "Consult our Product Finder",
    "text": "Use our advanced search tool to filter by industry or product category.",
    "url": "https://mosil.com/product-finder"
  },{
    "@type": "HowToStep",
    "name": "Contact our experts",
    "text": "Reach out for custom formulation requirements.",
    "url": "https://mosil.com/contact"
  }]
}
</script>