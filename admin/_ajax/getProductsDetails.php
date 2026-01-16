<?php
ob_start();
// require_once '../config/config.php';
// require_once '../includes/functions.php';


// Include configuration and functions
require_once '../../includes/config.php';
require_once '../../includes/functions.php';

$id  = $_POST['id'];

$products = [];
$productSql = "SELECT * FROM `products_v2` WHERE `id`= $id";
$productResult = $conn->query($productSql);
if ($productResult && $productResult->num_rows > 0) {
    while ($row = $productResult->fetch_assoc()) {
        $products[] = $row;
    }
}

// Fetch Parent Categories
$parentCategories = [];
$parentCatSql = "SELECT id, name FROM parent_category";
$parentCatResult = $conn->query($parentCatSql);
if ($parentCatResult && $parentCatResult->num_rows > 0) {
    while ($row = $parentCatResult->fetch_assoc()) {
        $parentCategories[] = $row;
    }
}



// Fetch Main Categories
$mainCategories = [];
$mainCatSql = "SELECT id, mcat_name FROM main_category";
$mainCatResult = $conn->query($mainCatSql);
if ($mainCatResult && $mainCatResult->num_rows > 0) {
    while ($row = $mainCatResult->fetch_assoc()) {
        $mainCategories[] = $row;
    }
}

// Fetch Sub Categories
$subCategories = [];
$subCatSql = "SELECT id, scat_name, m_cat FROM sub_category";
$subCatResult = $conn->query($subCatSql);
if ($subCatResult && $subCatResult->num_rows > 0) {
    while ($row = $subCatResult->fetch_assoc()) {
        $subCategories[] = $row;
    }
}

// Fetch Parent Attributes
$parentAttributes = [];
$parentAttrSql = "SELECT id, parent_attr_name FROM parent_attribute";
$parentAttrResult = $conn->query($parentAttrSql);
if ($parentAttrResult && $parentAttrResult->num_rows > 0) {
    while ($row = $parentAttrResult->fetch_assoc()) {
        $parentAttributes[] = $row;
    }
}

// Fetch Main Attributes
$mainAttributes = [];
$mainAttrSql = "SELECT id, main_attr_name FROM main_attribute";
$mainAttrResult = $conn->query($mainAttrSql);
if ($mainAttrResult && $mainAttrResult->num_rows > 0) {
    while ($row = $mainAttrResult->fetch_assoc()) {
        $mainAttributes[] = $row;
    }
}

// Fetch Sub Attributes
$subAttributes = [];
$subAttrSql = "SELECT id, sub_attr_name FROM sub_attribute";
$subAttrResult = $conn->query($subAttrSql);
if ($subAttrResult && $subAttrResult->num_rows > 0) {
    while ($row = $subAttrResult->fetch_assoc()) {
        $subAttributes[] = $row;
    }
}

$packing_options = [
    "1kg",
    "5kg",
    "5ltr",
    "20kg",
    "20ltr",
    "180kg",
    "180ltr",
    "210kg",
    "210ltr",
    "Spray500ML",
    "Spray700ML"
];

$cat_options = [
	"Autoassembly","Cardoor","Carseat","Engineparts","Fastners","Guideslideways","Motor","Opengear","Rollerbearing","Sunroof","Wireropep"
];
?>

<!-- Edit Product Modal -->
<?php foreach ($products as $product): ?>
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel<?php echo $id; ?>">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="#" class="needs-validation" enctype="multipart/form-data" id="editProductForm<?php echo $id; ?>">
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">

                    <ul class="nav nav-tabs" id="productTab<?php echo $id; ?>" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="basic-tab<?php echo $id; ?>" data-bs-toggle="tab" data-bs-target="#basic<?php echo $id; ?>" type="button" role="tab" aria-controls="basic<?php echo $id; ?>" aria-selected="true">Basic Information</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="categories-tab<?php echo $id; ?>" data-bs-toggle="tab" data-bs-target="#categories<?php echo $id; ?>" type="button" role="tab" aria-controls="categories<?php echo $id; ?>" aria-selected="false">Categories</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="attributes-tab<?php echo $id; ?>" data-bs-toggle="tab" data-bs-target="#attributes<?php echo $id; ?>" type="button" role="tab" aria-controls="attributes<?php echo $id; ?>" aria-selected="false">Attributes</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="details-tab<?php echo $id; ?>" data-bs-toggle="tab" data-bs-target="#details<?php echo $id; ?>" type="button" role="tab" aria-controls="details<?php echo $id; ?>" aria-selected="false">Product Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="media-tab<?php echo $id; ?>" data-bs-toggle="tab" data-bs-target="#media<?php echo $id; ?>" type="button" role="tab" aria-controls="media<?php echo $id; ?>" aria-selected="false">Media</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="seo-tab<?php echo $id; ?>" data-bs-toggle="tab" data-bs-target="#seo<?php echo $id; ?>" type="button" role="tab" aria-controls="seo<?php echo $id; ?>" aria-selected="false">SEO</button>
                        </li>
                    </ul>

                    <div class="tab-content p-3 border border-top-0" id="productTabContent<?php echo $id; ?>">
                        <!-- Basic Information Tab -->
                        <div class="tab-pane fade show active" id="basic<?php echo $id; ?>" role="tabpanel" aria-labelledby="basic-tab<?php echo $id; ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="product_name<?php echo $id; ?>" class="form-label">Product Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="product_name<?php echo $id; ?>" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="product_slug<?php echo $id; ?>" class="form-label">Product Slug <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="product_slug<?php echo $id; ?>" name="product_slug" value="<?php echo htmlspecialchars($product['slug']); ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="sub_title<?php echo $id; ?>" class="form-label">Sub Title</label>
                                <input class="form-control" id="sub_title<?php echo $id; ?>" name="sub_title" value="<?php echo htmlspecialchars($product['sub_title'] ?? ''); ?>"></input>
                            </div>
                            <div class="mb-3">
                                <label for="short_description<?php echo $id; ?>" class="form-label">Short Description</label>
                                <textarea class="form-control" id="short_description<?php echo $id; ?>" name="short_description" rows="3"><?php echo htmlspecialchars($product['short_description'] ?? ''); ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="status<?php echo $id; ?>" class="form-label">Status</label>
                                <select class="form-select" id="status<?php echo $id; ?>" name="status">
                                    <option value="Active" <?php echo ($product['status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                                    <option value="Inactive" <?php echo ($product['status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <!-- Categories Tab -->
                        <div class="tab-pane fade" id="categories<?php echo $id; ?>" role="tabpanel" aria-labelledby="categories-tab<?php echo $id; ?>">
                            <div class="mb-3">
                                <label for="parent_cat<?php echo $id; ?>" class="form-label">Parent Category <span class="text-danger">*</span></label>
                                <select class="form-select select2" id="parent_cat<?php echo $id; ?>" name="parent_cat[]" multiple required>
                                    <option value="">Select Parent Category</option>
                                    <?php
                                    $selectedParentCats = explode(',', $product['parent_cat'] ?? '');
                                    foreach ($parentCategories as $parentCat):
                                    ?>
                                        <option value="<?php echo htmlspecialchars($parentCat['id']); ?>" <?php echo in_array($parentCat['id'], $selectedParentCats) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($parentCat['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="main_cat<?php echo $id; ?>" class="form-label">Main Category</label>
                                <select class="form-select select2" id="main_cat<?php echo $id; ?>" name="main_cat[]" multiple>
                                    <option value="">Select Main Category</option>
                                    <?php
                                    $selectedMainCats = explode(',', $product['main_cat'] ?? '');
                                    foreach ($mainCategories as $mainCat):
                                    ?>
                                        <option value="<?php echo htmlspecialchars($mainCat['id']); ?>" <?php echo in_array($mainCat['id'], $selectedMainCats) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($mainCat['mcat_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="sub_cat<?php echo $id; ?>" class="form-label">Sub Category</label>
                                <select class="form-select select2" id="sub_cat<?php echo $id; ?>" name="sub_cat[]" multiple>
                                    <option value="">Select Sub Category</option>
                                    <?php
                                    $selectedSubCats = explode(',', $product['sub_cat'] ?? '');
                                    foreach ($subCategories as $subCat):
                                    ?>
                                        <option value="<?php echo htmlspecialchars($subCat['id']); ?>" <?php echo in_array($subCat['id'], $selectedSubCats) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($subCat['scat_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>

                        <!-- Attributes Tab -->
                        <div class="tab-pane fade" id="attributes<?php echo $id; ?>" role="tabpanel" aria-labelledby="attributes-tab<?php echo $id; ?>">
                            <div class="mb-3">
                                <label for="parent_attribute<?php echo $id; ?>" class="form-label">Parent Attribute</label>
                                <select class="form-select select2" id="parent_attribute<?php echo $id; ?>" name="parent_attribute[]" multiple>
                                    <option value="">Select Parent Attribute</option>
                                    <?php
                                    $selectedMainAttrs = explode(',', $product['attribute'] ?? '');
                                    foreach ($parentAttributes as $parentAttr):
                                    ?>
                                        <option value="<?php echo htmlspecialchars($parentAttr['id']); ?>" <?php echo in_array($parentAttr['id'], $selectedMainAttrs) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($parentAttr['parent_attr_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="main_attribute<?php echo $id; ?>" class="form-label">Main Attribute</label>
                                <select class="form-select select2" id="main_attribute<?php echo $id; ?>" name="main_attribute[]" multiple>
                                    <option value="">Select Main Attribute</option>
                                    <?php
                                    $selectedMainAttrs = explode(',', $product['main_attribute'] ?? '');
                                    foreach ($mainAttributes as $mainAttr):
                                    ?>
                                        <option value="<?php echo htmlspecialchars($mainAttr['id']); ?>" <?php echo in_array($mainAttr['id'], $selectedMainAttrs) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($mainAttr['main_attr_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="sub_attribute<?php echo $id; ?>" class="form-label">Sub Attribute</label>
                                <select class="form-select select2" id="sub_attribute<?php echo $id; ?>" name="sub_attribute[]" multiple>
                                    <option value="">Select Sub Attribute</option>
                                    <?php
                                    $selectedSubAttrs = explode(',', $product['sub_attribute'] ?? '');
                                    foreach ($subAttributes as $subAttr):
                                    ?>
                                        <option value="<?php echo htmlspecialchars($subAttr['id']); ?>" <?php echo in_array($subAttr['id'], $selectedSubAttrs) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($subAttr['sub_attr_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Product Details Tab -->
                        <div class="tab-pane fade" id="details<?php echo $id; ?>" role="tabpanel" aria-labelledby="details-tab<?php echo $id; ?>">
                            <div class="mb-3">
                                <label for="packing<?php echo $id; ?>" class="form-label">Packing</label>
                                <select class="form-select select2" id="packing<?php echo $id; ?>" name="packing[]" multiple>
                                    <option value="">Select Packing</option>
                                    <?php
                                    $selectPacking = explode(',', $product['packing'] ?? '');
                                    foreach ($packing_options as $option) {
                                        $selected = in_array($option, $selectPacking) ? 'selected' : '';
                                        echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="area_of_application<?php echo $id; ?>" class="form-label">Area of Application</label>
                                <textarea class="form-control rich-editor" id="area_of_application<?php echo $id; ?>" name="area_of_application" rows="5"><?php echo htmlspecialchars($product['area_of_application'] ?? ''); ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="benifits<?php echo $id; ?>" class="form-label">Benefits</label>
                                <textarea class="form-control rich-editor" id="benifits<?php echo $id; ?>" name="benifits" rows="5"><?php echo htmlspecialchars($product['benifits'] ?? ''); ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="characteristics<?php echo $id; ?>" class="form-label">Characteristics</label>
                                <textarea class="form-control rich-editor" id="characteristics<?php echo $id; ?>" name="characteristics" rows="5"><?php echo htmlspecialchars($product['characteristics'] ?? ''); ?></textarea>
                            </div>
                        </div>

                        <!-- Media Tab -->
                        <div class="tab-pane fade" id="media<?php echo $id; ?>" role="tabpanel" aria-labelledby="media-tab<?php echo $id; ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="product_image<?php echo $id; ?>" class="form-label">Product Image</label>
                                        <?php if (!empty($product['image'])): ?>
                                            <div class="mb-2">
                                                <img src="../uploads/products-image/<?php echo htmlspecialchars($product['image']); ?>" alt="Current Product Image" class="img-thumbnail product_img" style="max-height: 150px;">
                                            </div>
                                        <?php endif; ?>
                                        <input type="file" class="form-control required" id="product_image<?php echo $id; ?>" name="product_image" accept="image/*" required>
                                        <input type="hidden" class="existing_image" value="../uploads/products-image/<?php echo htmlspecialchars($product['image']); ?>" />
                                        <div class="form-text">Leave empty to keep the current image. Accepted formats: JPG, JPEG, PNG, GIF.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tds_file<?php echo $id; ?>" class="form-label">TDS File</label>
                                        <?php if (!empty($product['tds_file'])): ?>
                                            <div class="mb-2">
                                                <a href="../uploads/tds/<?php echo htmlspecialchars($product['tds_file']); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-file-pdf me-1"></i> View Current TDS File
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        <input type="file" class="form-control required" id="tds_file<?php echo $id; ?>" name="tds_file" accept=".pdf,.doc,.docx" required>
                                        <input type="hidden" class="existing_image" value="../uploads/tds/<?php echo htmlspecialchars($product['tds_file']); ?>" />
                                        <div class="form-text">Leave empty to keep the current file. Accepted formats: PDF, DOC, DOCX.</div>
                                    </div>
                                </div>
								<div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="product_cat_image" class="form-label">Product Cat Image</label>
										<select class="form-select" id="product_cat_image" name="product_cat_image">
											<option value="">Select Product Image</option>
										<?php
										$selectPacking = explode(',', $product['meta_title'] ?? '');
										foreach ($cat_options as $option) {
											$selected = in_array($option, $selectPacking) ? 'selected' : '';
											echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
										}
										?>
										</select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Tab -->
                        <div class="tab-pane fade" id="seo<?php echo $id; ?>" role="tabpanel" aria-labelledby="seo-tab<?php echo $id; ?>">
                            <div class="mb-3">
                                <label for="meta_title<?php echo $id; ?>" class="form-label">Meta Title</label>
                                <input type="text" class="form-control" id="meta_title<?php echo $id; ?>" name="meta_title" value="<?php echo htmlspecialchars($product['meta_title'] ?? ''); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="meta_description<?php echo $id; ?>" class="form-label">Meta Description</label>
                                <textarea class="form-control" id="meta_description<?php echo $id; ?>" name="meta_description" rows="3"><?php echo htmlspecialchars($product['meta_description'] ?? ''); ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="meta_keywords<?php echo $id; ?>" class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" id="meta_keywords<?php echo $id; ?>" name="meta_keywords" value="<?php echo htmlspecialchars($product['meta_keywords'] ?? ''); ?>">
                                <div class="form-text">Separate keywords with commas.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

<?php endforeach;
echo ob_get_clean(); // Output the full modal HTML
?>