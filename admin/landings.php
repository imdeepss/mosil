<?php
/**
 * Admin Panel - Landing Pages Manager (Polished & Dynamic)
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
                    'title' => $data['seo']['title'] ?? ($data['banner']['headline'] ?? ($data['hero']['headline'] ?? 'Untitled Landing Page')),
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
                    <p class="text-muted small mb-0">Manage simple, high-converting banner and contact form landing pages.</p>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="landing_form.php" class="btn btn-primary shadow-sm font-weight-bold">
                        <i class="fas fa-plus me-1"></i> Create New Landing Page
                    </a>
                </div>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo htmlspecialchars($messageType); ?> alert-dismissible fade show shadow-sm" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Landing Pages List Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="card-title mb-0 font-weight-bold text-dark">
                        <i class="fas fa-list me-2 text-primary"></i>All Landing Pages (<?php echo count($landings); ?>)
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table id="landingsTable" class="table table-hover align-middle mb-0 w-100">
                            <thead class="table-light text-uppercase small text-muted">
                                <tr>
                                    <th>URL Slug</th>
                                    <th>Page Title / Headline</th>
                                    <th>Indexing Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($landings) > 0): ?>
                                    <?php foreach ($landings as $landing): ?>
                                        <tr>
                                            <td class="align-middle">
                                                <a href="../<?php echo htmlspecialchars($landing['slug']); ?>" target="_blank" class="font-monospace text-primary font-weight-bold hover-underline text-decoration-none">
                                                    /<?php echo htmlspecialchars($landing['slug']); ?>
                                                </a>
                                            </td>
                                            <td class="align-middle text-dark font-weight-bold">
                                                <?php echo htmlspecialchars($landing['title']); ?>
                                            </td>
                                            <td class="align-middle">
                                                <?php if ($landing['noindex']): ?>
                                                    <span class="badge bg-warning text-dark px-2.5 py-1.5">
                                                        <i class="fas fa-eye-slash me-1"></i> Unlinked (noindex)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-success text-white px-2.5 py-1.5">
                                                        <i class="fas fa-globe me-1"></i> Public (Indexed)
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="align-middle text-end">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="../<?php echo htmlspecialchars($landing['slug']); ?>" target="_blank" class="btn btn-outline-secondary" title="View Live Page">
                                                        <i class="fas fa-external-link-alt"></i> Live
                                                    </a>
                                                    <button type="button" class="btn btn-outline-secondary" onclick="copyLandingUrl('<?php echo htmlspecialchars($landing['slug']); ?>')" title="Copy URL">
                                                        <i class="fas fa-copy"></i> Link
                                                    </button>
                                                    <a href="landing_form.php?file=<?php echo urlencode($landing['filename']); ?>" class="btn btn-outline-primary" title="Edit Page">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <button type="button" onclick="confirmDelete('<?php echo urlencode($landing['filename']); ?>', '<?php echo htmlspecialchars(addslashes($landing['slug'])); ?>')" class="btn btn-outline-danger" title="Delete Page">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
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
$(document).ready(function() {
    $('#landingsTable').DataTable({
        "order": [[ 0, "asc" ]],
        "pageLength": 10,
        "responsive": true,
        "language": {
            "emptyTable": "No landing pages found. Click 'Create New Landing Page' to create one."
        }
    });
});

function copyLandingUrl(slug) {
    const url = window.location.origin + window.location.pathname.replace('admin/landings.php', '') + slug;
    navigator.clipboard.writeText(url).then(() => {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Link Copied',
                text: url,
                timer: 1500,
                showConfirmButton: false
            });
        } else {
            alert('URL copied to clipboard: ' + url);
        }
    });
}

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
