<?php

$positions = getCareerPosition();

?>
<!-- Hero Section -->
<section class="relative w-full h-[748px] md:h-[480px] overflow-hidden">
    <div class="container relative z-20 flex items-end justify-start w-full h-full pb-4 md:pb-10">
        <h2
            class="text-white font-base font-normal text-[32px] md:text-[48px] leading-[120%] tracking-normal capitalize">
            Career
        </h2>
    </div>

    <!-- <div class="absolute inset-0 z-10 bg-gradient-to-tr from-black/60 via-black/20 to-transparent"></div> -->

    <div class="absolute inset-0 z-0 w-full h-full">
        <img src="<?php echo SITE_URL; ?>/assets/images/banners/career_v2.png" alt="Career"
            class="hidden md:block w-full h-full object-cover object-[50%_75%]" fetchpriority="high">

        <img src="<?php echo SITE_URL; ?>/assets/images/banners/career_mb_v2.png" alt="Career"
            class="block md:hidden w-full h-full object-cover object-center" fetchpriority="high">
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
            <a href="#" class="text-[#575757] font-bold">career</a>




        </nav>
    </div>
    <div class="relative grid grid-cols-1 md:grid-cols-2 place-items-end bg-[#FAFAFA] z-0 px-4 md:px-0 pt-4 md:pt-0">
        <div class="md:order-1 order-2 md:py-[52px] md:pr-[30px] h-full w-full md:px-4 py-10 xl:w-[652px] relative">
            <div class="absolute inset-0 -z-10 flex items-center justify-center pointer-events-none">
                <img src="<?php echo SITE_URL; ?>/assets/images/ui/Vector.png" class="w-full h-full object-contain"
                    alt="" loading="lazy" />
            </div>
            <div class="py-3.5">
                <span class="text-[#666666] font-normal text-xs leading-[120%] tracking-[0.015em] uppercase">
                    Got the Fire?
                </span>
                <div class="border-b border-primary pb-1">
                    <h2
                        class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                        Fuel Your Future With Us!
                    </h2>

                </div>
            </div>
            <form id="careerForm" method="POST" enctype="multipart/form-data"
                data-url="<?php echo SITE_URL; ?>/ajax/career.php"
                class="grid grid-cols-1 md:grid-cols-2 md:gap-4 gap-2 md:py-6 text-[#757575] font-helvetica font-normal text-[20px] leading-[140%] tracking-[0.01em] pt-4 md:pt-6">

                <input type="text" name="name" placeholder="Name" required
                    class="flex min-w-[240px] px-4 py-3 items-center flex-1 self-stretch rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none focus:border-main-green">

                <div class="relative flex min-w-[240px] flex-1">
                    <select name="position" id="positionSelect" required
                        class="appearance-none flex min-w-[240px] px-4 py-3 items-center flex-1 self-stretch rounded-[4px] border border-[#DEDEDE] bg-[#FFF] text-[#757575] focus:outline-none focus:border-main-green cursor-pointer">
                        <option value="" disabled selected>Please select your position</option>
                        <?php foreach ($positions as $position): ?>
                            <option value="<?= htmlspecialchars($position['position']) ?>" class="text-black">
                                <?= htmlspecialchars($position['position']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                </div>

                <input type="tel" name="mobile" placeholder="+91 Phone" required
                    class="flex min-w-[240px] px-4 py-3 items-center flex-1 self-stretch rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none">

                <input type="email" name="email" placeholder="Email" required
                    class="flex min-w-[240px] px-4 py-3 items-center flex-1 self-stretch rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none">

                <input type="text" name="city" placeholder="City" required
                    class="flex min-w-[240px] px-4 py-3 items-center flex-1 self-stretch rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none">

                <input type="text" name="pincode" placeholder="Pincode" required
                    class="flex min-w-[240px] px-4 py-3 items-center flex-1 self-stretch rounded-[4px] border border-[#DEDEDE] bg-[#FFF] placeholder:text-[#757575] focus:outline-none">

                <div class="md:col-span-2 relative">
                    <input type="file" id="upload" name="resume" class="hidden" accept=".pdf,.doc,.docx">
                    <label for="upload" id="fileLabel"
                        class="w-full p-3 border border-gray-200 rounded-md flex justify-between items-center cursor-pointer text-[#757575]">
                        <span>Upload Resume (PDF/DOC)</span> <img
                            src="<?php echo SITE_URL ?>/assets/icons/svg/upload.svg" width="24" height="24" />
                    </label>
                </div>

                <div id="formResponse"
                    class="md:col-span-2 hidden rounded-md p-4 mb-2 text-center text-sm font-semibold"></div>

                <button type="submit" id="submitBtn"
                    class="md:col-span-2 bg-main-green text-white py-4 rounded-full font-bold text-[18px] hover:bg-black transition-all disabled:bg-gray-400">
                    Send Application
                </button>
            </form>
        </div>

        <div class="md:order-2 order-1 w-full h-full min-h-[237px] lg:min-h-[575px] relative">
            <img src="<?php echo SITE_URL ?>/assets/images/ui/contact.jpg" alt="MOSIL Team"
                class="absolute inset-0 w-full h-full object-cover">
        </div>
    </div>

</section>

<section class="bg-white">
    <div class="container md:py-20 py-12 pb-0">
        <div class="py-3.5 hidden md:block">
            <span
                class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                Our culture
            </span>
            <div class="border-b border-primary pb-1">
                <h2
                    class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                    Life at MOSIL
                </h2>

            </div>
        </div>

        <div class="flex flex-col lg:flex-row flex-col-reverse items-center relative md:pt-10 -mx-4 md:mx-auto">

            <div class="w-full lg:w-[695px] flex flex-col">
                <div class="relative aspect-[695/214] overflow-hidden order-3 md:order-1">
                    <img src="<?php echo SITE_URL; ?>/assets/images/ui/contact-world-v2.png"
                        alt="Global connection and city skyline" class="w-full h-full object-cover object-center"
                        loading="lazy">
                </div>
                <div
                    class="bg-yellow-400 px-4 pr-12.5 py-5 md:px-8 md:py-8 md:rounded-bl-full rounded-br-full md:rounded-br relative z-10 flex justify-center items-center md:w-full w-fit order-1 md:order-2">
                    <h3
                        class="text-main-green font-base font-bold md:text-[40px] md:leading-[120%] text-[20px] leading-[140%]">
                        Why work with us?
                    </h3>
                </div>

                <p
                    class="text-[#575757] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em] md:py-9 md:pl-7.5 md:pr-6 pl-4 pr-4 py-4 order-2 md:order-3">
                    When you bring your talent to MOSIL, you join a culture that genuinely supports your growth and
                    well-being. At MOSIL, people come first. We offer a supportive, growth-driven workplace with
                    thoughtful leave policies, continuous learning opportunities, and real flexibility. Employees are
                    encouraged to explore ideas, build skills, and thrive in their roles. Here, your contribution
                    matters, and your well-being is genuinely prioritized.
                </p>
            </div>

            <div class="relative w-full lg:w-[586px] aspect-[586/532] overflow-hidden">

                <img src="<?php echo SITE_URL; ?>/assets/images/ui/work-with-us_v2.png"
                    alt="MOSIL team working in a specialized lubrication lab"
                    class="absolute inset-0 w-full h-full object-cover" loading="lazy">
            </div>
        </div>
    </div>
</section>