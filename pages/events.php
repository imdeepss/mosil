<?php
$pageTitle = 'Events';
$blogs = getBlogs();
?>


<section class="h-[60px] sticky top-0 z-10 bg-white"></section>
<div>

    <section class="container">
        <nav
            class="flex items-center breadcrumbs gap-1 text-[14px] md:text-[16px] leading-[150%] tracking-[0.015em] capitalize flex-wrap py-6">
            <a href="<?php echo SITE_URL; ?>/" class="text-[#A3A3A3] font-light">Home</a>
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>
            <a href="#" class="text-[#575757] font-bold">Events</a>

        </nav>
        <div class="py-3.5">
            <span class="text-b200 font-normal text-xs leading-[120%] tracking-[0.015em] uppercase">
                News & Beyond Business
            </span>
            <div class="border-b border-primary pb-1">
                <h2
                    class="text-main-green font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize md:whitespace-nowrap">
                    Events
                </h2>
            </div>
        </div>
        <div class="flex justify-start items-center gap-4 pt-6 pb-8">
            <button
                class="h-12 px-12 py-3 bg-main-green rounded py-3 px-12 text-white text-xl font-normal leading-7 tracking-tight">All</button>
            <button
                class="h-12 px-12 py-3 bg-[#F5F5F5] rounded py-3 px-12 text-[#A3A3A3] text-xl font-normal leading-7 tracking-tight">Exhibitions</button>
            <button
                class="h-12 px-12 py-3 bg-[#F5F5F5] rounded py-3 px-12 text-[#A3A3A3] text-xl font-normal leading-7 tracking-tight">Events</button>
            <button
                class="h-12 px-12 py-3 bg-[#F5F5F5] rounded py-3 px-12 text-[#A3A3A3] text-xl font-normal leading-7 tracking-tight">News</button>
            <button
                class="h-12 px-12 py-3 bg-[#F5F5F5] rounded py-3 px-12 text-[#A3A3A3] text-xl font-normal leading-7 tracking-tight">Beyond
                business</button>
        </div>
        <div class="md:mt-8 md:mb-10 swiper newsSwiper">
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
                                <h2>
                                    <?php echo $blog['category_name']; ?>
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
                                <?php echo date('F d, Y', strtotime($blog['created_at'])); ?>
                            </p>
                        </div>
                        <a href="<?php echo SITE_URL; ?>/blog/<?= urlencode($blog["slug"]) ?>" class="group/btn relative font-bold text-[18px] text-[#415C42] pb-2 inline-block w-fit
                        capitalize hover:text-main-green">
                            Read
                            <?php echo $blog['category_name']; ?>
                            <span
                                class="absolute bottom-0 left-0 w-full h-[2px] bg-[var(--color-primary)] transform scale-x-0 group-hover/btn:scale-x-100 transition-transform duration-300 origin-left"></span>
                        </a>

                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="mb-12 flex justify-start gap-4">
            <button
                class="text-[#666666] font-base font-normal text-[18px] leading-[140%] tracking-[0.015em] flex items-center gap-2"><svg
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M15 5L8 12L15 19" stroke="#666666" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>Prev</button>
            <div class="flex items-center gap-2">
                <button class="bg-[#F4C300] rounded text-[#1A3B1B] px-3 py-2">1</button>
                <button class="bg-[#FAE696] rounded text-[#1A3B1B] px-3 py-2">2</button>
                ...
                <button class="bg-[#FAE696] rounded text-[#1A3B1B] px-3 py-2">9</button>
            </div>
            <button
                class="text-lg font-normal flex items-center gap-2 text-[#666666] font-base font-normal text-[18px] leading-[140%]">Next
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M9 5L16 12L9 19" stroke="#666666" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg></button>
    </section>


</div>