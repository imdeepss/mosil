<?php

// Get params from URL (rewritten via .htaccess)
$categorySlug = isset($_GET['category']) ? $_GET['category'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : 'industry'; // 'industry' or 'product'

// Fetch category name from database
$categoryDetails = getCategoryDetailsBySlug($categorySlug);

if ($categoryDetails) {
    $categoryName = $categoryDetails['mcat_name'];
} else {
    $categoryName = ucwords(str_replace('-', ' ', $categorySlug));
    if (empty($categoryName)) {
        $categoryName = 'All Products';
    }
}

$pageTitle = $categoryName . ' - Products';


// Breadcrumb Logic
$parentLink = SITE_URL . '/product-finder';
$parentLabel = 'Product Finder';

if ($type === 'product') {
    $categoryLink = SITE_URL . '/product-finder/product-categories';
    $categoryLabel = 'Product Categories';
} else {
    $categoryLink = SITE_URL . '/product-finder/industry-categories';
    $categoryLabel = 'Industry Categories';
}


$productInfo = getProductsByCategorySlug($categorySlug);
$subCategories = getSubCategoriesByMainCategory($categorySlug);


?>
<!-- Hero Section -->
<section class="relative w-full h-[748px] md:h-[480px] overflow-hidden">
    <div class="container relative z-20 flex items-end justify-start w-full h-full pb-4 md:pb-10">
        <h2
            class="text-white font-base font-normal text-[32px] md:text-[48px] leading-[120%] tracking-normal capitalize">
            <?php echo $categoryName; ?>
        </h2>
    </div>
    <div class="absolute inset-0 z-0 w-full h-full">
        <?php if ($type === 'product'): ?>
            <img src="<?php echo SITE_URL; ?>/assets/images/banners/banner-v2-indu.png" alt="Product Finder Desktop"
                class="hidden md:block w-full h-full object-cover object-[50%_75%]" fetchpriority="high">

            <img src="<?php echo SITE_URL; ?>/assets/images/banners/banner-v2-indu-mb.png" alt="Product Finder Mobile"
                class="block md:hidden w-full h-full object-cover object-center" fetchpriority="high">
        <?php else: ?>
            <!-- Dynamic banner image could go here based on category -->
            <img src="<?php echo SITE_URL; ?>/assets/images/banners/product-listing.png" alt="Product Listing Desktop"
                class="hidden md:block w-full h-full object-cover object-[50%_75%]" fetchpriority="high">

            <img src="<?php echo SITE_URL; ?>/assets/images/banners/mb-product-listing.png" alt="Product Listing Mobile"
                class="block md:hidden w-full h-full object-cover object-center" fetchpriority="high">
        <?php endif; ?>
    </div>
</section>

<!-- Product Listing -->
<section class="bg-white">
    <div class="flex flex-col md:flex-row relative">

        <aside id="productCategorySidebar"
            class="fixed inset-0 z-[60] w-full h-full -translate-x-full transition-transform duration-300 overflow-y-auto bg-[#F4C300] md:translate-x-0 md:static md:inset-auto md:z-auto md:w-[388px] md:h-[767px] md:min-h-0 md:overflow-visible shrink-0 text-left">
            <h2
                class="text-main-green truncate font-base font-bold md:text-[24px] md:leading-[135%] text-[20px] leading-[140%] capitalize md:pt-9 pt-4 md:pb-6 pb-8 text-left md:px-[60px] px-4 flex items-center justify-between">
                Categories
                <button id="closeProductSidebar" class="md:hidden block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <path d="M8 24L24 8M8 8L24 24" stroke="#3B3B3B" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>
            </h2>

            <nav id="category-sidebar-nav"
                class="flex flex-col md:max-h-[660px] md:overflow-y-auto pr-4 md:pr-0 md:ml-2 md:pl-2 md:[direction:rtl] [&::-webkit-scrollbar]:w-2.5 [&::-webkit-scrollbar-track]:bg-[#FAE696] [&::-webkit-scrollbar-track]:rounded-full [&::-webkit-scrollbar-thumb]:bg-[#F6CD2B] [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:min-h-[32px] hover:[&::-webkit-scrollbar-thumb]:bg-[#F6CD2B]">
                <?php

                $filterItems = array_merge(
                    [['id' => 0, 'name' => 'All Products']],
                    $subCategories
                );

                foreach ($filterItems as $index => $cat):
                    $isChecked = ($index === 0) ? 'checked' : '';
                    ?>
                    <label
                        class="[direction:ltr] flex items-center justify-between py-4 md:px-[60px] px-4 border-b border-[#FAE696] cursor-pointer group gap-4">
                        <span class="text-main-green font-base font-normal text-[18px] leading-[140%] capitalize">
                            <?= $cat['name']; ?>
                        </span>
                        <input type="checkbox" <?= $isChecked; ?> class="subcategory-filter w-5 h-5 border border-[#1A3B1B] rounded-[4px] bg-transparent cursor-pointer appearance-none 
                          relative flex items-center justify-center shrink-0 my-[2.5px]
                          checked:bg-[#1A3B1B] transition-all duration-200
                          checked:before:content-[''] 
                          checked:before:w-[14px] checked:before:h-[14px] 
                          checked:before:bg-no-repeat checked:before:bg-center checked:before:bg-contain 
                          checked:before:bg-[url('<?= SITE_URL; ?>/assets/icons/svg/check.svg')]"
                            value="<?= $cat['id']; ?>">
                    </label>
                <?php endforeach;
                ?>
            </nav>
        </aside>

        <main class="flex-1 px-4 py-6 md:px-[54px] md:py-7 bg-white">

            <nav
                class="flex items-center breadcrumbs gap-1 text-[14px] md:text-[16px] leading-[150%] tracking-[0.015em] capitalize flex-wrap">
                <a href="<?php echo SITE_URL; ?>/" class="text-[#A3A3A3] font-light">Home</a>

                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg></span>
                <a href="<?php echo $parentLink; ?>" class="text-[#A3A3A3] font-light"><?php echo $parentLabel; ?></a>

                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg></span>
                <a href="<?php echo $categoryLink; ?>"
                    class="text-[#A3A3A3] font-light"><?php echo $categoryLabel; ?></a>

                <?php if (!empty($categoryName)): ?>
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg></span>
                    <a href="#" class="text-[#575757] font-bold pointer-events-none"><?php echo $categoryName; ?></a>
                <?php endif; ?>
            </nav>

            <div class="py-[14px] mt-4 md:mt-0">
                <div class="border-b-2 border-primary pb-2 flex items-center gap-4">
                    <button id="openProductSidebar" class="md:hidden block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <path d="M5.33398 8H26.6673M5.33398 16H26.6673M5.33398 24H26.6673" stroke="#666666"
                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <h2
                        class="text-main-green font-normal text-lg md:text-[24px] md:leading-[135%] leading-[140%] tracking-[0.015em] flex items-center gap-4">
                        All Products <span id="grid-total-count"
                            class="md:text-base text-[12px] leading-[120%] text-[#757575]">(<?php echo $productInfo['total_found']; ?>
                            Results)</span>
                    </h2>
                </div>
            </div>

            <div id="product-display-grid"
                class="grid grid-cols-2 md:grid-cols-3 md:gap-x-10 md:gap-y-12.5 md:py-2 md:max-h-[600px] md:overflow-y-auto gap-4 custom-scrollbar pr-4">
                <?php
                foreach ($productInfo['products'] as $product):
                    $productName = $product['name'];
                    $productSlug = $product['slug'];
                    ?>
                    <div
                        class="group cursor-pointer py-4 transition-all duration-500 ease-in-out hover:-translate-y-4 relative">
                        <a
                            href="<?php echo SITE_URL; ?>/product-finder/<?php echo $categorySlug ? $categorySlug : 'all'; ?>/<?php echo $productSlug; ?>">
                            <div
                                class="bg-[#FAFAFA] aspect-[4/3] flex items-center justify-center overflow-hidden md:mb-2.5 mb-2 md:border md:border-[#EBEBEB] md:py-2 md:px-5 md:h-[135px] h-[150px] w-full px-[34px] py-[30px]">
                                <img src="<?php echo SITE_URL; ?>/assets/uploads/products-image/<?php echo $product['image']; ?>"
                                    alt="<?php echo $productName; ?>"
                                    class="w-full h-full object-contain mix-blend-multiply">
                            </div>

                            <h3
                                class="text-[#3B3B3B] font-base font-bold md:text-[18px] md:leading-[140%] text-[16px] leading-[150%] tracking-[0.015em] capitalize md:mb-2 mb-1">
                                <?php echo $productName; ?>
                            </h3>
                            <p
                                class="text-[#757575] font-base font-normal text-[12px] leading-[150%] tracking-[0.015em] line-clamp-4">
                                <?php echo $product['sub_title']; ?>
                            </p>
                        </a>
                        <div
                            class="absolute bottom-0 left-0 h-1 w-0 bg-primary transition-all duration-300 group-hover:w-full">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('productCategorySidebar');
        const openBtn = document.getElementById('openProductSidebar');
        const closeBtn = document.getElementById('closeProductSidebar');

        if (openBtn && sidebar && closeBtn) {
            openBtn.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
            });

            closeBtn.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
            });
        }

        // --- Filter Logic ---
        const checkboxes = document.querySelectorAll('.subcategory-filter');
        const productGrid = document.getElementById('product-display-grid');
        const totalCountSpan = document.getElementById('grid-total-count');
        const categorySlug = "<?php echo $categorySlug; ?>";
        const siteUrl = "<?php echo SITE_URL; ?>";

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                // Mutually Exclusive Behavior: "Radio-like" checkbox
                // If I am checked, uncheck everyone else
                if (this.checked) {
                    checkboxes.forEach(cb => {
                        if (cb !== this) cb.checked = false;
                    });
                } else {
                    // If I am unchecked, and nothing else is checked, do we revert to "All Products" (id=0)?
                    // "All Products" is usually the checkbox with value 0.
                    // If the user unchecks the current selection, let's force check "All Products" if it exists.
                    // Or if they unchecked "All Products", we keep it checked?

                    // Logic: At least one must be checked? Or unchecking reverts to default.

                    // Check if anything is checked now
                    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    if (!anyChecked) {
                        // Nothing checked, find the "All Products" (value 0) and check it
                        const allProdCheckbox = Array.from(checkboxes).find(cb => cb.value == '0');
                        if (allProdCheckbox) {
                            allProdCheckbox.checked = true;
                        }
                    }
                }

                // Determine active ID
                let activeId = 0;
                checkboxes.forEach(cb => {
                    if (cb.checked) activeId = cb.value;
                });

                fetchProducts(activeId);
            });
        });

        function fetchProducts(subCatId) {
            // Optional: Show loading state
            productGrid.style.opacity = '0.5';

            const formData = new FormData();
            formData.append('sub_cat_id', subCatId);
            formData.append('category_slug', categorySlug);

            fetch(siteUrl + '/ajax/product-filter.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    // Update Grid
                    productGrid.innerHTML = data.html;
                    // Update Count
                    // Keep the text format: (25 Results)
                    if (totalCountSpan) {
                        totalCountSpan.innerText = `(${data.count} Results)`;
                    }

                    // Restore Opacity
                    productGrid.style.opacity = '1';
                })
                .catch(error => {
                    console.error('Error fetching products:', error);
                    productGrid.style.opacity = '1';
                });
        }

        // --- Smooth Parent Scroll (Scroll Chaining) Helper ---
        function handleScrollChaining(element) {
            element.addEventListener('wheel', (e) => {
                // Only apply on desktop where the fixed height/overflow exists (md breakpoint)
                if (window.innerWidth >= 768) {
                    const {
                        scrollTop,
                        scrollHeight,
                        clientHeight
                    } = element;

                    // Check boundaries with 1px tolerance
                    const isAtBottom = Math.ceil(scrollTop + clientHeight) >= scrollHeight;
                    const isAtTop = scrollTop <= 0;

                    // Propagate scroll to window if at boundary and user is trying to scroll past it
                    if ((isAtBottom && e.deltaY > 0) || (isAtTop && e.deltaY < 0)) {
                        e.preventDefault();
                        window.scrollBy({
                            top: e.deltaY,
                            behavior: 'smooth'
                        });
                    }
                }
            }, {
                passive: false
            });
        }

        // Apply to Product Grid
        if (productGrid) {
            handleScrollChaining(productGrid);
        }

        // Apply to Sidebar Nav
        const sidebarNav = document.getElementById('category-sidebar-nav');
        if (sidebarNav) {
            handleScrollChaining(sidebarNav);
        }
    });
</script>