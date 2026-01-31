<?php
$pageTitle = 'Events';
// Initial load: Page 1, Limit 6, Category All
$initialData = getEventsWithPagination(1, 6, 'All');
$blogs = $initialData['blogs'];
$totalPages = $initialData['totalPages'];
$currentPage = $initialData['currentPage'];

// Fetch latest event
$latestEvent = getLatestEvent();
$industries = getCategoryByParent("2"); // Fetch industries for the dropdown
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
            <a href="<?php echo SITE_URL; ?>/newsroom" class="text-[#A3A3A3] font-light">Newsroom</a>
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>
            <a href="#" class="text-[#575757] font-bold pointer-events-none">Events</a>
        </nav>
        <div class="py-3.5">
            <span
                class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                News & Beyond Business
            </span>
            <div class="border-b-2 border-primary pb-1">
                <h2
                    class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap md:whitespace-nowrap">
                    Events
                </h2>
            </div>
        </div>

        <!-- Filter Buttons -->
        <div class="flex justify-start items-center gap-4 pt-6 pb-8 overflow-x-auto no-scrollbar">
            <button
                class="filter-btn h-12 px-12 py-3 bg-main-green rounded text-white text-xl font-normal leading-7 tracking-tight transition-colors whitespace-nowrap"
                data-category="All">All</button>
            <button
                class="filter-btn h-12 px-12 py-3 bg-[#F5F5F5] rounded text-[#A3A3A3] text-xl font-normal leading-7 tracking-tight transition-colors whitespace-nowrap"
                data-category="Exhibitions">Exhibitions</button>
            <button
                class="filter-btn h-12 px-12 py-3 bg-[#F5F5F5] rounded text-[#A3A3A3] text-xl font-normal leading-7 tracking-tight transition-colors whitespace-nowrap"
                data-category="Events">Events</button>
            <button
                class="filter-btn h-12 px-12 py-3 bg-[#F5F5F5] rounded text-[#A3A3A3] text-xl font-normal leading-7 tracking-tight transition-colors whitespace-nowrap"
                data-category="News">News</button>
            <button
                class="filter-btn h-12 px-12 py-3 bg-[#F5F5F5] rounded text-[#A3A3A3] text-xl font-normal leading-7 tracking-tight transition-colors whitespace-nowrap"
                data-category="Beyond Business">Beyond business</button>
        </div>
        <?php if ($latestEvent): ?>
            <div id="latest-event-block" class="flex flex-col md:flex-row items-stretch overflow-hidden">
                <div class="relative w-full md:w-[437px] md:h-[280px] h-[238px] shrink-0">
                    <img src="<?php echo SITE_URL; ?>/assets/uploads/events/<?php echo $latestEvent['image']; ?>"
                        alt="<?php echo htmlspecialchars($latestEvent['title']); ?>" class="w-full h-full object-cover" />
                </div>

                <div
                    class="md:px-[50px] md:py-[36px] px-[24px] py-[24px] bg-[#F5F5F5] flex flex-col justify-center flex-grow">

                    <h2
                        class="text-[#1A3B1B] font-base font-normal md:text-[32px] md:leading-[120%] text-[24px] font-normal leading-[135%] capitalize mb-4">
                        <?php echo htmlspecialchars($latestEvent['title']); ?>
                    </h2>

                    <div
                        class="text-[#3B3B3B] font-base font-normal md:text-[16px] md:leading-[150%] text-[14px] leading-[150%] tracking-[0.015em] mb-2">
                        <?php
                        $desc = trim(preg_replace('/\s+/', ' ', strip_tags($latestEvent['description'])));
                        echo mb_strimwidth($desc, 0, 200, '...');
                        ?>
                    </div>
                    <p
                        class="text-[#3B3B3B] font-base font-normal md:text-[16px] md:leading-[150%] text-[14px] leading-[150%] tracking-[0.015em] mb-6">
                        Date: <?php echo date('d/m/Y', strtotime($latestEvent['event_date'])); ?>
                    </p>
                    <div class="flex flex-wrap items-center md:gap-4 gap-2 justify-start">
                        <button type="button" onclick="openContactModal('Contact')"
                            class="h-[48px] px-6 flex items-center justify-center bg-[#1A3B1B] text-white font-base font-normal text-[16px] leading-none rounded-full border-2 border-[#1A3B1B] cursor-pointer button-hover-vertical box-border">
                            Contact the team
                        </button>

                        <button type="button" onclick="openRegisterModal()"
                            class="h-[48px] px-6 flex items-center justify-center text-[#1A3B1B] border-2 border-[#1A3B1B] font-base font-normal text-[16px] leading-none rounded-full cursor-pointer button-hover-vertical box-border">
                            Register
                        </button>
                    </div>
                </div>

            </div>
        <?php endif; ?>
        <div class="md:mt-8 mb-10 swiper newsSwiper">
            <!-- Blog Container -->
            <div id="blog-container"
                class="swiper-wrapper md:!grid md:grid-cols-3 md:gap-10 transition-opacity duration-300">
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
                                    <?php echo $blog['category_name'] ?: 'General'; ?>
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
                                echo mb_strlen($content) > 150 ? substr($content, 0, 150) . '...' : $content;
                                ?>
                            </p>
                            <p class="font-normal text-[14px] leading-[150%] tracking-[0.015em] text-[#A3A3A3] mt-auto">
                                <?php echo $blog['category_name'] ?: 'General'; ?> |
                                <?php echo date('F d, Y', strtotime($blog['created_at'])); ?>
                            </p>
                        </div>
                        <a href="<?php echo SITE_URL; ?>/events/<?= $blog["slug"] ?? '' ?>" class="group/btn relative font-bold text-[18px] text-[#415C42] pb-2 inline-block w-fit
                        capitalize hover:text-main-green">
                            Read
                            <?php echo $blog['category_name'] ?: 'Article'; ?>
                            <span
                                class="absolute bottom-0 left-0 w-full h-[2px] bg-[var(--color-primary)] transform scale-x-0 group-hover/btn:scale-x-100 transition-transform duration-300 origin-left"></span>
                        </a>

                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Pagination Container -->
        <div id="pagination-container" class="mb-12 flex md:justify-start justify-center items-center gap-4">
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
</div>

<!-- Define SITE_URL for JS if not already defined -->
<script>
    if (typeof SITE_URL === 'undefined') {
        window.SITE_URL = "<?php echo SITE_URL; ?>";
    }
</script>
<script src="<?php echo SITE_URL; ?>/assets/js/events.js"></script>

<!-- Contact Modal -->
<div id="contactModal" class="fixed inset-0 z-[9999] hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeContactModal()"></div>

    <!-- Modal Content -->
    <div
        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-[600px] h-auto max-h-[90vh] overflow-y-auto bg-white rounded-lg shadow-xl p-5">
        <div class="flex justify-between items-center mb-5">
            <h2 class="text-[#1A3B1B] font-bold text-[24px] leading-tight">Get in Touch</h2>
            <button onclick="closeContactModal()" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <form id="contactForm" method="POST" action="" class="space-y-4" novalidate>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Name -->
                <div class="flex flex-col">
                    <input type="text" name="name" required placeholder="Name"
                        class="flex w-full px-4 py-3 items-center rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none focus:border-main-green transition-colors">
                    <span class="error-text hidden text-xs text-red-500 mt-1">Name is required</span>
                </div>

                <!-- Email -->
                <div class="flex flex-col">
                    <input type="email" name="email" required placeholder="Email"
                        class="flex w-full px-4 py-3 items-center rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none focus:border-main-green transition-colors">
                    <span class="error-text hidden text-xs text-red-500 mt-1">Valid email is required</span>
                </div>

                <!-- Phone -->
                <div class="flex flex-col">
                    <input type="tel" name="contact" required placeholder="+91 Phone"
                        class="flex w-full px-4 py-3 items-center rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none focus:border-main-green transition-colors">
                    <span class="error-text hidden text-xs text-red-500 mt-1">Valid phone number is required</span>
                </div>

                <!-- Company -->
                <div class="flex flex-col">
                    <input type="text" name="company_name" required placeholder="Company Name"
                        class="flex w-full px-4 py-3 items-center rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none focus:border-main-green transition-colors">
                    <span class="error-text hidden text-xs text-red-500 mt-1">Company name is required</span>
                </div>
            </div>

            <!-- Subject -->
            <div class="flex flex-col">
                <input type="text" name="subject" id="modalSubject" required placeholder="Subject"
                    class="flex w-full px-4 py-3 items-center rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none focus:border-main-green transition-colors">
                <span class="error-text hidden text-xs text-red-500 mt-1">Subject is required</span>
            </div>

            <!-- Message -->
            <div class="flex flex-col">
                <textarea name="message" required placeholder="Write your message here" rows="4"
                    class="flex w-full px-4 py-3 items-center rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none focus:border-main-green transition-colors"></textarea>
                <span class="error-text hidden text-xs text-red-500 mt-1">Message is required</span>
            </div>

            <div id="contactResponse" class="hidden p-4 rounded text-center text-sm font-medium"></div>

            <div class="text-center pt-2">
                <button type="submit" id="submitBtn"
                    class="bg-main-green text-white font-bold text-[16px] md:text-[18px] w-full py-3 rounded-full text-center cursor-pointer hover:bg-[#334d34] transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    Send Message
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Event Registration Modal -->
<div id="registerModal" class="fixed inset-0 z-[9999] hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeRegisterModal()"></div>

    <!-- Modal Content -->
    <div
        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-[800px] h-auto max-h-[90vh] overflow-y-auto bg-white rounded-lg shadow-xl p-5">
        <div class="flex justify-between items-center mb-5">
            <h2 class="text-[#1A3B1B] font-bold text-[24px] leading-tight">Event Registration</h2>
            <button onclick="closeRegisterModal()" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <div class="mb-2 flex items-center gap-2">
            <span class="text-sm text-gray-600">Registering for:</span>
            <h3 class="text-lg font-bold text-[#1A3B1B]" id="registerEventTitle"></h3>
        </div>

        <form id="registerForm" method="POST" action="" class="space-y-6" novalidate>
            <input type="hidden" name="event_title" id="formEventTitle">

            <!-- Section 1: Attendee details -->
            <div>
                <h3 class="text-[#1A3B1B] font-bold text-lg mb-3 border-b pb-1">Attendee Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Full Name -->
                    <div class="flex flex-col">
                        <input type="text" name="full_name" required placeholder="Full Name"
                            class="flex w-full px-4 py-3 items-center rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none focus:border-main-green transition-colors">
                        <span class="error-text hidden text-xs text-red-500 mt-1">Full Name is required</span>
                    </div>

                    <!-- Work Email -->
                    <div class="flex flex-col">
                        <input type="email" name="email" required placeholder="Work Email"
                            class="flex w-full px-4 py-3 items-center rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none focus:border-main-green transition-colors">
                        <span class="error-text hidden text-xs text-red-500 mt-1">Valid Work Email is required</span>
                    </div>

                    <!-- Mobile Number -->
                    <div class="flex flex-col">
                        <input type="tel" name="mobile" required placeholder="Mobile Number"
                            class="flex w-full px-4 py-3 items-center rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none focus:border-main-green transition-colors">
                        <span class="error-text hidden text-xs text-red-500 mt-1">Valid Mobile Number is required</span>
                    </div>

                    <!-- Company Name -->
                    <div class="flex flex-col">
                        <input type="text" name="company_name" required placeholder="Company Name"
                            class="flex w-full px-4 py-3 items-center rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none focus:border-main-green transition-colors">
                        <span class="error-text hidden text-xs text-red-500 mt-1">Company Name is required</span>
                    </div>

                    <!-- Job Title -->
                    <div class="flex flex-col">
                        <input type="text" name="job_title" required placeholder="Job Title / Designation"
                            class="flex w-full px-4 py-3 items-center rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none focus:border-main-green transition-colors">
                        <span class="error-text hidden text-xs text-red-500 mt-1">Job Title is required</span>
                    </div>

                    <!-- City and State -->
                    <div class="flex flex-col">
                        <input type="text" name="city_state" required placeholder="City and State"
                            class="flex w-full px-4 py-3 items-center rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none focus:border-main-green transition-colors">
                        <span class="error-text hidden text-xs text-red-500 mt-1">City and State is required</span>
                    </div>
                </div>
            </div>

            <!-- Section 2: Company & relationship -->
            <div>
                <h3 class="text-[#1A3B1B] font-bold text-lg mb-3 border-b pb-1">Company & Relationship</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Industry / Segment -->
                    <div class="flex flex-col">
                        <select name="industry"
                            class="flex w-full px-4 py-3 items-center rounded-[4px] border border-[#DEDEDE] bg-[#FFF] text-[#757575] focus:outline-none focus:border-main-green transition-colors appearance-none bg-no-repeat bg-[right_1rem_center]"
                            style="background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23333%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><polyline points=%226 9 12 15 18 9%22></polyline></svg>');">
                            <option value="">Select Industry / Segment</option>
                            <?php foreach ($industries as $industryOption): ?>
                                <option value="<?php echo htmlspecialchars($industryOption['mcat_name']); ?>">
                                    <?php echo htmlspecialchars($industryOption['mcat_name']); ?>
                                </option>
                            <?php endforeach; ?>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Company Size -->
                    <div class="flex flex-col">
                        <select name="company_size"
                            class="flex w-full px-4 py-3 items-center rounded-[4px] border border-[#DEDEDE] bg-[#FFF] text-[#757575] focus:outline-none focus:border-main-green transition-colors appearance-none bg-no-repeat bg-[right_1rem_center]"
                            style="background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23333%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><polyline points=%226 9 12 15 18 9%22></polyline></svg>');">
                            <option value="">Select Company Size</option>
                            <option value="1-50">1-50 employees</option>
                            <option value="51-200">51-200 employees</option>
                            <option value="201-500">201-500 employees</option>
                            <option value="500+">500+ employees</option>
                        </select>
                    </div>

                    <!-- Relationship -->
                    <div class="flex flex-col md:col-span-2">
                        <select name="relationship"
                            class="flex w-full px-4 py-3 items-center rounded-[4px] border border-[#DEDEDE] bg-[#FFF] text-[#757575] focus:outline-none focus:border-main-green transition-colors appearance-none bg-no-repeat bg-[right_1rem_center]"
                            style="background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23333%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><polyline points=%226 9 12 15 18 9%22></polyline></svg>');">
                            <option value="">Relationship with MOSIL</option>
                            <option value="Existing Customer">Existing Customer</option>
                            <option value="New Customer">New Customer (First time)</option>
                            <option value="Partner/Distributor">Partner / Distributor</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 3: Event preferences -->
            <div>
                <h3 class="text-[#1A3B1B] font-bold text-lg mb-3 border-b pb-1">Event Preferences</h3>
                <div class="grid grid-cols-1 gap-4">
                    <!-- Number of attendees -->
                    <div class="flex flex-col">
                        <select name="attendees_count"
                            class="flex w-full px-4 py-3 items-center rounded-[4px] border border-[#DEDEDE] bg-[#FFF] text-[#757575] focus:outline-none focus:border-main-green transition-colors appearance-none bg-no-repeat bg-[right_1rem_center]"
                            style="background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23333%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><polyline points=%226 9 12 15 18 9%22></polyline></svg>');">
                            <option value="1">Number of attendees: 1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5+">5+</option>
                        </select>
                    </div>

                    <!-- Areas of interest (Multi-select checkbox) -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-700 mb-2">Areas of interest *</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="areas_of_interest[]" value="Lubrication Solutions"
                                    class="w-4 h-4 text-main-green border-gray-300 rounded focus:ring-main-green">
                                <span class="text-sm text-gray-600">Lubrication Solutions</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="areas_of_interest[]" value="Industry Trends"
                                    class="w-4 h-4 text-main-green border-gray-300 rounded focus:ring-main-green">
                                <span class="text-sm text-gray-600">Industry Trends</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="areas_of_interest[]" value="Networking"
                                    class="w-4 h-4 text-main-green border-gray-300 rounded focus:ring-main-green">
                                <span class="text-sm text-gray-600">Networking</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="areas_of_interest[]" value="Product Knowledge"
                                    class="w-4 h-4 text-main-green border-gray-300 rounded focus:ring-main-green">
                                <span class="text-sm text-gray-600">Product Knowledge</span>
                            </label>
                        </div>
                        <span class="error-text hidden text-xs text-red-500 mt-1">Select at least one area</span>
                    </div>

                    <!-- How did you hear about this event -->
                    <div class="flex flex-col">
                        <select name="hear_about_source"
                            class="flex w-full px-4 py-3 items-center rounded-[4px] border border-[#DEDEDE] bg-[#FFF] text-[#757575] focus:outline-none focus:border-main-green transition-colors appearance-none bg-no-repeat bg-[right_1rem_center]"
                            style="background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23333%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><polyline points=%226 9 12 15 18 9%22></polyline></svg>');">
                            <option value="">How did you hear about this event?</option>
                            <option value="LinkedIn">LinkedIn</option>
                            <option value="Email">Email Invite</option>
                            <option value="Website">MOSIL Website</option>
                            <option value="Colleague">Colleague / Friend</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 5: Consent -->
            <div class="pt-2">
                <div class="flex flex-col gap-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="consent_terms" required
                            class="w-4 h-4 text-main-green border-gray-300 rounded focus:ring-main-green shrink-0">
                        <span class="text-xs text-gray-600">
                            I agree to the Terms & Conditions and Privacy Policy. <span class="text-red-500">*</span>
                        </span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="consent_updates"
                            class="w-4 h-4 text-main-green border-gray-300 rounded focus:ring-main-green shrink-0">
                        <span class="text-xs text-gray-600">
                            I agree to receive event‑related updates and product communication.
                        </span>
                    </label>
                </div>
            </div>

            <div id="registerResponse" class="hidden p-4 rounded text-center text-sm font-medium"></div>

            <div class="text-center pt-2">
                <button type="submit" id="registerSubmitBtn"
                    class="bg-main-green text-white font-bold text-[16px] md:text-[18px] w-full py-3 rounded-full text-center cursor-pointer hover:bg-[#334d34] transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    Register Now
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openContactModal(type) {
        document.getElementById('contactModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling

        const subjectInput = document.getElementById('modalSubject');
        // Safely get title handling potential quotes
        const latestEventTitle = <?php echo json_encode($latestEvent ? $latestEvent['title'] : ''); ?>;

        if (type === 'Contact' && latestEventTitle) {
            subjectInput.value = 'Enquiry regarding: ' + latestEventTitle;
        } else {
            subjectInput.value = 'General Enquiry';
        }
    }

    function closeContactModal() {
        document.getElementById('contactModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    function openRegisterModal() {
        document.getElementById('registerModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        const latestEventTitle = <?php echo json_encode($latestEvent ? $latestEvent['title'] : 'Event'); ?>;
        document.getElementById('registerEventTitle').textContent = latestEventTitle;
        document.getElementById('formEventTitle').value = latestEventTitle;
    }

    function closeRegisterModal() {
        document.getElementById('registerModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Modal Form Logic (Reused from contact.php)
    document.addEventListener('DOMContentLoaded', () => {
        // --- Register Form Logic ---
        const registerForm = document.getElementById('registerForm');
        if (registerForm) {
            // Select inputs that are required for real-time validation feedback
            const registerInputs = registerForm.querySelectorAll('input[required], select[required]');

            const validateRegisterField = (input) => {
                if (input.type === 'checkbox') {
                    if (input.required && !input.checked) {
                        // For checkboxes, maybe just visual cue if needed, but browser handles required attribute well.
                        // But we want custom error logic potentially.
                        // For now, let's skip strict "on blur" error for checkbox to avoid annoyance, 
                        // but we check it on submit.
                        return input.checked;
                    }
                    return true;
                }

                const type = input.name === 'email' ? 'email' : (input.name === 'mobile' ? 'tel' : 'default');
                const validators = {
                    email: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
                    tel: (value) => /^[0-9+\-\s]{10,}$/.test(value),
                    default: (value) => value.trim().length > 0
                };

                const isValid = validators[type] ? validators[type](input.value) : validators['default'](input.value);
                const wrapper = input.closest('.flex-col');
                const errorMsg = wrapper ? wrapper.querySelector('.error-text') : null;

                if (!isValid) {
                    input.classList.add('border-red-500', 'border-2');
                    if (errorMsg) errorMsg.classList.remove('hidden');
                } else {
                    input.classList.remove('border-red-500', 'border-2');
                    if (errorMsg) errorMsg.classList.add('hidden');
                }
                return isValid;
            };

            registerInputs.forEach(input => {
                if (input.type === 'hidden' || input.type === 'checkbox') return;
                input.addEventListener('blur', () => {
                    if (input.value.trim() !== '') validateRegisterField(input);
                });
                input.addEventListener('input', () => {
                    if (input.classList.contains('border-red-500')) {
                        input.classList.remove('border-red-500', 'border-2');
                        const wrapper = input.closest('.flex-col');
                        const errorMsg = wrapper ? wrapper.querySelector('.error-text') : null;
                        if (errorMsg) errorMsg.classList.add('hidden');
                    }
                });
            });

            registerForm.addEventListener('submit', function (e) {
                e.preventDefault();
                let isFormValid = true;

                // Validate all required inputs
                registerInputs.forEach(input => {
                    // Special check for checkbox
                    if (input.type === 'checkbox' && input.required && !input.checked) {
                        isFormValid = false;
                        // Shake or highlight?
                        const wrapper = input.closest('label');
                        if (wrapper) wrapper.classList.add('text-red-500');
                    } else if (input.type !== 'hidden' && input.type !== 'checkbox') {
                        if (!validateRegisterField(input)) isFormValid = false;
                    }
                });

                if (!isFormValid) {
                    // Remove checkbox red error on click
                    const checkboxes = registerForm.querySelectorAll('input[type="checkbox"][required]');
                    checkboxes.forEach(cb => {
                        cb.addEventListener('change', function () {
                            if (this.checked) this.closest('label').classList.remove('text-red-500');
                        }, { once: true });
                    });
                    return;
                }

                const btn = document.getElementById('registerSubmitBtn');
                const responseDiv = document.getElementById('registerResponse');
                const formData = new FormData(registerForm);

                btn.disabled = true;
                btn.textContent = 'Registering...';
                btn.classList.add('opacity-75');
                responseDiv.classList.add('hidden');

                fetch('<?php echo SITE_URL; ?>/ajax/event_register.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showRegisterResponse(data.message === 'success' ? 'Registration successful! Check your email.' : data.message, 'success');
                            registerForm.reset();
                            // Reset hidden field value if reset clears it
                            const latestEventTitle = <?php echo json_encode($latestEvent ? $latestEvent['title'] : 'Event'); ?>;
                            document.getElementById('formEventTitle').value = latestEventTitle;

                            registerInputs.forEach(i => i.classList.remove('border-red-500', 'border-2'));
                            document.querySelectorAll('.error-text').forEach(el => el.classList.add('hidden'));
                            document.querySelectorAll('input[type="checkbox"][required]').forEach(cb => cb.closest('label').classList.remove('text-red-500'));

                            setTimeout(closeRegisterModal, 3000);
                        } else {
                            showRegisterResponse(data.message || 'Error registering. Please try again.', 'error');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        showRegisterResponse('An unexpected error occurred.', 'error');
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.textContent = 'Register Now';
                        btn.classList.remove('opacity-75');
                    });

                function showRegisterResponse(msg, type) {
                    responseDiv.textContent = msg;
                    responseDiv.classList.remove('hidden', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700');
                    if (type === 'success') {
                        responseDiv.classList.add('bg-green-100', 'text-green-700');
                    } else {
                        responseDiv.classList.add('bg-red-100', 'text-red-700');
                    }
                }
            });
        }

        // --- Contact Form Logic ---
        const form = document.getElementById('contactForm');
        const inputs = form.querySelectorAll('input, textarea');

        // Validation Functions
        const validators = {
            email: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
            tel: (value) => /^[0-9+\-\s]{10,}$/.test(value),
            default: (value) => value.trim().length > 0
        };

        const validateField = (input) => {
            const type = input.name === 'email' ? 'email' : (input.name === 'contact' ? 'tel' : 'default');
            const isValid = validators[type](input.value);
            const wrapper = input.parentElement;
            const errorMsg = wrapper.querySelector('.error-text');

            if (!isValid) {
                input.classList.add('border-red-500', 'border-2'); // Added border-2 for visibility
                if (errorMsg) errorMsg.classList.remove('hidden');
            } else {
                input.classList.remove('border-red-500', 'border-2');
                if (errorMsg) errorMsg.classList.add('hidden');
            }
            return isValid;
        };

        // Event Listeners
        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                if (input.value.trim() !== '') {
                    validateField(input);
                }
            });

            input.addEventListener('input', () => {
                if (input.classList.contains('border-red-500')) {
                    input.classList.remove('border-red-500', 'border-2');
                    const wrapper = input.parentElement;
                    const errorMsg = wrapper.querySelector('.error-text');
                    if (errorMsg) errorMsg.classList.add('hidden');
                }
            });
        });

        // Form Submission
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            let isFormValid = true;
            inputs.forEach(input => {
                if (!validateField(input)) {
                    isFormValid = false;
                }
            });

            if (!isFormValid) return;

            const btn = document.getElementById('submitBtn');
            const responseDiv = document.getElementById('contactResponse');
            const formData = new FormData(form);

            // Disable UI
            btn.disabled = true;
            btn.textContent = 'Sending...';
            btn.classList.add('opacity-75'); // Visual feedback
            responseDiv.classList.add('hidden');

            fetch('<?php echo SITE_URL; ?>/ajax/contact.php', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showResponse(data.message === 'success' ? 'Thank you! Your message has been sent successfully.' : data.message, 'success');
                        form.reset();
                        inputs.forEach(i => i.classList.remove('border-red-500', 'border-2'));
                        setTimeout(closeContactModal, 3000); // Auto close after success
                    } else {
                        showResponse(data.message || 'Something went wrong. Please try again.', 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    showResponse('An unexpected error occurred. Please try again later.', 'error');
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.textContent = 'Send Message';
                    btn.classList.remove('opacity-75');
                });

            function showResponse(msg, type) {
                responseDiv.textContent = msg;
                responseDiv.classList.remove('hidden', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700');
                if (type === 'success') {
                    responseDiv.classList.add('bg-green-100', 'text-green-700');
                } else {
                    responseDiv.classList.add('bg-red-100', 'text-red-700');
                }
            }
        });
    });
</script>