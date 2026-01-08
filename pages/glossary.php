<section class="relative w-full h-[748px] md:h-[480px] overflow-hidden">
    <div class="absolute inset-0 z-0 w-full h-full">
        <img src="<?php echo SITE_URL; ?>/assets/images/banners/about-us.png" alt="Career"
            class="hidden md:block w-full h-full object-cover object-[50%_75%]" fetchpriority="high">

        <img src="<?php echo SITE_URL; ?>/assets/images/banners/glossary-banner-mb.png" alt="Career"
            class="block md:hidden w-full h-full object-cover object-center" fetchpriority="high">
    </div>
    <div class="container relative z-20 flex items-end justify-start w-full h-full pb-4 md:pb-10">
        <h2
            class="text-white font-base font-normal text-[32px] md:text-[48px] leading-[120%] tracking-normal capitalize">
            Know your lubrications
        </h2>
    </div>
</section>

<section class="">
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
            <a href="<?php echo SITE_URL; ?>/newsroom" class="text-[#A3A3A3] font-light">Newsroom</a>
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>
            <a href="<?php echo SITE_URL; ?>/glossary" class="text-[#575757] font-bold">Glossary</a>
        </nav>
        <div class="flex flex-col gap-6 border-b border-[#DEDEDE] pb-2 md:border-none md:pb-0">
            <div class="flex justify-between gap-4 items-center">
                <span class="text-[#1A3B1B] font-base font-normal text-[28px] leading-[135%] capitalize">
                    Glossary
                </span>

                <div class="w-60 h-10 max-w-[720px] rounded-3xl border border-[#757575] relative">

                    <input type="text"
                        class="justify-center text-sm text-[#757575] font-normal leading-5 tracking-tight py-1.5 w-full outline-none px-5 pr-10 h-full placeholder-[#757575]"
                        name="search" placeholder="search keyword">
                    <div class="w-4 h-4 right-4 top-1/2 -translate-y-1/2 absolute overflow-hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                            <path
                                d="M13.8833 14.875L9.42083 10.4125C9.06667 10.6958 8.65937 10.9201 8.19896 11.0854C7.73854 11.2507 7.24861 11.3333 6.72917 11.3333C5.44236 11.3333 4.3533 10.8877 3.46198 9.99635C2.57066 9.10503 2.125 8.01597 2.125 6.72917C2.125 5.44236 2.57066 4.3533 3.46198 3.46198C4.3533 2.57066 5.44236 2.125 6.72917 2.125C8.01597 2.125 9.10503 2.57066 9.99635 3.46198C10.8877 4.3533 11.3333 5.44236 11.3333 6.72917C11.3333 7.24861 11.2507 7.73854 11.0854 8.19896C10.9201 8.65937 10.6958 9.06667 10.4125 9.42083L14.875 13.8833L13.8833 14.875ZM6.72917 9.91667C7.61458 9.91667 8.36719 9.60677 8.98698 8.98698C9.60677 8.36719 9.91667 7.61458 9.91667 6.72917C9.91667 5.84375 9.60677 5.09115 8.98698 4.47135C8.36719 3.85156 7.61458 3.54167 6.72917 3.54167C5.84375 3.54167 5.09115 3.85156 4.47135 4.47135C3.85156 5.09115 3.54167 5.84375 3.54167 6.72917C3.54167 7.61458 3.85156 8.36719 4.47135 8.98698C5.09115 9.60677 5.84375 9.91667 6.72917 9.91667Z"
                                fill="#757575" />
                        </svg>
                    </div>

                </div>
            </div>
            <div
                class="p-5 md:inline-flex justify-center items-center gap-2 overflow-hidden rounded-[4px] border border-[#DEDEDE] bg-[#FFFFFF] hidden">
                <?php
                $letters = range('A', 'Z');
                foreach ($letters as $letter) { ?>
                    <button type="button"
                        class="letter-btn w-10 h-10 px-3 py-1.5 bg-[#F5F5F5] rounded-sm text-[#A3A3A3] hover:bg-gray-200 transition-colors"
                        data-letter="<?php echo $letter; ?>">
                        <?php echo $letter; ?>
                    </button>
                <?php } ?>
            </div>
        </div>
        <div class="py-6 flex gap-2 items-start justify-start">
            <div
                class="inline-flex flex-col md:hidden justify-center items-center gap-2 overflow-hidden rounded-[4px] bg-[#FFFFFF] ">
                <?php
                $letters = range('A', 'Z');
                foreach ($letters as $letter) { ?>
                    <button type="button"
                        class="letter-btn w-10 h-10 px-3 py-1.5 bg-[#F5F5F5] rounded-sm text-[#A3A3A3] hover:bg-gray-200 transition-colors"
                        data-letter="<?php echo $letter; ?>">
                        <?php echo $letter; ?>
                    </button>
                <?php } ?>
            </div>
            <div class="flex-1">
                <div id="glossary-grid" class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-5">
                    <!-- Content will be injected via JS -->
                    <!-- Placeholder shimmer or loading text can go here -->
                </div>
                <div id="load-more-container" class="mx-auto text-center" style="display: none;">
                    <button id="load-more-btn"
                        class="text-[#1A3B1B] text-center font-base font-bold text-[18px] leading-[120%] tracking-[0.01em] px-5 py-3 rounded-full bg-[#F5F5F5] button-hover-vertical transition-all border-2 border-[#F5F5F5] cursor-pointer">See
                        More</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div id="glossary-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/50" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full relative">
            <div class="bg-white px-12.5 py-11 rounded-[4px]">
                <div class="sm:flex sm:items-start">
                    <div class="text-left w-full">
                        <h3 class="text-[#1A3B1B] font-base font-bold text-[24px] leading-[135%] capitalize"
                            id="glossary-modal-title mb-4">Terms</h3>
                        <div class="mt-4">
                            <p class="text-[#666666] font-base font-normal text-[18px] leading-[140%] tracking-[0.015em] whitespace-pre-line"
                                id="glossary-modal-body">Description
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute right-4 top-4">
                <button type="button" id="glossary-modal-close" class="w-8 h-8">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <path d="M8 24L24 8M8 8L24 24" stroke="#A3A3A3" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    if (typeof SITE_URL === 'undefined') {
        window.SITE_URL = "<?php echo SITE_URL; ?>";
    }
</script>
<script src="<?php echo SITE_URL; ?>/assets/js/glossary.js"></script>