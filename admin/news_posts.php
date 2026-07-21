<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login");
    exit;
}

require_once '../includes/config.php';
require_once '../includes/functions.php';

$page_title = "News Posts";
$active_menu = "news_posts";


// Fetch categories for dropdown
$categories = [];
$catResult = $conn->query("SELECT id, name FROM news_categories ORDER BY name ASC");
while ($row = $catResult->fetch_assoc()) {
    $categories[] = $row;
}

// Fetch News Posts
$all_posts = [];
$sql = "SELECT p.*, c.name AS category_name FROM news_posts p JOIN news_categories c ON p.category_id = c.id ORDER BY p.id DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $all_posts[] = $row;
    }
}

$active_posts = array_filter($all_posts, function($post) { return strtolower($post['status']) === 'published'; });
$inactive_posts = array_filter($all_posts, function($post) { return strtolower($post['status']) !== 'published'; });

$status_filter = isset($_GET['status']) ? strtolower($_GET['status']) : 'all';

if ($status_filter === 'published') {
    $posts = $active_posts;
} elseif ($status_filter === 'draft' || $status_filter === 'inactive') {
    $posts = $inactive_posts;
} else {
    $posts = $all_posts;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = $_POST['category_id'];
    
    $stmt = $conn->prepare("SELECT image FROM news_posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($post = $res->fetch_assoc()) {
        if (!empty($post['image']) && file_exists('../assets/uploads/news/' . $post['image'])) {
            unlink('../assets/uploads/news/' . $post['image']);
        }
    }
    
    $stmt = $conn->prepare("DELETE FROM news_posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: " . $_SERVER['PHP_SELF'] . "?msg=deleted");
    exit;
}

if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') {
    $message = "News post deleted successfully.";
    $messageType = "success";
}
?>

<?php include 'includes/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">News Posts</h1>
                <a href="<?= BASE_URL; ?>admin/news_add_post.php" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> Add Post
                </a>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert alert-<?= $messageType ?> alert-dismissible fade show" role="alert">
                    <?= $message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Newss details -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Newss</h5>
                            <p class="card-text h2"><?php echo count($all_posts); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Active Newss</h5>
                            <p class="card-text h2"><?php echo count($active_posts); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Inactive Newss</h5>
                            <p class="card-text h2"><?php echo count($inactive_posts); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Categories</h5>
                            <p class="card-text h2"><?php echo count($categories); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link <?= $status_filter == 'all' ? 'active' : '' ?>" href="?status=all">
                        All <span class="badge bg-<?= $status_filter == 'all' ? 'primary' : 'secondary' ?> rounded-pill ms-1"><?= count($all_posts) ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $status_filter == 'published' ? 'active' : '' ?>" href="?status=published">
                        Published <span class="badge bg-<?= $status_filter == 'published' ? 'success' : 'secondary' ?> rounded-pill ms-1"><?= count($active_posts) ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($status_filter == 'draft' || $status_filter == 'inactive') ? 'active' : '' ?>" href="?status=draft">
                        Draft / Inactive <span class="badge bg-<?= ($status_filter == 'draft' || $status_filter == 'inactive') ? 'warning text-dark' : 'secondary' ?> rounded-pill ms-1"><?= count($inactive_posts) ?></span>
                    </a>
                </li>
            </ul>

            <div class="card shadow-sm">
                <div class="card-body">
                    <table id="postsTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($posts as $post): ?>
                                <tr>
                                    <td><?= $post['id'] ?></td>
                                    <td><?= htmlspecialchars($post['title']) ?></td>
                                    <td><?= htmlspecialchars($post['slug']) ?></td>
                                    <td><?= htmlspecialchars($post['category_name']) ?></td>
                                    <td>
                                        <?php if(strtolower($post['status']) === 'published'): ?>
                                            <span class="badge bg-success">Published</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?= ucfirst(htmlspecialchars($post['status'])) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= BASE_URL ?>admin/news_edit_post.php?id=<?= $post['id'] ?>"
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


<?php include 'includes/footer.php'; ?>



<!-- Delete Confirmation Form (Hidden) -->
<form id="deleteForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
    style="display: none;">
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
    $(document).ready(function () {
        // === Datatable Initialization ===
        const table = $('#postsTable').DataTable({
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


        // === Delete Confirmation with SweetAlert2 ===
        $(document).on('click', '.delete-btn', function () {
            const categoryId = $(this).data('id');
            const categoryName = $(this).data('title');
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

    });
</script>