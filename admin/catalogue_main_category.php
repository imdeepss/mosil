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
$page_title = "Main Categories";
$active_menu = "catalogue_main_category";

// Parent Categories Name
$parent_sql = "SELECT * FROM parent_category";
$parent_result = $conn->query($parent_sql);

// Create an array to hold parent categories
$parent_categories = [];

if ($parent_result->num_rows > 0) {
    while ($row = $parent_result->fetch_assoc()) {
        $parent_categories[] = [
            'id' => (int)$row['id'],
            'name' => $row['name'],
        ];
    }
}

// SQL query to fetch data from main_category table
$sql = "SELECT * FROM main_category";
$result = $conn->query($sql);

// Create an array to hold categories
$categories = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = [
            'id' => (int)$row['id'],
            'name' => $row['mcat_name'],
            'desc' => $row['mcat_desc'],
            'mcat_image' => $row['mcat_image'],
            'status' => $row['status'],
            'slug' => $row['slug'],
            'parent_cat' => $row['parent_cat'],
            'meta_title' => $row['meta_title'],
            'meta_keywords' => $row['meta_keywords'],
            'meta_description' => $row['meta_description'],
        ];
    }
}

// Initialize variables
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        // Common input fields
        $categoryId = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;
        $categoryName = sanitizeInput($_POST['category_name'] ?? '');
        $categoryDisc = sanitizeInput($_POST['category_disc'] ?? '');
        $categorySlug = sanitizeInput($_POST['category_slug'] ?? '');
        $parentCat = sanitizeInput($_POST['parent_cat'] ?? '');
        $metaTitle = sanitizeInput($_POST['meta_title'] ?? '');
        $metaKeywords = sanitizeInput($_POST['meta_keywords'] ?? '');
        $metaDescription = sanitizeInput($_POST['meta_description'] ?? '');
        $status = sanitizeInput($_POST['status'] ?? '');

        if ($action === 'add' || $action === 'edit') {
            // Validate form data
            if (empty($categoryName) || empty($categorySlug)) {
                $message = "Please fill in all required fields.";
                $messageType = "danger";
            } else {
                $category_image = '';

                // If editing, get the existing image
                if ($action === 'edit') {
                    $stmt = $conn->prepare("SELECT mcat_image FROM main_category WHERE id = ?");
                    $stmt->bind_param("i", $categoryId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $category_image = $row['mcat_image']; // Preserve existing image
                    $stmt->close();
                }

                // Process product image upload
                if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = '../assets/uploads/main-category/';
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $fileName = basename($_FILES['category_image']['name']);
                    $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                    $newFileName = 'product_' . time() . '.' . $fileExt;
                    $uploadFile = $uploadDir . $newFileName;
                    $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    if (in_array(strtolower($fileExt), $validExtensions)) {
                        if (move_uploaded_file($_FILES['category_image']['tmp_name'], $uploadFile)) {
                            $category_image = $newFileName; // Update to new image if uploaded
                        } else {
                            $message = "Failed to upload product image.";
                            $messageType = "danger";
                        }
                    } else {
                        $message = "Invalid image format. Allowed formats: JPG, JPEG, PNG, GIF.";
                        $messageType = "danger";
                    }
                }

                if ($action === 'add') {
                    // Insert new category
                    $stmt = $conn->prepare("INSERT INTO main_category (mcat_name, mcat_desc, slug, parent_cat, meta_title, meta_keywords, meta_description, mcat_image, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssssss", $categoryName, $categoryDisc, $categorySlug, $parentCat, $metaTitle, $metaKeywords, $metaDescription, $category_image, $status);
                    $stmt->execute();
                    $message = "Category added successfully.";
                } else {
                    // Update existing category
                    $stmt = $conn->prepare("UPDATE main_category SET mcat_name = ?, mcat_desc = ?, slug = ?, parent_cat = ?, meta_title = ?, meta_keywords = ?, meta_description = ?, mcat_image = ?, status = ? WHERE id = ?");
                    $stmt->bind_param("sssssssssi", $categoryName, $categoryDisc, $categorySlug, $parentCat, $metaTitle, $metaKeywords, $metaDescription, $category_image, $status, $categoryId);
                    $stmt->execute();
                    $message = "Category updated successfully.";
                }
                $messageType = "success";
            }
        } elseif ($action === 'delete') {
            // Delete category
            $stmt = $conn->prepare("DELETE FROM main_category WHERE id = ?");
            $stmt->bind_param("i", $categoryId);
            $stmt->execute();

            $message = "Category deleted successfully.";
            $messageType = "success";
        } elseif ($action === 'publish' || $action === 'unpublish') {
            $newStatus = ($action === 'publish') ? 'active' : 'inactive';

            $stmt = $conn->prepare("UPDATE main_category SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $newStatus, $categoryId);
            $stmt->execute();

            $message = ($action === 'publish') ? "Category published successfully." : "Category unpublished successfully.";
            $messageType = "success";
        }

        // Close statement and connection
        if (isset($stmt)) {
            $stmt->close();
        }
        $conn->close();
        header("Location: " . $_SERVER['PHP_SELF']);
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Main Categories</h1>
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
                            data-bs-target="#addCategoryModal">
                        <i class="fas fa-plus me-1"></i> Add New Category
                    </button>
                </div>
            </div>

            <!-- Alert Message -->
            <div id="alertContainer">
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Categories Overview Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Categories</h5>
                            <p class="card-text h2"><?php echo count($categories); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Active Categories</h5>
                            <p class="card-text h2"><?php echo count(array_filter($categories, function ($cat) {
                                return $cat['status'] === 'active';
                            })); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Inactive Categories</h5>
                            <p class="card-text h2"><?php echo count(array_filter($categories, function ($cat) {
                                return $cat['status'] === 'inactive';
                            })); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Products</h5>
                            <p class="card-text h2">
                                <?php echo array_sum(array_column($categories, 'products_count')); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories Table -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <table id="categoriesTable" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?php echo $category['id']; ?></td>
                                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                                    <td>
                                        <?php if ($category['status'] === 'Active'): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editCategoryModal<?php echo $category['id']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <?php if ($category['status'] === 'Active'): ?>
                                                <button type="button" class="btn btn-sm btn-warning unpublish-btn"
                                                        data-id="<?php echo $category['id']; ?>">
                                                    <i class="fas fa-eye-slash"></i>
                                                </button>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-sm btn-success publish-btn"
                                                        data-id="<?php echo $category['id']; ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            <?php endif; ?>
                                            <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                    data-id="<?php echo $category['id']; ?>"
                                                    data-name="<?php echo htmlspecialchars($category['name']); ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit Category Modal -->
                                <div class="modal fade" id="editCategoryModal<?php echo $category['id']; ?>" tabindex="-1"
                                     aria-labelledby="editCategoryModalLabel<?php echo $category['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editCategoryModalLabel<?php echo $category['id']; ?>">Edit Category</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                                  class="needs-validation" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <input type="hidden" name="action" value="edit">
                                                    <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">

                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="category_name<?php echo $category['id']; ?>" class="form-label">Category Name</label>
                                                            <input type="text" class="form-control" id="category_name<?php echo $category['id']; ?>"
                                                                   name="category_name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="category_disc<?php echo $category['id']; ?>" class="form-label">Category Description</label>
                                                            <input type="text" class="form-control" id="category_disc<?php echo $category['id']; ?>"
                                                                   name="category_disc" value="<?php echo htmlspecialchars($category['desc']); ?>" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="category_slug<?php echo $category['id']; ?>" class="form-label">Category Slug</label>
                                                            <input type="text" class="form-control" id="category_slug<?php echo $category['id']; ?>"
                                                                   name="category_slug" value="<?php echo htmlspecialchars($category['slug']); ?>" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="parent_category<?php echo $category['id']; ?>" class="form-label">Parent Category</label>
                                                            <select class="form-select" id="parent_category<?php echo $category['id']; ?>" name="parent_cat">
                                                                <?php foreach ($parent_categories as $parent): ?>
                                                                    <option value="<?php echo $parent['id']; ?>"
                                                                            <?php echo ($category['parent_cat'] == $parent['id']) ? 'selected' : ''; ?>>
                                                                        <?php echo htmlspecialchars($parent['name']); ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="status<?php echo $category['id']; ?>" class="form-label">Status</label>
                                                            <select class="form-select" id="status<?php echo $category['id']; ?>" name="status">
                                                                <option value="Active" <?php echo ($category['status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                                                                <option value="Inactive" <?php echo ($category['status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="meta_title<?php echo $category['id']; ?>" class="form-label">Meta Title</label>
                                                            <input type="text" class="form-control" id="meta_title<?php echo $category['id']; ?>"
                                                                   name="meta_title" value="<?php echo htmlspecialchars($category['meta_title']); ?>">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="meta_keywords<?php echo $category['id']; ?>" class="form-label">Meta Keywords</label>
                                                            <textarea class="form-control" id="meta_keywords<?php echo $category['id']; ?>"
                                                                      name="meta_keywords" rows="3"><?php echo htmlspecialchars($category['meta_keywords']); ?></textarea>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="meta_description<?php echo $category['id']; ?>" class="form-label">Meta Description</label>
                                                            <textarea class="form-control" id="meta_description<?php echo $category['id']; ?>"
                                                                      name="meta_description" rows="3"><?php echo htmlspecialchars($category['meta_description']); ?></textarea>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="category_image<?php echo $category['id']; ?>" class="form-label">Category Image</label>
                                                            <input type="file" class="form-control category-image-input"
                                                                   id="category_image<?php echo $category['id']; ?>" name="category_image" accept="image/*">
                                                            <div class="imagePreview mt-3"
                                                                 style="display: <?php echo !empty($category['mcat_image']) ? 'block' : 'none'; ?>;">
                                                                <img class="previewImg img-fluid rounded"
                                                                     src="<?php echo !empty($category['mcat_image']) ? '../assets/uploads/main-category/' . htmlspecialchars($category['mcat_image']) : '/placeholder.svg'; ?>"
                                                                     alt="Preview" style="max-height: 200px;" />
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
                                </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="needs-validation"
                  enctype="multipart/form-data" id="addCategoryForm">
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category_name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="category_name" name="category_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="category_slug" class="form-label">Category Slug</label>
                            <input type="text" class="form-control" id="category_slug" name="category_slug" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="category_disc" class="form-label">Category Description</label>
                            <input type="text" class="form-control" id="category_disc" name="category_disc" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="parent_cat" class="form-label">Parent Category</label>
                            <select class="form-select" id="parent_cat" name="parent_cat">
                                <?php foreach ($parent_categories as $parent): ?>
                                    <option value="<?php echo $parent['id']; ?>">
                                        <?php echo htmlspecialchars($parent['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="3"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="3"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="category_image" class="form-label">Category Image</label>
                            <input type="file" class="form-control" id="category_image" name="category_image" accept="image/*">
                            <div class="imagePreview mt-3" style="display: none;">
                                <img class="previewImg img-fluid rounded" src="/placeholder.svg" alt="Preview" style="max-height: 200px;" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Category</button>
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
                <h5 class="modal-title" id="importModalLabel">Import Categories</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                  enctype="multipart/form-data" class="needs-validation">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="import_file" class="form-label">CSV File</label>
                        <input type="file" class="form-control" id="import_file" name="import_file" accept=".csv" required>
                        <div class="form-text">Please upload a CSV file with the following columns: name, slug, description, status</div>
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
<form id="deleteForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="display: none;">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" id="delete_category_id" name="category_id" value="">
</form>

<!-- Publish Form (Hidden) -->
<form id="publishForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="display: none;">
    <input type="hidden" name="action" value="publish">
    <input type="hidden" id="publish_category_id" name="category_id" value="">
</form>

<!-- Unpublish Form (Hidden) -->
<form id="unpublishForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="display: none;">
    <input type="hidden" name="action" value="unpublish">
    <input type="hidden" id="unpublish_category_id" name="category_id" value="">
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
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Initialize DataTables
    var table = $('#categoriesTable').DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copy',
                className: 'btn btn-sm btn-secondary',
                exportOptions: { columns: [0, 1, 2] }
            },
            {
                extend: 'csv',
                className: 'btn btn-sm btn-secondary',
                exportOptions: { columns: [0, 1, 2] }
            },
            {
                extend: 'excel',
                className: 'btn btn-sm btn-secondary',
                exportOptions: { columns: [0, 1, 2] }
            },
            {
                extend: 'pdf',
                className: 'btn btn-sm btn-secondary',
                exportOptions: { columns: [0, 1, 2] }
            },
            {
                extend: 'print',
                className: 'btn btn-sm btn-secondary',
                exportOptions: { columns: [0, 1, 2] }
            }
        ]
    });

    // Hide the default buttons and use our custom export button
    $('.dt-buttons').hide();
    $('#exportBtn').on('click', function() {
        $('.buttons-excel').click();
    });

    // Auto-generate slug from name for add modal
    $('#category_name').on('keyup', function() {
        var name = $(this).val();
        var slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
        $('#category_slug').val(slug);
    });

    // Auto-generate slug from name for edit modals
    $(document).on('keyup', 'input[name="category_name"]', function() {
        var name = $(this).val();
        var slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
        $(this).closest('.row').find('input[name="category_slug"]').val(slug);
    });

    // Delete confirmation
    $(document).on('click', '.delete-btn', function() {
        var categoryId = $(this).data('id');
        var categoryName = $(this).data('name');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete the category "' + categoryName + '". This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#delete_category_id').val(categoryId);
                $('#deleteForm').submit();
            }
        });
    });

    // Publish confirmation
    $(document).on('click', '.publish-btn', function() {
        var categoryId = $(this).data('id');
        Swal.fire({
            title: 'Activate Category',
            text: 'Are you sure you want to activate this category?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, activate it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#publish_category_id').val(categoryId);
                $('#publishForm').submit();
            }
        });
    });

    // Unpublish confirmation
    $(document).on('click', '.unpublish-btn', function() {
        var categoryId = $(this).data('id');
        Swal.fire({
            title: 'Deactivate Category',
            text: 'Are you sure you want to deactivate this category?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, deactivate it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#unpublish_category_id').val(categoryId);
                $('#unpublishForm').submit();
            }
        });
    });

    // Image preview for file input change
    $(document).on('change', 'input[name="category_image"]', function() {
        const file = this.files[0];
        const input = $(this);
        const previewContainer = input.closest('.col-md-6').find('.imagePreview');
        const previewImg = previewContainer.find('.previewImg');

        if (file) {
            // Validate file size (5MB max)
            if (file.size > 5 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File',
                    text: 'File size must be less than 5MB'
                });
                input.val('');
                previewContainer.hide();
                return;
            }

            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File Type',
                    text: 'Please select a valid image file (JPEG, PNG, GIF, WebP)'
                });
                input.val('');
                previewContainer.hide();
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.attr('src', e.target.result);
                previewContainer.show();
            };
            reader.readAsDataURL(file);
        } else {
            // Revert to existing image or placeholder
            const existingSrc = previewImg.attr('src');
            if (existingSrc && !existingSrc.includes('placeholder.svg')) {
                previewContainer.show();
            } else {
                previewContainer.hide();
            }
        }
    });

    // Reset preview when modal is closed
    $('.modal').on('hidden.bs.modal', function() {
        const previewContainer = $(this).find('.imagePreview');
        const previewImg = previewContainer.find('.previewImg');
        const fileInput = $(this).find('input[name="category_image"]');
        fileInput.val(''); // Clear file input
        const action = $(this).find('input[name="action"]').val();
        if (action === 'edit' && previewImg.attr('src') && !previewImg.attr('src').includes('placeholder.svg')) {
            previewContainer.show(); // Keep existing image visible for edit modal
        } else {
            previewImg.attr('src', '/placeholder.svg');
            previewContainer.hide(); // Reset to placeholder for add modal
        }
    });

    // Form validation for both add and edit forms
    $('.needs-validation').each(function() {
        $(this).validate({
            rules: {
                category_name: {
                    required: true,
                    minlength: 3
                },
                category_slug: {
                    required: true,
                    minlength: 3
                },
                parent_cat: {
                    required: true
                },
                meta_title: {
                    required: true,
                    minlength: 3
                },
                meta_keywords: {
                    required: true,
                    minlength: 3
                },
                meta_description: {
                    required: true,
                    minlength: 5
                },
                status: {
                    required: true
                },
                category_image: {
                    extension: "jpg|jpeg|png|gif|webp",
                    required: function(element) {
                        return $(element).closest('form').find('input[name="action"]').val() === 'add';
                    }
                }
            },
            messages: {
                category_name: {
                    required: "Please enter a category name",
                    minlength: "Category name must be at least 3 characters"
                },
                category_slug: {
                    required: "Please enter a category slug",
                    minlength: "Category slug must be at least 3 characters"
                },
                parent_cat: {
                    required: "Please select a parent category"
                },
                meta_title: {
                    required: "Please enter a meta title",
                    minlength: "Meta title must be at least 3 characters"
                },
                meta_keywords: {
                    required: "Please enter meta keywords",
                    minlength: "Meta keywords must be at least 3 characters"
                },
                meta_description: {
                    required: "Please enter a meta description",
                    minlength: "Meta description must be at least 5 characters"
                },
                status: {
                    required: "Please select a status"
                },
                category_image: {
                    required: "Please upload a category image",
                    extension: "Please upload a valid image file (jpg, jpeg, png, gif, webp)"
                }
            },
            errorElement: "div",
            errorClass: "invalid-feedback",
            highlight: function(element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element) {
                $(element).removeClass("is-invalid").addClass("is-valid");
            },
            errorPlacement: function(error, element) {
                if (element.prop("type") === "file") {
                    error.insertAfter(element.closest('.col-md-6').find('.imagePreview'));
                } else {
                    error.insertAfter(element);
                }
            }
        });
    });
});
</script>