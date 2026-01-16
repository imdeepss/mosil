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
$page_title = "Parent Attribute";
$active_menu = "catalogue_parent_attribute";


//fetch from DB
// SQL query to fetch data from parent_attribute table
$sql = "SELECT * FROM parent_attribute";
$result = $conn->query($sql);

// Create an array to hold categories
$categories = [];

if ($result->num_rows > 0) {
    // Fetch each row as an associative array
    while ($row = $result->fetch_assoc()) {
        $categories[] = [
            'id' => (int) $row['id'],
            'name' => $row['parent_attr_name'],
            'sub_cat' => $row['sub_cat'],
            'status' => $row['status'],
            'meta_title' => $row['meta_title'],
            'meta_keywords' => $row['meta_keywords'],
            'meta_description' => $row['meta_description'],
        ];
    }
}

$fetch_sql = "SELECT id, scat_name FROM sub_category";
$sub_cat_result = $conn->query($fetch_sql);

// Create an array to hold categories
$sub_categories = [];

if ($sub_cat_result->num_rows > 0) {
    // Fetch each row as an associative array
    while ($row = $sub_cat_result->fetch_assoc()) {
        $sub_categories[] = [
            'id' => (int) $row['id'],
            'name' => $row['scat_name']
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
        $categoryName = sanitizeInput($_POST['parent_attribute_name'] ?? '');
        $subCatId = (int) sanitizeInput($_POST['sub_cat'] ?? '');
        $metaTitle = sanitizeInput($_POST['meta_title'] ?? '');
        $metaKeywords = sanitizeInput($_POST['meta_keywords'] ?? '');
        $metaDescription = sanitizeInput($_POST['meta_description'] ?? '');
        $status = sanitizeInput($_POST['status'] ?? '');

        if ($action === 'add' || $action === 'edit') {
            // Validate form data
            if (empty($categoryName) || empty($subCatId) || empty($status)) {
                $message = "Please fill in all required fields.";
                $messageType = "danger";
            } else {
                if ($action === 'add') {
                    // Insert new Parent Attribute
                    $stmt = $conn->prepare("INSERT INTO parent_attribute (parent_attr_name, sub_cat, meta_title, meta_keywords, meta_description, status) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssss", $categoryName, $subCatId, $metaTitle, $metaKeywords, $metaDescription, $status);
                    $stmt->execute();

                    $message = "Parent Attribute added successfully.";
                    $messageType = "success";
                } else {
                    // Update existing Parent Attribute
                    $stmt = $conn->prepare("UPDATE parent_attribute SET parent_attr_name = ?, sub_cat = ?, meta_title = ?, meta_keywords = ?, meta_description = ?, status = ? WHERE id = ?");
                    $stmt->bind_param("ssssssi", $categoryName, $subCatId, $metaTitle, $metaKeywords, $metaDescription, $status, $categoryId);
                    $stmt->execute();
                    $message = "Parent Attribute updated successfully.";
                    $messageType = "success";
                }
            }
        } elseif ($action === 'delete') {
            // Delete Parent Attribute
            $stmt = $conn->prepare("DELETE FROM parent_attribute WHERE id = ?");
            $stmt->bind_param("i", $categoryId);
            $stmt->execute();

            $message = "Parent Attribute deleted successfully.";
            $messageType = "success";
        } elseif ($action === 'publish' || $action === 'unpublish') {
            $newStatus = ($action === 'publish') ? 'Active' : 'Inactive';

            $stmt = $conn->prepare("UPDATE parent_attribute SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $stmt->bind_param("si", $newStatus, $categoryId);
            $stmt->execute();

            $message = ($action === 'publish') ? "Parent Attribute published successfully." : "Parent Attribute unpublished successfully.";
            $messageType = "success";
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
                <h1 class="h2">Parent Attribute</h1>
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
                            <p class="card-text h2"><?php echo array_sum(array_column($categories, 'products_count')); ?></p>
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
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editCategoryModal<?php echo $category['id']; ?>">
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

                                <!-- Edit Category Modal -->
                                <div class="modal fade" id="editCategoryModal<?php echo $category['id']; ?>" tabindex="-1" aria-labelledby="editCategoryModalLabel<?php echo $category['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editCategoryModalLabel<?php echo $category['id']; ?>">Edit Sub Category</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="needs-validation" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <input type="hidden" name="action" value="edit">
                                                    <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">

                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="sub_cat" class="form-label">Select Main Category</label>
                                                            <select class="form-select" id="sub_cat<?php echo $category['id']; ?>" name="sub_cat" required>
                                                                <option value="">-- Select Category --</option>
                                                                <?php foreach ($sub_categories as $sub_cat): ?>
                                                                    <option value="<?php echo $sub_cat['id']; ?>"
                                                                        <?php echo ($sub_cat['id'] == $category['sub_cat']) ? 'selected' : ''; ?>>
                                                                        <?php echo htmlspecialchars($sub_cat['name']); ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="parent_attribute_name<?php echo $category['id']; ?>" class="form-label">Parent Attribute</label>
                                                            <input type="text" class="form-control" id="parent_attribute_name<?php echo $category['id']; ?>" name="parent_attribute_name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
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
                                                            <input type="text" class="form-control" id="meta_title<?php echo $category['id']; ?>" name="meta_title" value="<?php echo htmlspecialchars($category['meta_title']); ?>">
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label for="meta_keywords<?php echo $category['id']; ?>" class="form-label">Meta Keywords</label>
                                                            <textarea class="form-control" id="meta_keywords<?php echo $category['id']; ?>" name="meta_keywords" rows="3"><?php echo htmlspecialchars($category['meta_keywords']); ?></textarea>
                                                        </div>

                                                        <div class="col-12 mb-3">
                                                            <label for="meta_description<?php echo $category['id']; ?>" class="form-label">Meta Description</label>
                                                            <textarea class="form-control" id="meta_description<?php echo $category['id']; ?>" name="meta_description" rows="3"><?php echo htmlspecialchars($category['meta_description']); ?></textarea>
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
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="needs-validation" enctype="multipart/form-data" id="addCategoryForm" novalidate>
                <div class="modal-body">
                    <!-- Hidden action field -->
                    <input type="hidden" name="action" value="add">

                    <!-- Category Name -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="parent_attribute_name" class="form-label">Parent Attribute Name</label>
                            <input type="text" class="form-control" id="parent_attribute_name" name="parent_attribute_name" required>
                            <div class="invalid-feedback">
                                Please provide a category name.
                            </div>
                        </div>


                        <!-- Parent Category (Select Option) -->
                        <div class="col-md-6 mb-3">
                            <label for="sub_cat" class="form-label">Select Main Category</label>
                            <select class="form-select" id="sub_cat<?php echo $category['id']; ?>" name="sub_cat" required>
                                <option value="">-- Select Category --</option>
                                <?php foreach ($sub_categories as $sub_cat): ?>
                                    <option value="<?php echo $sub_cat['id']; ?>">
                                        <?php echo htmlspecialchars($sub_cat['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Status -->
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

                        <!-- Meta Title -->
                        <div class="col-md-6 mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title">
                        </div>

                        <!-- Meta Keywords -->
                        <div class="col-md-6 mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="3"></textarea>
                        </div>

                        <!-- Meta Description -->
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
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" class="needs-validation">
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
            buttons: [{
                    extend: 'copy',
                    className: 'btn btn-sm btn-secondary',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn btn-sm btn-secondary',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn btn-sm btn-secondary',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-sm btn-secondary',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'print',
                    className: 'btn btn-sm btn-secondary',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                }
            ]
        });

        // Hide the default buttons and use our custom export button
        $('.dt-buttons').hide();

        $('#exportBtn').on('click', function() {
            $('.buttons-excel').click();
        });

        // Auto-generate slug from name
        $('#category_name').on('keyup', function() {
            var name = $(this).val();
            var slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            $('#category_slug').val(slug);
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

        // Form validation
        $(document).ready(function() {
            // Initialize form validation
            $("#addCategoryForm").validate({
                rules: {
                    parent_attribute_name: {
                        required: true,
                        minlength: 3
                    },
                    sub_cat: {
                        required: true
                    },
                    status: {
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
                },
                messages: {
                    parent_attribute_name: {
                        required: "Please enter a category name",
                        minlength: "Category name must be at least 3 characters"
                    },
                    sub_cat: {
                        required: "Please select a parent category"
                    },
                    status: {
                        required: "Please select a status"
                    },
                    meta_title: {
                        required: "Please Enter A Meta Title",
                        minlength: "Meta title must be at least 3 characters"
                    },
                    meta_keywords: {
                        required: "Please Enter A Meta Keywords",
                        minlength: "Meta keywords must be at least 3 characters"
                    },
                    meta_description: {
                        required: "Please Enter A Meta Description",
                        minlength: "Meta description must be at least 5 characters"
                    },
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
                        error.insertAfter(element.closest('.form-control'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                // Optional: submit handler for the form
                submitHandler: function(form) {
                    form.submit(); // This will submit the form after validation
                }
            });
        });

    });
</script>