<?php
// pages/about.php
$pageTitle = 'About Us';

$mosil_matters = [
    [
        "title" => "Custom-engineered lubricants",
        "description" => "Custom-engineered lubricants  ensuring peak machine  performance and durability.",
        "image" => "matter-1.jpg"
    ],
    [
        "title" => "Backed by global certifications",
        "description" => "Globally certified with ISO 9001, 
14001, 45001 and NSF 
certifications",
        "image" => "matter-2.jpg"
    ],
    [
        "title" => "Data-driven quadra methodology",
        "description" => "Data-Driven Quadra approach 
with TriboIntel documentation,
 reduces ris",
        "image" => "matter-3.jpg"
    ],
    [
        "title" => "Sustainable formulations",
        "description" => " Biodegradable and ESG-focused formulations  aligned with OECD protocols",
        "image" => "matter-4.jpg"
    ],
    [
        "title" => "Innovation built on research",
        "description" => "R&D backed innovation  creates proven, custom  lubricant solutions",
        "image" => "matter-5.jpg"
    ],
    [
        "title" => "Strength built for the extreme",
        "description" => " Special synthetic lubricants  significantly enhance equipment life  in tough environments",
        "image" => "matter-6.jpg"
    ]
];
?>
<!-- Hero Section -->
<section class="relative w-full h-[748px] md:h-[480px] overflow-hidden">
    <div class="container relative z-20 flex items-end justify-start w-full h-full pb-4 md:pb-10">
        <h2
            class="text-white font-base font-normal text-[32px] md:text-[48px] leading-[120%] tracking-normal capitalize">
            What you run on decides how far you run
        </h2>
    </div>

    <!-- <div class="absolute inset-0 z-10 bg-gradient-to-tr from-black/60 via-black/20 to-transparent"></div> -->

    <div class="absolute inset-0 z-0 w-full h-full">
        <img src="<?php echo SITE_URL; ?>/assets/images/banners/about-us.png" alt="Career"
            class="hidden md:block w-full h-full object-cover object-[50%_75%]" fetchpriority="high">

        <img src="<?php echo SITE_URL; ?>/assets/images/banners/career_mb_v2.png" alt="Career"
            class="block md:hidden w-full h-full object-cover object-center" fetchpriority="high">
    </div>
</section>

<section>
    <div class="container">
        <nav
            class="flex items-center breadcrumbs gap-1 text-[14px] md:text-[16px] leading-[150%] tracking-[0.015em] capitalize flex-wrap py-6">
            <a href="<?php echo SITE_URL; ?>/" class="text-[#A3A3A3] font-light">Home</a>
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>
            <a href="<?php echo SITE_URL; ?>/about" class="text-[#575757] font-bold">About Us</a>
        </nav>
        <div class="py-3.5">
            <span class="text-b200 font-normal text-xs leading-[120%] tracking-[0.015em] uppercase">
                Overview
            </span>
            <div class="border-b border-primary pb-1">
                <h2
                    class="text-main-green font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize md:whitespace-nowrap">
                    We are MOSIL
                </h2>
            </div>
        </div>
        <div class="flex flex-col md:flex-row gap-10 items-stretch flex-col-reverse pt-4 md:pt-0">

            <div
                class="flex-1 bg-[#F5F5F5] md:px-[64px] pb-12 md:pb-0md:py-8 px-4 py-4 md:rounded-bl-[110px] rounded-bl-[80px] flex flex-col justify-center gap-6">
                <h2 class="text-[#1A3B1B] font-base font-normal md:text-[28px] text-[24px] leading-[135%] capitalize">
                    India’s leading specialty lubricant & grease manufacturer
                </h2>

                <div
                    class="text-[#757575] font-base font-normal md:text-[16px] text-[14px] leading-[150%] tracking-[0.015em] flex flex-col gap-4">
                    <p>
                        50 years ago, MOSIL was born from a simple idea: industrial reliability should not be
                        compromised by
                        lack of access to quality lubrication. What began as a mission to solve on-ground maintenance
                        problems has grown into a trusted partner to industries that demand precision, durability and
                        performance.
                    </p>
                    <p>
                        MOSIL Lubricants is a leading Indian manufacturer of specialty lubricants, greases, coatings,
                        and aerosols serving demanding industrial applications across sectors. Backed by decades of
                        tribology expertise and strong in-house R&D, MOSIL develops solutions designed to perform under
                        real operating stress.
                    </p>
                </div>
            </div>

            <div class="w-full md:w-[456px] shrink-0 overflow-hidden">
                <img src="<?php echo SITE_URL; ?>/assets/images/ui/lubricant-manufacturer.png"
                    alt="MOSIL Lubricant Manufacturer" class="w-full h-full object-cover rounded-lg shadow-sm">
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container md:py-20 py-12">
        <div class="py-3.5">
            <span class="text-b200 font-normal text-xs leading-[120%] tracking-[0.015em] uppercase">
                Our History
            </span>
            <div class="border-b border-primary pb-1">
                <h2
                    class="text-main-green font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize md:whitespace-nowrap">
                    The journey that shaped us
                </h2>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-10 pt-10">
            <?php
            $history_data = [
                [
                    "year" => "1971 - 1980",
                    "title" => "The beginning",
                    "points" => [
                        "First batch of moly and graphite based specialty greases manufactured",
                        "Introduced products for the textile industry",
                        "Introduced silicone greases in india"
                    ]
                ],
                [
                    "year" => "1981 - 1990",
                    "title" => "Expansion & Growth",
                    "points" => [
                        "Expanded manufacturing capacity to meeting growing demand",
                        "Launched first range of synthetic lubricants",
                        "Established pan-India distribution network"
                    ]
                ],
                [
                    "year" => "1991 - 2000",
                    "title" => "Global Horizons",
                    "points" => [
                        "Started exports to Southeast Asian markets",
                        "Received ISO 9001 certification for quality management",
                        "Setup dedicated R&D center for tribology"
                    ]
                ],
                [
                    "year" => "2001 - 2010",
                    "title" => "Innovation Era",
                    "points" => [
                        "Developed biodegradable lubricants for eco-sensitive zones",
                        "Patented new anti-friction coating technology",
                        "Partnered with major automotive OEMs"
                    ]
                ]
            ];
            ?>
            <div class="flex flex-col justify-center md:gap-3 gap-2 max-w-md order-2 md:order-1">
                <div class="swiper our-history-swiper w-full">
                    <div class="swiper-wrapper">
                        <?php foreach ($history_data as $history): ?>
                            <div class="swiper-slide cursor-grab active:cursor-grabbing">
                                <h2 class="text-[#1A3B1B] font-bold text-[64px] leading-[135%] tracking-[0.01em]">
                                    <?php echo $history['year']; ?>
                                </h2>

                                <div class="flex flex-col gap-4">
                                    <p
                                        class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize">
                                        <?php echo $history['title']; ?>
                                    </p>
                                    <ul
                                        class="list-disc list-inside flex flex-col gap-2 text-[#757575] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em]">
                                        <?php foreach ($history['points'] as $point): ?>
                                            <li><?php echo $point; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="flex items-center gap-4 relative z-10 justify-start mt-4">
                    <button class="history-prev group cursor-pointer">
                        <svg class="w-12 h-12 transition-transform group-active:scale-90" viewBox="0 0 48 48">
                            <circle cx="24" cy="24" r="23" stroke="#1A3B1B" stroke-width="2" fill="none" />
                            <path d="M34 24L14 24M14 24L20 18M14 24L20 30" stroke="#1A3B1B" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button class="history-next group cursor-pointer">
                        <svg class="w-12 h-12 transition-transform group-active:scale-90" viewBox="0 0 48 48">
                            <circle cx="24" cy="24" r="23" stroke="#1A3B1B" stroke-width="2" fill="none" />
                            <path d="M14 24L34 24M34 24L28 18M34 24L28 30" stroke="#1A3B1B" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="relative order-1 md:order-2">
                <img src="<?php echo SITE_URL; ?>/assets/images/ui/four-square.png" alt="MOSIL Lubricant Manufacturer"
                    class="w-full h-full object-cover rounded-lg shadow-sm">
            </div>
        </div>
    </div>
</section>
<section class="bg-primary relative overflow-hidden z-1">
    <div class="absolute bottom-0 left-0 -z-10 pointer-events-none hidden md:block">
        <img src="<?php echo SITE_URL; ?>/assets/images/ui/bg_lubi_drop_left_light.png" alt="lubrication decision"
            class="block h-full w-full object-cover object-center" loading="lazy">
    </div>

    <div class="absolute top-0 right-0 h-full -z-10 pointer-events-none">
        <img src="<?php echo SITE_URL; ?>/assets/images/ui/bg_lubi_drop_right_light.png" alt="lubrication decision"
            class="block h-full w-full object-cover object-center" loading="lazy">
    </div>

    <div class="container relative z-10 md:pt-16 md:pb-18 pt-4 pb-5">
        <div class="py-3.5">
            <span class="text-b200 font-normal text-xs leading-[120%] tracking-[0.015em] uppercase">
                who we are
            </span>
            <div class="border-b border-[#ffffff] pb-1">
                <h2
                    class="text-main-green font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize md:whitespace-nowrap">
                    A brand driven by purpose, backed by science. since 1971
                </h2>
            </div>
        </div>

        <div class="swiper who-we-are-swiper pt-8 md:block block" id="about-who-we-are-swiper">
            <div class="swiper-wrapper md:grid md:grid-cols-5 md:gap-5">
                <?php for ($i = 0; $i < 5; $i++) { ?>
                    <div
                        class="swiper-slide group relative bg-y100 md:h-[204px] h-[208px]! p-4 overflow-hidden transition-all duration-300 ease-out hover:shadow-xl hover:-translate-y-2">
                        <div
                            class="absolute inset-0 bg-white/20 translate-y-full transition-transform duration-500 group-hover:translate-y-0 pointer-events-none">
                        </div>

                        <h6
                            class="text-[#3B3B3B] font-base font-normal text-[20px] leading-[140%] md:text-[18px] md:leading-[140%] mb-2 relative z-10">
                            Engineered lubricants for high performance
                        </h6>

                        <p
                            class="text-[#666666] font-base font-normal text-[14px] md:text-[12px] leading-[150%] md:leading-[150%] tracking-[0.015em] relative z-10">
                            High performance greases, oils, aerosols, coatings, corrosion preventives, dry films,
                            anti-frictional coatings and specialty cleaners for critical applications in various industries.
                        </p>

                        <div
                            class="absolute bottom-0 left-0 h-1 w-0 bg-[#1A3B1B] transition-all duration-300 group-hover:w-full z-20">
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="flex md:hidden items-center gap-4 relative z-10 justify-end mt-6">
                <button class="who-we-are-prev group cursor-pointer" aria-label="Previous slide">
                    <svg class="w-12 h-12 transition-transform group-active:scale-90" viewBox="0 0 48 48">
                        <circle cx="24" cy="24" r="23" stroke="#1A3B1B" stroke-width="2" fill="none" />
                        <path d="M34 24L14 24M14 24L20 18M14 24L20 30" stroke="#1A3B1B" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <button class="who-we-are-next group cursor-pointer" aria-label="Next slide">
                    <svg class="w-12 h-12 transition-transform group-active:scale-90" viewBox="0 0 48 48">
                        <circle cx="24" cy="24" r="23" stroke="#1A3B1B" stroke-width="2" fill="none" />
                        <path d="M14 24L34 24M34 24L28 18M34 24L28 30" stroke="#1A3B1B" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

<section class="relative">
    <div class="container md:py-20">
        <div class="py-3.5">
            <span class="text-b200 font-normal text-xs leading-[120%] tracking-[0.015em] uppercase">
                Why Mosil Matters?
            </span>
            <div class="border-b border-primary pb-1">
                <h2
                    class="text-main-green font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize md:whitespace-nowrap">
                    Pushing the boundaries of
                    your performance
                </h2>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 pt-6 md:pt-0">
            <?php foreach ($mosil_matters as $item): ?>
                <div
                    class="relative group overflow-hidden w-full md:h-[300px] h-[220px] flex flex-col justify-end cursor-pointer">

                    <div class="absolute inset-0 transition-transform duration-700 ease-out group-hover:scale-110"
                        style="background: linear-gradient(180deg, rgba(0, 0, 0, 0) 30%, rgba(0, 0, 0, 0.9) 100%), 
                        url('<?php echo SITE_URL; ?>/assets/images/ui/<?php echo $item['image']; ?>') no-repeat center/cover;">
                    </div>

                    <div
                        class="relative z-10 md:px-6 md:py-5 px-4 py-4 transition-transform duration-500 ease-out transform md:translate-y-15 group-hover:translate-y-0 max-w-[230px] md:max-w-full">

                        <h6
                            class="text-white font-base font-normal md:text-[24px] md:leading-[135%] text-[18px] leading-[140%] tracking-[0.015em] capitalize">
                            <?php echo $item['title']; ?>
                        </h6>

                        <p
                            class="text-white font-base font-light text-[15px] leading-[150%] mt-2 opacity-0 transition-opacity duration-300 group-hover:opacity-100 hidden md:block">
                            <?php echo $item['description']; ?>
                        </p>
                    </div>

                    <div
                        class="absolute inset-0 bg-main-green/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="relative bg-[#F5F5F5]">
    <div class="container pt-5 md:pb-6 pb-14 relative">
        <div class="py-3.5">
            <span class="text-b200 font-normal text-xs leading-[120%] tracking-[0.015em] uppercase">
                Visionaries behind
            </span>
            <div class="border-b border-primary pb-1">
                <h2
                    class="text-main-green font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize md:whitespace-nowrap">
                    Leadership driving progress
                </h2>
            </div>
        </div>
        <div class="grid grid-cols-1 pt-7">
            <div class="relative md:absolute top-0 right-0 w-full h-full flex justify-end">
                <img src="<?php echo SITE_URL; ?>/assets/images/ui/directors.svg" alt="Leadership driving progress"
                    class="object-contain object-right-top w-full h-full">
            </div>
            <div
                class="md:px-6 md:py-6 p-5 pt-9 bg-[#ffffff] bg-[#FAFAFA] border-l border-[#F4C300] rounded-bl-[33px] mb-5">
                <h2
                    class="flex flex-col gap-1 text-[#1A3B1B] font-base font-normal text-[20px] leading-[150%] tracking-[0.01em]">
                    Great
                    machines builds nation, great lubricants keep them alive</h2>
            </div>
            <div class="inline-flex flex-col items-start gap-6 w-full max-w-[718px]">
                <p class="text-[#757575] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em]">
                    Today,
                    the industrial world is evolving rapidly, with more automation, higher loads,
                    stringent
                    regulations, and growing sustainability expectations. In this environment, lubrication is no longer
                    a
                    side function; it has become a strategic lever for uptime, efficiency and long-term value.</p>
                <p class="text-[#757575] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em]">
                    MOSIL stands at the center of this shift. With a foundation rooted in tribology and a mindset shaped
                    by
                    real-world industry challenges, we engineer solutions - not just products. To ensure top performance
                    for
                    our customers, we invest in our employees as well as in state-of-the-art testing equipment, analysis
                    tools and infrastructure that exceed performance requirements.</p>
                <p class="text-[#757575] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em]">
                    Our commitment remains unchanged: to keep industries moving, machines performing and our customers
                    ahead
                    of what’s next as their performance multiplier
                </p>
                <div class="flex items-start gap-1 flex-col">
                    <p
                        class="text-[#575757] font-base font-bold text-[20px] leading-[140%] tracking-[0.01em] capitalize">
                        Samvar
                        Abindra Mavani & Shail Abindra Mavani</p>
                    <p class="text-[#575757] font-base font-normal text-[14px] leading-[150%] tracking-[0.015em]">
                        Directors,
                        MOSIL lubricants</p>
                </div>
            </div>
        </div>
    </div>
</section>