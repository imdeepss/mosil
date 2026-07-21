<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login");
    exit;
}

// Include configuration and functions
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Page title
$page_title = "Products";
$active_menu = "catalogue_product";

// Initialize variables
$message = '';
$messageType = '';


$all_posts = [];
$productSql = "SELECT * FROM `products_v2` ORDER BY `id` ASC";
$productResult = $conn->query($productSql);
if ($productResult && $productResult->num_rows > 0) {
    while ($row = $productResult->fetch_assoc()) {
        $all_posts[] = $row;
    }
}

$active_posts = array_filter($all_posts, function($post) { return $post['status'] === 'Active'; });
$inactive_posts = array_filter($all_posts, function($post) { return $post['status'] !== 'Active'; });

$status_filter = isset($_GET['status']) ? strtolower($_GET['status']) : 'all';

if ($status_filter === 'active') {
    $products = $active_posts;
} elseif ($status_filter === 'inactive') {
    $products = $inactive_posts;
} else {
    $products = $all_posts;
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

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add' || $action === 'edit') {
            // Get form data
            $productId = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
            $productName = sanitizeInput($_POST['product_name'] ?? '');
            $sub_title = sanitizeInput($_POST['sub_title'] ?? '');
            $productSlug = sanitizeInput($_POST['product_slug'] ?? '');

            // Handle multiple select values
            $parentCat = isset($_POST['parent_cat']) && is_array($_POST['parent_cat']) ? implode(',', $_POST['parent_cat']) : '';
            $mainCat = isset($_POST['main_cat']) && is_array($_POST['main_cat']) ? implode(',', $_POST['main_cat']) : '';
            $subCat = isset($_POST['sub_cat']) && is_array($_POST['sub_cat']) ? implode(',', $_POST['sub_cat']) : '';
            $mainAttribute = isset($_POST['main_attribute']) && is_array($_POST['main_attribute']) ? implode(',', $_POST['main_attribute']) : '';
            $parentAttribute = isset($_POST['parent_attribute']) && is_array($_POST['parent_attribute']) ? implode(',', $_POST['parent_attribute']) : '';
            $subAttribute = isset($_POST['sub_attribute']) && is_array($_POST['sub_attribute']) ? implode(',', $_POST['sub_attribute']) : '';
            $packing = isset($_POST['packing']) && is_array($_POST['packing']) ? implode(',', $_POST['packing']) : '';

            $shortDescription = sanitizeInput($_POST['short_description'] ?? '');
            $areaOfApplication = $_POST['area_of_application'] ?? '';
            $benifits = $_POST['benifits'] ?? '';
            $characteristics = $_POST['characteristics'] ?? '';
            // $packing = sanitizeInput($_POST['packing'] ?? '');
            $metaTitle = sanitizeInput($_POST['product_cat_image'] ?? '');
            $metaDescription = sanitizeInput($_POST['meta_description'] ?? '');
            $metaKeywords = sanitizeInput($_POST['meta_keywords'] ?? '');
            $status = sanitizeInput($_POST['status'] ?? 'Active');

            // Handle FAQs
            $faqsArray = [];
            if (isset($_POST['faq_question']) && is_array($_POST['faq_question'])) {
                foreach ($_POST['faq_question'] as $index => $question) {
                    $q = sanitizeInput($question);
                    $a = $_POST['faq_answer'][$index] ?? '';
                    if (!empty($q) && !empty($a)) {
                        $faqsArray[] = ['question' => $q, 'answer' => $a];
                    }
                }
            }
            $faqsJson = !empty($faqsArray) ? json_encode($faqsArray, JSON_UNESCAPED_UNICODE) : null;

            // Handle file uploads
            $productImage = '';
            $tdsFile = '';

            // Process product image upload
            if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../assets/uploads/products-image/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = basename($_FILES['product_image']['name']);
                $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                $newFileName = 'product_' . time() . '_' . uniqid() . '.' . $fileExt;
                $uploadFile = $uploadDir . $newFileName;
                $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                if (in_array(strtolower($fileExt), $validExtensions)) {
                    if (move_uploaded_file($_FILES['product_image']['tmp_name'], $uploadFile)) {
                        $productImage = $newFileName;
                    } else {
                        $message = "Failed to upload product image.";
                        $messageType = "danger";
                    }
                } else {
                    $message = "Invalid image format. Allowed formats: JPG, JPEG, PNG, GIF.";
                    $messageType = "danger";
                }
            }

            // Process TDS file upload
            if (isset($_FILES['tds_file']) && $_FILES['tds_file']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../assets/uploads/tds/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = basename($_FILES['tds_file']['name']);
                $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                $newFileName = 'tds_' . time() . '.' . $fileExt;
                $uploadFile = $uploadDir . $newFileName;
                $validExtensions = ['pdf', 'doc', 'docx'];
                if (in_array(strtolower($fileExt), $validExtensions)) {
                    if (move_uploaded_file($_FILES['tds_file']['tmp_name'], $uploadFile)) {
                        $tdsFile = $newFileName;
                    } else {
                        $message = "Failed to upload TDS file.";
                        $messageType = "danger";
                    }
                } else {
                    $message = "Invalid TDS file format. Allowed formats: PDF, DOC, DOCX.";
                    $messageType = "danger";
                }
            }

            if (empty($productImage)) {
                $message = "Product image is required.";
                $messageType = "danger";
            } elseif (empty($tdsFile)) {
                $message = "TDS file is required.";
                $messageType = "danger";
            }


            // Validate form data
            if (empty($productName) || empty($productSlug)) {
                $message = "Please fill in all required fields.";
                $messageType = "danger";
            } else {
                // Check if slug is unique
                $slugCheckSql = "SELECT id FROM products_v2 WHERE slug = ? AND id != ?";
                $slugStmt = $conn->prepare($slugCheckSql);
                $slugStmt->bind_param("si", $productSlug, $productId);
                $slugStmt->execute();
                $slugResult = $slugStmt->get_result();

                if ($slugResult->num_rows > 0) {
                    $message = "Product slug already exists. Please choose a different slug.";
                    $messageType = "danger";
                } else {
                    // Prepare current timestamp
                    $currentTime = date('Y-m-d H:i:s');

                    if ($action === 'add') {
                        // Insert new product
                        $insertSql = "INSERT INTO products_v2 (
                            name, sub_title,slug, parent_cat, main_cat, sub_cat, attribute,
                            main_attribute, sub_attribute, short_description, 
                            area_of_application, benifits, characteristics, 
                            packing, faqs, image, tds_file, meta_title, 
                            meta_description, meta_keywords, status, 
                            created_at, updated_at
                        ) VALUES (?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                        $stmt = $conn->prepare($insertSql);
                        $stmt->bind_param(
                            "sssssssssssssssssssssss",
                            $productName,
                            $sub_title,
                            $productSlug,
                            $parentCat,
                            $mainCat,
                            $subCat,
                            $parentAttribute,
                            $mainAttribute,
                            $subAttribute,
                            $shortDescription,
                            $areaOfApplication,
                            $benifits,
                            $characteristics,
                            $packing,
                            $faqsJson,
                            $productImage,
                            $tdsFile,
                            $metaTitle,
                            $metaDescription,
                            $metaKeywords,
                            $status,
                            $currentTime,
                            $currentTime
                        );

                        if ($stmt->execute()) {
                            $message = "Product added successfully.";
                            $messageType = "success";

                            // Log activity
                            logActivity("Product Added", "Added new product: $productName");

                            // Redirect to prevent form resubmission
                            header("Location: " . $_SERVER['PHP_SELF'] . "?success=added");
                            exit;
                        } else {
                            $message = "Error adding product: " . $stmt->error;
                            $messageType = "danger";
                        }
                    } else {
                        // Update existing product
                        $updateSql = "UPDATE products_v2 SET 
                            name = ?, 
                            sub_title = ?, 
                            slug = ?, 
                            parent_cat = ?, 
                            main_cat = ?, 
                            sub_cat = ?, 
                            attribute = ?,
                            main_attribute = ?, 
                            sub_attribute = ?, 
                            short_description = ?, 
                            area_of_application = ?, 
                            benifits = ?, 
                            characteristics = ?, 
                            packing = ?, 
                            faqs = ?,
                            meta_title = ?, 
                            meta_description = ?, 
                            meta_keywords = ?, 
                            status = ?, 
                            updated_at = ?";

                        $params = [
                            $productName,
                            $sub_title,
                            $productSlug,
                            $parentCat,
                            $mainCat,
                            $subCat,
                            $parentAttribute,
                            $mainAttribute,
                            $subAttribute,
                            $shortDescription,
                            $areaOfApplication,
                            $benifits,
                            $characteristics,
                            $packing,
                            $faqsJson,
                            $metaTitle,
                            $metaDescription,
                            $metaKeywords,
                            $status,
                            $currentTime
                        ];
                        $types = "ssssssssssssssssssss";

                        // Add image if uploaded
                        if (!empty($productImage)) {
                            $updateSql .= ", image = ?";
                            $params[] = $productImage;
                            $types .= "s";
                        }

                        // Add TDS file if uploaded
                        if (!empty($tdsFile)) {
                            $updateSql .= ", tds_file = ?";
                            $params[] = $tdsFile;
                            $types .= "s";
                        }

                        // Add WHERE clause
                        $updateSql .= " WHERE id = ?";
                        $params[] = $productId;
                        $types .= "i";

                        $stmt = $conn->prepare($updateSql);
                        $stmt->bind_param($types, ...$params);

                        if ($stmt->execute()) {
                            $message = "Product updated successfully.";
                            $messageType = "success";

                            // Log activity
                            logActivity("Product Updated", "Updated product: $productName (ID: $productId)");

                            // Redirect to prevent form resubmission
                            header("Location: " . $_SERVER['PHP_SELF'] . "?success=updated");
                            exit;
                        } else {
                            $message = "Error updating product: " . $stmt->error;
                            $messageType = "danger";
                        }
                    }
                }
            }
        } elseif ($action === 'delete') {
            $productId = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;

            // Get product details before deletion for logging
            $getProductSql = "SELECT name, image, tds_file FROM products_v2 WHERE id = ?";
            $getStmt = $conn->prepare($getProductSql);
            $getStmt->bind_param("i", $productId);
            $getStmt->execute();
            $productResult = $getStmt->get_result();
            $productData = $productResult->fetch_assoc();

            if ($productData) {
                // Delete the product
                $deleteSql = "DELETE FROM products_v2 WHERE id = ?";
                $stmt = $conn->prepare($deleteSql);
                $stmt->bind_param("i", $productId);

                if ($stmt->execute()) {
                    // Delete associated files
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $fileType = finfo_file($finfo, $_FILES['import_file']['tmp_name']);
                    finfo_close($finfo);

                    if ($fileType !== 'text/plain' && $fileType !== 'text/csv' && $fileType !== 'application/vnd.ms-excel') {
                        $message = "Invalid file type. Please upload a CSV file.";
                        $messageType = "danger";
                        exit;
                    }


                    if (!empty($productData['tds_file'])) {
                        $tdsPath = 'Uploads/tds/' . $productData['tds_file'];
                        if (file_exists($tdsPath)) {
                            unlink($tdsPath);
                        }
                    }

                    $message = "Product deleted successfully.";
                    $messageType = "success";

                    // Log activity
                    logActivity("Product Deleted", "Deleted product: " . $productData['name'] . " (ID: $productId)");

                    // Redirect to prevent form resubmission
                    header("Location: " . $_SERVER['PHP_SELF'] . "?success=deleted");
                    exit;
                } else {
                    $message = "Error deleting product: " . $stmt->error;
                    $messageType = "danger";
                }
            } else {
                $message = "Product not found.";
                $messageType = "danger";
            }
        } elseif ($action === 'import') {
            // Handle CSV import
            if (isset($_FILES['import_file']) && $_FILES['import_file']['error'] === UPLOAD_ERR_OK) {
                // Check if file is CSV
                $csvFile = $_FILES['import_file']['tmp_name'];
                $firstLine = fgets(fopen($csvFile, 'r'));

                if (strpos($firstLine, ',') === false) {
                    $message = "Invalid file format. CSV expected.";
                    $messageType = "danger";
                    exit;
                }


                $hasHeader = isset($_POST['has_header']) ? true : false;
                $file = $_FILES['import_file']['tmp_name'];

                if (($handle = fopen($file, "r")) !== FALSE) {
                    $importCount = 0;
                    $errorCount = 0;
                    $row = 1;

                    // Start transaction
                    $conn->begin_transaction();

                    try {
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            // Skip header row if exists
                            if ($row === 1 && $hasHeader) {
                                $row++;
                                continue;
                            }
                            // Skip empty rows (all fields empty)
                            if (empty(array_filter($data))) {
                                $row++;
                                continue;
                            }
                            // Validate and sanitize data
                            if (count($data) >= 9) {
                                $productName = sanitizeInput($data[0]);
                                $productSlug = generateSlug($productName);
                                $parentCat = sanitizeInput($data[1]);
                                $mainCat = sanitizeInput($data[2]);
                                $subCat = sanitizeInput($data[3]);
                                $attribute = sanitizeInput($data[4]);
                                $mainAttribute = sanitizeInput($data[5]);
                                $subAttribute = sanitizeInput($data[6]);
                                $tdsFile = sanitizeInput($data[7]);
                                $image = sanitizeInput($data[8]);
                                $shortDescription = '';
                                $areaOfApplication = '';
                                $benefits = '';
                                $characteristics = '';
                                $packing = '';
                                $status = 'Active';
                                $currentTime = date('Y-m-d H:i:s');


                                // // Check if product with this slug already exists
                                $checkSql = "SELECT id FROM products_v2 WHERE slug = ?";
                                $checkStmt = $conn->prepare($checkSql);
                                $checkStmt->bind_param("s", $productSlug);
                                $checkStmt->execute();
                                $checkResult = $checkStmt->get_result();

                                if ($checkResult->num_rows === 0) {
                                    // Insert new product with minimal required info
                                    $currentTime = date('Y-m-d H:i:s');

                                    $insertSql = "INSERT INTO products_v2 (
                                    name, slug, parent_cat, main_cat, sub_cat, 
                                    attribute, main_attribute, sub_attribute, 
                                    tds_file, image, short_description, area_of_application, 
                                    benifits, characteristics, packing, 
                                    status, created_at, updated_at
                                ) VALUES (?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                                    $stmt = $conn->prepare($insertSql);

                                    // Make sure all these variables are defined properly before this
                                    $stmt->bind_param(
                                        "ssssssssssssssssss",
                                        $productName,
                                        $productSlug,
                                        $parentCat,
                                        $mainCat,
                                        $subCat,
                                        $attribute,
                                        $mainAttribute,
                                        $subAttribute,
                                        $tdsFile,
                                        $image,
                                        $shortDescription,
                                        $areaOfApplication,
                                        $benefits,
                                        $characteristics,
                                        $packing,
                                        $status,
                                        $currentTime,
                                        $currentTime
                                    );



                                    if ($stmt->execute()) {
                                        $importCount++;
                                    } else {
                                        error_log("Insert error on row $row: " . $stmt->error);
                                        $errorCount++;
                                    }
                                } else {
                                    $errorCount++;
                                }
                            } else {
                                error_log("Invalid data on row $row: " . implode(",", $data));
                                $errorCount++;
                            }

                            $row++;
                        }
                        $conn->commit();

                        // Success message
                        $message = "Import completed: $importCount products imported successfully, $errorCount errors.";
                        $messageType = "success";
                    } catch (Exception $e) {
                        // Rollback if any error
                        $conn->rollback();
                        error_log("Import error: " . $e->getMessage());
                        $errorCount++;
                    } finally {
                        fclose($handle);
                    }

                    // Redirect after import
                    header("Location: " . $_SERVER['PHP_SELF'] . "?success=imported&count=$importCount&errors=$errorCount");
                    exit;
                } else {
                    $message = "Failed to open the CSV file.";
                    $messageType = "danger";
                }
            } else {
                $message = "Please upload a valid CSV file.";
                $messageType = "danger";
            }
        }
    }
}

// Handle success messages from redirects
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case 'added':
            $message = "Product added successfully.";
            $messageType = "success";
            break;
        case 'updated':
            $message = "Product updated successfully.";
            $messageType = "success";
            break;
        case 'deleted':
            $message = "Product deleted successfully.";
            $messageType = "success";
            break;
        case 'imported':
            $importCount = isset($_GET['count']) ? (int) $_GET['count'] : 0;
            $errorCount = isset($_GET['errors']) ? (int) $_GET['errors'] : 0;
            $message = "Import completed: $importCount products imported successfully, $errorCount errors.";
            $messageType = "success";
            break;
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Products</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="exportBtn">
                            <i class="fas fa-download me-1"></i> Export
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                            data-bs-target="#importModal">
                            <i class="fas fa-upload me-1"></i> Import
                        </button>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addProductModal">
                        <i class="fas fa-plus me-1"></i> Add New Product
                    </button>
                </div>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link <?= $status_filter == 'all' ? 'active' : '' ?>" href="?status=all">
                        All <span class="badge bg-<?= $status_filter == 'all' ? 'primary' : 'secondary' ?> rounded-pill ms-1"><?= count($all_posts) ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $status_filter == 'active' ? 'active' : '' ?>" href="?status=active">
                        Active <span class="badge bg-<?= $status_filter == 'active' ? 'success' : 'secondary' ?> rounded-pill ms-1"><?= count($active_posts) ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $status_filter == 'inactive' ? 'active' : '' ?>" href="?status=inactive">
                        Inactive <span class="badge bg-<?= $status_filter == 'inactive' ? 'warning text-dark' : 'secondary' ?> rounded-pill ms-1"><?= count($inactive_posts) ?></span>
                    </a>
                </li>
            </ul>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="productsTable" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($products)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No products found.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($products as $product): ?>
                                        <tr>
                                            <td><?php echo $product['id']; ?></td>
                                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                                            <td>
                                                <?php if ($product['status'] === 'Active'): ?>
                                                    <span class="badge bg-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-primary btnEditModal"
                                                        data-id="<?php echo $product['id']; ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                        data-id="<?php echo $product['id']; ?>"
                                                        data-name="<?php echo htmlspecialchars($product['name']); ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="needs-validation"
                enctype="multipart/form-data" id="addProductForm">
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">

                    <ul class="nav nav-tabs" id="productTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic"
                                type="button" role="tab" aria-controls="basic" aria-selected="true">Basic
                                Information</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="categories-tab" data-bs-toggle="tab"
                                data-bs-target="#categories" type="button" role="tab" aria-controls="categories"
                                aria-selected="false">Categories</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="attributes-tab" data-bs-toggle="tab"
                                data-bs-target="#attributes" type="button" role="tab" aria-controls="attributes"
                                aria-selected="false">Attributes</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                                type="button" role="tab" aria-controls="details" aria-selected="false">Product
                                Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="media-tab" data-bs-toggle="tab" data-bs-target="#media"
                                type="button" role="tab" aria-controls="media" aria-selected="false">Media</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo"
                                type="button" role="tab" aria-controls="seo" aria-selected="false">SEO</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="faqs-tab" data-bs-toggle="tab" data-bs-target="#faqs"
                                type="button" role="tab" aria-controls="faqs" aria-selected="false">FAQs</button>
                        </li>
                    </ul>

                    <div class="tab-content p-3 border border-top-0" id="productTabContent">
                        <!-- Basic Information Tab -->
                        <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="product_name" class="form-label">Product Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="product_name" name="product_name"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="product_slug" class="form-label">Product Slug <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="product_slug" name="product_slug"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="sub_title" class="form-label">Sub Title</label>
                                <input class="form-control" id="sub_title" name="sub_title" rows="3"></input>
                            </div>

                            <div class="mb-3">
                                <label for="short_description" class="form-label">Short Description</label>
                                <textarea class="form-control" id="short_description" name="short_description"
                                    rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <!-- Categories Tab -->
                        <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="categories-tab">
                            <div class="mb-3">
                                <label for="parent_cat" class="form-label">Parent Category <span
                                        class="text-danger">*</span></label>
                                <select class="form-select select2" id="parent_cat" name="parent_cat[]" multiple
                                    required>
                                    <option value="">Select Parent Category</option>
                                    <?php foreach ($parentCategories as $parentCat): ?>
                                        <option value="<?php echo htmlspecialchars($parentCat['id']); ?>">
                                            <?php echo htmlspecialchars($parentCat['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="main_cat" class="form-label">Main Category</label>
                                <select class="form-select select2" id="main_cat" name="main_cat[]" multiple>
                                    <option value="">Select Main Category</option>
                                    <?php foreach ($mainCategories as $mainCat): ?>
                                        <option value="<?php echo htmlspecialchars($mainCat['id']); ?>">
                                            <?php echo htmlspecialchars($mainCat['mcat_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="sub_cat" class="form-label">Sub Category</label>
                                <select class="form-select select2" id="sub_cat" name="sub_cat[]" multiple>
                                    <option value="">Select Sub Category</option>
                                    <?php foreach ($subCategories as $subCat): ?>
                                        <option value="<?php echo htmlspecialchars($subCat['id']); ?>"
                                            data-main-cat="<?php echo htmlspecialchars($subCat['m_cat']); ?>">
                                            <?php echo htmlspecialchars($subCat['scat_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Attributes Tab -->
                        <div class="tab-pane fade" id="attributes" role="tabpanel" aria-labelledby="attributes-tab">
                            <div class="mb-3">
                                <label for="parent_attribute" class="form-label">Parent Attribute</label>
                                <select class="form-select select2" id="parent_attribute" name="parent_attribute[]"
                                    multiple>
                                    <option value="">Select Main Attribute</option>
                                    <?php foreach ($parentAttributes as $parentAttr): ?>
                                        <option value="<?php echo htmlspecialchars($parentAttr['id']); ?>">
                                            <?php echo htmlspecialchars($parentAttr['parent_attr_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="main_attribute" class="form-label">Main Attribute</label>
                                <select class="form-select select2" id="main_attribute" name="main_attribute[]"
                                    multiple>
                                    <option value="">Select Main Attribute</option>
                                    <?php foreach ($mainAttributes as $mainAttr): ?>
                                        <option value="<?php echo htmlspecialchars($mainAttr['id']); ?>">
                                            <?php echo htmlspecialchars($mainAttr['main_attr_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="sub_attribute" class="form-label">Sub Attribute</label>
                                <select class="form-select select2" id="sub_attribute" name="sub_attribute[]" multiple>
                                    <option value="">Select Sub Attribute</option>
                                    <?php foreach ($subAttributes as $subAttr): ?>
                                        <option value="<?php echo htmlspecialchars($subAttr['id']); ?>">
                                            <?php echo htmlspecialchars($subAttr['sub_attr_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Product Details Tab -->
                        <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <div class="mb-3">
                                <label for="packing" class="form-label">Packing</label>
                                <select class="form-select select2" id="packing" name="packing[]" multiple>
                                    <option value="">Select Packing</option>
                                    <?php
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


                                    foreach ($packing_options as $option) {
                                        echo '<option value="' . htmlspecialchars($option) . '">' . htmlspecialchars($option) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="area_of_application" class="form-label">Area of Application</label>
                                <textarea class="form-control rich-editor" id="area_of_application"
                                    name="area_of_application" rows="5"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="benifits" class="form-label">Benefits</label>
                                <textarea class="form-control rich-editor" id="benifits" name="benifits"
                                    rows="5"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="characteristics" class="form-label">Characteristics</label>
                                <textarea class="form-control rich-editor" id="characteristics" name="characteristics"
                                    rows="5"></textarea>
                                <div class="form-text">Add rows in a table as per your requirement.</div>
                            </div>

                            <!-- <div class="mb-3">
                                <label for="packing" class="form-label">Packing</label>
                                <textarea class="form-control" id="packing" name="packing" rows="3"></textarea>
                            </div> -->
                        </div>

                        <!-- Media Tab -->
                        <div class="tab-pane fade" id="media" role="tabpanel" aria-labelledby="media-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="product_image" class="form-label">Product Image</label>
                                        <input type="file" class="form-control" id="product_image" name="product_image"
                                            accept="image/*">
                                        <div class="form-text">Accepted formats: WEBP, JPG, JPEG, PNG, GIF.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tds_file" class="form-label">TDS File</label>
                                        <input type="file" class="form-control" id="tds_file" name="tds_file"
                                            accept=".pdf,.doc,.docx">
                                        <div class="form-text">Accepted formats: PDF, DOC, DOCX.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="product_cat_image" class="form-label">Product Cat Image</label>
                                        <select class="form-select" id="product_cat_image" name="product_cat_image">
                                            <option value="">Select Product Image</option>
                                            <?php
                                            $cat_options = [
                                                "Autoassembly",
                                                "Cardoor",
                                                "Carseat",
                                                "Engineparts",
                                                "Fastners",
                                                "Guideslideways",
                                                "Motor",
                                                "Opengear",
                                                "Rollerbearing",
                                                "Sunroof",
                                                "Wireropep"
                                            ];
                                            foreach ($cat_options as $option) {
                                                echo '<option value="' . htmlspecialchars($option) . '">' . htmlspecialchars($option) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Tab -->
                        <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                            <div class="mb-3">
                                <label for="meta_title" class="form-label">Meta Title</label>
                                <input type="text" class="form-control" id="meta_title" name="meta_title">
                            </div>

                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control" id="meta_description" name="meta_description"
                                    rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords">
                                <div class="form-text">Separate keywords with commas.</div>
                            </div>
                        </div>

                        <!-- FAQs Tab -->
                        <div class="tab-pane fade" id="faqs" role="tabpanel" aria-labelledby="faqs-tab">
                            <div id="faq-container-add">
                                <!-- FAQ items will be appended here -->
                                <div class="faq-item border rounded p-3 mb-3 bg-light">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>FAQ #1</h6>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Question</label>
                                        <input type="text" class="form-control" name="faq_question[]" placeholder="e.g., What are the benefits?">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Answer</label>
                                        <textarea class="form-control rich-editor" name="faq_answer[]" rows="2" placeholder="e.g., The benefits include..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addFaqRow('faq-container-add')">
                                <i class="fas fa-plus"></i> Add Another FAQ
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- edit Modal -->
<div class="modal fade" id="editProductModal" aria-hidden="true">
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                enctype="multipart/form-data" class="needs-validation">
                <div class="modal-body">
                    <input type="hidden" name="action" value="import">
                    <div class="mb-3">
                        <label for="import_file" class="form-label">CSV File</label>
                        <input type="file" class="form-control" id="import_file" name="import_file" accept=".csv"
                            required>
                        <div class="form-text">Please upload a CSV file with the required columns: Name, Slug, Status
                            (optional).</div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="has_header" name="has_header" checked>
                            <label class="form-check-label" for="has_header">
                                File has header row
                            </label>
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> The CSV file should have at least the following columns:
                        Product Name, Product Slug. Additional columns will be ignored.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Form (Hidden) -->
<form id="deleteForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
    style="display: none;">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" id="delete_product_id" name="product_id" value="">
</form>

<?php include 'includes/footer.php'; ?>

<script defer src="assets/js/__product.js"></script>

<?php if (isset($_GET['edit_id']) && is_numeric($_GET['edit_id'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        var editId = <?php echo (int)$_GET['edit_id']; ?>;
        var btn = document.querySelector('.btnEditModal[data-id="' + editId + '"]');
        if (btn) {
            btn.click();
        } else {
            // If button is not on the current page (e.g., due to pagination), trigger AJAX directly
            $.ajax({
              url: "./_ajax/getProductsDetails.php",
              type: "POST",
              data: {
                id: editId,
              },
              dataType: "html",
              success: function (data) {
                $("#editProductModal").html(data).modal("show");
                if (typeof initializeRichEditors === 'function') initializeRichEditors();
                if (typeof prePopulateImage === 'function') prePopulateImage();
              }
            });
        }
    }, 500); // slight delay to ensure other scripts have initialized
});
</script>
<?php endif; ?>

<script>
function addFaqRow(containerId) {
    var container = document.getElementById(containerId);
    var count = container.querySelectorAll('.faq-item').length + 1;
    
    var html = `
    <div class="faq-item border rounded p-3 mb-3 bg-light position-relative">
        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2" onclick="removeFaqRow(this)">
            <i class="fas fa-trash"></i>
        </button>
        <div class="d-flex justify-content-between mb-2">
            <h6>FAQ #${count}</h6>
        </div>
        <div class="mb-2">
            <label class="form-label">Question</label>
            <input type="text" class="form-control" name="faq_question[]" placeholder="e.g., What are the benefits?">
        </div>
        <div class="mb-2">
            <label class="form-label">Answer</label>
            <textarea class="form-control rich-editor" name="faq_answer[]" rows="2" placeholder="e.g., The benefits include..."></textarea>
        </div>
    </div>`;
    
    container.insertAdjacentHTML('beforeend', html);
    
    if (typeof initializeRichEditors === 'function') {
        initializeRichEditors();
    }
}

function removeFaqRow(btn) {
    btn.closest('.faq-item').remove();
    // Optional: Re-index the FAQ # headers if needed
}
</script>