<?php
// pages/about.php
$pageTitle = 'About Us';

$mosil_matters = [
    [
        "title" => "Custom-engineered lubricants",
        "description" => "Custom-engineered lubricants  ensuring peak machine  performance and durability.",
        "image" => "matter-1.jpg"
    ],
    [
        "title" => "Backed by global certifications",
        "description" => "Globally certified with ISO 9001, 
14001, 45001 and NSF 
certifications",
        "image" => "matter-2.jpg"
    ],
    [
        "title" => "Data-driven quadra methodology",
        "description" => "Data-Driven Quadra approach 
with TriboIntel documentation,
 reduces ris",
        "image" => "matter-3.jpg"
    ],
    [
        "title" => "Sustainable formulations",
        "description" => " Biodegradable and ESG-focused formulations  aligned with OECD protocols",
        "image" => "matter-4.jpg"
    ],
    [
        "title" => "Innovation built on research",
        "description" => "R&D backed innovation  creates proven, custom  lubricant solutions",
        "image" => "matter-5.jpg"
    ],
    [
        "title" => "Strength built for the extreme",
        "description" => " Special synthetic lubricants  significantly enhance equipment life  in tough environments",
        "image" => "matter-6.jpg"
    ]
];

$lubricant_features = [
    [
        "title" => "Engineered lubricants for high performance",
        "desc" => "High performance greases, oils, aerosols, coatings, corrosion preventives, dry films anti frictional coatings and specialty cleaners for critical applications in various industries."
    ],
    [
        "title" => "Quadra thinking risk off, performance on",
        "desc" => "From selection to field alignment, we co-engineer every stage with TriboIntel to lower your risk and raise reliability staying hands-on, start to finish."
    ],
    [
        "title" => "Savings rooted in science",
        "desc" => "Our aim is to optimize processes that boost machine efficiency, reduce maintenance frequency and increase operational reliability leading to significant cost savings and enhanced productivity."
    ],
    [
        "title" => "Custom solutions, built around your machines",
        "desc" => "We work together with partners to develop custom solutions that are repeatedly put to the test, refined and adapted to the constantly changing production requirements."
    ],
    [
        "title" => "Partners in progress with infinite possibilities",
        "desc" => "We invest in high-performance labs and rapid response support that adapts to your evolving production demands."
    ]
];
?>
<!-- Hero Section -->
<section class="relative w-full h-[748px] md:h-[480px] overflow-hidden">
    <div class="container relative z-20 flex items-end justify-start w-full h-full pb-4 md:pb-10">
        <h2
            class="text-white font-base font-normal text-[32px] md:text-[48px] leading-[120%] tracking-normal capitalize">
            What you run on decides how far you run
        </h2>
    </div>

    <!-- <div class="absolute inset-0 z-10 bg-gradient-to-tr from-black/60 via-black/20 to-transparent"></div> -->

    <div class="absolute inset-0 z-0 w-full h-full">
        <img src="<?php echo SITE_URL; ?>/assets/images/banners/about-us.png" alt="Career"
            class="hidden md:block w-full h-full object-cover object-[50%_75%]" fetchpriority="high">

        <img src="<?php echo SITE_URL; ?>/assets/images/banners/career_mb_v2.png" alt="Career"
            class="block md:hidden w-full h-full object-cover object-center" fetchpriority="high">
    </div>
</section>

<section>
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
            <a href="<?php echo SITE_URL; ?>/about" class="text-[#575757] font-bold">About Us</a>
        </nav>
        <div class="py-3.5">
            <span
                class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                Overview
            </span>
            <div class="border-b border-primary pb-1">
                <h2
                    class="text-main-green font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                    We are MOSIL
                </h2>
            </div>
        </div>
        <div class="flex flex-col md:flex-row gap-10 items-stretch flex-col-reverse pt-4 md:pt-0">

            <div
                class="flex-1 bg-[#F5F5F5] md:px-[64px] pb-12 md:pb-0 md:py-8 px-4 py-4 md:rounded-bl-[110px] rounded-bl-[80px] flex flex-col justify-center gap-6">
                <h2 class="text-[#1A3B1B] font-base font-normal md:text-[28px] text-[24px] leading-[135%] capitalize">
                    India’s leading specialty lubricant & grease manufacturer
                </h2>

                <div
                    class="text-[#757575] font-base font-normal md:text-[16px] text-[14px] leading-[150%] tracking-[0.015em] flex flex-col gap-4">
                    <p>
                        50 years ago, MOSIL was born from a simple idea: industrial reliability should not be
                        compromised by
                        lack of access to quality lubrication. What began as a mission to solve on-ground maintenance
                        problems has grown into a trusted partner to industries that demand precision, durability and
                        performance.
                    </p>
                    <p>
                        MOSIL Lubricants is a leading Indian manufacturer of specialty lubricants, greases, coatings,
                        and aerosols serving demanding industrial applications across sectors. Backed by decades of
                        tribology expertise and strong in-house R&D, MOSIL develops solutions designed to perform under
                        real operating stress.
                    </p>
                </div>
            </div>

            <div class="w-full md:w-[456px] shrink-0 overflow-hidden">
                <img src="<?php echo SITE_URL; ?>/assets/images/ui/lubricant-manufacturer.png"
                    alt="MOSIL Lubricant Manufacturer" class="w-full h-full object-cover rounded-lg shadow-sm">
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container md:py-20 py-12">
        <div class="py-3.5">
            <span
                class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                Our History
            </span>
            <div class="border-b border-primary pb-1">
                <h2
                    class="text-main-green font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                    The journey that shaped us
                </h2>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-10 pt-10">
            <?php
            $history_data = [
                [
                    "year" => "1971 - 1980",
                    "title" => "The beginning",
                    "points" => [
                        "First batch of moly and graphite based specialty greases manufactured",
                        "Introduced products for the textile industry",
                        "Introduced silicone greases in india"
                    ]
                ],
                [
                    "year" => "1981 - 1990",
                    "title" => "Expansion & Growth",
                    "points" => [
                        "Expanded manufacturing capacity to meeting growing demand",
                        "Launched first range of synthetic lubricants",
                        "Established pan-India distribution network"
                    ]
                ],
                [
                    "year" => "1991 - 2000",
                    "title" => "Global Horizons",
                    "points" => [
                        "Started exports to Southeast Asian markets",
                        "Received ISO 9001 certification for quality management",
                        "Setup dedicated R&D center for tribology"
                    ]
                ],
                [
                    "year" => "2001 - 2010",
                    "title" => "Innovation Era",
                    "points" => [
                        "Developed biodegradable lubricants for eco-sensitive zones",
                        "Patented new anti-friction coating technology",
                        "Partnered with major automotive OEMs"
                    ]
                ]
            ];
            ?>
            <div class="flex flex-col justify-center md:gap-3 gap-2 max-w-md order-2 md:order-1">
                <div class="swiper our-history-swiper w-full">
                    <div class="swiper-wrapper">
                        <?php foreach ($history_data as $history): ?>
                            <div class="swiper-slide cursor-grab active:cursor-grabbing">
                                <h2 class="text-[#1A3B1B] font-bold text-[64px] leading-[135%] tracking-[0.01em]">
                                    <?php echo $history['year']; ?>
                                </h2>

                                <div class="flex flex-col gap-4">
                                    <p
                                        class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize">
                                        <?php echo $history['title']; ?>
                                    </p>
                                    <ul
                                        class="list-disc list-inside flex flex-col gap-2 text-[#757575] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em]">
                                        <?php foreach ($history['points'] as $point): ?>
                                            <li><?php echo $point; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="flex items-center gap-4 relative z-10 justify-start mt-4">
                    <button class="history-prev group cursor-pointer">
                        <svg class="w-12 h-12 transition-transform group-active:scale-90" viewBox="0 0 48 48">
                            <circle cx="24" cy="24" r="23" stroke="#1A3B1B" stroke-width="2" fill="none" />
                            <path d="M34 24L14 24M14 24L20 18M14 24L20 30" stroke="#1A3B1B" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button class="history-next group cursor-pointer">
                        <svg class="w-12 h-12 transition-transform group-active:scale-90" viewBox="0 0 48 48">
                            <circle cx="24" cy="24" r="23" stroke="#1A3B1B" stroke-width="2" fill="none" />
                            <path d="M14 24L34 24M34 24L28 18M34 24L28 30" stroke="#1A3B1B" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="relative order-1 md:order-2 group/main md:pb-0 pb-28">
                <div id="quadra-info-card"
                    class="absolute z-50 w-[330px] p-4 bg-white border border-[#E5E5E5] rounded-[4px] shadow-xl transition-all duration-300 opacity-0 pointer-events-none">
                    <h3 id="info-title" class="text-[#3B3B3B] font-bold text-[16px] mb-1 capitalize"></h3>
                    <p id="info-desc" class="text-[#757575] text-[12px] leading-[150%]"></p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-auto max-w-[638px]" viewBox="0 0 638 410"
                    fill="none">
                    <style>
                        /* 1. Target Top Face (Light Grey to Main Green) */
                        g:hover path[fill="#F5F5F5"] {
                            fill: #1A3B1B !important;
                        }

                        /* 2. Target Side Faces (Gradient/Grey to Dark Green) */
                        /* This targets the 3D depth parts of your boxes */
                        g:hover path[fill="url(#paint0_linear_1109_6875)"],
                        g:hover path[fill="#B0B0B0"],
                        g:hover path[fill="#EBEBEB"] {
                            fill: #142e15 !important;
                        }

                        /* 3. Target Icons (Grey to White) */
                        g:hover path[fill="#757575"] {
                            fill: #FFFFFF !important;
                        }

                        /* Make groups behave like buttons */
                        g {
                            cursor: pointer;
                        }
                    </style>

                    <g class="quadra-box" data-pos="top" data-title="Identify Painpoints"
                        data-desc="We begin by deeply understanding your unique challenges. At MOSIL, selling isn’t about pushing products, it’s about solving problems."
                        filter="url(#filter0_d_1109_6875)">
                        <path
                            d="M211.767 102.504L318.971 40L426.071 102.504L355.519 143.095C332.86 156.132 304.977 156.132 282.319 143.095L211.767 102.504Z"
                            fill="#F5F5F5" />
                        <path
                            d="M211.767 170.758V102.504L282.483 142.948C305.058 155.859 332.78 155.859 355.355 142.948L426.071 102.504V170.758L356.996 211.965C333.97 225.701 305.285 225.788 282.176 212.19L211.767 170.758Z"
                            fill="url(#paint0_linear_1109_6875)" />
                        <path
                            d="M343.717 97.39C343.14 93.955 340.909 90.759 337.241 88.121C333.434 85.385 328.428 83.495 322.761 82.657C315.862 81.636 308.186 82.274 301.703 84.407C294.968 86.623 290.24 90.145 288.388 94.326C286.679 98.185 287.58 102.281 290.928 105.862C294.255 109.423 299.629 112.088 306.057 113.367C312.928 114.734 320.464 114.427 327.273 112.502C334.179 110.551 339.396 107.205 342.032 103.053L340.088 102.823C337.594 106.625 332.77 109.688 326.412 111.485C320.073 113.277 313.072 113.565 306.696 112.296C294.409 109.852 287.048 101.916 290.288 94.605C292.008 90.724 296.408 87.452 302.676 85.389C308.723 83.4 315.867 82.803 322.278 83.752C333.1 85.354 340.958 91.039 341.829 97.902C341.862 98.155 342.184 98.365 342.615 98.414L366.668 101.149L367.271 99.979L343.72 97.388L343.717 97.39Z"
                            fill="#757575" />
                        <path
                            d="M347.63 95.4545C345.004 87.9565 335.722 81.9915 323.83 80.2035C315.669 78.9755 306.619 79.7645 299.005 82.3665C291.559 84.9115 286.331 88.8895 284.289 93.5685C282.348 98.0175 283.428 102.748 287.338 106.889C291.209 110.99 297.409 114.07 304.8 115.559C312.787 117.168 321.535 116.817 329.437 114.569C337.425 112.297 343.43 108.404 346.421 103.573L344.48 103.344C341.629 107.826 336.015 111.437 328.573 113.554C321.145 115.666 312.934 115.999 305.446 114.49C291.119 111.604 282.481 102.341 286.191 93.8445C288.105 89.4615 293.012 85.7305 300.004 83.3395C307.171 80.8895 315.676 80.1455 323.337 81.2985C334.692 83.0065 343.52 88.7915 345.827 96.0335C345.898 96.2585 346.205 96.4355 346.595 96.4785L367.869 98.8135L368.531 97.5355L347.632 95.4555L347.63 95.4545Z"
                            fill="#757575" />
                        <path
                            d="M351.664 93.6235C347.715 85.7555 337.518 79.7505 324.928 77.9075C315.592 76.5415 305.255 77.4755 296.564 80.4675C288.196 83.3485 282.326 87.8295 280.03 93.0835C277.825 98.1305 279.048 103.501 283.473 108.202C287.867 112.871 294.917 116.371 303.324 118.057C312.405 119.878 322.344 119.466 331.307 116.897C335.119 115.804 338.531 114.386 341.45 112.699C345.593 110.307 348.747 107.376 350.671 104.073L348.737 103.844C345.591 109.128 339.115 113.395 330.434 115.883C321.945 118.316 312.545 118.709 303.967 116.988C287.562 113.699 277.678 103.1 281.932 93.3595C284.098 88.3985 289.651 84.1645 297.568 81.4375C305.816 78.5975 315.613 77.7095 324.448 79.0025C336.536 80.7715 346.305 86.6175 349.942 94.2595C350.041 94.4665 350.335 94.6205 350.701 94.6575L369.074 96.4835L369.7 95.2965L351.666 93.6205L351.664 93.6235Z"
                            fill="#757575" />
                        <path
                            d="M366.137 102.17C365.607 102.112 339.25 99.2271 339.25 99.2271C339.103 99.2101 339.004 99.1351 339.014 99.0431C339.745 92.4891 332.582 86.5611 321.98 84.9461C316.103 84.0511 309.582 84.6001 304.082 86.4531C298.426 88.3591 294.426 91.3621 292.817 94.9091C291.335 98.1791 292.05 101.636 294.83 104.647C297.601 107.649 302.13 109.888 307.579 110.952C313.415 112.091 319.806 111.805 325.575 110.146C331.14 108.545 335.424 105.856 337.708 102.545L335.756 102.314C331.215 108.624 319.091 112.006 308.208 109.881C297.828 107.854 291.901 101.404 294.714 95.1961C296.189 91.9421 299.867 89.1851 305.07 87.4311C310.12 85.7291 316.101 85.2221 321.479 86.0411C331.179 87.5191 337.729 92.9571 337.059 98.9721C336.986 99.6261 337.766 100.214 338.872 100.339L365.473 103.453"
                            fill="#757575" />
                    </g>

                    <g class="quadra-box" data-pos="left" data-title="Expectation Mapping"
                        data-desc="Clear communication is key. We actively validate your goals and requirements, recognizing that standard solutions may need customization."
                        filter="url(#filter1_d_1109_6875)">
                        <path
                            d="M550.212 174.428L443.007 111.924L365.443 157.191C352.292 164.866 352.351 183.888 365.549 191.481L443.06 236.077L550.212 174.428Z"
                            fill="#F5F5F5" />
                        <path
                            d="M550.212 244.15V174.428L442.951 235.956C442.951 218.671 442.951 263.439 442.951 235.956C442.951 253.242 443.06 299.807 443.06 306.533L550.212 244.15Z"
                            fill="#B0B0B0" />
                        <path
                            d="M443.06 306.533V236L376.273 197.426C376.273 197.426 366.365 192.594 361.228 187.885C356.091 183.176 355.724 174.428 355.724 174.428C355.724 201.911 355.724 217.319 355.724 244.802C355.724 251.891 359.51 258.439 365.654 261.976L443.06 306.533Z"
                            fill="#EBEBEB" />
                        <g clip-path="url(#clip0_1109_6875)">
                            <path
                                d="M435.641 147.729L404.737 165.571C402.418 166.91 402.418 169.09 404.737 170.429L447.419 195.071C449.738 196.41 453.514 196.41 455.833 195.071L477.792 182.393L475.722 181.988L454.447 194.271C452.892 195.169 450.36 195.169 448.804 194.271L406.123 169.629C404.568 168.731 404.568 167.269 406.123 166.371L437.026 148.529C438.582 147.631 441.114 147.631 442.669 148.529L489.558 175.6L490.943 174.8L444.055 147.729C441.736 146.39 437.96 146.39 435.641 147.729Z"
                                fill="#757575" />
                            <path d="M475.722 181.988L477.791 182.393L477.953 182.3" fill="#757575" />
                            <path
                                d="M436.028 150.905L410.065 165.895C408.054 167.056 408.12 168.982 410.21 170.189L447.836 191.912C449.926 193.119 453.262 193.157 455.273 191.996L473.396 181.533L471.326 181.128L453.886 191.197C452.64 191.916 450.546 191.879 449.22 191.113L411.594 169.39C410.268 168.624 410.202 167.416 411.449 166.696L437.412 151.706C438.658 150.987 440.752 151.024 442.078 151.79L486.438 177.401L487.824 176.601L443.464 150.99C441.373 149.783 438.038 149.745 436.027 150.906L436.028 150.905Z"
                                fill="#757575" />
                            <path d="M466.669 180.215L468.739 180.62L468.773 180.6" fill="#757575" />
                            <path
                                d="M436.607 154.171L415.724 166.228C414.031 167.205 414.16 168.867 416.006 169.933L448.278 188.565C450.126 189.632 453.004 189.704 454.695 188.728L468.74 180.619L466.67 180.214L453.309 187.928C452.381 188.464 450.746 188.39 449.663 187.765L417.392 169.133C416.309 168.508 416.183 167.563 417.109 167.028L437.993 154.971C438.921 154.435 440.556 154.509 441.639 155.134L483.322 179.2L484.708 178.4L443.024 154.334C441.176 153.267 438.298 153.195 436.607 154.171Z"
                                fill="#757575" />
                            <path d="M462.262 179.352L464.34 179.76L464.437 179.704" fill="#757575" />
                            <path
                                d="M437.142 157.362L421.25 166.537C419.872 167.333 420.062 168.737 421.673 169.667L448.74 185.294C450.351 186.224 452.784 186.333 454.156 185.541L464.344 179.759L462.267 179.352L452.779 184.738C452.174 185.087 450.962 184.975 450.129 184.494L423.062 168.867Q422.229 168.386 422.037 167.337L438.531 158.162C439.135 157.813 440.348 157.925 441.179 158.405L480.208 181L481.593 180.2L442.567 157.606C440.956 156.676 438.522 156.567 437.145 157.362L437.142 157.362Z"
                                fill="#757575" />
                        </g>
                    </g>

                    <g class="quadra-box" data-pos="right" data-title="TriboIntel"
                        data-desc="Leveraging decades of tribological expertise, we analyze data to scientifically determine the best lubrication strategy."
                        filter="url(#filter2_d_1109_6875)">
                        <path
                            d="M87.0006 174.428L194.205 111.924L271.77 157.191C284.921 164.866 284.862 183.888 271.664 191.481L194.153 236.077L87.0006 174.428Z"
                            fill="#F5F5F5" />
                        <path
                            d="M87.0007 244.15V174.428L194.262 235.956C194.262 218.671 194.262 263.439 194.262 235.956C194.262 253.242 194.153 299.807 194.153 306.533L87.0007 244.15Z"
                            fill="#EBEBEB" />
                        <path
                            d="M194.152 306.533V236L260.939 197.426C260.939 197.426 270.846 192.594 275.984 187.885C281.121 183.176 281.488 174.428 281.488 174.428C281.488 201.911 281.488 217.319 281.488 244.802C281.488 251.891 277.702 258.439 271.558 261.976L194.152 306.533Z"
                            fill="#B0B0B0" />
                        <path
                            d="M229.506 168.731C226.861 168.912 220.993 169.444 215.319 169.958C210.23 170.42 204.975 170.896 202.018 171.121C202.131 172.126 201.966 173.567 200.683 175.044C198.701 177.326 194.719 178.919 190.29 179.2C184.379 179.575 177.281 177.531 175.63 173.464C174.051 169.572 178.492 165.42 185.323 164.398C190.471 163.628 195.977 164.767 199.434 167.303C204.743 165.412 209.878 163.295 214.846 161.247C217.338 160.22 219.915 159.158 222.491 158.133L223.603 159.065C221.041 160.084 218.471 161.144 215.987 162.168C210.91 164.261 205.662 166.425 200.203 168.359C199.486 168.613 198.564 168.513 198.06 168.126C195.142 165.893 190.221 164.834 185.817 165.493C179.99 166.365 176.197 169.897 177.539 173.206C178.942 176.662 185.015 178.396 190.077 178.075C193.853 177.835 197.246 176.48 198.932 174.537C200.089 173.203 200.173 171.896 200.042 171.034C199.964 170.531 200.584 170.087 201.45 170.023C204.31 169.81 209.753 169.317 215.017 168.84C220.709 168.324 226.596 167.791 229.277 167.607L229.509 168.731H229.506Z"
                            fill="#757575" />
                        <path
                            d="M210.528 185.028L210.465 185.064C206.539 187.319 201.823 188.912 196.824 189.668C188.884 190.87 179.602 190.039 171.995 187.443C164.557 184.905 159.347 180.955 157.324 176.319C155.39 171.886 156.419 167.168 160.22 163.035C164.067 158.852 170.32 155.768 177.83 154.348C191.12 151.837 205.962 154.902 214.156 161.807C214.359 161.978 214.274 162.213 213.976 162.327L213.419 162.539C213.124 162.651 212.731 162.604 212.53 162.436C204.822 155.952 190.9 153.07 178.443 155.424C164.072 158.139 155.454 167.389 159.228 176.042C161.121 180.383 166.011 184.086 172.996 186.469C180.163 188.915 188.886 189.701 196.332 188.574C205.42 187.197 213.446 182.753 216.78 177.25C218.196 174.913 218.727 172.438 218.362 169.889C218.332 169.686 218.587 169.505 218.937 169.485L219.604 169.446C219.962 169.425 220.283 169.576 220.312 169.783C220.705 172.496 220.141 175.132 218.63 177.624C216.968 180.37 214.167 182.929 210.53 185.029L210.528 185.028Z"
                            fill="#757575" />
                        <path
                            d="M213.785 186.82C213.761 186.834 213.738 186.847 213.714 186.861C209.247 189.426 203.884 191.236 198.205 192.097C189.176 193.464 178.617 192.518 169.962 189.565C161.503 186.679 155.577 182.186 153.277 176.914C151.078 171.872 152.247 166.507 156.57 161.805C160.945 157.049 168.057 153.541 176.596 151.927C191.738 149.065 208.651 152.57 217.962 160.454C218.165 160.625 218.08 160.86 217.781 160.973L217.223 161.185C216.928 161.297 216.532 161.25 216.333 161.081C207.508 153.618 191.512 150.297 177.206 153.001C160.732 156.114 150.851 166.717 155.177 176.637C157.348 181.614 162.953 185.858 170.958 188.59C179.171 191.392 189.172 192.294 197.706 191.001C208.126 189.423 217.329 184.328 221.148 178.021C222.779 175.327 223.387 172.472 222.953 169.531Q222.923 169.328 223.178 169.126L224.194 169.086C224.553 169.065 224.873 169.216 224.903 169.423C225.365 172.528 224.724 175.544 222.998 178.393C221.106 181.517 217.919 184.429 213.783 186.817L213.785 186.82Z"
                            fill="#757575" />
                        <path
                            d="M207.547 183.133C204.187 185.073 200.075 186.507 195.693 187.171C188.848 188.207 180.846 187.491 174.29 185.254C167.878 183.066 163.387 179.661 161.644 175.663C159.976 171.842 160.863 167.774 164.14 164.212C167.457 160.607 172.847 157.947 179.325 156.723C190.757 154.563 203.515 157.187 210.59 163.108C210.795 163.278 210.71 163.513 210.41 163.628L209.847 163.841C209.555 163.952 209.163 163.906 208.964 163.739C202.377 158.236 190.532 155.795 179.935 157.799C167.679 160.115 160.326 168.006 163.546 175.387C165.16 179.089 169.333 182.248 175.291 184.28C181.407 186.367 188.85 187.038 195.201 186.077C202.954 184.903 209.799 181.111 212.645 176.416C213.841 174.439 214.297 172.346 214.001 170.189C213.973 169.985 214.226 169.805 214.578 169.784L215.243 169.744C215.601 169.723 215.922 169.874 215.951 170.081C216.275 172.4 215.785 174.655 214.493 176.787C213.04 179.186 210.604 181.368 207.551 183.131L207.547 183.133Z"
                            fill="#757575" />
                        <path
                            d="M210.935 170.065C210.67 170.09 210.403 170.116 210.14 170.142C209.806 170.175 209.57 170.349 209.603 170.544C209.825 171.882 209.856 174.256 207.823 176.776C204.691 180.662 198.104 183.137 191.56 183.635C182.084 184.356 170.485 181.233 167.476 174.758C164.507 168.37 171.794 161.847 182.195 160.056C190.757 158.581 200.363 160.499 206.039 164.896C206.253 165.062 206.664 165.091 206.948 164.965C207.121 164.887 207.296 164.808 207.471 164.731C207.752 164.605 207.807 164.369 207.584 164.208C200.977 159.424 190.597 157.509 181.662 158.97C176.11 159.877 171.171 162.099 168.108 165.061C164.92 168.146 164.024 171.695 165.583 175.053C167.08 178.273 170.776 181.031 175.991 182.814C180.777 184.451 186.546 185.16 191.817 184.759C192.411 184.714 204.402 183.583 209.6 177.254C211.872 174.486 211.898 171.879 211.683 170.403C211.652 170.187 211.306 170.033 210.935 170.069L210.935 170.065Z"
                            fill="#757575" />
                    </g>

                    <g class="quadra-box" data-pos="bottom" data-title="Delivering Success"
                        data-desc="The final step is execution and validation. We deploy the solution, monitor performance, and prove the value delivered."
                        filter="url(#filter3_d_1109_6875)">
                        <path
                            d="M430.474 249.63L323.269 312.133L216.17 249.63L286.722 209.038C309.381 196.002 337.263 196.002 359.922 209.038L430.474 249.63Z"
                            fill="#F5F5F5" />
                        <path d="M216.17 318.617V249.629L323.352 312V381L216.17 318.617Z" fill="#EBEBEB" />
                        <path d="M430.474 318.421V249.629L323.322 312.012V381L430.474 318.421Z" fill="#B0B0B0" />
                        <g clip-path="url(#clip1_1109_6875)">
                            <path
                                d="M334.129 215.626L340.137 268.427C340.172 268.743 339.813 269.032 339.283 269.114L311.345 273.43C306.729 274.143 301.822 273.656 297.886 272.091C293.949 270.526 291.406 268.056 290.907 265.312C290.069 260.68 295.116 256.444 302.905 255.239C309.009 254.299 315.113 253.359 321.215 252.42L321.047 251.261L302.399 254.147C298.203 254.796 294.537 256.292 292.076 258.359C289.615 260.426 288.508 262.937 288.959 265.431C289.516 268.505 292.364 271.273 296.774 273.025C301.183 274.777 306.679 275.324 311.851 274.524L339.789 270.208C340.329 270.124 340.806 269.961 341.182 269.744C341.8 269.387 342.152 268.884 342.093 268.354L335.977 214.601L334.129 215.626Z"
                                fill="#757575" />
                            <path
                                d="M329.962 217.94L335.421 266.176C335.48 266.696 334.889 267.171 334.018 267.306L309.742 271.048C306.868 271.491 303.866 271.26 301.294 270.397C298.721 269.535 296.886 268.146 296.128 266.484L295.698 265.546C294.15 262.156 297.654 258.645 303.511 257.719C309.53 256.754 315.549 255.791 321.568 254.826L321.409 253.722C315.272 254.691 309.134 255.659 302.997 256.628C296.105 257.717 291.983 261.847 293.808 265.835L294.238 266.773C295.13 268.726 297.29 270.361 300.316 271.376C303.343 272.39 306.87 272.662 310.253 272.141L334.529 268.399C335.201 268.295 335.79 268.093 336.256 267.824C337.021 267.382 337.458 266.76 337.383 266.103L331.817 216.963L331.716 216.967L329.965 217.94L329.962 217.94Z"
                                fill="#757575" />
                            <path
                                d="M325.815 220.242L330.828 265C330.838 265.1 330.726 265.191 330.558 265.216L309.149 268.498C307.22 268.794 305.206 268.637 303.479 268.058C301.754 267.478 300.522 266.545 300.013 265.429L299.971 265.335C298.932 263.055 301.293 260.696 305.235 260.078C310.805 259.192 316.376 258.306 321.946 257.42L321.787 256.316C316.098 257.206 310.41 258.096 304.722 258.986C299.746 259.767 296.764 262.743 298.076 265.623L298.12 265.718C298.761 267.126 300.316 268.304 302.495 269.036C304.674 269.768 307.217 269.966 309.655 269.592L331.063 266.31C331.469 266.248 331.825 266.126 332.108 265.963C332.569 265.697 332.832 265.323 332.787 264.927L327.667 219.215L325.817 220.241L325.815 220.242Z"
                                fill="#757575" />
                            <path
                                d="M321.362 222.715L326.512 263.276L308.28 266.104C307.421 266.238 306.526 266.167 305.76 265.907C304.994 265.647 304.454 265.229 304.236 264.731C303.801 263.726 304.859 262.695 306.597 262.434L322.331 260.068L322.163 258.909C316.811 259.719 311.455 260.529 306.103 261.339C303.33 261.756 301.639 263.4 302.336 265.006C302.68 265.801 303.543 266.467 304.766 266.883C305.989 267.299 307.418 267.41 308.788 267.197L327.293 264.327C327.573 264.283 327.821 264.198 328.015 264.086C328.339 263.899 328.523 263.635 328.486 263.356L323.198 221.697L321.364 222.716L321.362 222.715Z"
                                fill="#757575" />
                        </g>

                        <defs>
                            <filter id="filter0_d_1109_6875" x="201.767" y="34" width="234.304" height="202.328"
                                filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                <feColorMatrix in="SourceAlpha" type="matrix"
                                    values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                <feOffset dy="4" />
                                <feGaussianBlur stdDeviation="5" />
                                <feComposite in2="hardAlpha" operator="out" />
                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.3 0" />
                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1109_6875" />
                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1109_6875"
                                    result="shape" />
                            </filter>
                            <filter id="filter1_d_1109_6875" x="345.615" y="105.924" width="214.597" height="214.609"
                                filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                <feColorMatrix in="SourceAlpha" type="matrix"
                                    values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                <feOffset dy="4" />
                                <feGaussianBlur stdDeviation="5" />
                                <feComposite in2="hardAlpha" operator="out" />
                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.3 0" />
                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1109_6875" />
                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1109_6875"
                                    result="shape" />
                            </filter>
                            <filter id="filter2_d_1109_6875" x="77" y="105.924" width="214.598" height="214.609"
                                filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                <feColorMatrix in="SourceAlpha" type="matrix"
                                    values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                <feOffset dy="4" />
                                <feGaussianBlur stdDeviation="5" />
                                <feComposite in2="hardAlpha" operator="out" />
                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.3 0" />
                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1109_6875" />
                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1109_6875"
                                    result="shape" />
                            </filter>
                            <filter id="filter3_d_1109_6875" x="206" y="193.261" width="234.475" height="201.739"
                                filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                <feColorMatrix in="SourceAlpha" type="matrix"
                                    values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                <feOffset dy="4" />
                                <feGaussianBlur stdDeviation="5" />
                                <feComposite in2="hardAlpha" operator="out" />
                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.3 0" />
                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1109_6875" />
                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1109_6875"
                                    result="shape" />
                            </filter>
                            <linearGradient id="paint0_linear_1109_6875" x1="342.5" y1="182" x2="212" y2="141.5"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#B0B0B0" />
                                <stop offset="1" stop-color="#EBEBEB" />
                            </linearGradient>
                            <clipPath id="clip0_1109_6875">
                                <rect width="100" height="100" fill="white"
                                    transform="matrix(0.866025 -0.5 0.866025 0.5 360 172)" />
                            </clipPath>
                            <clipPath id="clip1_1109_6875">
                                <rect width="100" height="100" fill="white"
                                    transform="matrix(0.866025 -0.5 0.866025 0.5 238 251)" />
                            </clipPath>
                        </defs>
                </svg>
            </div>
        </div>
    </div>
</section>
<section class="bg-primary relative overflow-hidden z-1">
    <div class="absolute bottom-0 left-0 -z-10 pointer-events-none hidden md:block">
        <img src="<?php echo SITE_URL; ?>/assets/images/ui/bg_lubi_drop_left_light.png" alt="lubrication decision"
            class="block h-full w-full object-cover object-center" loading="lazy">
    </div>

    <div class="absolute top-0 right-0 h-full -z-10 pointer-events-none">
        <img src="<?php echo SITE_URL; ?>/assets/images/ui/bg_lubi_drop_right_light.png" alt="lubrication decision"
            class="block h-full w-full object-cover object-center" loading="lazy">
    </div>

    <div class="container relative z-10 md:pt-16 md:pb-18 pt-4 pb-5">
        <div class="py-3.5">
            <span
                class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                who we are
            </span>
            <div class="border-b border-[#ffffff] pb-1">
                <h2
                    class="text-main-green font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                    A brand driven by purpose, backed by science. since 1971
                </h2>
            </div>
        </div>

        <div class="swiper who-we-are-swiper !pt-8 md:block block" id="about-who-we-are-swiper">
            <div class="swiper-wrapper md:grid md:grid-cols-5">
                <?php foreach ($lubricant_features as $feature): ?>
                    <div
                        class="swiper-slide group relative bg-y100 md:h-[204px] !h-[204px] p-3   overflow-hidden transition-all duration-300 ease-in-out hover:-translate-y-4 !mt-4">
                        <div
                            class="absolute inset-0 bg-white/20 translate-y-full transition-transform duration-500 group-hover:translate-y-0 pointer-events-none">
                        </div>

                        <h6
                            class="text-[#3B3B3B] font-base font-normal text-[20px] leading-[140%] md:text-[18px] md:leading-[140%] mb-2 relative z-10">
                            <?php echo $feature['title']; ?>
                        </h6>

                        <p
                            class="text-[#666666] font-base font-normal text-[14px] md:text-[12px] leading-[150%] md:leading-[150%] tracking-[0.015em] relative z-10">
                            <?php echo $feature['desc']; ?>
                        </p>

                        <div
                            class="absolute bottom-0 left-0 h-1 w-0 bg-[#1A3B1B] transition-all duration-300 group-hover:w-full z-20">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="flex md:hidden items-center gap-4 relative z-10 justify-end mt-6">
                <button class="who-we-are-prev group cursor-pointer" aria-label="Previous slide">
                    <svg class="w-12 h-12 transition-transform group-active:scale-90" viewBox="0 0 48 48">
                        <circle cx="24" cy="24" r="23" stroke="#1A3B1B" stroke-width="2" fill="none" />
                        <path d="M34 24L14 24M14 24L20 18M14 24L20 30" stroke="#1A3B1B" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <button class="who-we-are-next group cursor-pointer" aria-label="Next slide">
                    <svg class="w-12 h-12 transition-transform group-active:scale-90" viewBox="0 0 48 48">
                        <circle cx="24" cy="24" r="23" stroke="#1A3B1B" stroke-width="2" fill="none" />
                        <path d="M14 24L34 24M34 24L28 18M34 24L28 30" stroke="#1A3B1B" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

<section class="relative">
    <div class="container md:py-20">
        <div class="py-3.5">
            <span
                class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                Why Mosil Matters?
            </span>
            <div class="border-b border-primary pb-1">
                <h2
                    class="text-main-green font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                    Pushing the boundaries of
                    your performance
                </h2>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 pt-6 md:pt-0">
            <?php foreach ($mosil_matters as $item): ?>
                <div
                    class="relative group overflow-hidden w-full md:h-[300px] h-[220px] flex flex-col justify-end cursor-pointer">

                    <div class="absolute inset-0 transition-transform duration-700 ease-out group-hover:scale-110"
                        style="background: linear-gradient(180deg, rgba(0, 0, 0, 0) 30%, rgba(0, 0, 0, 0.9) 100%), 
                        url('<?php echo SITE_URL; ?>/assets/images/ui/<?php echo $item['image']; ?>') no-repeat center/cover;">
                    </div>

                    <div
                        class="relative z-10 md:px-6 md:py-5 px-4 py-4 transition-transform duration-500 ease-out transform md:translate-y-15 group-hover:translate-y-0 max-w-[230px] md:max-w-full">

                        <h6
                            class="text-white font-base font-normal md:text-[24px] md:leading-[135%] text-[18px] leading-[140%] tracking-[0.015em] capitalize">
                            <?php echo $item['title']; ?>
                        </h6>

                        <p
                            class="text-white font-base font-light text-[15px] leading-[150%] mt-2 opacity-0 transition-opacity duration-300 group-hover:opacity-100 hidden md:block">
                            <?php echo $item['description']; ?>
                        </p>
                    </div>

                    <div
                        class="absolute inset-0 bg-main-green/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="relative bg-[#F5F5F5]">
    <div class="container pt-5 md:pb-6 pb-14 relative">
        <div class="py-3.5">
            <span
                class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                Visionaries behind
            </span>
            <div class="border-b border-primary pb-1">
                <h2
                    class="text-main-green font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                    Leadership driving progress
                </h2>
            </div>
        </div>
        <div class="grid grid-cols-1 pt-7">
            <div class="relative md:absolute top-0 right-0 w-full h-full flex justify-end">
                <img src="<?php echo SITE_URL; ?>/assets/images/ui/directors.svg" alt="Leadership driving progress"
                    class="object-contain object-right-top w-full h-full">
            </div>
            <div
                class="md:px-6 md:py-6 p-5 pt-9 bg-[#ffffff] bg-[#FAFAFA] border-l border-[#F4C300] rounded-bl-[33px] mb-5">
                <h2
                    class="text-[#1A3B1B] font-base font-normal text-[20px] leading-[150%] tracking-[0.01em] relative pl-10">
                    <span class="absolute md:bottom-1/2 bottom-full left-0"><img
                            src="<?php echo SITE_URL; ?>/assets/icons/svg/quotes.svg" alt=" quote" /></span>
                    Great machines builds nation, great lubricants keep them alive
                </h2>
            </div>
            <div class="inline-flex flex-col items-start gap-6 w-full max-w-[718px]">
                <p class="text-[#757575] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em]">
                    Today,
                    the industrial world is evolving rapidly, with more automation, higher loads,
                    stringent
                    regulations, and growing sustainability expectations. In this environment, lubrication is no longer
                    a
                    side function; it has become a strategic lever for uptime, efficiency and long-term value.</p>
                <p class="text-[#757575] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em]">
                    MOSIL stands at the center of this shift. With a foundation rooted in tribology and a mindset shaped
                    by
                    real-world industry challenges, we engineer solutions - not just products. To ensure top performance
                    for
                    our customers, we invest in our employees as well as in state-of-the-art testing equipment, analysis
                    tools and infrastructure that exceed performance requirements.</p>
                <p class="text-[#757575] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em]">
                    Our commitment remains unchanged: to keep industries moving, machines performing and our customers
                    ahead
                    of what’s next as their performance multiplier
                </p>
                <div class="flex items-start gap-1 flex-col">
                    <p
                        class="text-[#575757] font-base font-bold text-[20px] leading-[140%] tracking-[0.01em] capitalize">
                        Samvar
                        Abindra Mavani & Shail Abindra Mavani</p>
                    <p class="text-[#575757] font-base font-normal text-[14px] leading-[150%] tracking-[0.015em]">
                        Directors,
                        MOSIL lubricants</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const card = document.getElementById('quadra-info-card');
        const boxes = document.querySelectorAll('.quadra-box');
        const positions = ['pos-top', 'pos-left', 'pos-right', 'pos-bottom'];

        boxes.forEach(box => {
            box.addEventListener('mouseenter', () => {
                const pos = box.getAttribute('data-pos');

                // Update Content
                document.getElementById('info-title').textContent = box.getAttribute('data-title');
                document.getElementById('info-desc').textContent = box.getAttribute('data-desc');

                // Remove previous positions first
                card.classList.remove(...positions);

                // Add new position and show
                card.classList.add(`pos-${pos}`);
                card.classList.remove('opacity-0', 'translate-y-2'); // Remove hidden state
            });

            box.addEventListener('mouseleave', () => {
                // Hide card
                card.classList.add('opacity-0', 'translate-y-2');
                card.classList.remove(...positions);
            });
        });

        // Hide card when clicking outside (Mobile/Touch specific)
        document.addEventListener('click', (e) => {
            const isClickInsideBox = e.target.closest('.quadra-box');
            // Card has pointer-events: none, so clicks will pass through it to whatever is behind.
            // But we still check if the click was NOT on a box.

            if (!isClickInsideBox) {
                card.classList.add('opacity-0', 'translate-y-2');
                card.classList.remove(...positions);
            }
        });
    });
</script>