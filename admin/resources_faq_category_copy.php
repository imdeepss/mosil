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
$page_title = "FAQ Categories";
$active_menu = "resources_faq_category";

// Initialize variables
$message = '';
$messageType = '';


// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add' || $action === 'edit') {
            // Get form data
            $categoryId = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;
            $categoryName = sanitizeInput($_POST['category_name'] ?? '');
            $categorySlug = sanitizeInput($_POST['category_slug'] ?? '');
            $description = sanitizeInput($_POST['description'] ?? '');
            $displayOrder = (int)($_POST['display_order'] ?? 0);
            $status = sanitizeInput($_POST['status'] ?? '');

            // Validate form data
            if (empty($categoryName) || empty($categorySlug)) {
                $message = "Please fill in all required fields.";
                $messageType = "danger";
            } else {
                if ($action === 'add') {
                    // Check if slug is unique in categoryMap
                    if (array_search($categorySlug, array_column($categoryMap, 'slug')) !== false) {
                        $message = "Category slug already exists.";
                        $messageType = "danger";
                    } else {
                        // Add new category to categoryMap (in a real app, this could be stored in a database table)
                        $newCategoryId = max(array_keys($categoryMap)) + 1;
                        $categoryMap[$newCategoryId] = [
                            'name' => $categoryName,
                            'slug' => $categorySlug,
                            'description' => $description,
                            'display_order' => $displayOrder,
                            'status' => $status
                        ];
                        $message = "FAQ Category added successfully.";
                        $messageType = "success";
                    }
                } elseif ($action === 'edit') {
                    // Check if slug is unique (excluding current category)
                    $slugExists = false;
                    foreach ($categoryMap as $id => $cat) {
                        if ($id != $categoryId && $cat['slug'] === $categorySlug) {
                            $slugExists = true;
                            break;
                        }
                    }
                    if ($slugExists) {
                        $message = "Category slug already exists.";
                        $messageType = "danger";
                    } else {
                        // Update category in categoryMap
                        $categoryMap[$categoryId] = [
                            'name' => $categoryName,
                            'slug' => $categorySlug,
                            'description' => $description,
                            'display_order' => $displayOrder,
                            'status' => $status
                        ];
                        // Update status of FAQs in this category
                        $stmt = $conn->prepare("UPDATE faq SET status = ?, updated_at = NOW() WHERE category = ?");
                        $stmt->bind_param("si", $status, $categoryId);
                        if ($stmt->execute()) {
                            $message = "FAQ Category updated successfully.";
                            $messageType = "success";
                        } else {
                            $message = "Error updating FAQs: " . $stmt->error;
                            $messageType = "danger";
                        }
                        $stmt->close();
                    }
                }
            }
        } elseif ($action === 'delete') {
            // Get category ID
            $categoryId = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;

            // Check if category has FAQs
            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM faq WHERE category = ?");
            $stmt->bind_param("i", $categoryId);
            $stmt->execute();
            $result = $stmt->get_result();
            $count = $result->fetch_assoc()['count'];
            $stmt->close();

            if ($count > 0) {
                $message = "Cannot delete category with associated FAQs.";
                $messageType = "danger";
            } else {
                // Remove category from categoryMap
                unset($categoryMap[$categoryId]);
                $message = "FAQ Category deleted successfully.";
                $messageType = "success";
            }
        } elseif ($action === 'publish' || $action === 'unpublish') {
            // Get category ID
            $categoryId = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;
            $newStatus = ($action === 'publish') ? 'Active' : 'Inactive';

            // Update status in categoryMap
            if (isset($categoryMap[$categoryId])) {
                $categoryMap[$categoryId]['status'] = $newStatus;
                // Update status of FAQs in this category
                $stmt = $conn->prepare("UPDATE faq SET status = ?, updated_at = NOW() WHERE category = ?");
                $stmt->bind_param("si", $newStatus, $categoryId);
                if ($stmt->execute()) {
                    $message = ($action === 'publish') ? "FAQ Category published successfully." : "FAQ Category unpublished successfully.";
                    $messageType = "success";
                } else {
                    $message = "Error updating status: " . $stmt->error;
                    $messageType = "danger";
                }
                $stmt->close();
            } else {
                $message = "Category not found.";
                $messageType = "danger";
            }
        }
    }
}

// Fetch FAQ categories from faq table
$faqCategories = [];
$result = $conn->query("
    SELECT category, COUNT(*) as faqs_count, MIN(created_at) as created_at, MIN(updated_at) as updated_at
    FROM faq
    GROUP BY category
    ORDER BY category ASC
");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        if (isset($categoryMap[$row['category']])) {
            $faqCategories[] = [
                'id' => $row['category'],
                'name' => $categoryMap[$row['category']]['name'],
                'slug' => $categoryMap[$row['category']]['slug'],
                'description' => $categoryMap[$row['category']]['description'] ?? '',
                'display_order' => $categoryMap[$row['category']]['display_order'] ?? 1,
                'status' => $categoryMap[$row['category']]['status'] ?? 'Active',
                'faqs_count' => $row['faqs_count'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            ];
        }
    }
    $result->free();
} else {
    $message = "Error fetching categories: " . $conn->error;
    $messageType = "danger";
}
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">FAQ Categories</h1>
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

            <!-- FAQ Categories Overview Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Categories</h5>
                            <p class="card-text h2"><?php echo count($faqCategories); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Active Categories</h5>
                            <p class="card-text h2"><?php echo count(array_filter($faqCategories, function ($cat) {
                                                        return $cat['status'] === 'Active';
                                                    })); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total FAQs</h5>
                            <p class="card-text h2"><?php echo array_sum(array_column($faqCategories, 'faqs_count')); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ Categories Table -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <table id="faqCategoriesTable" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($faqCategories as $category): ?>
                                <tr>
                                    <td><?php echo $category['id']; ?></td>
                                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                                    <td><?php echo htmlspecialchars($category['description'] ?? ''); ?></td>
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
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editCategoryModalLabel<?php echo $category['id']; ?>">Edit FAQ Category</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="needs-validation">
                                                <div class="modal-body">
                                                    <input type="hidden" name="action" value="edit">
                                                    <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">

                                                    <div class="mb-3">
                                                        <label for="category_name<?php echo $category['id']; ?>" class="form-label">Category Name</label>
                                                        <input type="text" class="form-control" id="category_name<?php echo $category['id']; ?>" name="category_name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="category_slug<?php echo $category['id']; ?>" class="form-label">Category Slug</label>
                                                        <input type="text" class="form-control" id="category_slug<?php echo $category['id']; ?>" name="category_slug" value="<?php echo htmlspecialchars($category['slug']); ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="description<?php echo $category['id']; ?>" class="form-label">Description</label>
                                                        <textarea class="form-control" id="description<?php echo $category['id']; ?>" name="description" rows="3"><?php echo htmlspecialchars($category['description'] ?? ''); ?></textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="display_order<?php echo $category['id']; ?>" class="form-label">Display Order</label>
                                                        <input type="number" class="form-control" id="display_order<?php echo $category['id']; ?>" name="display_order" value="<?php echo $category['display_order']; ?>" min="1">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="status<?php echo $category['id']; ?>" class="form-label">Status</label>
                                                        <select class="form-select" id="status<?php echo $category['id']; ?>" name="status">
                                                            <option value="Active" <?php echo ($category['status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                                                            <option value="Inactive" <?php echo ($category['status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                                                        </select>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add New FAQ Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="needs-validation" id="addCategoryForm">
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">

                    <div class="mb-3">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="category_slug" class="form-label">Category Slug</label>
                        <input type="text" class="form-control" id="category_slug" name="category_slug" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="display_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="display_order" name="display_order" value="1" min="1">
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
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
                <h5 class="modal-title" id="importModalLabel">Import FAQ Categories</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" class="needs-validation">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="import_file" class="form-label">CSV File</label>
                        <input type="file" class="form-control" id="import_file" name="import_file" accept=".csv" required>
                        <div class="form-text">Please upload a CSV file with the following columns: name, slug, description, display_order, status</div>
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
        var table = $('#faqCategoriesTable').DataTable({
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
        $('.delete-btn').on('click', function() {
            var categoryId = $(this).data('id');
            var categoryName = $(this).data('name');

            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete the FAQ category "' + categoryName + '". This action cannot be undone!',
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
        $('.publish-btn').on('click', function() {
            var categoryId = $(this).data('id');

            Swal.fire({
                title: 'Activate FAQ Category',
                text: 'Are you sure you want to activate this FAQ category?',
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
        $('.unpublish-btn').on('click', function() {
            var categoryId = $(this).data('id');

            Swal.fire({
                title: 'Deactivate FAQ Category',
                text: 'Are you sure you want to deactivate this FAQ category?',
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
        $("#addCategoryForm").validate({
            rules: {
                category_name: {
                    required: true,
                    minlength: 3
                },
                category_slug: {
                    required: true,
                    minlength: 3
                },
                display_order: {
                    required: true,
                    digits: true,
                    min: 1
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
                display_order: {
                    required: "Please enter a display order",
                    digits: "Display order must be a whole number",
                    min: "Display order must be at least 1"
                }
            },
            errorElement: "div",
            errorClass: "invalid-feedback",
            highlight: function(element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element) {
                $(element).addClass("is-valid").removeClass("is-invalid");
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });
    });
</script>