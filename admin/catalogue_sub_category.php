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
$page_title = "Sub Categories";
$active_menu = "catalogue_sub_category";

// Fetch from DB
// SQL query to fetch data from sub_category table
$sql = "SELECT * FROM sub_category";
$result = $conn->query($sql);

// Create an array to hold categories
$categories = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = [
            'id' => (int) $row['id'],
            'name' => $row['scat_name'],
            'main_c' => $row['m_cat'],
            'status' => $row['status'],
            'meta_title' => $row['meta_title'],
            'meta_keywords' => $row['meta_keywords'],
            'meta_description' => $row['meta_description'],
        ];
    }
}

$fetch_sql = "SELECT id, mcat_name FROM main_category";
$main_cat_result = $conn->query($fetch_sql);

// Create an array to hold main categories
$main_categories = [];

if ($main_cat_result->num_rows > 0) {
    while ($row = $main_cat_result->fetch_assoc()) {
        $main_categories[] = [
            'id' => (int) $row['id'],
            'name' => $row['mcat_name']
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
        $categoryId = isset($_POST['category_id']) ? (int) $_POST['category_id'] : 0;
        $categoryName = sanitizeInput($_POST['sub_category_name'] ?? '');
        $mainCatId = isset($_POST['main_category_name']) && is_array($_POST['main_category_name']) ? implode(',', $_POST['main_category_name']) : '';
        $metaTitle = sanitizeInput($_POST['meta_title'] ?? '');
        $metaKeywords = sanitizeInput($_POST['meta_keywords'] ?? '');
        $metaDescription = sanitizeInput($_POST['meta_description'] ?? '');
        $status = sanitizeInput($_POST['status'] ?? '');

        if ($action === 'add' || $action === 'edit') {
            
            if ($action === 'add') {
                // Insert new sub-category
                $stmt = $conn->prepare("INSERT INTO sub_category (scat_name, m_cat, meta_title, meta_keywords, meta_description, status) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $categoryName, $mainCatId, $metaTitle, $metaKeywords, $metaDescription, $status);
                if ($stmt->execute()) {
                    $message = "Sub-category added successfully.";
                    $messageType = "success";
                } else {
                    $message = "Error adding sub-category: " . $stmt->error;
                    $messageType = "danger";
                }
            } else {
                // Update existing sub-category
                $stmt = $conn->prepare("UPDATE sub_category SET scat_name = ?, m_cat = ?, meta_title = ?, meta_keywords = ?, meta_description = ?, status = ? WHERE id = ?");
                $stmt->bind_param("ssssssi", $categoryName, $mainCatId, $metaTitle, $metaKeywords, $metaDescription, $status, $categoryId);
                if ($stmt->execute()) {
                    $message = "Sub-category updated successfully.";
                    $messageType = "success";
                } else {
                    $message = "Error updating sub-category: " . $stmt->error;
                    $messageType = "danger";
                }
            }
            
        } elseif ($action === 'delete') {
            // Delete sub-category
            $stmt = $conn->prepare("DELETE FROM sub_category WHERE id = ?");
            $stmt->bind_param("i", $categoryId);
            if ($stmt->execute()) {
                $message = "Sub-category deleted successfully.";
                $messageType = "success";
            } else {
                $message = "Error deleting sub-category: " . $stmt->error;
                $messageType = "danger";
            }
        } elseif ($action === 'publish' || $action === 'unpublish') {
            $newStatus = ($action === 'publish') ? 'Active' : 'Inactive';

            $stmt = $conn->prepare("UPDATE sub_category SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $stmt->bind_param("si", $newStatus, $categoryId);
            if ($stmt->execute()) {
                $message = ($action === 'publish') ? "Sub-category published successfully." : "Sub-category unpublished successfully.";
                $messageType = "success";
            } else {
                $message = "Error updating status: " . $stmt->error;
                $messageType = "danger";
            }
        }

        // Close statement and connection
        if (isset($stmt)) {
            $stmt->close();
        }
        $conn->close();
    }
}
?>

<?php include 'includes/header.php'; ?>



<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Sub Categories</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="exportBtn">
                            <i class="fas fa-download me-1"></i> Export
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="fas fa-upload me-1"></i> Import
                        </button>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
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
                                                        return $cat['status'] === 'Active';
                                                    })); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Inactive Categories</h5>
                            <p class="card-text h2"><?php echo count(array_filter($categories, function ($cat) {
                                                        return $cat['status'] === 'Inactive';
                                                    })); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Products</h5>
                            <p class="card-text h2">0</p> <!-- Placeholder, as products_count is not available -->
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
                                            <button type="button" class="btn btn-sm btn-primary btnEditModal"  data-id="<?php echo $category['id']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <?php if ($category['status'] === 'Active'): ?>
                                                <button type="button" class="btn btn-sm btn-warning unpublish-btn" data-id="<?php echo $category['id']; ?>">
                                                    <i class="fas fa-eye-slash"></i>
                                                </button>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-sm btn-success publish-btn" data-id="<?php echo $category['id']; ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            <?php endif; ?>
                                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="<?php echo $category['id']; ?>" data-name="<?php echo htmlspecialchars($category['name']); ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>



<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal"></div>


<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="needs-validation" enctype="multipart/form-data" id="addCategoryForm" novalidate>
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sub_category_name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="sub_category_name" name="sub_category_name" required>
                            <div class="invalid-feedback">
                                Please provide a category name.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="main_category_name" class="form-label">Select Main Category</label>
                            <select class="form-select select2" id="main_category_name" name="main_category_name[]" multiple required>
                                <option value="">-- Select Main Category --</option>
                                <?php foreach ($main_categories as $m_category): ?>
                                    <option value="<?php echo $m_category['id']; ?>">
                                        <?php echo htmlspecialchars($m_category['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">-- Select Status --</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select the status.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="3"></textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="3"></textarea>
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
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="import_file" class="form-label">CSV File</label>
                        <input type="file" class="form-control" id="import_file" name="import_file" accept=".csv" required>
                        <div class="form-text">Please upload a CSV file with the following columns: scat_name, m_cat, meta_title, meta_keywords, meta_description, status</div>
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

<script>
// === INIT SELECT2 ===
function initSelect2($container = $(document)) {
    $container.find(".select2").each(function () {
        const $el = $(this);
        const $modalParent = $el.closest(".modal");
        if ($el.hasClass("select2-hidden-accessible")) {
            $el.select2("destroy");
        }
        $el.select2({
            dropdownParent: $modalParent.length ? $modalParent : $(document.body),
            width: "100%",
            placeholder: "-- Select Category --",
            allowClear: true
        });
    });
}

// === INIT VALIDATION ===
function initValidation($container = $(document)) {
    $container.find(".needs-validation").each(function () {
        $(this).validate({
            rules: {
                sub_category_name: {
                    required: true,
                    minlength: 3
                },
                main_category_name: {
                    required: true
                },
                status: {
                    required: true
                },
                meta_title: {
                    minlength: 3
                },
                meta_keywords: {
                    minlength: 3
                },
                meta_description: {
                    minlength: 5
                }
            },
            messages: {
                sub_category_name: {
                    required: "Please enter a category name",
                    minlength: "Category name must be at least 3 characters"
                },
                main_category_name: {
                    required: "Please select a parent category"
                },
                status: {
                    required: "Please select a status"
                },
                meta_title: {
                    minlength: "Meta title must be at least 3 characters"
                },
                meta_keywords: {
                    minlength: "Meta keywords must be at least 3 characters"
                },
                meta_description: {
                    minlength: "Meta description must be at least 5 characters"
                }
            },
            errorElement: "div",
            errorClass: "invalid-feedback",
            highlight: function (element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function (element) {
                $(element).removeClass("is-invalid").addClass("is-valid");
            },
            errorPlacement: function (error, element) {
                if (element.hasClass("select2-hidden-accessible")) {
                    error.insertAfter(element.next(".select2-container"));
                } else {
                    error.insertAfter(element);
                }
            },           
        });
    });
}

// === DOCUMENT READY ===
$(document).ready(function () {
    // === DATATABLES ===
    const table = $('#categoriesTable').DataTable({
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

    $('.dt-buttons').hide();

    $('#exportBtn').on('click', function () {
        $('.buttons-excel').click();
    });

    // === SELECT2 INIT ON PAGE LOAD ===
    initSelect2();

    // === VALIDATION INIT ON PAGE LOAD ===
    initValidation();

    // === CONFIRM DELETE ===
    $(document).on('click', '.delete-btn', function () {
        const categoryId = $(this).data('id');
        const categoryName = $(this).data('name');

        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete the category "${categoryName}". This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then(result => {
            if (result.isConfirmed) {
                $('#delete_category_id').val(categoryId);
                $('#deleteForm').submit();
            }
        });
    });

    // === CONFIRM PUBLISH ===
    $(document).on('click', '.publish-btn', function () {
        const categoryId = $(this).data('id');

        Swal.fire({
            title: 'Activate Category',
            text: 'Are you sure you want to activate this category?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, activate it!'
        }).then(result => {
            if (result.isConfirmed) {
                $('#publish_category_id').val(categoryId);
                $('#publishForm').submit();
            }
        });
    });

    // === CONFIRM UNPUBLISH ===
    $(document).on('click', '.unpublish-btn', function () {
        const categoryId = $(this).data('id');

        Swal.fire({
            title: 'Deactivate Category',
            text: 'Are you sure you want to deactivate this category?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, deactivate it!'
        }).then(result => {
            if (result.isConfirmed) {
                $('#unpublish_category_id').val(categoryId);
                $('#unpublishForm').submit();
            }
        });
    });

    // === LOAD MODAL CONTENT VIA AJAX ===
    $(document).on('click', '.btnEditModal', function () {
        const productId = $(this).data('id');
        $.ajax({
            url: "./_ajax/getSubCat.php",
            type: "POST",
            data: { id: productId },
            dataType: "html",
            success: function (data) {
                $("#editCategoryModal").html(data);
                const $modal = $("#editCategoryModal");

                $modal.modal("show");

                $modal.on("shown.bs.modal", function () {
                    initSelect2($(this));
                    // initValidation($(this));
                });
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                Swal.fire({
                    icon: 'error',
                    title: 'Load Error',
                    text: 'Unable to load edit form. Please try again later.'
                });
            }
        });
    });
});
</script>