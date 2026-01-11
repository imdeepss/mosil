<?php
// Get slug from URL
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$slug = htmlspecialchars($slug, ENT_QUOTES, 'UTF-8');

// Fetch the case study details
// Note: Assuming getCaseStudyBySlug exists, if not we will use getBlogBySlug as placeholder or similar logic
$caseStudy = getCaseStudyBySlug($slug);

// If case study not found, redirect to case study listing or show 404
if (!$caseStudy) {
    // You might want to redirect to a 404 page or back to the case study listing
    echo '<script>window.location.href = "' . SITE_URL . '/case-studies";</script>';
    exit;
}

// Fetch suggested case studies for the bottom section
// Reuse getCaseStudiesWithPagination to get recent ones
$suggestedData = getCaseStudiesWithPagination(1, 4);
$suggestedCaseStudies = $suggestedData['caseStudies'];

// Set Page Title for SEO
$pageTitle = htmlspecialchars($caseStudy['title']);
?>


<section class="h-[60px] sticky top-0 z-10 bg-white"></section>


<section class="w-full bg-white">
    <div class="container">
        <!-- Breadcrumbs -->
        <nav
            class="flex items-center breadcrumbs gap-1 text-[14px] md:text-[16px] leading-[150%] tracking-[0.015em] capitalize flex-wrap py-6">
            <a href="<?php echo SITE_URL; ?>/" class="text-[#A3A3A3] font-light">Home</a>
            <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg></span>
            <a href="<?php echo SITE_URL; ?>/newsroom" class="text-[#A3A3A3] font-light">Newsroom</a>
            <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg></span>
            <a href="<?php echo SITE_URL; ?>/case-studies" class="text-[#A3A3A3] font-light">Case Studies</a>
            <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg></span>
            <span class="text-[#575757] font-bold line-clamp-1">
                <?php echo $caseStudy['title']; ?>
            </span>
        </nav>

        <!-- Hero Image -->
        <div class="w-full h-[180px] md:h-[443px] rounded-[4px] overflow-hidden md:mb-8 mb-4">
            <img src="<?php echo SITE_URL; ?>/assets/uploads/case_studies/<?php echo $caseStudy['image']; ?>"
                alt="<?php echo $caseStudy['title']; ?>" class="w-full h-full object-cover">
        </div>

        <!-- Content -->
        <div class="max-w-none">
            <h1 class="not-prose text-[#4B4D4B] font-bold text-[32px] leading-[120%] capitalize mb-2">
                <?php echo $caseStudy['title']; ?>
            </h1>

            <p class="not-prose text-[#575A56] font-normal text-[16px] leading-[135%] tracking-[0.01em] mb-4">
                <?php echo date('d F Y', strtotime($caseStudy['created_at'])); ?>
            </p>

            <div id="dynamic-blog-content" class="blog-content prose max-w-none">
                <!-- Introduction -->
                <?php if (!empty($caseStudy['introduction'])): ?>
                    <h2 class="text-[#1A3B1B] font-bold text-[18px] md:text-[20px] mb-2">Introduction</h2>
                    <div class="mb-6">
                        <?php echo clean_content($caseStudy['introduction']); ?>
                    </div>
                <?php endif; ?>

                <!-- Challenge -->
                <?php if (!empty($caseStudy['challenge'])): ?>
                    <h2 class="text-[#1A3B1B] font-bold text-[18px] md:text-[20px] mb-2">Challenge</h2>
                    <div class="mb-6">
                        <?php echo clean_content($caseStudy['challenge']); ?>
                    </div>
                <?php endif; ?>

                <!-- Expectation -->
                <?php if (!empty($caseStudy['expectation'])): ?>
                    <h2 class="text-[#1A3B1B] font-bold text-[18px] md:text-[20px] mb-2">Expectation</h2>
                    <div class="mb-6">
                        <?php echo clean_content($caseStudy['expectation']); ?>
                    </div>
                <?php endif; ?>

                <!-- Solution -->
                <?php if (!empty($caseStudy['solution'])): ?>
                    <h2 class="text-[#1A3B1B] font-bold text-[18px] md:text-[20px] mb-2">Solution</h2>
                    <div class="mb-6">
                        <?php echo clean_content($caseStudy['solution']); ?>
                    </div>
                <?php endif; ?>

                <!-- Recommendation -->
                <?php if (!empty($caseStudy['recommendation'])): ?>
                    <h2 class="text-[#1A3B1B] font-bold text-[18px] md:text-[20px] mb-2">Recommendation</h2>
                    <div class="mb-6">
                        <?php echo clean_content($caseStudy['recommendation']); ?>
                    </div>
                <?php endif; ?>

                <!-- Result -->
                <?php if (!empty($caseStudy['result'])): ?>
                    <div class="bg-[#F5F5F5] p-4 rounded-[4px] mb-6 border-l-[1px] border-[#F4C300]">
                        <h2 class="text-[#1A3B1B] font-bold text-[18px] md:text-[20px] mb-2">Result</h2>
                        <div class="text-[#666666] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em]">
                            <?php echo clean_content($caseStudy['result']); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Benefits -->
                <?php if (!empty($caseStudy['benefits'])): ?>
                    <h2 class="text-[#1A3B1B] font-bold text-[18px] md:text-[20px] mb-2">Benefits</h2>
                    <div class="mb-6">
                        <?php echo clean_content($caseStudy['benefits']); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($caseStudy['industry_segment'])): ?>
                    <p><strong class="font-bold text-[#1A3B1B]">Industry Segment:</strong>
                        <?php echo $caseStudy['industry_segment']; ?>
                    </p>
                <?php endif; ?>
                <?php if (!empty($caseStudy['equipment'])): ?>
                    <p><strong class="font-bold text-[#1A3B1B]">Equipment:</strong>
                        <?php echo $caseStudy['equipment']; ?>
                    </p>
                <?php endif; ?>
                <?php if (!empty($caseStudy['application'])): ?>
                    <p><strong class="font-bold text-[#1A3B1B]">Application:</strong>
                        <?php echo $caseStudy['application']; ?>
                    </p>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

<!-- Related Case Studies Section -->
<section class="w-full md:py-20 py-5">
    <div class="container">

        <div class="py-3.5">

            <div class="border-b-2 border-primary pb-1 flex md:items-center items-end justify-between">
                <h2
                    class="text-[var(--color-main-green)] font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize">
                    Explore Relevant Case Studies</h2>
                <div class="hidden md:inline-flex justify-start items-center gap-4">
                    <button
                        class="swiper-prev w-8 h-8 flex items-center justify-center rounded-full border-2 border-[#1A3B1B] opacity-50 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 rotate-180" viewBox="0 0 16 16"
                            fill="none">
                            <path
                                d="M8.88331 3.17188L13.325 7.61353M13.325 7.61353L8.88331 12.0552M13.325 7.61353L1.90356 7.61353"
                                stroke="#1A3B1B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>

                    <button
                        class="swiper-next w-8 h-8 flex items-center justify-center rounded-full border-2 border-[#1A3B1B] cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 16 16" fill="none">
                            <path
                                d="M8.88331 3.17188L13.325 7.61353M13.325 7.61353L8.88331 12.0552M13.325 7.61353L1.90356 7.61353"
                                stroke="#1A3B1B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>


        <div class="swiper caseStudyDetailSwiper overflow-hidden md:mt-8 mt-2">
            <div class="swiper-wrapper">
                <?php foreach ($suggestedCaseStudies as $item): ?>
                    <div class="swiper-slide h-auto">
                        <div class="flex flex-col h-full bg-white rounded-[4px] overflow-hidden group">
                            <!-- Image -->
                            <div class="relative h-[240px] w-full overflow-hidden">
                                <img src="<?php echo SITE_URL; ?>/assets/uploads/case_studies/<?php echo $item['image']; ?>"
                                    alt="<?php echo $item['title']; ?>"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">

                                <div
                                    class="absolute bottom-2 left-2 px-2 py-1 bg-[var(--color-primary)] text-[var(--color-main-green)] font-bold text-[10px] leading-[135%] tracking-[0.01em] uppercase">
                                    Case Study
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-4 flex flex-col flex-1">
                                <h3 class="font-bold text-[18px] leading-[140%] text-[#3B3B3B] mb-2 line-clamp-2">
                                    <?php echo $item['title']; ?>
                                </h3>
                                <p class="text-[#757575] text-[16px] leading-[150%] mb-4 line-clamp-2 flex-grow">
                                    <?php echo substr(strip_tags($item['content']), 0, 100) . '...'; ?>
                                </p>
                                <div class="mt-auto">
                                    <p class="text-[#A3A3A3] text-[14px] mb-3">
                                        <?php echo date('F d, Y', strtotime($item['created_at'])); ?>
                                    </p>
                                    <a href="<?php echo SITE_URL; ?>/case-study/<?php echo $item['slug']; ?>"
                                        class="inline-block text-[#1A3B1B] font-bold text-[18px] border-b-2 border-transparent hover:border-primary transition-all">
                                        Read Case Study
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="md:hidden flex justify-end items-center gap-4">
                <button
                    class="swiper-prev w-8 h-8 flex items-center justify-center rounded-full border-2 border-[#1A3B1B] opacity-50 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 rotate-180" viewBox="0 0 16 16" fill="none">
                        <path
                            d="M8.88331 3.17188L13.325 7.61353M13.325 7.61353L8.88331 12.0552M13.325 7.61353L1.90356 7.61353"
                            stroke="#1A3B1B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>

                <button
                    class="swiper-next w-8 h-8 flex items-center justify-center rounded-full border-2 border-[#1A3B1B] cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 16 16" fill="none">
                        <path
                            d="M8.88331 3.17188L13.325 7.61353M13.325 7.61353L8.88331 12.0552M13.325 7.61353L1.90356 7.61353"
                            stroke="#1A3B1B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Initialize Swiper
        const caseStudySwiper = new Swiper('.caseStudyDetailSwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            navigation: {
                nextEl: '.swiper-next',
                prevEl: '.swiper-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1280: {
                    slidesPerView: 3.2,
                }
            }
        });
    });
</script>