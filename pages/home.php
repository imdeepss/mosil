<?php
$industries = getCategoryByParent("2");
$products = getCategoryByParent("3", "4");
$caseStudies = getCaseStudy("4");
$blogs = getBlogs(3);

?>
<!-- Hero Section -->
<section class="relative h-[720px] w-full overflow-hidden">
    <img src="<?php echo SITE_URL; ?>/assets/images/banners/home-banner.gif" alt="Hero Image"
        class="block h-full w-full object-cover object-center md:block hidden" fetchpriority="high">
    <img src="<?php echo SITE_URL; ?>/assets/images/banners/mb-home-banner.gif" alt="Hero Image"
        class="block h-full w-full object-cover object-center block md:hidden" fetchpriority="high">
</section>


<!-- Lubricant solutions for every industry -->
<section class="bg-white overflow-hidden">
    <div class="container relative md:py-20 py-12">
        <div class="py-3.5 reveal-up">
            <span class="text-b200 font-normal text-xs leading-[120%] tracking-[0.015em] uppercase">
                Industries we serve
            </span>
            <div class="border-b border-primary pb-1 flex items-center justify-between gap-13">
                <h2
                    class="text-main-green font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize">
                    Lubricant solutions for every industry
                </h2>
                <a href="<?php echo SITE_URL; ?>/product-finder/industry-categories/"
                    class="font-light md:font-bold text-lg md:text-2xl leading-[120%] tracking-[0.01em] text-main-green hover:text-primary transition-colors whitespace-nowrap">
                    See All
                </a>
            </div>
        </div>

        <div class="md:mt-8 mt-6 flex flex-col lg:flex-row items-stretch gap-5">
            <div
                class="hidden lg:flex w-full lg:w-[35%] py-16 px-8 flex-col gap-4 bg-[#F5F5F5] relative overflow-hidden z-20">
                <div class="absolute inset-0 opacity-50 pointer-events-none">
                    <img src="<?php echo SITE_URL; ?>/assets/images/ui/Vector.png" class="w-full h-full object-contain"
                        alt="" loading="lazy" />
                </div>

                <div class="relative z-10 flex flex-col gap-4">
                    <?php if (!empty($industries)):
                        $firstIndustry = $industries[0];
                        ?>
                        <div id="industry-content">
                            <h2
                                class="text-main-green font-base font-normal text-[28px] leading-[135%] capitalize industry-title">
                                <?php echo $firstIndustry['mcat_name']; ?>
                            </h2>
                            <p
                                class="text-[#575757] font-base font-normal text-[14px] leading-[150%] tracking-[0.015em] industry-tagline">
                                <?php echo $firstIndustry['mcat_desc']; ?>
                            </p>
                        </div>
                        <p class="text-[#777777] font-base font-normal text-[18px] leading-[140%] industry-desc">
                            <?php echo $firstIndustry['mcat_desc']; ?>
                        </p>

                        <a href="<?php echo SITE_URL; ?>/product-finder/industry-categories/<?php echo $firstIndustry['slug']; ?>"
                            class="industry-link inline-block bg-main-green text-white px-10 py-3 rounded-full font-base hover:bg-black transition-all w-fit">
                            View
                        </a>
                    <?php endif; ?>
                </div>

                <div class="flex gap-4 relative z-10">
                    <button class="swiper-prev group cursor-pointer">
                        <svg class="w-12 h-12 transition-transform group-active:scale-90" viewBox="0 0 48 48">
                            <circle cx="24" cy="24" r="23" stroke="#1A3B1B" stroke-width="2" fill="none" />
                            <path d="M34 24L14 24M14 24L20 18M14 24L20 30" stroke="#1A3B1B" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button class="swiper-next group cursor-pointer">
                        <svg class="w-12 h-12 transition-transform group-active:scale-90" viewBox="0 0 48 48">
                            <circle cx="24" cy="24" r="23" stroke="#1A3B1B" stroke-width="2" fill="none" />
                            <path d="M14 24L34 24M34 24L28 18M34 24L28 30" stroke="#1A3B1B" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="w-full lg:w-[65%] relative">
                <div class="swiper industrySwiper h-full">
                    <div class="swiper-wrapper">
                        <?php foreach ($industries as $industry) { ?>
                            <div class="swiper-slide h-auto bg-[#F5F5F5]" data-title="<?php echo $industry['mcat_name']; ?>"
                                data-tagline="<?php echo $industry['mcat_desc']; ?>"
                                data-desc="<?php echo $industry['mcat_desc']; ?>"
                                data-link="<?php echo SITE_URL; ?>/industry/<?php echo $industry['slug']; ?>">
                                <img src="<?php echo SITE_URL; ?>/assets/uploads/main-category/<?php echo $industry['mcat_image']; ?>"
                                    class="w-full h-[240px] md:h-[480px] object-cover"
                                    alt="<?php echo $industry['mcat_name']; ?>" loading="lazy">
                                <div class="lg:hidden p-6 flex flex-col gap-4">
                                    <div>
                                        <h2
                                            class="text-main-green font-base font-normal text-[28px] leading-[135%] capitalize">
                                            <?php echo $industry['mcat_name']; ?>
                                        </h2>
                                        <p
                                            class="text-[#575757] font-base font-normal text-[14px] leading-[150%] tracking-[0.015em]">
                                            <?php echo $industry['mcat_desc']; ?>
                                        </p>
                                    </div>
                                    <p class="text-[#777777] font-base font-normal text-[18px] leading-[140%]">
                                        <?php echo $industry['mcat_desc']; ?>
                                    </p>
                                    <a href="<?php echo SITE_URL; ?>/product-finder/industry-categories/<?php echo $industry['slug']; ?>"
                                        class="inline-block bg-main-green text-white px-10 py-3 rounded-full font-base hover:bg-black transition-all w-fit">
                                        View
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Products engineered for performance -->
<section class="bg-[var(--color-b10)]">
    <div class="container relative py-6">
        <div class="py-3.5">
            <span class="text-[var(--color-b200)] font-normal text-xs leading-[120%] tracking-[0.015em] uppercase">
                Our Product range
            </span>
            <div class="border-b border-primary pb-1 flex items-center justify-between">
                <h2
                    class="text-[var(--color-main-green)] font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize">
                    Products engineered for performance</h2>
                <a href="<?php echo SITE_URL; ?>/product-finder/product-categories"
                    class="font-light md:font-bold text-lg md:text-2xl leading-[120%] tracking-[0.01em] text-main-green hover:text-primary transition-colors whitespace-nowrap">See
                    All</a>
            </div>
        </div>
        <div class="mt-8 flex flex-col lg:flex-row items-stretch gap-0 w-full overflow-hidden">
            <?php foreach ($products as $product) { ?>
                <div
                    class="group relative flex-1 hover:flex-[1.5] transition-all duration-700 ease-in-out md:min-h-[480px] min-h-[300px] overflow-hidden flex flex-col justify-between bg-black cursor-pointer">

                    <div class="absolute inset-0 w-full h-full z-0">
                        <img src="<?php echo SITE_URL; ?>/assets/uploads/main-category/<?php echo $product['mcat_image']; ?>"
                            alt="Product Image" class="w-full h-full object-cover object-center" loading="lazy">
                        <div class="absolute inset-0 bg-black/40"></div>
                    </div>

                    <div class="relative z-10 flex flex-col items-stretch h-full text-white">

                        <div class="relative overflow-hidden border-b border-white transition-colors duration-500">
                            <div
                                class="absolute inset-0 bg-primary -translate-x-full group-hover:translate-x-0 transition-transform duration-500 ease-in-out z-0">
                            </div>

                            <div class="relative z-10 flex items-center justify-between px-6 py-4">
                                <p
                                    class="text-white group-hover:text-main-green font-normal text-base leading-[120%] tracking-[0.015em] transition-all duration-500 opacity-0 translate-x-[-10px] group-hover:opacity-100 group-hover:translate-x-0">
                                    <?php echo $product['mcat_desc']; ?>
                                </p>

                                <a href="<?php echo SITE_URL; ?>/product-finder/industry-categories/<?php echo $product['slug']; ?>"
                                    class="transition-all duration-500 transform group-hover:-rotate-45">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path d="M14 5L21 12M21 12L14 19M21 12L3 12" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="text-white group-hover:text-main-green transition-colors duration-500" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="p-6">
                            <h6
                                class="font-base font-light text-lg md:text-[20px] leading-[150%] tracking-[0.01em] group-hover:text-primary transition-colors duration-500 max-w-[250px]">
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
            <p class="text-b200 font-normal text-xs leading-[120%] tracking-[0.015em] uppercase mb-1">
                the mosil edge
            </p>
            <div class="border-b border-primary pb-1">
                <h2
                    class="text-main-green font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize">
                    Pushing the boundaries of your performance
                </h2>
            </div>
        </div>

        <div class="md:mt-8 mt-6 flex flex-col lg:flex-row items-stretch">
            <div class="w-full lg:w-2/3 swiper edgeSwiper relative overflow-hidden">
                <div class="swiper-wrapper relative">
                    <?php
                    foreach ($caseStudies as $study) { ?>
                        <div
                            class="swiper-slide animate-slide-left w-full relative md:min-h-[450px] min-h-[360px] group overflow-hidden">
                            <img src="<?php echo SITE_URL; ?>/assets/uploads/case_studies/<?php echo $study['image']; ?>"
                                alt="Case Study Image"
                                class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                loading="lazy">

                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent flex flex-col justify-end text-white pb-22">
                                <div class="md:p-8 p-4">
                                    <h3
                                        class="font-base md:text-[20px] text-[16px] font-normal leading-[140%] tracking-[0.01em] md:mb-3.5 mb-2">
                                        <?php echo $study['title']; ?>
                                    </h3>
                                    <p
                                        class="font-base md:text-[14px] text-[12px] font-normal leading-[150%] tracking-[0.015em] md:mb-3.5 mb-2 text-white/90">
                                        <?php echo $study['description']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="absolute bottom-0 left-0 w-full z-20 flex flex-col">
                    <div class="swiper-pagination-custom relative md:p-8 p-4 flex">
                        <div class="swiper-pagination inset-auto! relative! w-auto! flex gap-2"></div>
                    </div>
                    <a href="<?php echo SITE_URL; ?>/case-studies"
                        class="text-white font-normal md:text-[18px] text-[16px] uppercase whitespace-nowrap border-t-2 border-white block w-full text-center py-4 cursor-pointer">
                        See all
                    </a>
                </div>
            </div>

            <div
                class="animate-slide-right w-full lg:w-1/3 bg-main-green text-white md:px-7 px-5 md:py-10 py-4 relative overflow-hidden">
                <img src="<?php echo SITE_URL; ?>/assets/images/ui/mosil-adv-bg.png"
                    class="absolute inset-0 w-full h-full object-cover pointer-events-none" alt="Background pattern"
                    loading="lazy" />

                <div class="relative z-10">
                    <h2 class="font-light text-lg md:text-[40px] leading-[120%] capitalize mb-2 md:mb-10">MOSIL's
                        Advantages
                    </h2>

                    <div class="grid grid-cols-2 gap-2 md:gap-6">
                        <?php
                        $stats = [
                            ['num' => 50, 'label' => 'Years of expertise in the industry'],
                            ['num' => 60, 'label' => 'Strong channel partners network'],
                            ['num' => 2, 'label' => 'Smart manufacturing plants'],
                            ['num' => 2, 'label' => 'In-house R&D facility'],
                            ['num' => 5, 'label' => 'Global continents covered'],
                            ['num' => 200, 'label' => 'Application solutions']
                        ];
                        foreach ($stats as $stat) { ?>
                            <div>
                                <span class="text-4xl font-semibold text-primary">
                                    <span class="counter" data-target="<?php echo $stat['num']; ?>">0</span>+
                                </span>
                                <p class="text-b20 font-light md:text-[14px] text-[12px] leading-[150%] mt-2 md:pr-0 pr-5">
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
            <p class="text-b200 font-normal text-xs leading-[120%] tracking-[0.015em] uppercase mb-1">
                Our Infrastructure
            </p>
            <div class="border-b border-primary pb-1">
                <h2
                    class="text-main-green font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize">
                    Infrastructure that powers precision
                </h2>
            </div>
        </div>

        <div class="md:mt-8 mt-6 grid grid-cols-1 lg:grid-cols-2 md:gap-8 gap-5">
            <div
                class="group flex flex-col bg-[#F5F5F5] overflow-hidden opacity-0 animate-slide-left transition-all duration-500 hover:shadow-2xl">
                <div class="h-[153px] md:h-[256px] w-full overflow-hidden">
                    <img src="<?php echo SITE_URL; ?>/assets/images/ui/manufacturing-plant.png"
                        alt="Manufacturing Plant"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        loading="lazy">
                </div>
                <div
                    class="md:px-4.5 px-2.5 md:py-6 py-4 border-l-4 border-transparent transition-all duration-300 group-hover:border-main-green flex-1">
                    <h3
                        class="font-base font-bold md:text-[18px] text-[16px] leading-[140%] tracking-[0.015em] capitalize text-main-green md:mb-2 mb-1">
                        Manufacturing Plant
                    </h3>
                    <p class="font-base font-normal text-[14px]  leading-[150%] tracking-[0.015em] text-[#575757]">
                        At MOSIL, every solution is backed by strong infrastructure designed for consistency and
                        scale.
                        Our three advanced manufacturing units—two in Navi Mumbai and one in Palghar—provide
                        flexible
                        production lines and integrated quality control systems.
                    </p>
                </div>
            </div>

            <div class="flex flex-col md:gap-6 gap-5">
                <div
                    class="group flex flex-col sm:flex-row bg-[#F5F5F5] overflow-hidden min-h-[192px] opacity-0 animate-slide-right [animation-delay:200ms] hover:shadow-xl transition-all duration-300">
                    <div class="w-full sm:w-2/5 shrink-0 overflow-hidden h-[153px] md:h-[193px]">
                        <img src="<?php echo SITE_URL; ?>/assets/images/ui/warehouse.png" alt="Warehouse"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                            loading="lazy">
                    </div>
                    <div
                        class="p-6 flex flex-col justify-center border-l-0 sm:border-l-4 border-transparent transition-all duration-300 group-hover:border-primary">
                        <h3
                            class="font-base font-bold md:text-[18px] text-[16px] leading-[140%] tracking-[0.015em] capitalize text-main-green md:mb-2 mb-1">
                            Warehouse
                        </h3>
                        <p class="font-base font-normal text-[14px] leading-[150%] tracking-[0.015em] text-[#575757]">
                            With in-house NABL accredited tribology labs, pilot scale testing facilities, and an
                            expert
                            team of chemists and tribologists.
                        </p>
                    </div>
                </div>

                <div
                    class="group flex flex-col sm:flex-row bg-[#F5F5F5] overflow-hidden min-h-[192px] opacity-0 animate-slide-right [animation-delay:400ms] hover:shadow-xl transition-all duration-300">
                    <div class="w-full sm:w-2/5 shrink-0 overflow-hidden h-[153px] md:h-[193px]">
                        <img src="<?php echo SITE_URL; ?>/assets/images/ui/resreach-development.png" alt="R&D Lab"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                            loading="lazy">
                    </div>
                    <div
                        class="p-6 flex flex-col justify-center border-l-0 sm:border-l-4 border-transparent transition-all duration-300 group-hover:border-primary">
                        <h3
                            class="font-base font-bold text-[18px] leading-[140%] tracking-[0.015em] capitalize text-main-green mb-2">
                            Research & Development & QA Lab
                        </h3>
                        <p class="font-base font-normal text-[14px] leading-[150%] tracking-[0.015em] text-[#575757]">
                            At MOSIL, R&D is the engine driving every innovation we deliver through intelligence &
                            advanced methods.
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
        "image" => "/assets/images/ui/IdentifyPainpoints.png"
    ],
    [
        "title" => "Expectation Mapping",
        "desc" => "Actively validate not assume",
        "image" => "/assets/images/ui/ExpectationMapping.png"
    ],
    [
        "title" => "TriboIntel",
        "desc" => "Tribology based performance documentation",
        "image" => "/assets/images/ui/TriboIntel.png"
    ],
    [
        "title" => "Delivering Success",
        "desc" => "We don’t sell. We solve",
        "image" => "/assets/images/ui/DeliveringSuccess.png"
    ]
];
?>

<section class="bg-[var(--color-primary)] relative">
    <div class="absolute bottom-0 left-0">
        <img src="<?php echo SITE_URL; ?>/assets/images/ui/bg_lubi_drop_left_light.png" alt="lubrication decision"
            class="block h-full w-full object-cover object-center" loading="lazy">
    </div>
    <div class="container relative z-10 md:pt-10.5 md:pb-13 pt-6 pb-6">


        <div class="py-3.5">
            <p class="text-b200 font-normal text-xs leading-[120%] tracking-[0.015em] uppercase mb-1">
                How we help
            </p>
            <div class="md:border-b md:border-white pb-1">
                <h2
                    class="text-main-green font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize">
                    Four angles of every lubrication decision
                </h2>
            </div>
        </div>
        <p
            class="md:pr-28 pr-0 font-normal text-lg leading-[140%] tracking-normal text-[var(--color-b200)] hidden md:block">
            Quadra
            Thinking is
            MOSIL’s way of solving
            every lubrication challenge by looking at performance,
            application, environment, and customer reality together</p>
        <div class="md:mt-8 mt-6 grid grid-cols-2 lg:grid-cols-4 md:gap-10 gap-4">
            <?php foreach ($lubricationItems as $index => $item) { ?>
                <div
                    class="group bg-y100 h-[208px] px-3 pt-2 md:pb-6 pb-3 relative flex flex-col justify-between overflow-hidden transition-all duration-300 ease-out hover:shadow-xl hover:-translate-y-2">

                    <div
                        class="absolute inset-0 bg-white/20 translate-y-full transition-transform duration-500 group-hover:translate-y-0">
                    </div>

                    <div
                        class="w-[72px] h-[72px] ml-auto relative z-10 transition-transform duration-500 group-hover:scale-110 group-hover:rotate-3">
                        <img src="<?php echo SITE_URL; ?><?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>"
                            class="block h-full w-full object-cover object-center" loading="lazy">
                    </div>

                    <div class="relative z-10">
                        <h6
                            class="font-normal md:text-2xl text-lg leading-[135%] tracking-[0.015em] capitalize text-main-green mb-1 transition-colors duration-300 group-hover:text-black">
                            <?php echo $item['title']; ?>
                        </h6>
                        <p
                            class="font-base font-normal text-xm md:text-xs leading-[150%] tracking-[0.015em] text-main-green/80">
                            <?php echo $item['desc']; ?>
                        </p>
                    </div>

                    <div
                        class="absolute bottom-0 left-0 h-1 w-0 bg-main-green transition-all duration-300 group-hover:w-full">
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
    <div class="absolute top-0 right-0 h-full">
        <img src="<?php echo SITE_URL; ?>/assets/images/ui/bg_lubi_drop_right_light.png" alt="lubrication decision"
            class="block h-full w-full object-cover object-center" loading="lazy">
    </div>
</section>


<!-- MOSIL newsroom -->
<section>
    <div class="container md:py-20 py-6">
        <span class="text-[var(--color-b200)] font-normal text-xs leading-[120%] tracking-[0.015em] uppercase">
            In the Spotlight
        </span>
        <div class="mb-3.5 border-b border-primary pb-1 flex items-center justify-between">
            <h2
                class="text-[var(--color-main-green)] font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize">
                MOSIL Newsroom</h2>
            <a href="<?php echo SITE_URL; ?>/newsroom"
                class="font-light md:font-bold text-lg md:text-2xl leading-[120%] tracking-[0.01em] text-main-green hover:text-primary transition-colors whitespace-nowrap">See
                All</a>
        </div>

        <div class="md:mt-8 mt-6 swiper newsSwiper">
            <div class="swiper-wrapper md:!grid md:grid-cols-3 md:gap-8">
                <?php
                foreach ($blogs as $blog) { ?>

                    <div class="swiper-slide grid! grid-rows-[auto_1fr_auto]! group">
                        <div class="relative h-[240px] w-full rounded-[4px] overflow-hidden shrink-0">
                            <img src="<?php echo SITE_URL; ?>/assets/uploads/blog/<?php echo $blog['image']; ?>"
                                alt="Hero Image"
                                class="block h-full w-full object-center rounded-[4px] group-hover:scale-150 transition-transform duration-500"
                                loading="lazy">
                            <div
                                class="absolute bottom-2 left-2 px-2 py-1 bg-[var(--color-primary)] text-[var(--color-main-green)] font-bold text-[10px] leading-[135%] tracking-[0.01em]">
                                <h2><?php echo $blog['category_name']; ?></h2>
                            </div>
                        </div>
                        <div class="my-4 flex flex-col flex-1">
                            <h2
                                class="font-bold text-lg leading-[140%] tracking-[0.015em] capitalize text-[#3B3B3B] mb-3 line-clamp-2">
                                <?php echo $blog['title']; ?>
                            </h2>
                            <p
                                class="font-normal text-[16px] leading-[150%] tracking-[0.015em] text-[var(--color-b100)] mb-2 line-clamp-3">
                                <?php
                                $content = $blog['content'];

                                // Remove HTML tags
                                $content = strip_tags($content);

                                // Optional: clean extra spaces
                                $content = trim(preg_replace('/\s+/', ' ', $content));

                                // Limit characters to a reasonable amount if line-clamp isn't enough, 
                                // but line-clamp-3 handles the visuals.
                                echo substr($content, 0, 500);
                                ?>
                            </p>
                            <p
                                class="font-normal text-[14px] leading-[150%] tracking-[0.015em] text-[var(--color-b70)] mt-auto">
                                <?php echo $blog['category_name']; ?> |
                                <?php echo date('F d, Y', strtotime($blog['created_at'])); ?>
                            </p>
                        </div>
                        <a href="<?php echo SITE_URL; ?>/blog/<?= urlencode(
                               $blog["slug"]
                           ) ?>"
                            class="font-bold text-[18px] leading-[140%] tracking-[0.015em] capitalize text-[var(--color-main-green)] border-b-2 border-[var(--color-primary)] pb-2 inline-block w-fit">Read
                            <?php echo $blog['category_name']; ?></a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="flex items-center gap-4 relative z-10 justify-end pt-4">
            <button class="news-prev group cursor-pointer">
                <svg class="w-12 h-12 transition-transform group-active:scale-90" viewBox="0 0 48 48">
                    <circle cx="24" cy="24" r="23" stroke="#1A3B1B" stroke-width="2" fill="none" />
                    <path d="M34 24L14 24M14 24L20 18M14 24L20 30" stroke="#1A3B1B" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <button class="news-next group cursor-pointer">
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
            <div class="border-b border-primary pb-1 ">
                <h2
                    class="text-[var(--color-main-green)] font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize">
                    Mobilise your profit
                    with MOSIL</h2>

            </div>
        </div>

        <div class="md:mt-8 mt-6 swiper logoSwiper">
            <div class="swiper-wrapper flex items-center">
                <?php
                $brands = [];
                foreach (range('A', 'Z') as $letter) {
                    $brands[] = $letter . '.png';
                }
                foreach ($brands as $brand) { ?>
                    <div class="swiper-slide !w-auto">
                        <div
                            class="md:w-[276px] md:h-[132px] w-[112px] h-[56px] bg-white p-1 md:p-2 flex items-center justify-center">
                            <img src="<?php echo SITE_URL; ?>/assets/images/brand/<?php echo $brand; ?>" alt="Brand Logo"
                                class="max-h-full max-w-full object-contain" loading="lazy">
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

</section>