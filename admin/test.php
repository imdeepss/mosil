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


$products = [];
$productSql = "SELECT * FROM `products` ORDER BY `id` ASC";
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

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add' || $action === 'edit') {
            // Get form data
            $productId = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
            $productName = sanitizeInput($_POST['product_name'] ?? '');
            $productSlug = sanitizeInput($_POST['product_slug'] ?? '');

            // Handle multiple select values
            $parentCat = isset($_POST['parent_cat']) && is_array($_POST['parent_cat']) ? implode(',', $_POST['parent_cat']) : '';
            $mainCat = isset($_POST['main_cat']) && is_array($_POST['main_cat']) ? implode(',', $_POST['main_cat']) : '';
            $subCat = isset($_POST['sub_cat']) && is_array($_POST['sub_cat']) ? implode(',', $_POST['sub_cat']) : '';
            $mainAttribute = isset($_POST['main_attribute']) && is_array($_POST['main_attribute']) ? implode(',', $_POST['main_attribute']) : '';
            $parentAttribute = isset($_POST['parent_attribute']) && is_array($_POST['parent_attribute']) ? implode(',', $_POST['parent_attribute']) : '';
            $subAttribute = isset($_POST['sub_attribute']) && is_array($_POST['sub_attribute']) ? implode(',', $_POST['sub_attribute']) : '';

            $shortDescription = sanitizeInput($_POST['short_description'] ?? '');
            $areaOfApplication = $_POST['area_of_application'] ?? '';
            $benifits = $_POST['benifits'] ?? '';
            $characteristics = $_POST['characteristics'] ?? '';
            $packing = sanitizeInput($_POST['packing'] ?? '');
            $metaTitle = sanitizeInput($_POST['meta_title'] ?? '');
            $metaDescription = sanitizeInput($_POST['meta_description'] ?? '');
            $metaKeywords = sanitizeInput($_POST['meta_keywords'] ?? '');
            $status = sanitizeInput($_POST['status'] ?? 'Active');

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
                $newFileName = 'product_' . time() . '.' . $fileExt;
                $uploadFile = $uploadDir . $newFileName;
                $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
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
                $uploadDir = '../assets/uploads/products-image/';
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

            // Validate form data
            if (empty($productName) || empty($productSlug)) {
                $message = "Please fill in all required fields.";
                $messageType = "danger";
            } else {
                // Check if slug is unique
                $slugCheckSql = "SELECT id FROM products WHERE slug = ? AND id != ?";
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
                        $insertSql = "INSERT INTO products (
                            name, slug, parent_cat, main_cat, sub_cat, attribute,
                            main_attribute, sub_attribute, short_description, 
                            area_of_application, benifits, characteristics, 
                            packing, image, tds_file, meta_title, 
                            meta_description, meta_keywords, status, 
                            created_at, updated_at
                        ) VALUES (?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                        $stmt = $conn->prepare($insertSql);
                        $stmt->bind_param(
                            "sssssssssssssssssssss",
                            $productName,
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
                        $updateSql = "UPDATE products SET 
                            name = ?, 
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
                            meta_title = ?, 
                            meta_description = ?, 
                            meta_keywords = ?, 
                            status = ?, 
                            updated_at = ?";

                        $params = [
                            $productName,
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
                            $metaTitle,
                            $metaDescription,
                            $metaKeywords,
                            $status,
                            $currentTime
                        ];
                        $types = "ssssssssssssssssss";

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
            $getProductSql = "SELECT name, image, tds_file FROM products WHERE id = ?";
            $getStmt = $conn->prepare($getProductSql);
            $getStmt->bind_param("i", $productId);
            $getStmt->execute();
            $productResult = $getStmt->get_result();
            $productData = $productResult->fetch_assoc();

            if ($productData) {
                // Delete the product
                $deleteSql = "DELETE FROM products WHERE id = ?";
                $stmt = $conn->prepare($deleteSql);
                $stmt->bind_param("i", $productId);

                if ($stmt->execute()) {
                    // Delete associated files
                    if (!empty($productData['image'])) {
                        $imagePath = './assets/images/uploads/products-image' . $productData['image'];
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }
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
                $hasHeader = isset($_POST['has_header']) ? true : false;
                $file = $_FILES['import_file']['tmp_name'];

                if (($handle = fopen($file, "r")) !== FALSE) {
                    $importCount = 0;
                    $errorCount = 0;
                    $row = 1;

                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        // Skip header row if exists
                        if ($row === 1 && $hasHeader) {
                            $row++;
                            continue;
                        }

                        // Check if we have at least the required fields
                        if (count($data) >= 2) {
                            $productName = sanitizeInput($data[0]);
                            $productSlug = sanitizeInput($data[1]);
                            $status = isset($data[2]) ? sanitizeInput($data[2]) : 'Active';

                            // Check if product with this slug already exists
                            $checkSql = "SELECT id FROM products WHERE slug = ?";
                            $checkStmt = $conn->prepare($checkSql);
                            $checkStmt->bind_param("s", $productSlug);
                            $checkStmt->execute();
                            $checkResult = $checkStmt->get_result();

                            if ($checkResult->num_rows === 0) {
                                // Insert new product with basic information
                                $currentTime = date('Y-m-d H:i:s');
                                $insertSql = "INSERT INTO products (name, slug, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?)";
                                $stmt = $conn->prepare($insertSql);
                                $stmt->bind_param("sssss", $productName, $productSlug, $status, $currentTime, $currentTime);

                                if ($stmt->execute()) {
                                    $importCount++;
                                } else {
                                    $errorCount++;
                                }
                            } else {
                                $errorCount++;
                            }
                        } else {
                            $errorCount++;
                        }

                        $row++;
                    }

                    fclose($handle);

                    $message = "Import completed: $importCount products imported successfully, $errorCount errors.";
                    $messageType = "success";

                    // Log activity
                    logActivity("Products Imported", "Imported $importCount products from CSV");

                    // Redirect to prevent form resubmission
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
                                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#editProductModal<?php echo $product['id']; ?>">
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

                                        <!-- Edit Product Modal -->
                                        <div class="modal fade" id="editProductModal<?php echo $product['id']; ?>" tabindex="-1"
                                            aria-labelledby="editProductModalLabel<?php echo $product['id']; ?>"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editProductModalLabel<?php echo $product['id']; ?>">Edit Product
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form method="post"
                                                        action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                                        class="needs-validation" enctype="multipart/form-data"
                                                        id="editProductForm<?php echo $product['id']; ?>">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="action" value="edit">
                                                            <input type="hidden" name="product_id"
                                                                value="<?php echo $product['id']; ?>">

                                                            <ul class="nav nav-tabs"
                                                                id="productTab<?php echo $product['id']; ?>" role="tablist">
                                                                <li class="nav-item" role="presentation">
                                                                    <button class="nav-link active"
                                                                        id="basic-tab<?php echo $product['id']; ?>"
                                                                        data-bs-toggle="tab"
                                                                        data-bs-target="#basic<?php echo $product['id']; ?>"
                                                                        type="button" role="tab"
                                                                        aria-controls="basic<?php echo $product['id']; ?>"
                                                                        aria-selected="true">Basic Information</button>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                    <button class="nav-link"
                                                                        id="categories-tab<?php echo $product['id']; ?>"
                                                                        data-bs-toggle="tab"
                                                                        data-bs-target="#categories<?php echo $product['id']; ?>"
                                                                        type="button" role="tab"
                                                                        aria-controls="categories<?php echo $product['id']; ?>"
                                                                        aria-selected="false">Categories</button>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                    <button class="nav-link"
                                                                        id="attributes-tab<?php echo $product['id']; ?>"
                                                                        data-bs-toggle="tab"
                                                                        data-bs-target="#attributes<?php echo $product['id']; ?>"
                                                                        type="button" role="tab"
                                                                        aria-controls="attributes<?php echo $product['id']; ?>"
                                                                        aria-selected="false">Attributes</button>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                    <button class="nav-link"
                                                                        id="details-tab<?php echo $product['id']; ?>"
                                                                        data-bs-toggle="tab"
                                                                        data-bs-target="#details<?php echo $product['id']; ?>"
                                                                        type="button" role="tab"
                                                                        aria-controls="details<?php echo $product['id']; ?>"
                                                                        aria-selected="false">Product Details</button>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                    <button class="nav-link"
                                                                        id="media-tab<?php echo $product['id']; ?>"
                                                                        data-bs-toggle="tab"
                                                                        data-bs-target="#media<?php echo $product['id']; ?>"
                                                                        type="button" role="tab"
                                                                        aria-controls="media<?php echo $product['id']; ?>"
                                                                        aria-selected="false">Media</button>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                    <button class="nav-link"
                                                                        id="seo-tab<?php echo $product['id']; ?>"
                                                                        data-bs-toggle="tab"
                                                                        data-bs-target="#seo<?php echo $product['id']; ?>"
                                                                        type="button" role="tab"
                                                                        aria-controls="seo<?php echo $product['id']; ?>"
                                                                        aria-selected="false">SEO</button>
                                                                </li>
                                                            </ul>

                                                            <div class="tab-content p-3 border border-top-0"
                                                                id="productTabContent<?php echo $product['id']; ?>">
                                                                <!-- Basic Information Tab -->
                                                                <div class="tab-pane fade show active"
                                                                    id="basic<?php echo $product['id']; ?>" role="tabpanel"
                                                                    aria-labelledby="basic-tab<?php echo $product['id']; ?>">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label
                                                                                    for="product_name<?php echo $product['id']; ?>"
                                                                                    class="form-label">Product Name <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="text" class="form-control"
                                                                                    id="product_name<?php echo $product['id']; ?>"
                                                                                    name="product_name"
                                                                                    value="<?php echo htmlspecialchars($product['name']); ?>"
                                                                                    required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label
                                                                                    for="product_slug<?php echo $product['id']; ?>"
                                                                                    class="form-label">Product Slug <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="text" class="form-control"
                                                                                    id="product_slug<?php echo $product['id']; ?>"
                                                                                    name="product_slug"
                                                                                    value="<?php echo htmlspecialchars($product['slug']); ?>"
                                                                                    required>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label
                                                                            for="short_description<?php echo $product['id']; ?>"
                                                                            class="form-label">Short Description</label>
                                                                        <textarea class="form-control"
                                                                            id="short_description<?php echo $product['id']; ?>"
                                                                            name="short_description"
                                                                            rows="3"><?php echo htmlspecialchars($product['short_description'] ?? ''); ?></textarea>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="status<?php echo $product['id']; ?>"
                                                                            class="form-label">Status</label>
                                                                        <select class="form-select"
                                                                            id="status<?php echo $product['id']; ?>"
                                                                            name="status">
                                                                            <option value="Active" <?php echo ($product['status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                                                                            <option value="Inactive" <?php echo ($product['status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <!-- Categories Tab -->
                                                                <div class="tab-pane fade"
                                                                    id="categories<?php echo $product['id']; ?>" role="tabpanel"
                                                                    aria-labelledby="categories-tab<?php echo $product['id']; ?>">
                                                                    <div class="mb-3">
                                                                        <label for="parent_cat<?php echo $product['id']; ?>"
                                                                            class="form-label">Parent Category <span
                                                                                class="text-danger">*</span></label>
                                                                        <select class="form-select select2"
                                                                            id="parent_cat<?php echo $product['id']; ?>"
                                                                            name="parent_cat[]" multiple required>
                                                                            <option value="">Select Parent Category</option>
                                                                            <?php
                                                                            $selectedParentCats = explode(',', $product['parent_cat'] ?? '');
                                                                            foreach ($parentCategories as $parentCat):
                                                                                ?>
                                                                                <option
                                                                                    value="<?php echo htmlspecialchars($parentCat['id']); ?>"
                                                                                    <?php echo in_array($parentCat['id'], $selectedParentCats) ? 'selected' : ''; ?>>
                                                                                    <?php echo htmlspecialchars($parentCat['name']); ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="main_cat<?php echo $product['id']; ?>"
                                                                            class="form-label">Main Category</label>
                                                                        <select class="form-select select2"
                                                                            id="main_cat<?php echo $product['id']; ?>"
                                                                            name="main_cat[]" multiple>
                                                                            <option value="">Select Main Category</option>
                                                                            <?php
                                                                            $selectedMainCats = explode(',', $product['main_cat'] ?? '');
                                                                            foreach ($mainCategories as $mainCat):
                                                                                ?>
                                                                                <option
                                                                                    value="<?php echo htmlspecialchars($mainCat['id']); ?>"
                                                                                    <?php echo in_array($mainCat['id'], $selectedMainCats) ? 'selected' : ''; ?>>
                                                                                    <?php echo htmlspecialchars($mainCat['mcat_name']); ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="sub_cat<?php echo $product['id']; ?>"
                                                                            class="form-label">Sub Category</label>
                                                                        <select class="form-select select2"
                                                                            id="sub_cat<?php echo $product['id']; ?>"
                                                                            name="sub_cat[]" multiple>
                                                                            <option value="">Select Sub Category</option>
                                                                            <?php
                                                                            $selectedSubCats = explode(',', $product['sub_cat'] ?? '');
                                                                            foreach ($subCategories as $subCat):
                                                                                ?>
                                                                                <option
                                                                                    value="<?php echo htmlspecialchars($subCat['id']); ?>"
                                                                                    <?php echo in_array($subCat['id'], $selectedSubCats) ? 'selected' : ''; ?>>
                                                                                    <?php echo htmlspecialchars($subCat['scat_name']); ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>

                                                                    </div>
                                                                </div>

                                                                <!-- Attributes Tab -->
                                                                <div class="tab-pane fade"
                                                                    id="attributes<?php echo $product['id']; ?>" role="tabpanel"
                                                                    aria-labelledby="attributes-tab<?php echo $product['id']; ?>">
                                                                    <div class="mb-3">
                                                                        <label
                                                                            for="parent_attribute<?php echo $product['id']; ?>"
                                                                            class="form-label">Parent Attribute</label>
                                                                        <select class="form-select select2"
                                                                            id="parent_attribute<?php echo $product['id']; ?>"
                                                                            name="parent_attribute[]" multiple>
                                                                            <option value="">Select Parent Attribute</option>
                                                                            <?php
                                                                            $selectedMainAttrs = explode(',', $product['attribute'] ?? '');
                                                                            foreach ($parentAttributes as $parentAttr):
                                                                                ?>
                                                                                <option
                                                                                    value="<?php echo htmlspecialchars($parentAttr['id']); ?>"
                                                                                    <?php echo in_array($parentAttr['id'], $selectedMainAttrs) ? 'selected' : ''; ?>>
                                                                                    <?php echo htmlspecialchars($parentAttr['parent_attr_name']); ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>


                                                                    <div class="mb-3">
                                                                        <label for="main_attribute<?php echo $product['id']; ?>"
                                                                            class="form-label">Main Attribute</label>
                                                                        <select class="form-select select2"
                                                                            id="main_attribute<?php echo $product['id']; ?>"
                                                                            name="main_attribute[]" multiple>
                                                                            <option value="">Select Main Attribute</option>
                                                                            <?php
                                                                            $selectedMainAttrs = explode(',', $product['main_attribute'] ?? '');
                                                                            foreach ($mainAttributes as $mainAttr):
                                                                                ?>
                                                                                <option
                                                                                    value="<?php echo htmlspecialchars($mainAttr['id']); ?>"
                                                                                    <?php echo in_array($mainAttr['id'], $selectedMainAttrs) ? 'selected' : ''; ?>>
                                                                                    <?php echo htmlspecialchars($mainAttr['main_attr_name']); ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="sub_attribute<?php echo $product['id']; ?>"
                                                                            class="form-label">Sub Attribute</label>
                                                                        <select class="form-select select2"
                                                                            id="sub_attribute<?php echo $product['id']; ?>"
                                                                            name="sub_attribute[]" multiple>
                                                                            <option value="">Select Sub Attribute</option>
                                                                            <?php
                                                                            $selectedSubAttrs = explode(',', $product['sub_attribute'] ?? '');
                                                                            foreach ($subAttributes as $subAttr):
                                                                                ?>
                                                                                <option
                                                                                    value="<?php echo htmlspecialchars($subAttr['id']); ?>"
                                                                                    <?php echo in_array($subAttr['id'], $selectedSubAttrs) ? 'selected' : ''; ?>>
                                                                                    <?php echo htmlspecialchars($subAttr['sub_attr_name']); ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <!-- Product Details Tab -->
                                                                <div class="tab-pane fade"
                                                                    id="details<?php echo $product['id']; ?>" role="tabpanel"
                                                                    aria-labelledby="details-tab<?php echo $product['id']; ?>">
                                                                    <div class="mb-3">
                                                                        <label
                                                                            for="area_of_application<?php echo $product['id']; ?>"
                                                                            class="form-label">Area of Application</label>
                                                                        <textarea class="form-control rich-editor"
                                                                            id="area_of_application<?php echo $product['id']; ?>"
                                                                            name="area_of_application"
                                                                            rows="5"><?php echo htmlspecialchars($product['area_of_application'] ?? ''); ?></textarea>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="benifits<?php echo $product['id']; ?>"
                                                                            class="form-label">Benefits</label>
                                                                        <textarea class="form-control rich-editor"
                                                                            id="benifits<?php echo $product['id']; ?>"
                                                                            name="benifits"
                                                                            rows="5"><?php echo htmlspecialchars($product['benifits'] ?? ''); ?></textarea>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label
                                                                            for="characteristics<?php echo $product['id']; ?>"
                                                                            class="form-label">Characteristics</label>
                                                                        <textarea class="form-control rich-editor"
                                                                            id="characteristics<?php echo $product['id']; ?>"
                                                                            name="characteristics"
                                                                            rows="5"><?php echo htmlspecialchars($product['characteristics'] ?? ''); ?></textarea>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="packing<?php echo $product['id']; ?>"
                                                                            class="form-label">Packing</label>
                                                                        <textarea class="form-control"
                                                                            id="packing<?php echo $product['id']; ?>"
                                                                            name="packing"
                                                                            rows="3"><?php echo htmlspecialchars($product['packing'] ?? ''); ?></textarea>
                                                                    </div>
                                                                </div>

                                                                <!-- Media Tab -->
                                                                <div class="tab-pane fade"
                                                                    id="media<?php echo $product['id']; ?>" role="tabpanel"
                                                                    aria-labelledby="media-tab<?php echo $product['id']; ?>">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label
                                                                                    for="product_image<?php echo $product['id']; ?>"
                                                                                    class="form-label">Product Image</label>
                                                                                <?php if (!empty($product['image'])): ?>
                                                                                    <div class="mb-2">
                                                                                        <img src="../assets/uploads/products-image/<?php echo htmlspecialchars($product['image']); ?>"
                                                                                            alt="Current Product Image"
                                                                                            class="img-thumbnail"
                                                                                            style="max-height: 150px;">
                                                                                    </div>
                                                                                <?php endif; ?>
                                                                                <input type="file" class="form-control"
                                                                                    id="product_image<?php echo $product['id']; ?>"
                                                                                    name="product_image" accept="image/*">
                                                                                <div class="form-text">Leave empty to keep the
                                                                                    current image. Accepted formats: JPG, JPEG,
                                                                                    PNG, GIF.</div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label
                                                                                    for="tds_file<?php echo $product['id']; ?>"
                                                                                    class="form-label">TDS File</label>
                                                                                <?php if (!empty($product['tds_file'])): ?>
                                                                                    <div class="mb-2">
                                                                                        <a href="Uploads/tds/<?php echo htmlspecialchars($product['tds_file']); ?>"
                                                                                            target="_blank"
                                                                                            class="btn btn-sm btn-outline-primary">
                                                                                            <i class="fas fa-file-pdf me-1"></i>
                                                                                            View Current TDS File
                                                                                        </a>
                                                                                    </div>
                                                                                <?php endif; ?>
                                                                                <input type="file" class="form-control"
                                                                                    id="tds_file<?php echo $product['id']; ?>"
                                                                                    name="tds_file" accept=".pdf,.doc,.docx">
                                                                                <div class="form-text">Leave empty to keep the
                                                                                    current file. Accepted formats: PDF, DOC,
                                                                                    DOCX.</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- SEO Tab -->
                                                                <div class="tab-pane fade" id="seo<?php echo $product['id']; ?>"
                                                                    role="tabpanel"
                                                                    aria-labelledby="seo-tab<?php echo $product['id']; ?>">
                                                                    <div class="mb-3">
                                                                        <label for="meta_title<?php echo $product['id']; ?>"
                                                                            class="form-label">Meta Title</label>
                                                                        <input type="text" class="form-control"
                                                                            id="meta_title<?php echo $product['id']; ?>"
                                                                            name="meta_title"
                                                                            value="<?php echo htmlspecialchars($product['meta_title'] ?? ''); ?>">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label
                                                                            for="meta_description<?php echo $product['id']; ?>"
                                                                            class="form-label">Meta Description</label>
                                                                        <textarea class="form-control"
                                                                            id="meta_description<?php echo $product['id']; ?>"
                                                                            name="meta_description"
                                                                            rows="3"><?php echo htmlspecialchars($product['meta_description'] ?? ''); ?></textarea>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="meta_keywords<?php echo $product['id']; ?>"
                                                                            class="form-label">Meta Keywords</label>
                                                                        <input type="text" class="form-control"
                                                                            id="meta_keywords<?php echo $product['id']; ?>"
                                                                            name="meta_keywords"
                                                                            value="<?php echo htmlspecialchars($product['meta_keywords'] ?? ''); ?>">
                                                                        <div class="form-text">Separate keywords with commas.
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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

                            <div class="mb-3">
                                <label for="packing" class="form-label">Packing</label>
                                <textarea class="form-control" id="packing" name="packing" rows="3"></textarea>
                            </div>
                        </div>

                        <!-- Media Tab -->
                        <div class="tab-pane fade" id="media" role="tabpanel" aria-labelledby="media-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="product_image" class="form-label">Product Image</label>
                                        <input type="file" class="form-control" id="product_image" name="product_image"
                                            accept="image/*">
                                        <div class="form-text">Accepted formats: JPG, JPEG, PNG, GIF.</div>
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

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<!-- Include Select2 for enhanced dropdowns -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Include TinyMCE for Rich Text Editing -->
<script
    src="https://uploads/products-image.cloud/1/l0fm44htgn6ktukigemg0o9h6w031qyuz0jev5gqo64jckzv/tinymce/7/tinymce.min.js"
    referrerpolicy="origin"></script>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Include jQuery Validation Plugin -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
    $(document).ready(function () {
        // Initialize Select2
        $('#editProductModal .select2').select2({
            placeholder: "Select options",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#editProductModal')
        });

        // Initialize DataTables
        $('#productsTable').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                text: 'Export to Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                extend: 'csv',
                text: 'Export to CSV',
                className: 'btn btn-sm btn-info',
                exportOptions: {
                    columns: [0, 2, 3, 4, 5]
                }
            }
            ],
            // pageLength: 25,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search products..."
            }
        });

        // Hide default DataTables buttons
        $('.dt-buttons').hide();

        // Custom export button
        $('#exportBtn').on('click', function () {
            $('.buttons-excel').click();
        });

        // Initialize TinyMCE for rich text editors
        tinymce.init({
            selector: '.rich-editor',
            height: 300,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter | ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | table | help',
            menubar: 'file edit view insert format tools table help',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px; }',
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            }
        });

        // Auto-generate slug from product name
        $('#product_name').on('keyup', function () {
            var name = $(this).val();
            var slug = name.toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special characters
                .replace(/\s+/g, '-') // Replace spaces with hyphens
                .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
                .trim(); // Trim whitespace
            $('#product_slug').val(slug);
        });

        // Apply the same for edit forms
        $('[id^="product_name"]').each(function () {
            var id = $(this).attr('id').replace('product_name', '');
            $(this).on('keyup', function () {
                var name = $(this).val();
                var slug = name.toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim();
                $('#product_slug' + id).val(slug);
            });
        });

        // Dependent dropdowns for categories
        $('#main_cat').on('change', function () {
            filterSubCategories();
        });

        function filterSubCategories() {
            var selectedMainCats = $('#main_cat').val() || [];

            $('#sub_cat option').each(function () {
                var mainCatId = $(this).data('main-cat');
                if (selectedMainCats.length === 0 || selectedMainCats.includes(mainCatId) || $(this).val() === '') {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // Delete confirmation
        $('.delete-btn').on('click', function () {
            var productId = $(this).data('id');
            var productName = $(this).data('name');

            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete the product "' + productName + '". This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete_product_id').val(productId);
                    $('#deleteForm').submit();
                }
            });
        });

        // Form validation
        $("#addProductForm").validate({
            rules: {
                product_name: {
                    required: true,
                    minlength: 3
                },
                product_slug: {
                    required: true,
                    minlength: 3
                },
                "parent_cat[]": {
                    required: true
                },
                short_description: {
                    minlength: 10
                }
            },
            messages: {
                product_name: {
                    required: "Please enter a product name",
                    minlength: "Product name must be at least 3 characters"
                },
                product_slug: {
                    required: "Please enter a product slug",
                    minlength: "Slug must be at least 3 characters"
                },
                "parent_cat[]": {
                    required: "Please select at least one parent category"
                },
                short_description: {
                    minlength: "Description must be at least 10 characters"
                }
            },
            errorElement: "div",
            errorClass: "invalid-feedback",
            highlight: function (element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function (element) {
                $(element).addClass("is-valid").removeClass("is-invalid");
            },
            errorPlacement: function (error, element) {
                if (element.hasClass("select2") || element.hasClass("select2-hidden-accessible")) {
                    error.insertAfter(element.next(".select2-container"));
                } else {
                    error.insertAfter(element);
                }
            }
        });

        // Validate Edit Product Forms
        $("form[id^='editProductForm']").each(function () {
            $(this).validate({
                rules: {
                    product_name: {
                        required: true,
                        minlength: 3
                    },
                    product_slug: {
                        required: true,
                        minlength: 3
                    },
                    "parent_cat[]": {
                        required: true
                    },
                    short_description: {
                        minlength: 10
                    }
                },
                messages: {
                    product_name: {
                        required: "Please enter a product name",
                        minlength: "Product name must be at least 3 characters"
                    },
                    product_slug: {
                        required: "Please enter a product slug",
                        minlength: "Slug must be at least 3 characters"
                    },
                    "parent_cat[]": {
                        required: "Please select at least one parent category"
                    },
                    short_description: {
                        minlength: "Description must be at least 10 characters"
                    }
                },
                errorElement: "div",
                errorClass: "invalid-feedback",
                highlight: function (element) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function (element) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                },
                errorPlacement: function (error, element) {
                    if (element.hasClass("select2") || element.hasClass("select2-hidden-accessible")) {
                        error.insertAfter(element.next(".select2-container"));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });

        // Fix for Select2 inside Bootstrap modal
        $('.modal').on('shown.bs.modal', function () {
            $(this).find('.select2').select2({
                dropdownParent: $(this)
            });
        });

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function () {
            $('.alert-dismissible').alert('close');
        }, 5000);
    });
</script>