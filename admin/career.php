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
$page_title = "Careers";
$active_menu = "careers";

// SQL query to fetch data from career table
$sql = "SELECT * FROM career";
$result = $conn->query($sql);

// Create an array to hold careers
$careers = [];

if ($result->num_rows > 0) {
    // Fetch each row as an associative array
    while ($row = $result->fetch_assoc()) {
        $careers[] = [
            'id' => (int)$row['id'],
            'position' => $row['position'],
            'status' => $row['status'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
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
        $careerId = isset($_POST['career_id']) ? (int)$_POST['career_id'] : 0;
        $position = sanitizeInput($_POST['position'] ?? '');
        $status = sanitizeInput($_POST['status'] ?? '');

        if ($action === 'add' || $action === 'edit') {
            // Validate form data
            if (empty($position) || empty($status)) {
                $message = "Please fill in all required fields.";
                $messageType = "danger";
            } else {
                if ($action === 'add') {
                    // Insert new career
                    $stmt = $conn->prepare("INSERT INTO career (position, status) VALUES (?, ?)");
                    $stmt->bind_param("ss", $position, $status);
                    $stmt->execute();
                    $message = "Career added successfully.";
                    $messageType = "success";
                } else {
                    // Update existing career
                    $stmt = $conn->prepare("UPDATE career SET position = ?, status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
                    $stmt->bind_param("ssi", $position, $status, $careerId);
                    $stmt->execute();
                    $message = "Career updated successfully.";
                    $messageType = "success";
                }
            }
        } elseif ($action === 'delete') {
            // Delete career
            $stmt = $conn->prepare("DELETE FROM career WHERE id = ?");
            $stmt->bind_param("i", $careerId);
            $stmt->execute();
            $message = "Career deleted successfully.";
            $messageType = "success";
        } elseif ($action === 'publish' || $action === 'unpublish') {
            $newStatus = ($action === 'publish') ? 'Active' : 'Inactive';
            $stmt = $conn->prepare("UPDATE career SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $stmt->bind_param("si", $newStatus, $careerId);
            $stmt->execute();
            $message = ($action === 'publish') ? "Career published successfully." : "Career unpublished successfully.";
            $messageType = "success";
        }

        // Close statement and connection
        if (isset($stmt)) {
            $stmt->close();
        }
        $conn->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Careers</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="exportBtn">
                            <i class="fas fa-download me-1"></i> Export
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="fas fa-upload me-1"></i> Import
                        </button>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addCareerModal">
                        <i class="fas fa-plus me-1"></i> Add New Career
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

            <!-- Careers Overview Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Careers</h5>
                            <p class="card-text h2"><?php echo count($careers); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Active Careers</h5>
                            <p class="card-text h2"><?php echo count(array_filter($careers, function ($career) {
                                return $career['status'] === 'Active';
                            })); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Inactive Careers</h5>
                            <p class="card-text h2"><?php echo count(array_filter($careers, function ($career) {
                                return $career['status'] === 'Inactive';
                            })); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Careers Table -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <table id="careersTable" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($careers as $career): ?>
                                <tr>
                                    <td><?php echo $career['id']; ?></td>
                                    <td><?php echo htmlspecialchars($career['position']); ?></td>
                                    <td>
                                        <?php if ($career['status'] === 'Active'): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editCareerModal<?php echo $career['id']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <?php if ($career['status'] === 'Active'): ?>
                                                <button type="button" class="btn btn-sm btn-warning unpublish-btn"
                                                        data-id="<?php echo $career['id']; ?>">
                                                    <i class="fas fa-eye-slash"></i>
                                                </button>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-sm btn-success publish-btn"
                                                        data-id="<?php echo $career['id']; ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            <?php endif; ?>
                                            <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                    data-id="<?php echo $career['id']; ?>"
                                                    data-name="<?php echo htmlspecialchars($career['position']); ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit Career Modal -->
                                <div class="modal fade" id="editCareerModal<?php echo $career['id']; ?>" tabindex="-1"
                                     aria-labelledby="editCareerModalLabel<?php echo $career['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editCareerModalLabel<?php echo $career['id']; ?>">Edit Career</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                                  class="needs-validation" novalidate>
                                                <div class="modal-body">
                                                    <input type="hidden" name="action" value="edit">
                                                    <input type="hidden" name="career_id" value="<?php echo $career['id']; ?>">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="position<?php echo $career['id']; ?>" class="form-label">Position</label>
                                                            <input type="text" class="form-control" id="position<?php echo $career['id']; ?>"
                                                                   name="position" value="<?php echo htmlspecialchars($career['position']); ?>" required>
                                                            <div class="invalid-feedback">Please enter a position.</div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="status<?php echo $career['id']; ?>" class="form-label">Status</label>
                                                            <select class="form-select" id="status<?php echo $career['id']; ?>" name="status" required>
                                                                <option value="Active" <?php echo ($career['status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                                                                <option value="Inactive" <?php echo ($career['status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                                                            </select>
                                                            <div class="invalid-feedback">Please select a status.</div>
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

<!-- Add Career Modal -->
<div class="modal fade" id="addCareerModal" tabindex="-1" aria-labelledby="addCareerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCareerModalLabel">Add New Career</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="needs-validation" id="addCareerForm" novalidate>
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="position" class="form-label">Position</label>
                            <input type="text" class="form-control" id="position" name="position" required>
                            <div class="invalid-feedback">Please enter a position.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">-- Select Status --</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            <div class="invalid-feedback">Please select a status.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Career</button>
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
                <h5 class="modal-title" id="importModalLabel">Import Careers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="import_file" class="form-label">CSV File</label>
                        <input type="file" class="form-control" id="import_file" name="import_file" accept=".csv" required>
                        <div class="form-text">Please upload a CSV file with the following columns: position, status</div>
                        <div class="invalid-feedback">Please upload a CSV file.</div>
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
    <input type="hidden" id="delete_career_id" name="career_id" value="">
</form>

<!-- Publish Form (Hidden) -->
<form id="publishForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="display: none;">
    <input type="hidden" name="action" value="publish">
    <input type="hidden" id="publish_career_id" name="career_id" value="">
</form>

<!-- Unpublish Form (Hidden) -->
<form id="unpublishForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="display: none;">
    <input type="hidden" name="action" value="unpublish">
    <input type="hidden" id="unpublish_career_id" name="career_id" value="">
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
    var table = $('#careersTable').DataTable({
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

    // Delete confirmation
    $(document).on('click', '.delete-btn', function() {
        var careerId = $(this).data('id');
        var careerName = $(this).data('name');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete the career "' + careerName + '". This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#delete_career_id').val(careerId);
                $('#deleteForm').submit();
            }
        });
    });

    // Publish confirmation
    $(document).on('click', '.publish-btn', function() {
        var careerId = $(this).data('id');
        Swal.fire({
            title: 'Activate Career',
            text: 'Are you sure you want to activate this career?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, activate it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#publish_career_id').val(careerId);
                $('#publishForm').submit();
            }
        });
    });

    // Unpublish confirmation
    $(document).on('click', '.unpublish-btn', function() {
        var careerId = $(this).data('id');
        Swal.fire({
            title: 'Deactivate Career',
            text: 'Are you sure you want to deactivate this career?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, deactivate it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#unpublish_career_id').val(careerId);
                $('#unpublishForm').submit();
            }
        });
    });

    // Form validation for both add and edit forms
    $('.needs-validation').each(function() {
        $(this).validate({
            rules: {
                position: {
                    required: true,
                    minlength: 3
                },
                status: {
                    required: true
                }
            },
            messages: {
                position: {
                    required: "Please enter a position",
                    minlength: "Position must be at least 3 characters"
                },
                status: {
                    required: "Please select a status"
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
                error.insertAfter(element);
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
});
</script>