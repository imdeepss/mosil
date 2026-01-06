<?php
$pageTitle = 'Newsroom';
$blogs = getBlogs(3);
$latestBlogs = getLatestBlogs(5);


$mosil_news = [
    [
        "category" => "Exhibition",
        "title" => "MOSIL at IME 2025 Exhibition, Kolkata,",
        "date" => "07 May 2025",
        "image" => "ime_exhibition.jpg",
        "is_featured" => true
    ],
    [
        "category" => "News",
        "title" => "Equipment reliability linked with lubrication and lubricants",
        "image" => "car_reliability.jpg",
        "is_featured" => false
    ],
    [
        "category" => "Beyond business",
        "title" => "Beyond business : Ensuring smooth Innovation",
        "image" => "robotic_arm.jpg",
        "is_featured" => false
    ],
    [
        "category" => "News",
        "title" => "Myths about bearing lubrication",
        "image" => "bearing_gear.jpg",
        "is_featured" => false
    ],
    [
        "category" => "News",
        "title" => "Tribotsav 2025: Tribotsav: Spirit of togetherness",
        "image" => "team_photo.jpg",
        "is_featured" => false
    ]
];
$lubricationItems = [
    [
        "title" => "Identify Painpoints",
        "description" => "Understand deeply unique challenges",
        "image" => "/assets/images/ui/IdentifyPainpoints.png"
    ],
    [
        "title" => "Expectation Mapping",
        "description" => "Actively validate not assume",
        "image" => "/assets/images/ui/ExpectationMapping.png"
    ],
    [
        "title" => "TriboIntel",
        "description" => "Tribology based performance documentation",
        "image" => "/assets/images/ui/TriboIntel.png"
    ],
];
?>

<!-- Hero Section -->
<section class="relative h-[400px] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="<?php echo SITE_URL; ?>/assets/images/banners/newsroom-banner.png" class="w-full h-full object-cover"
            alt="Newsroom">
    </div>
    <div class="container relative z-20 flex items-end justify-start w-full h-full pb-4 md:pb-10">
        <h2
            class="text-white font-base font-normal text-[32px] md:text-[48px] leading-[120%] tracking-normal capitalize">
            Newsroom
        </h2>
    </div>
</section>


<section class="bg-main-green">
    <div class="container">
        <div class="flex items-center justify-start">
            <button
                class="text-[#FFFFFF] text-center font-base font-normal text-[20px] leading-[120%] tracking-[0.01em] px-10 py-4 relative">
                <span class="absolute bottom-0 left-0 z-0 bg-primary w-full h-1"></span>
                Event
            </button>
            <button
                class="text-[#FFFFFF] text-center font-base font-normal text-[20px] leading-[120%] tracking-[0.01em] px-10 py-4 relative">
                Case studies
            </button>
            <button
                class="text-[#FFFFFF] text-center font-base font-normal text-[20px] leading-[120%] tracking-[0.01em] px-10 py-4 relative">
                Blogs
            </button>
            <button
                class="text-[#FFFFFF] text-center font-base font-normal text-[20px] leading-[120%] tracking-[0.01em] px-10 py-4 relative">
                Glossary
            </button>
            <button
                class="text-[#FFFFFF] text-center font-base font-normal text-[20px] leading-[120%] tracking-[0.01em] px-10 py-4 relative">
                FAQs
            </button>
        </div>
    </div>
</section>



<section class="w-full bg-white">
    <div class="container py-6">
        <nav
            class="flex items-center breadcrumbs gap-1 text-[14px] md:text-[16px] leading-[150%] tracking-[0.015em] capitalize flex-wrap ">
            <a href="<?php echo SITE_URL; ?>/" class="text-[#A3A3A3] font-light">Home</a>

            <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg></span>
            <a href="#" class="text-[#575757] font-bold">Newsroom</a>
        </nav>
        <div class="py-3.5">
            <span class="text-b200 font-normal text-xs leading-[120%] tracking-[0.015em] uppercase">
                in the spotlight
            </span>
            <div class="border-b border-primary pb-1 flex md:items-center items-end justify-between">
                <h2
                    class="text-[var(--color-main-green)] font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize">
                    Latest events</h2>
                <a href="<?php echo SITE_URL; ?>/events"
                    class="font-light md:font-bold text-lg md:text-2xl leading-[120%] tracking-[0.01em] text-main-green hover:text-primary transition-colors whitespace-nowrap">See
                    All</a>
            </div>
        </div>
        <div class="newsroom-events py-9.5">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 auto-rows-[240px]">

                <?php foreach ($latestBlogs as $item): ?>
                    <a href="<?php echo SITE_URL; ?>/blog/<?php echo $item['slug']; ?>" class="relative group overflow-hidden block
       <?php echo $item['is_featured'] ? 'md:col-span-2 md:row-span-2' : 'col-span-1'; ?>">

                        <div class="absolute inset-0 transition-transform duration-700 group-hover:scale-105" style="background: linear-gradient(180deg, rgba(0,0,0,0) 40%, rgba(0,0,0,0.9) 100%), 
            url('<?php echo SITE_URL; ?>/assets/uploads/blog/<?php echo $item['image']; ?>') no-repeat center/cover;">
                        </div>

                        <div class="relative h-full flex flex-col justify-end z-10 gap-2
            <?php echo $item['is_featured'] ? 'px-7.5 py-8.5' : 'px-3 py-4'; ?>">

                            <span
                                class="inline-block bg-[#F9DC6B] text-[#1A3B1B] text-[12px] font-base font-bold uppercase px-2 py-1 w-fit">
                                <?php echo $item['category_name']; ?>
                            </span>

                            <h3 class="text-[#FFFFFF] font-base font-bold leading-[135%] tracking-[0.01em]
                <?php echo $item['is_featured'] ? 'text-[24px]' : 'text-[14px]'; ?>">
                                <?php echo $item['title']; ?>
                            </h3>

                            <?php if (isset($item['created_at'])): ?>
                                <p class="text-[#FFFFFF] font-base font-normal text-[14px] leading-[135%] tracking-[0.01em]">
                                    <?php echo date('F d, Y', strtotime($item['created_at'])); ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div
                            class="absolute inset-0 bg-main-green/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>


<section class="w-full bg-[#F5F5F5]">
    <div class="container pt-[30px] pb-[80px]">
        <div class="py-3.5">
            <span class="text-b200 font-normal text-xs leading-[120%] tracking-[0.015em] uppercase">
                real world performance
            </span>
            <div class="border-b border-primary pb-1 flex md:items-center items-end justify-between">
                <h2
                    class="text-main-green font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize">
                    Case study
                </h2>
                <a href="<?php echo SITE_URL; ?>/case-studies"
                    class="font-light md:font-bold text-lg md:text-2xl leading-[120%] tracking-[0.01em] text-main-green hover:text-primary transition-colors whitespace-nowrap">
                    See All
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-6">
            <div class="relative overflow-hidden md:h-full h-[300px]">
                <img src="<?php echo SITE_URL; ?>/assets/images/ui/case-study.png" alt="Case Study Featured"
                    class="w-full h-full object-cover transition-transform duration-700 hover:scale-105"
                    loading="lazy" />
            </div>

            <div class="flex flex-col gap-5">
                <?php
                $case_studies = [1, 2, 3];
                foreach ($case_studies as $cs):
                    ?>
                    <div class="pt-5 pb-7 pl-8 pr-5.5 bg-[#F4C300] rounded-br-[40px] relative group flex flex-col gap-2">
                        <span
                            class="text-[#3B3B3B] font-base font-normal text-[12px] leading-[150%] tracking-[0.015em] opacity-80">
                            07 May 2025
                        </span>

                        <h3
                            class="text-[#3B3B3B] font-base font-bold text-[16px] leading-[150%] tracking-[0.015em] capitalize">
                            Slack adjuster: “Global performance. Local advantage.”
                        </h3>

                        <p class="text-[#3B3B3B] font-base font-normal text-[14px] leading-[150%] tracking-[0.015em]">
                            MOSIL developed a customised grease for an automotive brake part manufacturer that met
                            the customer’s European benchmark and cleared their validation flawlessly.
                        </p>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>


<section class="w-full">
    <div class="container pt-[24px] pb-[80px]">
        <div class="py-3.5">
            <span class="text-b200 font-normal text-xs leading-[120%] tracking-[0.015em] uppercase">
                Lubrication basics and beyond
            </span>
            <div class="border-b border-primary pb-1 flex md:items-center items-end justify-between">
                <h2
                    class="text-main-green font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize">
                    Blogs
                </h2>
                <a href="<?php echo SITE_URL; ?>/blogs"
                    class="font-light md:font-bold text-lg md:text-2xl leading-[120%] tracking-[0.01em] text-main-green hover:text-primary transition-colors whitespace-nowrap">
                    See All
                </a>
            </div>
        </div>

        <div class="md:mt-8 mt-6 swiper newsSwiper">
            <div class="swiper-wrapper md:!grid md:grid-cols-3 md:gap-10">
                <?php foreach ($blogs as $blog) { ?>

                    <div class="swiper-slide grid! grid-rows-[auto_1fr_auto]!">

                        <div class="relative h-[240px] w-full rounded-[4px] overflow-hidden shrink-0 group/img">
                            <img src="<?php echo SITE_URL; ?>/assets/uploads/blog/<?php echo $blog['image']; ?>"
                                alt="Hero Image"
                                class="block h-full w-full object-center rounded-[4px] group-hover/img:scale-110 transition-transform duration-500"
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
                                class="font-normal text-[16px] leading-[150%] tracking-[0.015em] text-[#757575] mb-2 line-clamp-3">
                                <?php
                                $content = trim(preg_replace('/\s+/', ' ', strip_tags($blog['content'])));
                                echo substr($content, 0, 500);
                                ?>
                            </p>
                            <p class="font-normal text-[14px] leading-[150%] tracking-[0.015em] text-[#A3A3A3] mt-auto">
                                <?php echo $blog['category_name']; ?> |
                                <?php echo date('F d, Y', strtotime($blog['created_at'])); ?>
                            </p>
                        </div>
                        <a href="<?php echo SITE_URL; ?>/blog/<?= urlencode($blog["slug"]) ?>"
                            class="group/btn relative font-bold text-[18px] text-[#415C42] pb-2 inline-block w-fit capitalize hover:text-main-green">
                            Read <?php echo $blog['category_name']; ?>
                            <span
                                class="absolute bottom-0 left-0 w-full h-[2px] bg-[var(--color-primary)] transform scale-x-0 group-hover/btn:scale-x-100 transition-transform duration-300 origin-left"></span>
                        </a>

                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<section class="bg-main-green relative">
    <div class="absolute bottom-0 left-0">
        <img src="<?php echo SITE_URL; ?>/assets/images/ui/bg_lubi_drop_left_light.png" alt="lubrication decision"
            class="block h-full w-full object-cover object-center" loading="lazy">
    </div>
    <div class="container relative z-10 md:pt-[64px] md:pb-[86px] pt-6 pb-6">


        <div class="py-3.5">
            <p class="text-[#FAFAFA] font-normal text-xs leading-[120%] tracking-[0.015em] uppercase mb-1">
                Glossary
            </p>
            <div class="md:border-b md:border-primary pb-1">
                <h2 class="text-white font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize">
                    Know the important terms
                </h2>
            </div>
        </div>
        <div class="md:mt-8 mt-6 grid grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-[#415C42] px-4 py-6 flex flex-col">
                <h6 class="text-[#FFFFFF] font-base font-normal text-[64px] leading-[120%]">
                    A
                </h6>
                <p class="text-[#FFFFFF] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em] mb-2">
                    Lubrications terms as per letter A

                </p>
                <p class="text-[#F5F5F5] font-base font-normal text-[12px] leading-[150%] tracking-[0.015em] mb-6">
                    You can find more such terms on the glossary page

                </p>
                <a href="#"
                    class="text-[#FFFFFF] font-base font-bold text-[16px] leading-[150%] tracking-[0.015em] capitalize">
                    Read all terms
                </a>
            </div>
            <?php foreach ($lubricationItems as $index => $item) { ?>
                <div class="bg-[#415C42] px-4 py-6 flex flex-col gap-4">
                    <h6 class="text-[#FFFFFF] font-base font-bold text-[18px] leading-[140%] tracking-[0.015em] capitalize">
                        <?php echo $item['title'] ?>
                    </h6>
                    <p
                        class="text-[#FFFFFF] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em] line-clamp-4">
                        <?php echo $item['description'] ?>
                    </p>
                    <a href="#"
                        class="text-[#FFFFFF] font-base font-bold text-[16px] leading-[150%] tracking-[0.015em] capitalize">
                        Read more
                    </a>
                </div>
            <?php } ?>
        </div>

    </div>
    <div class="absolute top-0 right-0 h-full">
        <img src="<?php echo SITE_URL; ?>/assets/images/ui/bg_lubi_drop_right_light.png" alt="lubrication decision"
            class="block h-full w-full object-cover object-center" loading="lazy">
    </div>
</section>




<?php
$faq_data = [
    [
        "category" => "Oil",
        "open" => true, // Set true to have it open by default
        "questions" => [
            [
                "q" => "What is viscosity of oil?",
                "a" => "Viscosity of an oil is a relative thickness that determines the flowability of the oil."
            ],
            [
                "q" => "What is a flash point of an oil?",
                "a" => "Flashpoint of an oil is the temperature at which 5% of the oil starts generating enough vapours to ignite the oil in the presence of an external source."
            ]
        ]
    ],
    [
        "category" => "Grease",
        "open" => false,
        "questions" => [
            [
                "q" => "What is the primary function of grease?",
                "a" => "Grease functions to maintain a lubricant film between moving parts while staying in place under gravity or centrifugal force."
            ]
        ]
    ]
];
?>

<section class="w-full">
    <div class="container py-[80px]">
        <div class="py-3.5">
            <span class="text-b200 font-normal text-xs leading-[120%] tracking-[0.015em] uppercase">
                Faqs
            </span>
            <div class="border-b border-primary pb-1 flex md:items-center items-end justify-between">
                <h2
                    class="text-main-green font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize">
                    Answer to your questions
                </h2>
                <a href="<?php echo SITE_URL; ?>/blogs"
                    class="font-light md:font-bold text-lg md:text-2xl leading-[120%] tracking-[0.01em] text-main-green hover:text-primary transition-colors whitespace-nowrap">
                    See All
                </a>
            </div>
        </div>

        <div class="md:mt-10 mt-6">

            <?php foreach ($faq_data as $index => $item): ?>
                <details class="group border-b-2 border-[#EBEBEB] overflow-hidden transition-all duration-500" <?php echo $item['open'] ? 'open' : ''; ?>>
                    <summary
                        class="flex justify-between items-center px-4 py-4 md:px-5 md:py-6 cursor-pointer list-none outline-none">
                        <span
                            class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize transition-transform duration-300">
                            <?php echo $item['category']; ?>
                        </span>

                        <div class="relative w-6 h-6 flex items-center justify-center">
                            <span class="absolute md:w-5 w-4 h-[2px] bg-[#1A3B1B] rounded-full"></span>
                            <span
                                class="absolute w-[2px] md:h-5 h-4 bg-[#1A3B1B] rounded-full transition-transform duration-500 ease-in-out group-open:rotate-90 group-open:opacity-0"></span>
                        </div>
                    </summary>

                    <div class="px-4 py-6">
                        <ul class="flex flex-col gap-4">
                            <?php foreach ($item['questions'] as $qa): ?>
                                <li class="border-b-2 border-[#DEDEDE] pb-3 flex flex-col gap-3">
                                    <p class="text-[#3B3B3B] font-base font-normal text-[18px] leading-[140%]">
                                        <?php echo $qa['q']; ?>
                                    </p>
                                    <p
                                        class="text-[#757575] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em]">
                                        <?php echo $qa['a']; ?>
                                    </p>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="flex justify-center pt-8">
                            <button
                                class="px-8 py-2 border border-[#1A3B1B] text-[#1A3B1B] rounded-full hover:bg-[#1A3B1B] hover:text-white transition-all duration-300 font-base text-[14px]">
                                Read More
                            </button>
                        </div>
                    </div>
                </details>
            <?php endforeach; ?>

        </div>
    </div>
</section>


<section class="w-full bg-white">
    <div class="container py-20">
        <div class="flex flex-col md:flex-row items-stretch overflow-hidden">

            <div class="relative w-full md:w-[437px] h-[280px] shrink-0">
                <img src="<?php echo SITE_URL; ?>/assets/images/ui/connect.jpg" alt="Stay connected"
                    class="w-full h-full object-cover" />
            </div>

            <div class="p-[50px] bg-[#F4C300] flex flex-col justify-center flex-grow">

                <h2 class="text-[#1A3B1B] font-base font-normal text-[32px] leading-[120%] capitalize mb-4">
                    Stay connected
                </h2>

                <p class="text-[#3B3B3B] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em] mb-6">
                    Get MOSIL press releases & newsletters in your inbox, and reach our media relations team for
                    interviews or info – stay connected to our experts worldwide.
                </p>

                <div class="flex flex-wrap items-center gap-4 justify-start">
                    <button type="button"
                        class="py-3 px-6 bg-[#1A3B1B] text-white text-center font-base font-normal text-[16px] leading-[150%] rounded-full border border-[#1A3B1B] cursor-pointer button-hover-vertical">
                        Contact the team
                    </button>

                    <button type="button"
                        class="py-3 px-6 text-[#1A3B1B] bg-transparent border border-[#1A3B1B] text-center font-base font-normal text-[16px] leading-[150%] rounded-full cursor-pointer button-hover-vertical">
                        Subscribe
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>