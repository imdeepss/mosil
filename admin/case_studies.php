<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login");
    exit;
}

require_once '../includes/config.php';
require_once '../includes/functions.php';

$page_title = "Case Studies";
$active_menu = "case_studies";

$case_studies = []; // Renamed from $categories to $case_studies for clarity

$result = $conn->query("SELECT id, title, introduction FROM case_studies ORDER BY title ASC");
while ($row = $result->fetch_assoc()) {
    $case_studies[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = $_POST['category_id'];
    
    // Fetch image and file
    $stmt = $conn->prepare("SELECT image, case_study_file FROM case_studies WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($post = $res->fetch_assoc()) {
        if (!empty($post['image']) && file_exists('../assets/uploads/case_studies/' . $post['image'])) {
            unlink('../assets/uploads/case_studies/' . $post['image']);
        }
        if (!empty($post['case_study_file']) && file_exists('../assets/uploads/case_studies/' . $post['case_study_file'])) {
            unlink('../assets/uploads/case_studies/' . $post['case_study_file']);
        }
    }
    
    $stmt = $conn->prepare("DELETE FROM case_studies WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: " . $_SERVER['PHP_SELF'] . "?msg=deleted");
    exit;
}

if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') {
    $message = "Case study deleted successfully.";
    $messageType = "success";
}
?>

<?php include 'includes/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Case Studies</h1>
                <a href="<?= BASE_URL ?>admin/case_studies_add.php" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> Add Case Study
                </a>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert alert-<?= htmlspecialchars($messageType) ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Case Study Table -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <table id="postsTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Title</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($case_studies as $post): ?>
                                <tr>
                                    <td><?= $post['id'] ?></td>
                                    <td><?= htmlspecialchars($post['title']) ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= BASE_URL ?>admin/case_studies_edit.php?id=<?= $post['id'] ?>"
                                                class="btn btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-danger delete-btn" data-id="<?= $post['id'] ?>"
                                                data-title="<?= htmlspecialchars($post['title']) ?>">
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

<!-- Delete Form -->
<form id="deleteForm" method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" style="display: none;">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" id="delete_category_id" name="category_id" value="">
</form>

<?php include 'includes/footer.php'; ?>

<!-- Include DataTables and SweetAlert -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        // Initialize DataTables
        $('#postsTable').DataTable({
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

        // SweetAlert2 for delete
        $(document).on('click', '.delete-btn', function () {
            const categoryId = $(this).data('id');
            const title = $(this).data('title');
            $('#delete_category_id').val(categoryId);
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete the case study "${title}". This action cannot be undone!`,
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
        $('.dt-buttons').hide();
    });
</script>