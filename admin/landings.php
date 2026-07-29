<?php
/**
 * Admin Panel - Landing Pages Manager
 */
session_start();
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Check Admin Auth
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$page_title = "Landing Pages";
$active_menu = "landings";

$landings_dir = '../data/landings/';
$message = '';
$messageType = 'success';

// Handle Delete Request
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['file'])) {
    $file_to_delete = basename($_GET['file']);
    $file_path = $landings_dir . $file_to_delete;
    
    if (file_exists($file_path)) {
        if (unlink($file_path)) {
            $message = "Landing page '{$file_to_delete}' deleted successfully.";
            $messageType = "success";
        } else {
            $message = "Failed to delete landing page file.";
            $messageType = "danger";
        }
    } else {
        $message = "Landing page file not found.";
        $messageType = "warning";
    }
}

// Fetch all landing page JSON files
$landings = [];
if (is_dir($landings_dir)) {
    $files = scandir($landings_dir);
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'json') {
            $json_content = @file_get_contents($landings_dir . $file);
            $data = json_decode($json_content, true);
            if ($data) {
                $landings[] = [
                    'filename' => $file,
                    'slug' => $data['id'] ?? pathinfo($file, PATHINFO_FILENAME),
                    'title' => $data['seo']['title'] ?? ($data['hero']['headline'] ?? 'Untitled Landing Page'),
                    'noindex' => !empty($data['seo']['noindex'])
                ];
            }
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
                <div>
                    <h1 class="h2 text-dark"><i class="fas fa-bullhorn text-primary me-2"></i>Landing Pages</h1>
                    <p class="text-muted small mb-0">Manage dynamic landing page copy, images, and diagnostic templates.</p>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="landing_form.php" class="btn btn-primary shadow-sm font-weight-bold">
                        <i class="fas fa-plus me-1"></i> Create New Landing Page
                    </a>
                </div>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo htmlspecialchars($messageType); ?> alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Landing Pages List Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 font-weight-bold text-dark">
                        <i class="fas fa-list me-2 text-primary"></i>All Landing Pages (<?php echo count($landings); ?>)
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="landingsTable" class="table table-hover align-middle mb-0">
                            <thead class="table-light text-uppercase small text-muted">
                                <tr>
                                    <th class="px-4 py-3">URL Slug</th>
                                    <th class="px-4 py-3">Page Title / Headline</th>
                                    <th class="px-4 py-3">Indexing Status</th>
                                    <th class="px-4 py-3 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($landings) > 0): ?>
                                    <?php foreach ($landings as $landing): ?>
                                        <tr>
                                            <td class="px-4 py-3 font-monospace text-primary font-weight-bold">
                                                /<?php echo htmlspecialchars($landing['slug']); ?>
                                            </td>
                                            <td class="px-4 py-3 text-dark font-weight-bold">
                                                <?php echo htmlspecialchars($landing['title']); ?>
                                            </td>
                                            <td class="px-4 py-3">
                                                <?php if ($landing['noindex']): ?>
                                                    <span class="badge bg-warning text-dark px-2.5 py-1">
                                                        <i class="fas fa-eye-slash me-1"></i> Unlinked (noindex)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-success text-white px-2.5 py-1">
                                                        <i class="fas fa-globe me-1"></i> Public (Indexed)
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-4 py-3 text-end">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="../<?php echo htmlspecialchars($landing['slug']); ?>" target="_blank" class="btn btn-outline-secondary" title="View Live Page">
                                                        <i class="fas fa-external-link-alt me-1"></i> Live
                                                    </a>
                                                    <a href="landing_form.php?file=<?php echo urlencode($landing['filename']); ?>" class="btn btn-outline-primary" title="Edit Page">
                                                        <i class="fas fa-edit me-1"></i> Edit
                                                    </a>
                                                    <button type="button" onclick="confirmDelete('<?php echo urlencode($landing['filename']); ?>', '<?php echo htmlspecialchars(addslashes($landing['slug'])); ?>')" class="btn btn-outline-danger" title="Delete Page">
                                                        <i class="fas fa-trash-alt me-1"></i> Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="fas fa-folder-open fa-3x mb-3 d-block text-secondary opacity-50"></i>
                                            No landing pages found. Click <strong>"Create New Landing Page"</strong> above to create one.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<script>
function confirmDelete(filename, slug) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Delete Landing Page?',
            text: 'Are you sure you want to delete /' + slug + '? This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Delete It!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'landings.php?action=delete&file=' + filename;
            }
        });
    } else {
        if (confirm('Are you sure you want to delete /' + slug + '?')) {
            window.location.href = 'landings.php?action=delete&file=' + filename;
        }
    }
}
</script>

<?php include 'includes/footer.php'; ?>
