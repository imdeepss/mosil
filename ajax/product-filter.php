<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

$subCatId = isset($_POST['sub_cat_id']) ? (int) $_POST['sub_cat_id'] : 0;
$categorySlug = isset($_POST['category_slug']) ? $_POST['category_slug'] : '';

if ($subCatId > 0) {
    // Fetch by subcategory ID
    $data = getProductsBySubCategoryID($subCatId, $categorySlug);
} else {
    // Default: Fetch by main category slug (All Products)
    $data = getProductsByCategorySlug($categorySlug);
}

$products = $data['products'];
$totalCount = $data['total_found'];

ob_start();
if (!empty($products)):
    foreach ($products as $product):
        // Ensure we have a product name and slug
        $productName = isset($product['name']) ? $product['name'] : '';
        $productSlug = isset($product['slug']) ? $product['slug'] : '';
        $productImage = isset($product['image']) ? $product['image'] : 'dummy.png';
        $shortDesc = isset($product['short_description']) ? $product['short_description'] : '';

        // Construct Detail Link
        $detailLink = SITE_URL . '/product-finder/' . ($categorySlug ? $categorySlug : 'all') . '/' . $productSlug;
        ?>
        <div class="group cursor-pointer py-4">
            <a href="<?php echo $detailLink; ?>">
                <div
                    class="bg-[#FAFAFA] aspect-[4/3] flex items-center justify-center overflow-hidden md:mb-2.5 mb-2 md:border md:border-[#EBEBEB] md:py-5 md:px-22 md:h-[135px] h-[150px] w-full px-[34px] py-[30px]">
                    <img src="<?php echo SITE_URL; ?>/assets/uploads/products-image/<?php echo $productImage; ?>"
                        alt="<?php echo htmlspecialchars($productName); ?>"
                        class="w-full h-auto object-contain transition-transform duration-500 group-hover:scale-110">
                </div>
                <h3
                    class="text-[#3B3B3B] font-base font-bold md:text-[18px] md:leading-[140%] text-[16px] leading-[150%] tracking-[0.015em] capitalize md:mb-2 mb-1">
                    <?php echo $productName; ?>
                </h3>
                <p class="text-[#757575] font-base font-normal text-[12px] leading-[150%] tracking-[0.015em] line-clamp-4">
                    <?php echo $shortDesc; ?>
                </p>
            </a>
        </div>
        <?php
    endforeach;
else:
    ?>
    <div class="col-span-full py-10 text-center">
        <p class="text-[#757575] font-base text-lg">No products found in this category.</p>
    </div>
    <?php
endif;

$htmlHtml = ob_get_clean();

header('Content-Type: application/json');
echo json_encode(['count' => $totalCount, 'html' => $htmlHtml]);
exit;
?>