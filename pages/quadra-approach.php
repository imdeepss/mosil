<?php
// pages/quadra-approach.php
$pageTitle = 'Quadra Approach';
?>
<section class="h-[60px] sticky top-0 z-10 bg-white"></section>

<section class="py-6 bg-white relative">
    <div class="container">
        <div
            class="flex items-center breadcrumbs gap-1 text-[14px] md:text-[16px] leading-[150%] tracking-[0.015em] capitalize">
            <a href="<?php echo SITE_URL; ?>/" class="text-[#A3A3A3] font-light">Home</a>
            <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg></span>
            <a href="<?php echo SITE_URL; ?>/quadra-approach" class="text-[#575757] font-bold">Quadra
                Approach</a>
        </div>
        <div class="py-3.5">
            <div class="border-b-2 border-primary pb-1">
                <h2
                    class="text-main-green font-normal text-[24px] leading-[135%] md:text-[40px] md:leading-[120%] tracking-normal capitalize">
                    Quadra thinking risk off, performance on!
                </h2>
            </div>
        </div>

        <p
            class="md:pr-72 pr-0 font-light md:text-lg text-[12px] leading-[150%] leading-[140%] tracking-normal text-[var(--color-b100)] md:mb-9 mb-12">
            Quadra thinking is our systematic four-stage approach: identify pain points, map expectations, apply
            TriboIntel for data-backed analysis, and deliver validated success. Our data-driven Quadra approach with
            TriboIntel intensive documentation reduces risk, build accurate, high-impact solutions.
        </p>
        <?php
        $quadraSteps = [
            [
                'id' => 'painpoints',
                'title' => 'Identify Painpoints',
                'icon' => SITE_URL . '/assets/images/ui/IdentifyPainpointsWhite.png',
                'bg_image' => SITE_URL . '/assets/images/ui/IP.png',
                'description' => "We begin by deeply understanding your unique challenges. At MOSIL, selling isn’t about pushing products, it’s about solving problems. We listen carefully to uncover both known and hidden pain points, documenting them thoroughly to ensure our solutions address what truly matters to you",
                'corner_class' => 'rounded-tl-none'
            ],
            [
                'id' => 'expectation',
                'title' => 'Expectation Mapping',
                'icon' => SITE_URL . '/assets/images/ui/ExpectationMappingWhite.png',
                'bg_image' => SITE_URL . '/assets/images/ui/EM.png',
                'description' => "Once we understand the problem, we align on success. We map out your specific technical and operational expectations—whether it’s extending equipment life, reducing downtime, or improving efficiency. This step ensures that our proposed solution matches your goals perfectly.",
                'corner_class' => 'rounded-tr-none'
            ],
            [
                'id' => 'tribointel',
                'title' => 'TriboIntel',
                'icon' => SITE_URL . '/assets/images/ui/TriboIntelWhite.png',
                'bg_image' => SITE_URL . '/assets/images/ui/TRI.png',
                'description' => "Leveraging decades of tribological expertise, we analyze the data. Mosil’s TriboIntel approach combines advanced lab analysis with field experience to scientifically determine the best lubrication strategy. We don't just guess; we engineer the right solution based on facts.",
                'corner_class' => 'rounded-bl-none'
            ],
            [
                'id' => 'success',
                'title' => 'Delivering Success',
                'icon' => SITE_URL . '/assets/images/ui/DeliveringSuccessWhite.png',
                'bg_image' => SITE_URL . '/assets/images/ui/DS.png',
                'description' => "The final step is execution and validation. We deploy the solution, monitor performance, and prove the value delivered. It's not just about supplying a product; it 's about delivering measurable success and ensuring long-term reliability for your operations.",
                'corner_class' => 'rounded-br-none'
            ]
        ];
        ?>

        <div class="flex flex-col md:flex-row gap-4 pb-[77px]">
            <!-- Left Side: Interactive Grid -->
            <div class="w-full md:basis-2/5 grid grid-cols-2 md:gap-6 gap-3">
                <?php foreach ($quadraSteps as $index => $step):
                    $isActive = $index === 0 ? 'active' : '';
                    ?>
                    <div class="quadra-card cursor-pointer relative aspect-square rounded-[40px] <?php echo $step['corner_class']; ?> overflow-hidden group transition-all duration-300 transform hover:scale-[1.02] <?php echo $isActive ? 'ring-4 ring-main-green opacity-100' : 'opacity-50'; ?>"
                        data-index="<?php echo $index; ?>">

                        <div class="absolute inset-0 z-0 bg-lightgray transition-transform duration-700 group-hover:scale-110"
                            style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.35) 0%, rgba(0, 0, 0, 0.35) 100%), 
                        url('<?php echo $step['bg_image']; ?>') center / cover no-repeat;">
                        </div>

                        <div class="relative z-10 flex flex-col items-center justify-center w-full h-full md:gap-4">
                            <img src="<?php echo $step['icon']; ?>" alt="<?php echo $step['title']; ?>"
                                class="w-16 h-16 object-contain transition-transform duration-300 group-hover:scale-110">

                            <h2
                                class="text-[#FFF] text-center font-base font-normal md:text-[16px] md:leading-[135%] md:tracking-[0.01em] text-[14px] leading-[150%] tracking-[0.015em]">
                                <?php echo $step['title']; ?>
                            </h2>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Right Side: Content Area -->
            <div class="w-full md:basis-3/5 bg-[#F5F5F5] md:px-10 px-4 md:py-20 py-10 relative min-h-[400px]">
                <div class="flex flex-col md:gap-10 gap-6">
                    <h2
                        class="text-main-green font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize">
                        Four angles of
                        every lubrication decision.
                    </h2>

                    <!-- Tab Headers -->
                    <ul class="flex items-center gap-2 border-b md:w-fit overflow-x-auto">
                        <?php foreach ($quadraSteps as $index => $step):
                            $activeClass = $index === 0 ? 'border-b-2 border-main-green text-main-green font-bold' : 'text-main-green font-normal hover:text-main-green';
                            ?>
                            <li class="quadra-tab px-4 pb-2 text-[14px] leading-[150%] tracking-[0.015em] cursor-pointer whitespace-nowrap transition-colors <?php echo $activeClass; ?>"
                                data-index="<?php echo $index; ?>">
                                <?php echo $step['title']; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <!-- Content Display -->
                    <div id="quadra-content-container">
                        <p id="quadra-description"
                            class="text-[#575757] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em] animate-fadeIn">
                            <?php echo $quadraSteps[0]['description']; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<section class="relative">
    <div class="absolute inset-0 z-0">
        <!-- <img src="<?php echo SITE_URL; ?>/assets/images/ui/QuadraApproachBg.png" alt="Quadra Approach"
            class="w-full h-full object-cover"> -->
    </div>
    <div class="container py-20 relative z-10">
        <div class="mb-12 relative z-10">
            <h2 class="text-[#3B3B3B] font-base font-bold text-[40px] leading-[120%] mb-2">TriboIntel</h2>
            <p class="text-[#3B3B3B] font-base font-normal text-[28px] leading-[135%] capitalize">MOSIL’s Own Process
                Developed To Reduce Customer Risk</p>
        </div>

        <div class="relative flex flex-col md:flex-row items-center justify-between gap-10 md:gap-0">

            <!-- Center Cube (Desktop: Absolute Center, Mobile: Static) -->
            <div
                class="md:absolute md:left-1/2 md:top-1/2 md:-translate-x-1/2 md:-translate-y-1/2 order-1 md:order-none">
                <img src="<?php echo SITE_URL; ?>/assets/images/ui/cubic.png" alt="Cubic Process"
                    class="h-full w-full object-contain">
            </div>

            <!-- Left Column -->
            <div class="flex flex-col gap-[200px] w-full md:w-auto order-2 md:order-none">
                <!-- Item 1: Dynamic Friction Engineering -->
                <div class="flex flex-row items-start gap-4 relative group">
                    <!-- Icon -->
                    <div
                        class="w-[75px] h-[75px] rounded-full bg-[#DEDEDE] flex items-center justify-center shrink-0 relative z-10">
                        <img src="<?php echo SITE_URL; ?>/assets/icons/svg/chart-pie.svg" alt="Icon">
                    </div>
                    <!-- Content -->
                    <div class="flex flex-col max-w-[306px]">
                        <h3
                            class="text-[#3B3B3B] font-base font-bold text-[16px] leading-[150%] tracking-[0.015em] capitalize mb-2">
                            Dynamic Friction
                            Engineering</h3>
                        <p class="text-[#3B3B3B] font-base font-normal text-[14px] leading-[150%] tracking-[0.015em]">
                            MOSIL engineers lubricants to dynamically
                            control friction under real-world stress through advanced, field-validated formulation
                            science.</p>
                    </div>
                    <!-- arrow -->
                    <div class="absolute left-16 top-[75%] w-full h-full z-[100] pointer-events-none">
                        <img src="<?php echo SITE_URL; ?>/assets/images/ui/top-left-bar.png" alt="Arrow">
                    </div>
                </div>

                <!-- Item 3: Intelligence Over Intervals -->
                <div class="flex flex-row items-start gap-4 md:gap-6 relative group">
                    <!-- Icon -->
                    <div class="w-[75px] h-[75px] rounded-full bg-[#DEDEDE] flex items-center justify-center shrink-0">
                        <img src="<?php echo SITE_URL; ?>/assets/icons/svg/flag.svg" alt="Search">
                    </div>
                    <!-- Content -->
                    <div class="flex flex-col max-w-[306px]">
                        <h3 class="text-[#3B3B3B] font-bold text-[18px] leading-[140%] mb-2">Intelligence Over Intervals
                        </h3>
                        <p class="text-[#575757] text-[14px] leading-[150%]">TriboIntel converts field documentation
                            into adaptive intelligence, creating smarter lubrication strategies that prevent failures
                            proactively.</p>
                    </div>
                    <div class="absolute left-16 bottom-[65%] w-full h-full z-[100] pointer-events-none">
                        <img src="<?php echo SITE_URL; ?>/assets/images/ui/bottom-left-bar.png" alt="Arrow">
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="flex flex-col gap-[200px] w-full md:w-auto order-3 md:order-none">
                <!-- Item 2: Adaptive Application Fit -->
                <div
                    class="flex flex-row-reverse md:flex-row items-start gap-4 md:gap-6 relative group md:text-right text-left">
                    <!-- Content (Desktop: Left, Mobile: Right due to reverse) -->
                    <div class="flex flex-col max-w-[306px] md:items-end">
                        <h3 class="text-[#3B3B3B] font-bold text-[18px] leading-[140%] mb-2">Adaptive Application Fit
                        </h3>
                        <p class="text-[#575757] text-[14px] leading-[150%]">TriboIntel calibrates lubricants through
                            detailed on-site assessments, ensuring solutions match exact operating conditions and
                            evolving needs.</p>
                    </div>

                    <!-- Icon -->
                    <div class="w-[75px] h-[75px] rounded-full bg-[#DEDEDE] flex items-center justify-center shrink-0">
                        <img src="<?php echo SITE_URL; ?>/assets/icons/svg/light-bulb.svg" alt="Search">
                    </div>

                    <div class="absolute right-0 top-[75%] w-full h-full z-[100] pointer-events-none">
                        <img src="<?php echo SITE_URL; ?>/assets/images/ui/top-right-bar.png" alt="Arrow">
                    </div>

                </div>

                <!-- Item 4: Lifecycle Intelligence -->
                <div
                    class="flex flex-row-reverse md:flex-row items-start gap-4 md:gap-6 relative group md:text-right text-left">
                    <!-- Content -->
                    <div class="flex flex-col max-w-[306px] md:items-end">
                        <h3 class="text-[#3B3B3B] font-bold text-[18px] leading-[140%] mb-2">Lifecycle Intelligence</h3>
                        <p class="text-[#575757] text-[14px] leading-[150%]">MOSIL applies lifecycle intelligence using
                            data, prediction, and field feedback to anticipate and prevent equipment failures.</p>
                    </div>

                    <!-- Icon -->
                    <div class="w-[75px] h-[75px] rounded-full bg-[#DEDEDE] flex items-center justify-center shrink-0">
                        <img src="<?php echo SITE_URL; ?>/assets/icons/svg/puzzle.svg" alt="Search">
                    </div>
                    <div class="absolute right-0 bottom-[65%] w-full h-full z-[100] pointer-events-none">
                        <img src="<?php echo SITE_URL; ?>/assets/images/ui/bottom-right-bar.png" alt="Arrow">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    window.quadraData = <?php echo json_encode($quadraSteps); ?>;
</script>
<script src="<?php echo SITE_URL; ?>/assets/js/quadra-approach.js"></script>