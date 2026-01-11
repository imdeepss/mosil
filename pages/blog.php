<?php
$pageTitle = 'Blog';
// Initial load: Page 1, Limit 3, Category All
$initialData = getBlogsWithPagination(1, 3, 'All');
$blogs = $initialData['blogs'];
$totalPages = $initialData['totalPages'];
$currentPage = $initialData['currentPage'];
?>

<section class="h-[60px] sticky top-0 z-10 bg-white"></section>

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
        <a href="<?php echo SITE_URL; ?>/newsroom" class="text-[#A3A3A3] font-light">Newsroom</a>
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </span>
        <a href="#" class="text-[#575757] font-bold">Blog</a>

    </nav>
    <div class="py-3.5">
        <span
            class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
            News
        </span>
        <div class="border-b-2 border-primary pb-1">
            <h2
                class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap md:whitespace-nowrap">
                Featured Blogs
            </h2>
        </div>
    </div>
    <!-- Featured Blogs Section -->
    <div class="">

        <?php
        // Fetch top 4 for featured section
        $featuredData = getBlogsWithPagination(1, 4, 'All');
        $featuredBlogs = $featuredData['blogs'];

        if (!empty($featuredBlogs)):
            $mainFeatured = $featuredBlogs[0];
            $subFeatured = array_slice($featuredBlogs, 1, 3);
            ?>
            <!-- Main Featured Item -->
            <div class="w-full relative my-6 group cursor-pointer overflow-hidden">
                <a href="<?php echo SITE_URL; ?>/blog/<?php echo $mainFeatured['slug']; ?>"
                    class="block md:h-[400px] h-[280px] w-full">
                    <img src="<?php echo SITE_URL; ?>/assets/uploads/blog/<?php echo $mainFeatured['image']; ?>"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        alt="<?php echo $mainFeatured['title']; ?>">
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent/10 to-black/100 pointer-events-none"
                        style="background: linear-gradient(180deg, rgba(0, 0, 0, 0.00) 10.6%, #000 99.84%);">
                    </div>
                    <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/80 to-transparent md:p-7.5 p-4">
                        <div
                            class="px-2 py-1 bg-[#F9DC6B] text-[var(--color-main-green)] font-bold text-[10px] leading-[135%] tracking-[0.01em] inline-block mb-2">
                            <h2>
                                Blog
                            </h2>
                        </div>
                        <h3 class="text-white font-bold text-[18px] leading-[140%] tracking-[0.015em] mb-2">
                            <?php echo $mainFeatured['title']; ?>
                        </h3>

                        <p class="font-normal text-[14px] leading-[150%] tracking-[0.015em] text-[#ffffff] mt-auto">
                            Blog |
                            <?php echo date('F d, Y', strtotime($mainFeatured['created_at'])); ?>
                        </p>
                    </div>
                </a>
                <!-- <img src="<?php echo SITE_URL; ?>/assets/images/ui/case-study-banner.png" /> -->
            </div>

            <!-- Sub Featured Items (Row of 3) -->
            <div class="grid grid-cols-2 md:grid-cols-3 md:gap-8 gap-4 [&>:last-child]:hidden! 
            md:[&>:last-child]:grid!">
                <?php foreach ($subFeatured as $blog): ?>
                    <div class="swiper-slide grid! grid-rows-[auto_1fr_auto]!">

                        <div class="relative md:h-[240px] h-[184px] w-full rounded-[4px] overflow-hidden shrink-0 group/img">
                            <img src="<?php echo SITE_URL; ?>/assets/uploads/blog/<?php echo $blog['image']; ?>"
                                alt="Hero Image"
                                class="block h-full w-full object-center rounded-[4px] group-hover/img:scale-110 transition-transform duration-500"
                                loading="lazy">

                            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent/10 to-black/100 pointer-events-none"
                                style="background: linear-gradient(180deg, rgba(0, 0, 0, 0.00) 10.6%, #000 99.84%);">
                            </div>

                            <div class="absolute bottom-2 left-2">
                                <div
                                    class="px-2 py-1 bg-[#F9DC6B] text-[var(--color-main-green)] font-bold text-[10px] leading-[135%] tracking-[0.01em] inline-block mb-2">
                                    <h2>Blog</h2>
                                </div>
                                <h3
                                    class="text-white font-bold text-[12px] leading-[150%] tracking-[0.015em] mb-2 block md:hidden">
                                    <?php echo $blog['title']; ?>
                                </h3>
                            </div>
                        </div>

                        <div class="my-4 flex flex-col flex-1 hidden md:block">
                            <h2
                                class="font-bold md:text-lg md:leading-[140%] tracking-[0.015em] capitalize text-[#3B3B3B] mb-3 line-clamp-2">
                                <?php echo $blog['title']; ?>
                            </h2>
                            <p
                                class="font-normal text-[16px] leading-[150%] tracking-[0.015em] text-[#757575] mb-2 line-clamp-3">
                                <?php
                                $content = trim(preg_replace('/\s+/', ' ', strip_tags($blog['content'])));
                                echo mb_strlen($content) > 150 ? substr($content, 0, 150) . '...' : $content;
                                ?>
                            </p>
                            <p class="font-normal text-[14px] leading-[150%] tracking-[0.015em] text-[#A3A3A3] mt-auto">
                                Blog |
                                <?php echo date('F d, Y', strtotime($blog['created_at'])); ?>
                            </p>
                        </div>
                        <a href="<?php echo SITE_URL; ?>/blog/<?php echo $blog['slug']; ?>" class="group/btn
                    relative font-bold text-[18px] text-[#415C42] pb-2 w-fit
                    capitalize hover:text-main-green hidden md:inline-block">
                            Read Blog
                            <span
                                class="absolute bottom-0 left-0 w-full h-[2px] bg-[#F9DC6B] transform scale-x-0 group-hover/btn:scale-x-100 transition-transform duration-300 origin-left"></span>
                        </a>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>


</section>
<!-- All blogs Section -->
<section class="container md:pt-20 pt-12 md:pb-28 pb-20">
    <div class="py-3.5">
        <span
            class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
            RESOURCES
        </span>
        <div class="border-b-2 border-primary pb-1">
            <h2
                class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap md:whitespace-nowrap">
                All Blogs
            </h2>
        </div>
    </div>

    <!-- Filter Buttons -->
    <div class="flex justify-start items-center gap-4 md:pt-6 md:pb-8 pt-4 pb-4 overflow-x-auto">
        <button
            class="filter-btn h-12 px-8 md:px-12 py-3 bg-main-green rounded text-white text-[16px] leading-[150%] md:text-xl font-normal md:leading-7 tracking-tight transition-colors whitespace-nowrap"
            data-category="All">All Blogs</button>
        <button
            class="filter-btn h-12 px-8 md:px-12 py-3 bg-[#F5F5F5] rounded text-[#A3A3A3] text-[16px] leading-[150%] md:text-xl font-normal md:leading-7 tracking-tight transition-colors whitespace-nowrap"
            data-category="Industry information">Industry information</button>
        <button
            class="filter-btn h-12 px-8 md:px-12 py-3 bg-[#F5F5F5] rounded text-[#A3A3A3] text-[16px] leading-[150%] md:text-xl font-normal md:leading-7 tracking-tight transition-colors whitespace-nowrap"
            data-category="General management">General management</button>
        <button
            class="filter-btn h-12 px-8 md:px-12 py-3 bg-[#F5F5F5] rounded text-[#A3A3A3] text-[16px] leading-[150%] md:text-xl font-normal md:leading-7 tracking-tight transition-colors whitespace-nowrap"
            data-category="Discover">Discover</button>
        <button
            class="filter-btn h-12 px-8 md:px-12 py-3 bg-[#F5F5F5] rounded text-[#A3A3A3] text-[16px] leading-[150%] md:text-xl font-normal md:leading-7 tracking-tight transition-colors whitespace-nowrap"
            data-category="Technical concepts">Technical concepts</button>
    </div>

    <!-- Blog Grid (Paginated) -->
    <div id="blog-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 md:gap-8 gap-4 md:mb-12 mb-10">
        <?php foreach ($blogs as $blog): ?>
            <div class="swiper-slide grid! grid-rows-[auto_1fr_auto]!">

                <div class="relative h-[240px] w-full rounded-[4px] overflow-hidden shrink-0 group/img">
                    <img src="<?php echo SITE_URL; ?>/assets/uploads/blog/<?php echo $blog['image']; ?>" alt="Hero Image"
                        class="block h-full w-full object-center rounded-[4px] group-hover/img:scale-110 transition-transform duration-500"
                        loading="lazy">

                    <div
                        class="absolute bottom-2 left-2 px-2 py-1 bg-[#F9DC6B] text-[var(--color-main-green)] font-bold text-[10px] leading-[135%] tracking-[0.01em]">
                        <h2>
                            Blog
                        </h2>
                    </div>
                </div>

                <div class="my-4 flex flex-col flex-1">
                    <h2
                        class="font-bold text-lg leading-[140%] tracking-[0.015em] capitalize text-[#3B3B3B] mb-3 line-clamp-2">
                        <?php echo $blog['title']; ?>
                    </h2>
                    <p class="font-normal text-[16px] leading-[150%] tracking-[0.015em] text-[#757575] mb-2 line-clamp-3">
                        <?php
                        $content = trim(preg_replace('/\s+/', ' ', strip_tags($blog['content'])));
                        echo mb_strlen($content) > 150 ? substr($content, 0, 150) . '...' : $content;
                        ?>
                    </p>
                    <p class="font-normal text-[14px] leading-[150%] tracking-[0.015em] text-[#A3A3A3] mt-auto">
                        Blog |
                        <?php echo date('F d, Y', strtotime($blog['created_at'])); ?>
                    </p>
                </div>
                <a href="<?php echo SITE_URL; ?>/blog/<?php echo $blog['slug']; ?>" class="group/btn relative
                font-bold text-[18px] text-[#415C42] pb-2 inline-block w-fit
                capitalize hover:text-main-green">
                    Read Blog
                    <span
                        class="absolute bottom-0 left-0 w-full h-[2px] bg-[#F9DC6B] transform scale-x-0 group-hover/btn:scale-x-100 transition-transform duration-300 origin-left"></span>
                </a>

            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination Container -->
    <div id="pagination-container" class="flex md:justify-start justify-center items-center gap-4">
        <!-- Initial Pagination Render (Server Side) -->
        <?php if ($currentPage > 1): ?>
            <button onclick="changePage(<?php echo $currentPage - 1; ?>)"
                class="text-[#666666] font-base font-normal text-[18px] leading-[140%] tracking-[0.015em] flex items-center gap-2 hover:text-main-green">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M15 5L8 12L15 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>Prev
            </button>
        <?php else: ?>
            <button disabled
                class="text-gray-300 font-base font-normal text-[18px] flex items-center gap-2 cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M15 5L8 12L15 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>Prev
            </button>
        <?php endif; ?>

        <div class="flex items-center gap-2">
            <?php
            $range = [];
            if ($totalPages <= 7) {
                for ($i = 1; $i <= $totalPages; $i++)
                    $range[] = $i;
            } else {
                if ($currentPage <= 4) {
                    for ($i = 1; $i <= 5; $i++)
                        $range[] = $i;
                    $range[] = '...';
                    $range[] = $totalPages;
                } else if ($currentPage >= $totalPages - 3) {
                    $range[] = 1;
                    $range[] = '...';
                    for ($i = $totalPages - 4; $i <= $totalPages; $i++)
                        $range[] = $i;
                } else {
                    $range[] = 1;
                    $range[] = '...';
                    $range[] = $currentPage - 1;
                    $range[] = $currentPage;
                    $range[] = $currentPage + 1;
                    $range[] = '...';
                    $range[] = $totalPages;
                }
            }

            foreach ($range as $p) {
                if ($p === '...') {
                    echo '<span class="px-2 text-gray-400">...</span>';
                } else {
                    $activeClass = ($p == $currentPage) ? 'bg-[#F4C300] font-bold' : 'bg-[#FAE696] hover:bg-[#F4C300]';
                    $onclick = ($p == $currentPage) ? '' : 'onclick="changePage(' . $p . ')"';
                    echo "<button $onclick class=\"$activeClass rounded text-[#1A3B1B] w-8 h-8 flex items-center justify-center transition-colors\">$p</button>";
                }
            }
            ?>
        </div>

        <?php if ($currentPage < $totalPages): ?>
            <button onclick="changePage(<?php echo $currentPage + 1; ?>)"
                class="text-[#666666] font-base font-normal text-[18px] leading-[140%] tracking-[0.015em] flex items-center gap-2 hover:text-main-green">
                Next
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
        <?php else: ?>
            <button disabled
                class="text-gray-300 font-base font-normal text-[18px] flex items-center gap-2 cursor-not-allowed">
                Next
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
        <?php endif; ?>
    </div>
</section>

<!-- Define SITE_URL for JS if not already defined -->
<script>
    if (typeof SITE_URL === 'undefined') {
        window.SITE_URL = "<?php echo SITE_URL; ?>";
    }
</script>
<script src="<?php echo SITE_URL; ?>/assets/js/blog.js"></script>