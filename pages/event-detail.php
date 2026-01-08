<?php
// Get slug from URL
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$slug = htmlspecialchars($slug, ENT_QUOTES, 'UTF-8');

// Fetch the blog/event details
$event = getBlogBySlug($slug);

// If event not found, redirect to events listing or show 404
if (!$event) {
    echo '<script>window.location.href = "' . SITE_URL . '/events";</script>';
    exit;
}

// Fetch suggested blogs for the sidebar
$suggestedData = getBlogsWithPagination(1, 2);
$suggestedBlogs = $suggestedData['blogs'];

// Set Page Title for SEO
$pageTitle = htmlspecialchars($event['title']);
?>

<section class="h-[60px] sticky top-0 z-10 bg-white"></section>

<section class="w-full bg-white">
    <div class="container relative py-6">
        <!-- Breadcrumbs -->
        <nav
            class="flex items-center breadcrumbs gap-1 text-[14px] md:text-[16px] leading-[150%] tracking-[0.015em] capitalize flex-wrap">
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
            <a href="<?php echo SITE_URL; ?>/events" class="text-[#A3A3A3] font-light">Events</a>
            <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg></span>
            <span class="text-[#575757] font-bold line-clamp-1">
                <?php echo $event['title']; ?>
            </span>
        </nav>
    </div>
    <div class="container relative grid grid-cols-1 md:grid-cols-12 md:gap-8">
        <!-- Left Column: Main Content (8 cols) -->
        <div class="md:col-span-8 md:pb-30 pb-12">



            <!-- Hero Image -->
            <div class="w-full h-[180px] md:h-[400px] rounded-[4px] overflow-hidden md:mb-8 mb-4">
                <img src="<?php echo SITE_URL; ?>/assets/uploads/blog/<?php echo $event['image']; ?>"
                    alt="<?php echo $event['title']; ?>" class="w-full h-full object-cover">
            </div>

            <!-- Content Area -->
            <div class="max-w-none">
                <h1
                    class="not-prose text-[#4B4D4B] font-bold text-[24px] md:text-[32px] leading-[120%] capitalize mb-2">
                    <?php echo $event['title']; ?>
                </h1>

                <p class="not-prose text-[#575A56] font-normal text-[16px] leading-[135%] tracking-[0.01em] mb-6">
                    <?php echo date('d F Y', strtotime($event['created_at'])); ?>
                </p>

                <!-- Cleaned Content -->
                <div id="dynamic-blog-content" class="blog-content prose max-w-none">
                    <?php echo clean_content($event['content']); ?>
                </div>

                <!-- Extra Fields for Industry Segment (Similar to Case Study, conditionally shown if exists in $event) -->
                <?php if (!empty($event['industry_segment']) || !empty($event['equipment']) || !empty($event['application'])): ?>
                    <hr class="border-[#DEDEDE] my-8">
                    <div class="flex flex-col gap-2 text-[14px] md:text-[16px] leading-[160%] text-[#3B3B3B]">
                        <?php if (!empty($event['industry_segment'])): ?>
                            <p><strong class="font-bold text-[#1A3B1B]">Industry Segment:</strong>
                                <?php echo $event['industry_segment']; ?>
                            </p>
                        <?php endif; ?>
                        <?php if (!empty($event['equipment'])): ?>
                            <p><strong class="font-bold text-[#1A3B1B]">Equipment:</strong>
                                <?php echo $event['equipment']; ?>
                            </p>
                        <?php endif; ?>
                        <?php if (!empty($event['application'])): ?>
                            <p><strong class="font-bold text-[#1A3B1B]">Application:</strong>
                                <?php echo $event['application']; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <!-- Right Column: Sidebar (4 cols) -->
        <div class="md:col-span-4 border-l-0 md:border-l md:border-[#D9D9D9] md:pl-8">
            <div class="py-3.5">
                <div class="border-b border-primary pb-1">
                    <h3
                        class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                        Suggested Blogs
                    </h3>

                </div>
            </div>

            <div class="swiper eventSuggestedSwiper md:py-6! py-4! w-full">
                <div class="swiper-wrapper flex md:flex-col md:gap-8">
                    <?php foreach ($suggestedBlogs as $item): ?>
                        <div class="swiper-slide flex flex-col group cursor-pointer h-auto">
                            <a href="<?php echo SITE_URL; ?>/blog/<?php echo $item['slug']; ?>"
                                class="group relative block overflow-hidden rounded-[4px] h-[240px] bg-gray-100">

                                <img src="<?php echo SITE_URL; ?>/assets/uploads/blog/<?php echo $item['image']; ?>"
                                    alt="<?php echo $item['title']; ?>"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">

                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-60">
                                </div>

                                <span
                                    class="absolute bottom-2 left-2 bg-[#F9DC6B] text-[#1A3B1B] font-base font-bold text-[10px] leading-[135%] tracking-[0.01em] px-2 py-1">
                                    <?php echo !empty($item['category_name']) ? $item['category_name'] : 'Blog'; ?>
                                </span>
                            </a>
                            <div class="flex flex-col py-4 gap-3">
                                <h4
                                    class="text-[#3B3B3B] font-base font-bold text-[18px] leading-[140%] tracking-[0.015em] capitalize">
                                    <a href="<?php echo SITE_URL; ?>/blog/<?php echo $item['slug']; ?>">
                                        <?php echo $item['title']; ?>
                                    </a>
                                </h4>
                                <p
                                    class="text-[#757575] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em] line-clamp-3">
                                    <?php $content = trim(preg_replace('/\s+/', ' ', strip_tags($item['content'])));
                                    echo $content; ?>
                                </p>
                                <p
                                    class="text-[#A3A3A3] font-base font-normal text-[14px] leading-[150%] tracking-[0.015em]">
                                    <?php echo !empty($item['category_name']) ? $item['category_name'] : 'Blog'; ?>
                                    | <?php echo date('d F Y', strtotime($item['created_at'])); ?>
                                </p>
                            </div>
                            <a href="<?php echo SITE_URL; ?>/blog/<?php echo $item['slug']; ?>" class="group/btn
                                    relative font-bold text-[18px] text-[#415C42] pb-2 w-fit
                                    capitalize hover:text-main-green">
                                Read Blog
                                <span
                                    class="absolute bottom-0 left-0 w-full h-[2px] bg-[#F9DC6B] transform scale-x-0 group-hover/btn:scale-x-100 transition-transform duration-300 origin-left"></span>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Mobile Navigation -->
                <div class="md:hidden flex justify-end items-center gap-4 mt-4 mb-6">
                    <button
                        class="swiper-prev w-8 h-8 flex items-center justify-center rounded-full border-2 border-[#1A3B1B] cursor-pointer">
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

    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const swiper = new Swiper('.eventSuggestedSwiper', {
            slidesPerView: 1,
            spaceBetween: 16,
            navigation: {
                nextEl: '.swiper-next',
                prevEl: '.swiper-prev',
            },
            breakpoints: {
                768: {
                    enabled: false,
                    slidesPerView: 'auto',
                    spaceBetween: 0
                }
            }
        });
    });
</script>