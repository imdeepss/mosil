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
$page_title = "Content Pages";
$active_menu = "cms_content";

// Initialize variables
$message = '';
$messageType = '';

// Process form submission (in a real application, this would save to database)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add' || $action === 'edit') {
            // Get form data
            $pageId = isset($_POST['page_id']) ? (int)$_POST['page_id'] : 0;
            $pageTitle = sanitizeInput($_POST['page_title'] ?? '');
            $pageSlug = sanitizeInput($_POST['page_slug'] ?? '');
            $pageContent = $_POST['page_content'] ?? '';
            $metaTitle = sanitizeInput($_POST['meta_title'] ?? '');
            $metaDescription = sanitizeInput($_POST['meta_description'] ?? '');
            $status = sanitizeInput($_POST['status'] ?? '');

            // Validate form data
            if (empty($pageTitle) || empty($pageSlug)) {
                $message = "Please fill in all required fields.";
                $messageType = "danger";
            } else {
                // In a real application, you would save to database
                // For demo purposes, we'll just show a success message
                $message = ($action === 'add') ? "Page added successfully." : "Page updated successfully.";
                $messageType = "success";
            }
        } elseif ($action === 'delete') {
            // Get page ID
            $pageId = isset($_POST['page_id']) ? (int)$_POST['page_id'] : 0;

            // In a real application, you would delete from database
            // For demo purposes, we'll just show a success message
            $message = "Page deleted successfully.";
            $messageType = "success";
        } elseif ($action === 'publish' || $action === 'unpublish') {
            // Get page ID
            $pageId = isset($_POST['page_id']) ? (int)$_POST['page_id'] : 0;

            // In a real application, you would update the status in database
            // For demo purposes, we'll just show a success message
            $message = ($action === 'publish') ? "Page published successfully." : "Page unpublished successfully.";
            $messageType = "success";
        }
    }
}

// Sample data for content pages (in a real application, this would come from database)
$contentPages = [
    [
        'id' => 1,
        'title' => 'About Us',
        'slug' => 'about-us',
        'content' => '<p>This is the about us page content.</p>',
        'meta_title' => 'About Our Company',
        'meta_description' => 'Learn more about our company and what we do.',
        'status' => 'published',
        'created_at' => '2023-05-01',
        'updated_at' => '2023-05-15'
    ],
    [
        'id' => 2,
        'title' => 'Services',
        'slug' => 'services',
        'content' => '<p>Our services page content goes here.</p>',
        'meta_title' => 'Our Services',
        'meta_description' => 'Explore the services we offer to our clients.',
        'status' => 'published',
        'created_at' => '2023-05-02',
        'updated_at' => '2023-05-16'
    ],
    [
        'id' => 3,
        'title' => 'Contact Us',
        'slug' => 'contact-us',
        'content' => '<p>Contact us page with form and details.</p>',
        'meta_title' => 'Contact Our Team',
        'meta_description' => 'Get in touch with our team for inquiries and support.',
        'status' => 'published',
        'created_at' => '2023-05-03',
        'updated_at' => '2023-05-17'
    ],
    [
        'id' => 4,
        'title' => 'Privacy Policy',
        'slug' => 'privacy-policy',
        'content' => '<p>Our privacy policy details.</p>',
        'meta_title' => 'Privacy Policy',
        'meta_description' => 'Read our privacy policy and how we protect your data.',
        'status' => 'published',
        'created_at' => '2023-05-04',
        'updated_at' => '2023-05-18'
    ],
    [
        'id' => 5,
        'title' => 'Terms of Service',
        'slug' => 'terms-of-service',
        'content' => '<p>Terms of service content.</p>',
        'meta_title' => 'Terms of Service',
        'meta_description' => 'Our terms of service and conditions of use.',
        'status' => 'draft',
        'created_at' => '2023-05-05',
        'updated_at' => '2023-05-19'
    ],
    [
        'id' => 6,
        'title' => 'FAQ',
        'slug' => 'faq',
        'content' => '<p>Frequently asked questions and answers.</p>',
        'meta_title' => 'Frequently Asked Questions',
        'meta_description' => 'Find answers to commonly asked questions about our products and services.',
        'status' => 'draft',
        'created_at' => '2023-05-06',
        'updated_at' => '2023-05-20'
    ],
    [
        'id' => 7,
        'title' => 'Blog',
        'slug' => 'blog',
        'content' => '<p>Our blog page with latest articles.</p>',
        'meta_title' => 'Company Blog',
        'meta_description' => 'Read our latest articles and industry insights.',
        'status' => 'published',
        'created_at' => '2023-05-07',
        'updated_at' => '2023-05-21'
    ]
];
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Content Pages</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="exportBtn">
                            <i class="fas fa-download me-1"></i> Export
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="fas fa-upload me-1"></i> Import
                        </button>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addPageModal">
                        <i class="fas fa-plus me-1"></i> Add New Page
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

            <!-- Content Pages Table -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <table id="contentPagesTable" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Meta Title</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contentPages as $page): ?>
                                <tr>
                                    <td><?php echo $page['id']; ?></td>
                                    <td><?php echo htmlspecialchars($page['title']); ?></td>
                                    <td><?php echo htmlspecialchars($page['slug']); ?></td>
                                    <td><?php echo htmlspecialchars($page['meta_title']); ?></td>
                                    <td>
                                        <?php if ($page['status'] === 'published'): ?>
                                            <span class="badge bg-success">Published</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Draft</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo date('M d, Y', strtotime($page['created_at'])); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($page['updated_at'])); ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editPageModal<?php echo $page['id']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <?php if ($page['status'] === 'published'): ?>
                                                <button type="button" class="btn btn-sm btn-warning unpublish-btn" data-id="<?php echo $page['id']; ?>">
                                                    <i class="fas fa-eye-slash"></i>
                                                </button>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-sm btn-success publish-btn" data-id="<?php echo $page['id']; ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            <?php endif; ?>
                                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="<?php echo $page['id']; ?>" data-title="<?php echo htmlspecialchars($page['title']); ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit Page Modal -->
                                <div class="modal fade" id="editPageModal<?php echo $page['id']; ?>" tabindex="-1" aria-labelledby="editPageModalLabel<?php echo $page['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editPageModalLabel<?php echo $page['id']; ?>">Edit Page</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="needs-validation">
                                                <div class="modal-body">
                                                    <input type="hidden" name="action" value="edit">
                                                    <input type="hidden" name="page_id" value="<?php echo $page['id']; ?>">

                                                    <div class="mb-3">
                                                        <label for="page_title<?php echo $page['id']; ?>" class="form-label">Page Title</label>
                                                        <input type="text" class="form-control" id="page_title<?php echo $page['id']; ?>" name="page_title" value="<?php echo htmlspecialchars($page['title']); ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="page_slug<?php echo $page['id']; ?>" class="form-label">Page Slug</label>
                                                        <input type="text" class="form-control" id="page_slug<?php echo $page['id']; ?>" name="page_slug" value="<?php echo htmlspecialchars($page['slug']); ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="page_content<?php echo $page['id']; ?>" class="form-label">Page Content</label>
                                                        <textarea class="form-control editor" id="page_content<?php echo $page['id']; ?>" name="page_content" rows="10"><?php echo htmlspecialchars($page['content']); ?></textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="meta_title<?php echo $page['id']; ?>" class="form-label">Meta Title</label>
                                                        <input type="text" class="form-control" id="meta_title<?php echo $page['id']; ?>" name="meta_title" value="<?php echo htmlspecialchars($page['meta_title']); ?>">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="meta_description<?php echo $page['id']; ?>" class="form-label">Meta Description</label>
                                                        <textarea class="form-control" id="meta_description<?php echo $page['id']; ?>" name="meta_description" rows="3"><?php echo htmlspecialchars($page['meta_description']); ?></textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="status<?php echo $page['id']; ?>" class="form-label">Status</label>
                                                        <select class="form-select" id="status<?php echo $page['id']; ?>" name="status">
                                                            <option value="published" <?php echo ($page['status'] === 'published') ? 'selected' : ''; ?>>Published</option>
                                                            <option value="draft" <?php echo ($page['status'] === 'draft') ? 'selected' : ''; ?>>Draft</option>
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

<!-- Add Page Modal -->
<div class="modal fade" id="addPageModal" tabindex="-1" aria-labelledby="addPageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPageModalLabel">Add New Page</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="needs-validation" id="addPageForm">
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">

                    <div class="mb-3">
                        <label for="page_title" class="form-label">Page Title</label>
                        <input type="text" class="form-control" id="page_title" name="page_title" required>
                    </div>

                    <div class="mb-3">
                        <label for="page_slug" class="form-label">Page Slug</label>
                        <input type="text" class="form-control" id="page_slug" name="page_slug" required>
                    </div>

                    <div class="mb-3">
                        <label for="page_content" class="form-label">Page Content</label>
                        <textarea class="form-control editor" id="page_content" name="page_content" rows="10"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control" id="meta_title" name="meta_title">
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Page</button>
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
                <h5 class="modal-title" id="importModalLabel">Import Pages</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" class="needs-validation">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="import_file" class="form-label">CSV File</label>
                        <input type="file" class="form-control" id="import_file" name="import_file" accept=".csv" required>
                        <div class="form-text">Please upload a CSV file with the following columns: title, slug, content, meta_title, meta_description, status</div>
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
    <input type="hidden" id="delete_page_id" name="page_id" value="">
</form>

<!-- Publish Form (Hidden) -->
<form id="publishForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="display: none;">
    <input type="hidden" name="action" value="publish">
    <input type="hidden" id="publish_page_id" name="page_id" value="">
</form>

<!-- Unpublish Form (Hidden) -->
<form id="unpublishForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="display: none;">
    <input type="hidden" name="action" value="unpublish">
    <input type="hidden" id="unpublish_page_id" name="page_id" value="">
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
        var table = $('#contentPagesTable').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'copy',
                    className: 'btn btn-sm btn-secondary',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn btn-sm btn-secondary',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn btn-sm btn-secondary',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-sm btn-secondary',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'print',
                    className: 'btn btn-sm btn-secondary',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                }
            ]
        });

        // Hide the default buttons and use our custom export button
        $('.dt-buttons').hide();

        $('#exportBtn').on('click', function() {
            $('.buttons-excel').click();
        });

        // Initialize TinyMCE
        tinymce.init({
            selector: '.editor',
            height: 300,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; font-size: 16px; }'
        });

        // Auto-generate slug from title
        $('#page_title').on('keyup', function() {
            var title = $(this).val();
            var slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            $('#page_slug').val(slug);
        });

        // Delete confirmation
        $('.delete-btn').on('click', function() {
            var pageId = $(this).data('id');
            var pageTitle = $(this).data('title');

            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete the page "' + pageTitle + '". This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete_page_id').val(pageId);
                    $('#deleteForm').submit();
                }
            });
        });

        // Publish confirmation
        $('.publish-btn').on('click', function() {
            var pageId = $(this).data('id');

            Swal.fire({
                title: 'Publish Page',
                text: 'Are you sure you want to publish this page?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, publish it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#publish_page_id').val(pageId);
                    $('#publishForm').submit();
                }
            });
        });

        // Unpublish confirmation
        $('.unpublish-btn').on('click', function() {
            var pageId = $(this).data('id');

            Swal.fire({
                title: 'Unpublish Page',
                text: 'Are you sure you want to unpublish this page?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, unpublish it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#unpublish_page_id').val(pageId);
                    $('#unpublishForm').submit();
                }
            });
        });

        // Form validation
        $("#addPageForm").validate({
            rules: {
                page_title: {
                    required: true,
                    minlength: 3
                },
                page_slug: {
                    required: true,
                    minlength: 3
                }
            },
            messages: {
                page_title: {
                    required: "Please enter a page title",
                    minlength: "Page title must be at least 3 characters"
                },
                page_slug: {
                    required: "Please enter a page slug",
                    minlength: "Page slug must be at least 3 characters"
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