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
$page_title = "Event Categories";
$active_menu = "event_categories ";


// Create an array to hold categories
$sql = "SELECT * FROM event_categories ORDER BY id DESC";
$result = $conn->query($sql);

$categories = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Initialize variables
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'add') {
        $name = $_POST['name'];
        $slug = $_POST['slug'];
        $stmt = $conn->prepare("INSERT INTO event_categories (name, slug) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $slug);
        $stmt->execute();
        $message = "Category added successfully!";
        $messageType = "success";
    }

    if ($action === 'edit') {
        $id = $_POST['category_id'];
        $name = $_POST['name'];
        $slug = $_POST['slug'];
        $stmt = $conn->prepare("UPDATE event_categories SET name = ?, slug = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $slug, $id);
        $stmt->execute();
        $message = "Category updated successfully!";
        $messageType = "success";
    }

    if ($action === 'delete') {
        $id = $_POST['category_id'];
        $stmt = $conn->prepare("DELETE FROM event_categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $message = "Event Category deleted successfully.";
        $messageType = "success";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>

<?php include 'includes/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Event Categories</h1>
                <div>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <i class="fas fa-plus me-1"></i> Add Category
                    </button>
                </div>
            </div>

            <!-- Alert Message -->
            <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Categories Table -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <table id="categoriesTable" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <tr>
                                        <td><?php echo $cat['id']; ?></td>
                                        <td><?php echo htmlspecialchars($cat['name']); ?></td>
                                        <td><?php echo htmlspecialchars($cat['slug']); ?></td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editCategoryModal<?php echo $cat['id']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm delete-btn" data-name="<?php echo $cat['name']; ?>" data-id="<?php echo $cat['id']; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Edit Category Modal -->
                                    <div class="modal fade" id="editCategoryModal<?php echo $cat['id']; ?>" tabindex="-1" aria-labelledby="editCategoryModalLabel<?php echo $cat['id']; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editCategoryModalLabel<?php echo $cat['id']; ?>">Edit Category</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="needs-validation" novalidate>
                                                    <input type="hidden" name="action" value="edit">
                                                    <input type="hidden" name="category_id" value="<?php echo $cat['id']; ?>">

                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="edit_category_name_<?php echo $cat['id']; ?>" class="form-label">Category Name</label>
                                                            <!-- <input type="text" class="form-control" id="edit_category_name_<?php echo $cat['id']; ?>" name="name" value="<?php echo htmlspecialchars($cat['name']); ?>" required minlength="3"> -->
                                                            <input type="text" class="form-control slug-source" id="edit_category_name_<?php echo $cat['id']; ?>" name="name" value="<?php echo htmlspecialchars($cat['name']); ?>" required>

                                                            <div class="invalid-feedback">
                                                                Please enter a category name (at least 3 characters).
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_category_slug_<?php echo $cat['id']; ?>" class="form-label">Slug</label>
                                                            <!-- <input type="text" class="form-control" id="edit_category_slug_<?php echo $cat['id']; ?>" name="slug" value="<?php echo htmlspecialchars($cat['slug']); ?>" required minlength="3"> -->
                                                            <input type="text" class="form-control slug-target" id="edit_category_slug_<?php echo $cat['id']; ?>" name="slug" value="<?php echo htmlspecialchars($cat['slug']); ?>" required>
                                                            <div class="invalid-feedback">
                                                                Please enter a slug (at least 3 characters).
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
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No categories found.</td>
                                </tr>
                            <?php endif; ?>
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
        <form method="post" action="" id="addCategoryForm" class="modal-content needs-validation" novalidate>
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add Event Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="action" value="add">
                <div class="mb-3">
                    <label for="category_name" class="form-label">Category Name</label>
                    <input type="text" class="form-control slug-source" id="category_name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="category_slug" class="form-label">Slug</label>
                    <input type="text" class="form-control slug-target" id="category_slug" name="slug" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Category</button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>



<!-- Delete Confirmation Form (Hidden) -->
<form id="deleteForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="display: none;">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" id="delete_category_id" name="category_id" value="">
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
        // === Datatable Initialization ===
        const table = $('#categoriesTable').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'].map(type => ({
                extend: type,
                className: 'btn btn-sm btn-secondary',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }))
        });

        $('.dt-buttons').hide();
        $('#exportBtn').on('click', () => $('.buttons-excel').click());

        // === Slug Generation Utility ===
        const generateSlug = (text) =>
            text.toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '');

        // === Slug Auto-Generation Logic ===
        $(document).on('input', '.slug-source', function() {
            const $slugInput = $($(this).data('target'));
            if (!$slugInput.data('manual')) {
                $slugInput.val(generateSlug($(this).val()));
            }
        });

        $(document).on('input', '.slug-target', function() {
            $(this).data('manual', true);
        });

        // === Set data attributes on DOM load ===
        $('#category_name').attr('data-target', '#category_slug');
        $('#category_slug').data('manual', false);

        $('input[id^="edit_category_name_"]').each(function() {
            const id = $(this).attr('id').replace('edit_category_name_', '');
            $(this).attr('data-target', `#edit_category_slug_${id}`);
            $(`#edit_category_slug_${id}`).data('manual', false);
        });

        // === Delete Confirmation with SweetAlert2 ===
        $(document).on('click', '.delete-btn', function() {
            const categoryId = $(this).data('id');
            const categoryName = $(this).data('name');
            $('#delete_category_id').val(categoryId);
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete the category "${categoryName}". This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteForm').submit();
                }
            });
        });

        // === Form Validation ===
        const validateForm = (formSelector) => {
            $(formSelector).validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    slug: {
                        required: true,
                        minlength: 3
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a category name",
                        minlength: "Category name must be at least 3 characters"
                    },
                    slug: {
                        required: "Please enter a slug",
                        minlength: "Slug must be at least 3 characters"
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
                        error.insertAfter(element.closest('.form-control'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        };

        // Init validation for Add Category
        validateForm("#addCategoryForm");

        // Init validation for all Edit Category forms
        $('form').each(function() {
            if ($(this).find('input[name="action"]').val() === 'edit') {
                validateForm(this);
            }
        });
    });
</script>

