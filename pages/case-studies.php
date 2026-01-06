<?php
$pageTitle = 'Case Studies';
// Initial load: Page 1, Limit 6, Category All
$initialData = getCaseStudiesWithPagination(1, 6, 'All');
$caseStudies = $initialData['caseStudies'];
$totalPages = $initialData['totalPages'];
$currentPage = $initialData['currentPage'];
?>

<section class="h-[60px] sticky top-0 z-10 bg-white"></section>

<section class="container py-20">


    <!-- Featured Case Studies Section -->
    <div class="py-12">
        <span class="text-b200 font-normal text-xs leading-[120%] tracking-[0.015em] uppercase">
            LATEST CONTENT
        </span>
        <div class="border-b border-primary pb-1 mb-8">
            <h2 class="text-main-green font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize md:whitespace-nowrap">
                Featured Case Studies
            </h2>
        </div>

        <?php 
        // Fetch top 4 for featured section
        $featuredData = getCaseStudiesWithPagination(1, 4, 'All'); 
        $featuredStudies = $featuredData['caseStudies'];
        
        if (!empty($featuredStudies)):
            $mainFeatured = $featuredStudies[0];
            $subFeatured = array_slice($featuredStudies, 1, 3);
        ?>
            <!-- Main Featured Item -->
            <div class="w-full relative mb-8 group cursor-pointer overflow-hidden rounded-lg">
                <a href="<?php echo SITE_URL; ?>/case-studies/<?= urlencode($mainFeatured["slug"]) ?>" class="block h-[400px] w-full">
                    <img src="<?php echo SITE_URL; ?>/assets/uploads/case_studies/<?php echo $mainFeatured['image']; ?>" 
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                        alt="<?php echo $mainFeatured['title']; ?>">
                    <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/80 to-transparent p-8">
                        <h3 class="text-white text-3xl font-bold mb-2"><?php echo $mainFeatured['title']; ?></h3>
                    </div>
                </a>
            </div>

            <!-- Sub Featured Items (Row of 3) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <?php foreach ($subFeatured as $study): ?>
                    <div class="group flex flex-col h-full">
                        <div class="relative h-[200px] overflow-hidden rounded-lg mb-4">
                            <img src="<?php echo SITE_URL; ?>/assets/uploads/case_studies/<?php echo $study['image']; ?>"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                alt="<?php echo $study['title']; ?>" loading="lazy">
                            <div class="absolute bottom-2 left-2 px-2 py-1 bg-[#F4C300] text-[#1A3B1B] font-bold text-[10px] uppercase">
                                Case Study
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-[#1A3B1B] mb-2 leading-tight group-hover:text-[#415C42] transition-colors">
                            <?php echo $study['title']; ?>
                        </h3>
                        <p class="text-[#757575] text-sm line-clamp-3 mb-3">
                            <?php 
                            $intro = trim(preg_replace('/\s+/', ' ', strip_tags($study['introduction'])));
                            echo mb_strlen($intro) > 100 ? substr($intro, 0, 100) . '...' : $intro;
                            ?>
                        </p>
                        <div class="mt-auto">
                            <span class="text-xs text-[#A3A3A3] block mb-1">Case study | <?php echo date('F d, Y', strtotime($study['created_at'])); ?></span>
                            <a href="<?php echo SITE_URL; ?>/case-studies/<?= urlencode($study["slug"]) ?>" class="text-[#1A3B1B] font-bold text-sm hover:underline">Read Case Study</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- All Case Studies Section -->
    <div class="py-3.5">
        <span class="text-b200 font-normal text-xs leading-[120%] tracking-[0.015em] uppercase">
            RESOURCES
        </span>
        <div class="border-b border-primary pb-1">
            <h2 class="text-main-green font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize md:whitespace-nowrap">
                All Case Studies
            </h2>
        </div>
    </div>

    <!-- Filter Buttons -->
    <div class="flex justify-start items-center gap-4 pt-6 pb-8 overflow-x-auto">
        <button
            class="filter-btn h-12 px-12 py-3 bg-main-green rounded text-white text-xl font-normal leading-7 tracking-tight transition-colors whitespace-nowrap"
            data-category="All">All Case Studies</button>
        <button
            class="filter-btn h-12 px-12 py-3 bg-[#F5F5F5] rounded text-[#A3A3A3] text-xl font-normal leading-7 tracking-tight transition-colors whitespace-nowrap"
            data-category="Industry information">Industry information</button>
        <button
            class="filter-btn h-12 px-12 py-3 bg-[#F5F5F5] rounded text-[#A3A3A3] text-xl font-normal leading-7 tracking-tight transition-colors whitespace-nowrap"
            data-category="General management">General management</button>
        <button
            class="filter-btn h-12 px-12 py-3 bg-[#F5F5F5] rounded text-[#A3A3A3] text-xl font-normal leading-7 tracking-tight transition-colors whitespace-nowrap"
            data-category="Discover">Discover</button>
        <button
            class="filter-btn h-12 px-12 py-3 bg-[#F5F5F5] rounded text-[#A3A3A3] text-xl font-normal leading-7 tracking-tight transition-colors whitespace-nowrap"
            data-category="Technical concepts">Technical concepts</button>
    </div>

    <!-- Case Studies Grid (Paginated) -->
    <div id="blog-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        <?php foreach ($caseStudies as $study): ?>
            <div class="group flex flex-col h-full">
                <!-- Image -->
                <div class="relative h-[240px] overflow-hidden rounded-lg mb-4">
                    <img src="<?php echo SITE_URL; ?>/assets/uploads/case_studies/<?php echo $study['image']; ?>"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        alt="<?php echo $study['title']; ?>" loading="lazy">
                    <div class="absolute bottom-2 left-2 px-2 py-1 bg-[#F4C300] text-[#1A3B1B] font-bold text-[10px] uppercase">
                        Case Study
                    </div>
                </div>

                <!-- Content -->
                <div class="flex flex-col flex-1">
                    <h3 class="text-xl font-bold text-[#1A3B1B] mb-3 leading-tight group-hover:text-[#415C42] transition-colors">
                        <?php echo $study['title']; ?>
                    </h3>

                    <p class="text-[#757575] text-sm leading-relaxed mb-4 line-clamp-3">
                        <?php 
                        $intro = trim(preg_replace('/\s+/', ' ', strip_tags($study['introduction'])));
                        echo mb_strlen($intro) > 150 ? substr($intro, 0, 150) . '...' : $intro;
                        ?>
                    </p>

                    <div class="mt-auto">
                         <span class="text-xs text-[#A3A3A3] block mb-1">Case study | <?php echo date('F d, Y', strtotime($study['created_at'])); ?></span>
                        <a href="<?php echo SITE_URL; ?>/case-studies/<?= urlencode($study["slug"]) ?>" class="text-[#1A3B1B] font-bold text-sm hover:underline">Read Case Study</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination Container -->
    <div id="pagination-container" class="mb-12 flex justify-start gap-4">
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
<script src="<?php echo SITE_URL; ?>/assets/js/case-studies.js"></script>