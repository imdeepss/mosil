<?php
// Ensure we have data
$industries = getCategoryByParent("2");
?>

<section class="industry-slider-container bg-white overflow-hidden py-12 md:py-20 font-['Inter']">
    <div class="container mx-auto relative">
        <div class="md:mt-8 mt-6 flex flex-col flex-col-reverse lg:flex-row md:gap-5 items-stretch">

            <!-- LEFT PANEL: Static Container with Swapping Content -->
            <div
                class="hidden w-full lg:w-[433px] lg:h-[480px] bg-[#F5F5F5] rounded-[4px] relative lg:flex flex-col justify-between py-16 px-8.5 flex-col gap-4 bg-[#F5F5F5] z-20 shrink-0">

                <!-- Background Graphic -->
                <div class="absolute inset-0 opacity-50 pointer-events-none select-none">
                    <!-- Using SITE_URL as per existing project structure -->
                    <img src="<?php echo SITE_URL; ?>/assets/images/ui/Vector.png" class="w-full h-full object-contain"
                        alt="">
                </div>

                <!-- Text Content Swiper -->
                <!-- We use a Swiper here for the text too, to perfectly create the "fade" effect synchronized with the images -->
                <div
                    class="swiper contentSwiper w-full h-full !m-0 pointer-events-none relative z-10 [&_.swiper-slide]:!opacity-0 [&_.swiper-slide]:transition-opacity [&_.swiper-slide]:duration-500 [&_.swiper-slide-active]:!opacity-100">
                    <div class="swiper-wrapper">
                        <?php foreach ($industries as $industry): ?>
                            <div class="swiper-slide !flex flex-col items-start h-full bg-transparent gap-4">
                                <div>
                                    <h2
                                        class="text-[#1A3B1B] text-[28px] md:text-[32px] leading-[1.2] font-normal capitalize">
                                        <?php echo $industry['mcat_name']; ?>
                                    </h2>
                                    <p class="text-[#575757] text-[13px] uppercase tracking-wider font-medium">
                                        <?php echo $industry['mcat_desc']; ?>
                                    </p>

                                </div>
                                <div
                                    class="text-[#575757] font-base font-normal text-[12px] leading-[150%] tracking-[0.015em] md:text-[18px] md:leading-[140%] md:tracking-normal industry-desc min-h-[150px] overflow-hidden">
                                    <?php echo $industry['meta_description']; ?>
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

                <!-- Navigation Controls -->
                <!-- Placed absolutely within the left panel at the bottom -->
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

            <!-- RIGHT PANEL: Image Slider -->
            <!-- Use min-w-0 to prevent flexbox overflow issues -->
            <div class="w-full min-w-0 lg:flex-1 relative z-10">
                <!-- Clip-path ensures slides are hidden immediately when they go left of this container, fixing "hide from left side" -->
                <div class="swiper imageSwiper w-full h-[500px] md:h-[480px] !overflow-visible"
                    style="clip-path: inset(0 -100% 0 0);">
                    <div class="swiper-wrapper">
                        <?php foreach ($industries as $industry): ?>
                            <div
                                class="swiper-slide industry-image-slide rounded-[4px] overflow-hidden relative group cursor-grab active:cursor-grabbing !w-[85vw] !h-[500px] shrink-0 !opacity-100 transition-[width,opacity,filter] duration-[800ms] ease-[cubic-bezier(0.4,0,0.2,1)] lg:!w-[270px] lg:!h-[480px] lg:!opacity-20 lg:[&.is-expanded]:!w-[426px] lg:[&.is-expanded]:!opacity-100 lg:[&.is-expanded]:z-10">
                                <img src="<?php echo SITE_URL; ?>/assets/uploads/main-category/<?php echo $industry['mcat_image']; ?>"
                                    class="w-full !h-[214px] md:!h-[480px] object-cover transform transition-transform duration-700 group-hover:scale-105"
                                    alt="<?php echo $industry['mcat_name']; ?>">
                                <!-- Mobile Only Content -->
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
    <div class="md:mt-8 mt-6 flex flex-col lg:flex-row items-stretch gap-5">
        <div
            class="hidden lg:flex w-full lg:w-[433px] lg:h-[480px] py-16 px-8.5 flex-col gap-4 bg-[#F5F5F5] relative overflow-hidden z-20 shrink-0 rounded-[4px]">
            <div class="absolute inset-0 opacity-50 pointer-events-none">
                <img src="<?php echo SITE_URL; ?>/assets/images/ui/Vector.png"
                    class="w-full h-full object-contain opacity-90" alt="" loading="lazy" />
            </div>

            <div class="relative z-10 flex flex-col gap-4">
                <?php if (!empty($industries)):
                    $firstIndustry = $industries[0];
                    ?>
                    <div id="industry-content">
                        <h2
                            class="text-[#1A3B1B] font-base font-normal text-[18px] leading-[140%] capitalize md:text-[28px] md:leading-[135%] industry-title">
                            <?php echo $firstIndustry['mcat_name']; ?>
                        </h2>
                        <p
                            class="text-[#575757] font-base font-normal text-[12px] leading-[150%] tracking-[0.015em] md:text-[14px] md:tracking-[0.015em] industry-tagline line-clamp-4">
                            <?php echo $firstIndustry['mcat_desc']; ?>
                        </p>
                    </div>
                    <p
                        class="text-[#575757] font-base font-normal text-[12px] leading-[150%] tracking-[0.015em] md:text-[18px] md:leading-[140%] md:tracking-normal industry-desc min-h-[150px] overflow-hidden">
                        <?php echo $firstIndustry['meta_description']; ?>
                    </p>

                    <div class="">
                        <a href="<?php echo SITE_URL; ?>/product-finder/industry-categories/<?php echo $firstIndustry['slug']; ?>"
                            class="industry-link inline-flex items-center justify-center bg-main-green px-10 h-[48px] rounded-full transition-all w-[124px] button-hover border-2 border-transparent text-[#FFFFFF] text-center font-base font-normal text-[16px] leading-none tracking-[0.015em]">
                            View
                        </a>
                    </div>
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

        <div class="w-full lg:flex-1 min-w-0 relative z-10">
            <style>
                #industry-swiper-container {
                    clip-path: inset(0 -100vw 0 0);
                }
            </style>
            <div id="industry-swiper-container" class="swiper industrySwiper h-full !overflow-visible">
                <div class="swiper-wrapper">
                    <?php foreach ($industries as $industry) { ?>
                        <div class="swiper-slide !w-[85vw] md:!w-[270px] [&.swiper-slide-active]:md:!w-[426px] [&.swiper-slide-duplicate-active]:md:!w-[426px] transition-[width] duration-800 ease-in-out h-[500px] md:h-[480px] bg-[#F5F5F5] overflow-hidden relative group cursor-pointer shrink-0 rounded-[4px]"
                            data-title="<?php echo $industry['mcat_name']; ?>"
                            data-tagline="<?php echo $industry['mcat_desc']; ?>"
                            data-desc="<?php echo $industry['meta_description']; ?>"
                            data-link="<?php echo SITE_URL; ?>/product-finder/industry-categories/<?php echo $industry['slug']; ?>">
                            <img src="<?php echo SITE_URL; ?>/assets/uploads/main-category/<?php echo $industry['mcat_image']; ?>"
                                class="w-full !h-[214px] md:!h-[480px] object-cover shrink-0 rounded-[4px]"
                                alt="<?php echo $industry['mcat_name']; ?>" loading="lazy">

                            <div class="lg:hidden h-[286px] p-4 flex flex-col gap-4">
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
                                        class="text-[#575757] font-base font-normal text-[14px] leading-[150%] tracking-[0.015em] empty:hidden">
                                        <?php echo clean_content($industry['meta_description']); ?>
                                    </p>
                                </div>
                                <div
                                    class="flex items-center justify-between gap-4 mt-auto swiper-no-swiping relative z-50">
                                    <a href="<?php echo SITE_URL; ?>/product-finder/industry-categories/<?php echo $industry['slug']; ?>"
                                        class="inline-block bg-main-green text-white px-10 py-3 rounded-full hover:bg-black transition-all w-[150px] text-[16px] leading-[150%] tracking-[0.015em] text-center">
                                        View
                                    </a>
                                    <div class="flex gap-2">
                                        <button
                                            class="industry-mobile-prev w-12 h-12 rounded-full border border-[#1A3B1B] flex items-center justify-center shrink-0 bg-transparent hover:bg-gray-100 transition-colors">
                                            <svg class="w-8 h-8" viewBox="0 0 48 48" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M34 24L14 24M14 24L20 18M14 24L20 30" stroke="#1A3B1B"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                        <button
                                            class="industry-mobile-next w-12 h-12 rounded-full border border-[#1A3B1B] flex items-center justify-center shrink-0 bg-transparent hover:bg-gray-100 transition-colors">
                                            <svg class="w-8 h-8" viewBox="0 0 48 48" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M14 24L34 24M34 24L28 18M34 24L28 30" stroke="#1A3B1B"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    document.addEventListener('DOMContentLoaded', () => {

        // 1. Initialize Content Swiper (Left Side)
        // Uses Fade effect for smooth text transitions
        const contentSwiper = new Swiper('.contentSwiper', {
            effect: 'fade',
            fadeEffect: { crossFade: true },
            allowTouchMove: false, // User should swipe images, not text
            speed: 600,
            loop: true,
            slidesPerView: 1,
        });

        // 2. Initialize Image Swiper (Right Side)
        // Standard slider with specific width requirements
        const imageSwiper = new Swiper('.imageSwiper', {
            slidesPerView: 'auto', // Allows expected 426px width
            spaceBetween: 20,      // Gap between images
            loop: true,            // Infinite scrolling
            speed: 800,            // Smooth slide speed
            centeredSlides: false, // Active slide aligns left to touch the panel
            grabCursor: true,
            navigation: {
                nextEl: '.nav-next',
                prevEl: '.nav-prev',
            },
            // Link to content swiper
            on: {
                // Initialize: Set first slide expanded
                init: function () {
                    this.slides[this.activeIndex].classList.add('is-expanded');
                    this.update(); // Ensure layout matches
                },
                // When transition STARTS: Expand the NEW slide, but keep OLD one expanded too (buffer)
                slideChangeTransitionStart: function () {
                    const activeIndex = this.activeIndex;
                    const slides = this.slides;

                    // Add expanded class to current active slide
                    slides[activeIndex].classList.add('is-expanded');

                    // Sync Content Text
                    contentSwiper.slideToLoop(this.realIndex);

                    // Force update to handle the growing slide
                    this.update();
                },
                // When transition ENDS: Shrink the OLD slides (off-screen)
                slideChangeTransitionEnd: function () {
                    const activeIndex = this.activeIndex;
                    const slides = this.slides;

                    // Remove expanded from all EXCEPT active (shrinks the previous ones)
                    for (let i = 0; i < slides.length; i++) {
                        if (i !== activeIndex) {
                            slides[i].classList.remove('is-expanded');
                        }
                    }

                    // Force update to snap wrapper to new positions (active slide fixed at 0)
                    this.update();
                }
            }
        });

    });
</script>