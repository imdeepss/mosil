<?php
$pageTitle = 'Product Details';

$chevronRight = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round" />
</svg>';

$categorySlug = isset($_GET['category']) ? $_GET['category'] : '';
$productSlug = isset($_GET['product']) ? $_GET['product'] : '';

$product = getProductBySlug($productSlug);
$blogs = getBlogs(10);
$relatedProducts = getRelatedProducts($product['sub_cat'] ?? '', $product['id'] ?? 0);

$packingImageMap = [
    "Spray500ML" => SITE_URL . "/assets/icons/svg/packet.svg",
    "Spray700ML" => SITE_URL . "/assets/icons/svg/packet.svg",
    "1kg" => SITE_URL . "/assets/icons/svg/packet.svg",
    "5kg" => SITE_URL . "/assets/icons/svg/container.svg",
    "5ltr" => SITE_URL . "/assets/icons/svg/container.svg",
    "20kg" => SITE_URL . "/assets/icons/svg/container.svg",
    "20ltr" => SITE_URL . "/assets/icons/svg/container.svg",
    "180kg" => SITE_URL . "/assets/icons/svg/container.svg",
    "180ltr" => SITE_URL . "/assets/icons/svg/barrel.svg",
    "210kg" => SITE_URL . "/assets/icons/svg/barrel.svg",
    "210ltr" => SITE_URL . "/assets/icons/svg/barrel.svg",
];




function parseListString($str)
{
    if (empty($str))
        return [];

    $str = str_ireplace(['&nbsp;', '&amp;nbsp;'], ' ', $str);

    $str = html_entity_decode($str);

    $str = str_replace("\xC2\xA0", ' ', $str);

    $str = str_ireplace(['</li>', '<br>', '<br/>', '<p>', '</ul>', '</div>'], "\n", $str);
    $str = strip_tags($str);

    $lines = explode("\n", $str);

    $lines = array_map(function ($line) {
        return trim($line, " \t\n\r\0\x0B-•");
    }, $lines);

    return array_filter($lines, function ($line) {
        return !empty(trim($line));
    });
}

function parseTableString($str)
{
    if (empty($str))
        return ['headers' => [], 'rows' => []];

    $str = html_entity_decode($str);

    $str = str_ireplace(['<br>', '<br/>', '<br />'], "\n", $str);

    if (stripos($str, '<table') !== false) {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $str);
        libxml_clear_errors();

        $rows = [];
        $headers = [];
        $foundHeader = false;

        $trElements = $dom->getElementsByTagName('tr');
        foreach ($trElements as $rowIndex => $tr) {
            $cols = [];
            $cells = $tr->childNodes;
            foreach ($cells as $cell) {
                if ($cell->nodeName === 'td' || $cell->nodeName === 'th') {
                    $val = trim($cell->textContent);
                    if ($val === '' || $val === '&nbsp;') {
                        $val = '-';
                    }
                    $cols[] = $val;
                }
            }

            if (empty($cols))
                continue;

            while (count($cols) < 3)
                $cols[] = '-';
            $cols = array_slice($cols, 0, 3);

            if (
                !$foundHeader && (
                    stripos($cols[0], 'Characteristics') !== false ||
                    stripos($cols[1], 'Test Method') !== false ||
                    stripos($cols[2], 'Typical Values') !== false)
            ) {
                $headers = $cols;
                $foundHeader = true;
            } else {
                $rows[] = $cols;
            }
        }

        if (empty($headers)) {
            $headers = ['Characteristics', 'Test Method', 'Typical Values'];
        }

        return ['headers' => $headers, 'rows' => $rows];
    }

    $str = strip_tags($str);

    $lines = explode("\n", trim($str));
    $headers = [];
    $rows = [];

    $foundHeader = false;

    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line))
            continue;

        $cols = explode("\t", $line);
        $cols = array_map('trim', $cols);

        while (count($cols) < 3) {
            $cols[] = '-';
        }
        $cols = array_slice($cols, 0, 3);

        if (
            !$foundHeader && (
                stripos($cols[0], 'Characteristics') !== false ||
                stripos($cols[1], 'Test Method') !== false ||
                stripos($cols[2], 'Typical Values') !== false)
        ) {
            $headers = $cols;
            $foundHeader = true;
        } else {
            $rows[] = $cols;
        }
    }

    if (empty($headers)) {
        $headers = ['Characteristics', 'Test Method', 'Typical Values'];
    }

    return ['headers' => $headers, 'rows' => $rows];
}

?>
<?php if (!$product): ?>
    <section class="container py-20 text-center">
        <h1 class="text-3xl font-bold text-gray-700">Product Not Found</h1>
        <p class="text-gray-500 mt-4">The product you are looking for does not exist or has been removed.</p>

        <a href="<?php echo SITE_URL; ?>/product-finder"
            class="inline-block mt-6 px-6 py-3 bg-main-green text-white rounded-full">Back to Product Finder</a>
    </section>
    <?php return; endif; ?>


<section class="h-[60px] sticky top-0 z-10 bg-white"></section>

<div class="flex flex-col gap-6 mb-6">
    <!-- Breadcrumbs & Product Main Info -->
    <section class="container py-6">
        <nav
            class="flex items-center breadcrumbs gap-1 text-[14px] md:text-[16px] leading-[150%] tracking-[0.015em] capitalize flex-wrap">
            <a href="<?php echo SITE_URL; ?>/" class="text-[#A3A3A3] font-light">Home</a>
            <span><?php echo $chevronRight; ?></span>
            <a href="<?php echo SITE_URL; ?>/product-finder" class="text-[#A3A3A3] font-light">Product Finder</a>

            <?php




            if ($categorySlug) {
                $categoryName = ucwords(str_replace('-', ' ', $categorySlug));


                echo '<span>' . $chevronRight . '</span>';

                ?>
                <a href="<?php echo SITE_URL; ?>/product-finder/industry-categories/<?php echo $categorySlug; ?>"
                    class="text-[#575757] font-bold"><?php echo $categoryName; ?></a>
                <?php
            }

            if ($productSlug) {
                echo '<span>' . $chevronRight . '</span>';
                echo '<span class="text-[#575757] font-bold">' . ucwords(str_replace('-', ' ', $productSlug)) . '</span>';
            }
            ?>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-10 pt-6 pb-[56px]">
            <!-- Product Image -->
            <div
                class="bg-[#F5F5F5] border border-[#EBEBEB] flex items-center justify-center h-[315px] md:h-auto md:mb-[66px]">
                <div class="w-full max-w-[180px] md:max-w-[215px] aspect-[4/3] flex items-center justify-center">
                    <img src="<?php echo SITE_URL; ?>/assets/uploads/products-image/<?php echo $product['image'] ?>"
                        alt="<?= htmlspecialchars($product['name']) ?>"
                        class="max-w-full max-h-full object-contain mix-blend-multiply transition-transform duration-500 hover:scale-105">
                </div>
            </div>
            <!-- Product Details -->
            <div>
                <div class="bg-primary p-6">
                    <div class="flex flex-col md:gap-8 gap-5">
                        <h1
                            class="text-main-green font-base font-bold md:text-[32px] md:leading-[120%] capitalize text-[24px] leading-[135%]">
                            <?php echo $product['name'] ?>
                        </h1>
                        <div>
                            <p class="font-base mb-2 font-normal text-[16px] leading-[150%] text-[#575757]">
                                <?= nl2br(htmlspecialchars($product['sub_title'] ?? '')) ?>
                            </p>

                            <?php $shortDescList = parseListString($product['short_description'] ?? ''); ?>
                            <?php if (!empty($shortDescList)): ?>
                                <ul
                                    class="list-inside list-disc font-base font-normal text-[16px] leading-[150%] text-[#575757] flex flex-col gap-2">
                                    <?php foreach ($shortDescList as $descItem): ?>
                                        <li><?= nl2br(htmlspecialchars($descItem)) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <!-- Pack Sizes -->
                        <div class="flex items-center gap-2">
                            <?php $packingList = array_filter(array_map('trim', explode(',', $product['packing'] ?? '')));
                            sort($packingList, SORT_NATURAL | SORT_FLAG_CASE);

                            foreach ($packingList as $packing):
                                $packing = trim($packing); ?>
                                <div
                                    class="bg-[#F9DC6B] text-[#575757] font-base font-normal text-[16px] leading-[150%] py-1 px-2 rounded-full flex items-center justify-center gap-1">
                                    <img src="<?php echo $packingImageMap[$packing]; ?>" alt="Container" width="32"
                                        height="32">
                                    <span
                                        class="text-[#575757] font-base font-normal text-[16px] leading-[135%] tracking-[0.01em]"><?= $packing ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-2 justify-start pt-4">
                    <button type="button"
                        class="openEnquiryModal py-3 px-11 bg-main-green text-white text-center font-base font-normal text-lg md:text-[16px] leading-[150%] tracking-[0.015em] rounded-full border border-main-green button-hover transition-colors cursor-pointer">
                        Enquire Now
                    </button>
                    <button type="button"
                        class="openEnquiryModal py-3 px-11 text-main-green bg-white border border-main-green text-center font-base font-normal text-lg md:text-[16px] leading-[150%] tracking-[0.015em] rounded-full button-hover transition-colors cursor-pointer">
                        Get TDS
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Enquiry Modal -->
    <div id="enquiryModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 transition-opacity" aria-hidden="true" id="modalBackdrop">
        </div>

        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Modal Panel -->
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full w-full relative">

                <div class="absolute top-4 right-4 cursor-pointer" id="closeEnquiryModal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 hover:text-gray-700"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-2xl font-medium leading-6 text-main-green mb-6" id="modal-title">Enquire</h3>

                    <form method="POST" action="">
                        <input type="hidden" name="submit_enquiry" value="1">
                        <input type="hidden" name="subject"
                            value="<?= htmlspecialchars($product['name'] ?? 'Product Enquiry') ?>">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- First Name -->
                            <div>
                                <input type="text" name="first_name" required placeholder="First Name"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-main-green text-gray-700 placeholder-gray-400">
                            </div>
                            <!-- Last Name -->
                            <div>
                                <input type="text" name="last_name" required placeholder="Last Name"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-main-green text-gray-700 placeholder-gray-400">
                            </div>
                            <!-- Email -->
                            <div>
                                <input type="email" name="email" required placeholder="Email"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-main-green text-gray-700 placeholder-gray-400">
                            </div>
                            <!-- Company Name -->
                            <div>
                                <input type="text" name="company_name" required placeholder="Company Name"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-main-green text-gray-700 placeholder-gray-400">
                            </div>
                            <!-- Phone -->
                            <div>
                                <input type="text" name="contact" required placeholder="+91 Phone"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-main-green text-gray-700 placeholder-gray-400">
                            </div>
                            <!-- Zip -->
                            <div>
                                <input type="text" name="pincode" required placeholder="Zip"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-main-green text-gray-700 placeholder-gray-400">
                            </div>
                            <!-- Country -->
                            <div>
                                <input type="text" name="country" placeholder="Country"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-main-green text-gray-700 placeholder-gray-400">
                            </div>
                            <!-- City -->
                            <div>
                                <input type="text" name="city" placeholder="City"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-main-green text-gray-700 placeholder-gray-400">
                            </div>
                            <!-- Industry -->
                            <div>
                                <input type="text" name="industry" placeholder="Industry"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-main-green text-gray-700 placeholder-gray-400">
                            </div>
                            <!-- Product Name (Readonly) -->
                            <div>
                                <input type="text" value="<?= htmlspecialchars($product['name'] ?? '') ?>" disabled
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md bg-gray-50 text-gray-500">
                            </div>
                        </div>

                        <!-- Message -->
                        <div class="mb-6">
                            <textarea name="message" required placeholder="Write your message here" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-main-green text-gray-700 placeholder-gray-400"></textarea>
                        </div>

                        <!-- Message Container -->
                        <div id="formMessage" class="hidden mb-4 text-center text-sm font-medium"></div>

                        <!-- Submit Button -->
                        <div class="text-left">
                            <button type="submit"
                                class="px-8 py-3 bg-main-green text-white font-medium rounded-full hover:bg-opacity-90 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-main-green">
                                Submit
                            </button>
                        </div>
                        <!-- response -->
                    </form>
                </div>
            </div>
        </div>
    </div>




    <!-- Product Information Accordion -->
    <div class="bg-[#F5F5F5]">
        <section class="container md:py-6 py-8">
            <h2
                class="mb-10 text-main-green font-base font-normal text-[24px] md:text-[32px] md:leading-[120%] leading-[135%] capitalize">
                Product Information
            </h2>
            <div class="w-full flex flex-col">
                <div class="w-full flex flex-col">
                    <?php
                    $areaOfAppList = parseListString($product['area_of_application'] ?? '');
                    $benefitsList = parseListString($product['benifits'] ?? ($product['benefits'] ?? ''));
                    $characteristicsData = parseTableString($product['characteristics'] ?? '');

                    $productInfo = [];

                    if (!empty($areaOfAppList)) {
                        $productInfo['Area of Application'] = [
                            'type' => 'list',
                            'content' => $areaOfAppList
                        ];
                    }

                    if (!empty($benefitsList)) {
                        $productInfo['Benefits'] = [
                            'type' => 'list',
                            'content' => $benefitsList
                        ];
                    }

                    if (!empty($characteristicsData['rows'])) {
                        $productInfo['Characteristics'] = [
                            'type' => 'table',
                            'headers' => $characteristicsData['headers'],
                            'content' => $characteristicsData['rows']
                        ];
                    }
                    ?>

                    <?php foreach ($productInfo as $title => $data): ?>
                        <details class="group border-b-2 border-[#EBEBEB] overflow-hidden transition-all duration-500">
                            <summary
                                class="flex justify-between items-center px-4 py-4 md:px-5 md:py-6 cursor-pointer list-none outline-none">
                                <span
                                    class="text-[#3B3B3B] font-base font-normal text-[20px] md:text-[24px] md:leading-[135%] leading-[140%] tracking-[0.015em] capitalize transition-transform duration-300">
                                    <?php echo $title; ?>
                                </span>
                                <div class="relative w-6 h-6 flex items-center justify-center">
                                    <span class="absolute md:w-5 w-4 h-[2px] bg-[#3B3B3B] rounded-full"></span>
                                    <span
                                        class="absolute w-[2px] md:h-5 h-4 bg-[#3B3B3B] rounded-full transition-transform duration-500 ease-in-out group-open:rotate-90 group-open:opacity-0"></span>
                                </div>
                            </summary>

                            <div
                                class="text-[#757575] font-base font-normal text-[16px] leading-[150%] animate-fadeIn px-4 md:px-5">
                                <?php if ($data['type'] === 'list'): ?>
                                    <ul
                                        class="flex flex-col gap-2 [&>li]:border-b-2 [&>li]:border-[#EBEBEB] [&>li]:py-2 [&>li]:text-[16px] [&>li]:leading-[150%] [&>li]:tracking-[0.01em] [&>li]:text-main-green [&>li]:relative [&>li:last-child]:border-0">
                                        <?php foreach ($data['content'] as $listItem): ?>
                                            <li class="flex items-start md:items-center md:gap-4 gap-3">
                                                <span
                                                    class="bg-main-green rounded-full p-1 w-6 h-6 flex items-center justify-center shrink-0 mt-1 md:mt-0">
                                                    <img src="<?php echo SITE_URL; ?>/assets/icons/svg/check.svg" alt="" width="14"
                                                        height="14" />
                                                </span>
                                                <span class="text-[#575757]"><?php echo $listItem; ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php elseif ($data['type'] === 'table'): ?>
                                    <div class="overflow-x-auto">
                                        <table class="w-full min-w-[600px] text-left border-collapse">
                                            <thead>
                                                <tr class="bg-[#EBEBEB] border-b border-[#F5F5F5]">
                                                    <?php foreach ($data['headers'] as $header): ?>
                                                        <th
                                                            class="py-4 px-4 text-[#3B3B3B] text-center font-base font-normal text-[18px] leading-[120%] tracking-[0.01em] border-r border-[#FFFFFF]">
                                                            <?php echo $header; ?>
                                                        </th>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data['content'] as $row): ?>
                                                    <tr
                                                        class="bg-[#FFFFFF] border-b border-[#EBEBEB] last:border-0 hover:bg-gray-50 transition-colors">
                                                        <td
                                                            class="py-3 px-4 text-[#949494] text-center font-base font-normal text-[14px] leading-[120%] tracking-[0.01em]">
                                                            <?php echo $row[0]; ?>
                                                        </td>
                                                        <td
                                                            class="py-3 px-4 text-[#949494] text-center font-base font-normal text-[14px] leading-[120%] tracking-[0.01em]">
                                                            <?php echo $row[1]; ?>
                                                        </td>
                                                        <td
                                                            class="py-3 px-4 text-[#949494] text-center font-base font-normal text-[14px] leading-[120%] tracking-[0.01em]">
                                                            <?php echo $row[2]; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </details>
                    <?php endforeach; ?>
                </div>
        </section>
    </div>

    <!-- Relevant Products Slider -->
    <section class="container">
        <div class="mt-[56px] overflow-hidden">
            <div class="py-[14px] mt-4 md:mt-0">
                <div class="border-b-2 border-primary pb-2 flex items-center justify-between gap-4">

                    <h2
                        class="text-main-green font-normal text-lg md:text-[24px] md:leading-[135%] leading-[140%] tracking-[0.015em] flex items-center gap-4">
                        Relevant products
                    </h2>
                    <div class="hidden md:flex items-center gap-4 relative z-10">
                        <button
                            class="group cursor-pointer relevant-prev [&.swiper-button-disabled]:opacity-50 [&.swiper-button-disabled]:cursor-not-allowed">
                            <svg class="w-8 h-8 transition-transform group-active:scale-90 text-main-green rotate-180"
                                viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="16" cy="16" r="15" stroke="currentColor" stroke-width="2" />

                                <g transform="translate(8, 8)">
                                    <path
                                        d="M8.88307 3.17285L13.3247 7.61451M13.3247 7.61451L8.88306 12.0562M13.3247 7.61451L1.90332 7.61451"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </g>
                            </svg>
                        </button>
                        <button
                            class="group cursor-pointer relevant-next [&.swiper-button-disabled]:opacity-50 [&.swiper-button-disabled]:cursor-not-allowed">
                            <svg class="w-8 h-8 transition-transform group-active:scale-90 text-main-green"
                                viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="16" cy="16" r="15" stroke="currentColor" stroke-width="2" />

                                <g transform="translate(8, 8)">
                                    <path
                                        d="M8.88307 3.17285L13.3247 7.61451M13.3247 7.61451L8.88306 12.0562M13.3247 7.61451L1.90332 7.61451"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </g>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Swiper Container -->
            <div class="relevantProductsSwiper swiper w-full md:py-2">
                <div class="swiper-wrapper">
                    <?php foreach ($relatedProducts as $product):
                        $productName = $product['name'];
                        $productSlug = $product['slug']; ?>
                        <div class="swiper-slide group cursor-pointer py-4">
                            <a
                                href="<?php echo SITE_URL; ?>/product-finder/<?php echo $categorySlug ? $categorySlug : 'all'; ?>/<?php echo $productSlug; ?>">
                                <div
                                    class="bg-[#FAFAFA] aspect-[4/3] flex items-center justify-center overflow-hidden md:mb-4 mb-2 md:border md:border-[#EBEBEB] md:py-5 md:px-22 md:h-[208px] h-[150px] w-full px-[34px] py-[30px]">
                                    <img src="<?php echo SITE_URL; ?>/assets/uploads/products-image/<?php echo $product['image']; ?>"
                                        alt="<?php echo $productName; ?>"
                                        class="w-full h-auto object-contain transition-transform duration-500 group-hover:scale-110 mix-blend-darken aspect-[4/3]">
                                </div>
                                <h3
                                    class="text-[#3B3B3B] font-base font-bold text-[24px] leading-[135%] capitalize md:mb-2 mb-1">
                                    <?php echo $productName; ?>
                                </h3>
                                <p
                                    class="text-[#757575] font-base font-normal text-[14px] leading-[150%] tracking-[0.015em] line-clamp-4">
                                    <?php echo $product['short_description']; ?>
                                </p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="flex md:hidden items-center justify-end gap-4 relative z-10 pt-4">
                <button
                    class="group cursor-pointer relevant-prev [&.swiper-button-disabled]:opacity-50 [&.swiper-button-disabled]:cursor-not-allowed">
                    <svg class="w-8 h-8 transition-transform group-active:scale-90 text-main-green rotate-180"
                        viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="16" cy="16" r="15" stroke="currentColor" stroke-width="2" />

                        <g transform="translate(8, 8)">
                            <path
                                d="M8.88307 3.17285L13.3247 7.61451M13.3247 7.61451L8.88306 12.0562M13.3247 7.61451L1.90332 7.61451"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                    </svg>
                </button>
                <button
                    class="group cursor-pointer relevant-next [&.swiper-button-disabled]:opacity-50 [&.swiper-button-disabled]:cursor-not-allowed">
                    <svg class="w-8 h-8 transition-transform group-active:scale-90 text-main-green" viewBox="0 0 32 32"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="16" cy="16" r="15" stroke="currentColor" stroke-width="2" />

                        <g transform="translate(8, 8)">
                            <path
                                d="M8.88307 3.17285L13.3247 7.61451M13.3247 7.61451L8.88306 12.0562M13.3247 7.61451L1.90332 7.61451"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <!-- Case Studies Slider -->
    <section class="container">
        <div class="mt-[56px] mb-[10px] overflow-hidden">
            <div class="py-[14px] mt-4 md:mt-0">
                <div class="border-b-2 border-primary pb-2 flex items-center justify-between gap-4">

                    <h2
                        class="text-main-green font-normal text-lg md:text-[24px] md:leading-[135%] leading-[140%] tracking-[0.015em] flex items-center gap-4">
                        Case studies
                    </h2>
                    <div class="md:flex hidden items-center gap-4 relative z-10">
                        <button
                            class="group cursor-pointer case-prev [&.swiper-button-disabled]:opacity-50 [&.swiper-button-disabled]:cursor-not-allowed">
                            <svg class="w-8 h-8 transition-transform group-active:scale-90 text-main-green rotate-180"
                                viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="16" cy="16" r="15" stroke="currentColor" stroke-width="2" />

                                <g transform="translate(8, 8)">
                                    <path
                                        d="M8.88307 3.17285L13.3247 7.61451M13.3247 7.61451L8.88306 12.0562M13.3247 7.61451L1.90332 7.61451"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </g>
                            </svg>
                        </button>
                        <button
                            class="group cursor-pointer case-next [&.swiper-button-disabled]:opacity-50 [&.swiper-button-disabled]:cursor-not-allowed">
                            <svg class="w-8 h-8 transition-transform group-active:scale-90 text-main-green"
                                viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="16" cy="16" r="15" stroke="currentColor" stroke-width="2" />

                                <g transform="translate(8, 8)">
                                    <path
                                        d="M8.88307 3.17285L13.3247 7.61451M13.3247 7.61451L8.88306 12.0562M13.3247 7.61451L1.90332 7.61451"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </g>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Swiper Container -->
            <div class="caseStudySwiper swiper w-full mt-8">
                <div class="swiper-wrapper ">
                    <?php foreach ($blogs as $blog): ?>
                        <div class="swiper-slide !h-auto">
                            <div class="relative h-[240px] w-full rounded-[4px] overflow-hidden">
                                <img src="<?php echo SITE_URL; ?>/assets/uploads/blog/<?php echo $blog['image']; ?>"
                                    alt="Hero Image" class="block h-full w-full object-center rounded-[4px]" loading="lazy">
                                <div
                                    class="absolute bottom-2 left-2 px-2 py-1 bg-[var(--color-primary)] text-[var(--color-main-green)] font-bold text-[10px] leading-[135%] tracking-[0.01em]">
                                    <h2><?php echo $blog['category_name']; ?></h2>
                                </div>
                            </div>
                            <div class="my-4">
                                <h2
                                    class="font-bold text-lg leading-[140%] tracking-[0.015em] capitalize text-[#3B3B3B] mb-3">
                                    <?php echo $blog['title']; ?>
                                </h2>
                                <p
                                    class="font-normal text-[16px] leading-[150%] tracking-[0.015em] text-[var(--color-b100)] mb-2 line-clamp-3">
                                    <?php
                                    $content = $blog['content'];

                                    $content = strip_tags($content);

                                    $content = trim(preg_replace('/\s+/', ' ', $content));

                                    echo substr($content, 0, 500);
                                    ?>
                                </p>
                                <p
                                    class="font-normal text-[14px] leading-[150%] tracking-[0.015em] text-[var(--color-b70)]">
                                    <?php echo $blog['category_name']; ?> |
                                    <?php echo date('F d, Y', strtotime($blog['created_at'])); ?>
                                </p>
                            </div>
                            <a href="<?php echo SITE_URL; ?>/blog/<?= urlencode(
                                   $blog["slug"]
                               ) ?>"
                                class="font-bold text-[18px] leading-[140%] tracking-[0.015em] capitalize text-[var(--color-main-green)] border-b-2 border-[var(--color-primary)] pb-2 inline-block w-fit">Read
                                <?php echo $blog['category_name']; ?></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="flex md:hidden items-center justify-end gap-4 relative z-10 pt-4">
                <button
                    class="group cursor-pointer case-prev [&.swiper-button-disabled]:opacity-50 [&.swiper-button-disabled]:cursor-not-allowed">
                    <svg class="w-8 h-8 transition-transform group-active:scale-90 text-main-green rotate-180"
                        viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="16" cy="16" r="15" stroke="currentColor" stroke-width="2" />

                        <g transform="translate(8, 8)">
                            <path
                                d="M8.88307 3.17285L13.3247 7.61451M13.3247 7.61451L8.88306 12.0562M13.3247 7.61451L1.90332 7.61451"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                    </svg>
                </button>
                <button
                    class="group cursor-pointer case-next [&.swiper-button-disabled]:opacity-50 [&.swiper-button-disabled]:cursor-not-allowed">
                    <svg class="w-8 h-8 transition-transform group-active:scale-90 text-main-green" viewBox="0 0 32 32"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="16" cy="16" r="15" stroke="currentColor" stroke-width="2" />

                        <g transform="translate(8, 8)">
                            <path
                                d="M8.88307 3.17285L13.3247 7.61451M13.3247 7.61451L8.88306 12.0562M13.3247 7.61451L1.90332 7.61451"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                    </svg>
                </button>
            </div>
        </div>
    </section>
</div>