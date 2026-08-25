<?php
/**
 * Dynamic Landing Page Form Builder (Simplified Edition)
 * MOSIL Lubricants - Landing Page CMS
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

$page_title = "Landing Page Builder";
$active_menu = "landings";

$landings_dir = '../data/landings/';
$uploads_dir = '../assets/uploads/landings/';

if (!is_dir($landings_dir)) {
    mkdir($landings_dir, 0777, true);
}
if (!is_dir($uploads_dir)) {
    mkdir($uploads_dir, 0777, true);
}

// Default Simplified Data Structure
$data = [
    'id' => '',
    'seo' => [
        'title' => '',
        'description' => '',
        'noindex' => true
    ],
    'banner' => [
        'headline' => '',
        'sub_headline' => '',
        'cta_text' => 'Get in Touch',
        'image' => '',
        'image_position' => 'right',
        'image_alt' => ''
    ],
    'form' => [
        'heading' => 'Contact Us Today',
        'sub_heading' => 'Fill out the form below to receive a response.',
        'email_to' => '',
        'success_message' => 'Thank you! We will get back to you shortly.'
    ],
    // Legacy support
    'hero' => [
        'headline' => '',
        'sub_headline' => '',
        'cta_text' => 'Get in Touch',
        'image' => '',
        'image_position' => 'right',
        'image_alt' => ''
    ]
];

$filename = isset($_GET['file']) ? basename($_GET['file']) : '';
$is_edit = false;

if ($filename && file_exists($landings_dir . $filename)) {
    $is_edit = true;
    $page_title = "Edit Landing Page";
    $json_content = @file_get_contents($landings_dir . $filename);
    $saved_data = json_decode($json_content, true);
    if (is_array($saved_data)) {
        // Merge structures
        $data = array_replace_recursive($data, $saved_data);
        
        // Handle legacy Hero -> Banner fallback
        if (empty($saved_data['banner']) && !empty($saved_data['hero'])) {
            $data['banner'] = [
                'headline' => $saved_data['hero']['headline'] ?? '',
                'sub_headline' => $saved_data['hero']['sub_headline'] ?? '',
                'cta_text' => $saved_data['hero']['cta_text'] ?? 'Get in Touch',
                'image' => $saved_data['hero']['image'] ?? '',
                'image_position' => $saved_data['hero']['image_position'] ?? 'right',
                'image_alt' => $saved_data['hero']['image_alt'] ?? ''
            ];
        }
        
        // Handle legacy form intro -> sub_heading
        if (empty($saved_data['form']['sub_heading']) && !empty($saved_data['form']['intro'])) {
            $data['form']['sub_heading'] = $saved_data['form']['intro'];
        }
    }
} else {
    $page_title = "Create Landing Page";
}

// Image upload processing helper
function processImageUpload($fileKey, $removeFlag, $existingPath)
{
    $targetDir = '../assets/uploads/landings/';

    // Check if user requested removal
    if (!empty($removeFlag)) {
        if (!empty($existingPath) && file_exists('../' . $existingPath)) {
            @unlink('../' . $existingPath);
        }
        return '';
    }

    // Check if new file was uploaded
    if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES[$fileKey]['tmp_name'];
        $originalName = $_FILES[$fileKey]['name'];
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

        if (in_array($ext, $allowed)) {
            $newFileName = 'banner_' . uniqid() . '.' . $ext;
            $destination = $targetDir . $newFileName;

            if (move_uploaded_file($tmpName, $destination)) {
                // Remove old image if replaced
                if (!empty($existingPath) && file_exists('../' . $existingPath)) {
                    @unlink('../' . $existingPath);
                }
                return 'assets/uploads/landings/' . $newFileName;
            }
        }
    }

    return $existingPath;
}

$message = '';
$messageType = 'success';

// Form Submit Handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slug = trim($_POST['slug'] ?? '');
    $slug = strtolower(preg_replace('/[^a-zA-Z0-9-]/', '-', $slug));
    $slug = trim($slug, '-');
    
    if (empty($slug)) {
        $message = "URL slug is required.";
        $messageType = "danger";
    } else {
        // Process Banner Image
        $banner_image = processImageUpload('banner_image', $_POST['remove_banner_image'] ?? 0, $data['banner']['image'] ?? '');

        // Preserve other sections from existing data if editing
        $save_data = $data;
        
        $save_data['id'] = $slug;
        $save_data['seo'] = [
            'title' => trim($_POST['seo_title'] ?? ''),
            'description' => trim($_POST['seo_desc'] ?? ''),
            'noindex' => isset($_POST['seo_noindex']) ? true : false
        ];
        $save_data['banner'] = [
            'headline' => trim($_POST['banner_headline'] ?? ''),
            'sub_headline' => trim($_POST['banner_sub_headline'] ?? ''),
            'cta_text' => trim($_POST['banner_cta'] ?? 'Get in Touch'),
            'image' => $banner_image,
            'image_position' => $_POST['banner_image_position'] ?? 'right',
            'image_alt' => trim($_POST['banner_image_alt'] ?? '')
        ];

        
        // Map back to legacy hero structure for backward compatibility
        $save_data['hero'] = [
            'headline' => $save_data['banner']['headline'],
            'sub_headline' => $save_data['banner']['sub_headline'],
            'cta_text' => $save_data['banner']['cta_text'],
            'image' => $save_data['banner']['image'],
            'image_position' => $save_data['banner']['image_position'],
            'image_alt' => $save_data['banner']['image_alt']
        ];

        $target_file = $landings_dir . $slug . '.json';
        
        // Remove old file if slug was renamed during edit
        if ($is_edit && $filename !== $slug . '.json' && file_exists($landings_dir . $filename)) {
            @unlink($landings_dir . $filename);
        }

        if (file_put_contents($target_file, json_encode($save_data, JSON_PRETTY_PRINT))) {
            $message = "Landing page saved successfully!";
            $messageType = "success";
            $data = $save_data;
            $filename = $slug . '.json';
            $is_edit = true;
        } else {
            $message = "Failed to save landing page file.";
            $messageType = "danger";
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
                    <a href="landings.php" class="btn btn-outline-secondary btn-sm mb-2">
                        <i class="fas fa-arrow-left me-1"></i> Back to Landing Pages
                    </a>
                    <h1 class="h2 text-dark">
                        <i class="fas fa-edit text-primary me-2"></i>
                        <?php echo $is_edit ? 'Edit Landing Page: /' . htmlspecialchars($data['id']) : 'Create New Landing Page'; ?>
                    </h1>
                </div>
                <?php if ($is_edit && !empty($data['id'])): ?>
                    <a href="../<?php echo htmlspecialchars($data['id']); ?>" target="_blank" class="btn btn-outline-primary shadow-sm font-weight-bold">
                        <i class="fas fa-external-link-alt me-1"></i> View Live Page
                    </a>
                <?php endif; ?>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo htmlspecialchars($messageType); ?> alert-dismissible fade show shadow-sm" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data">
                
                <!-- CARD 1: URL & SEO Settings -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="card-title mb-0 text-dark font-weight-bold">
                            <i class="fas fa-link text-primary me-2"></i>1. URL Slug & SEO Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold small text-secondary">URL Slug <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">/</span>
                                    <input type="text" name="slug" id="slugInput" value="<?php echo htmlspecialchars($data['id']); ?>" class="form-control font-monospace" required placeholder="example-campaign-slug">
                                </div>
                                <small class="text-muted">Must be alphanumeric characters or hyphens only. e.g. <code>cost-per-component</code></small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold small text-secondary">SEO Page Title</label>
                                <input type="text" name="seo_title" value="<?php echo htmlspecialchars($data['seo']['title'] ?? ''); ?>" class="form-control" placeholder="Browser tab title & search engine result header">
                            </div>
                            <div class="col-12">
                                <label class="form-label font-weight-bold small text-secondary">SEO Meta Description</label>
                                <textarea name="seo_desc" rows="2" class="form-control" placeholder="Brief snippet summarizing the page content for search engines..."><?php echo htmlspecialchars($data['seo']['description'] ?? ''); ?></textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="seo_noindex" id="seoNoIndex" value="1" <?php echo !empty($data['seo']['noindex']) ? 'checked' : ''; ?>>
                                    <label class="form-check-label font-weight-bold text-dark" for="seoNoIndex">
                                        Hide page from search engines & indexers (set <code>noindex, nofollow</code>)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: BANNER SETTINGS -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="card-title mb-0 text-dark font-weight-bold">
                            <i class="fas fa-image text-primary me-2"></i>2. Hero Banner Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold small text-secondary">Main Title / Headline (H1)</label>
                            <textarea name="banner_headline" rows="2" class="form-control font-weight-bold" required placeholder="e.g. Specialty Greases Formulated to Match OEM Specifications"><?php echo htmlspecialchars($data['banner']['headline'] ?? ''); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold small text-secondary">Sub-headline / Paragraph Text</label>
                            <textarea name="banner_sub_headline" rows="3" class="form-control" placeholder="Supporting text, value propositions or brief instructions..."><?php echo htmlspecialchars($data['banner']['sub_headline'] ?? ''); ?></textarea>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold small text-secondary">CTA Button Text (Scrolls to Form)</label>
                                <input type="text" name="banner_cta" value="<?php echo htmlspecialchars($data['banner']['cta_text'] ?? 'Get in Touch'); ?>" class="form-control">
                            </div>
                        </div>

                        <!-- Image Upload block -->
                        <div class="p-3 bg-light rounded border">
                            <h6 class="text-primary font-weight-bold mb-2"><i class="fas fa-upload me-1"></i> Banner Image (Optional)</h6>
                            <div class="row g-3 align-items-center">
                                <div class="col-md-5">
                                    <label class="form-label small text-muted">Upload Image File</label>
                                    <input type="file" name="banner_image" accept="image/*" class="form-control form-control-sm">
                                    <?php if (!empty($data['banner']['image'])): ?>
                                        <div class="mt-2 d-flex align-items-center gap-2">
                                            <img src="../<?php echo htmlspecialchars($data['banner']['image']); ?>" class="rounded border bg-white" style="max-height: 45px; max-width: 75px; object-fit: cover;">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="remove_banner_image" value="1" id="remBannerImg">
                                                <label class="form-check-label text-danger small" for="remBannerImg">Remove Image</label>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small text-muted">Image Placement / Layout Style</label>
                                    <select name="banner_image_position" class="form-select form-select-sm">
                                        <option value="right" <?php echo ($data['banner']['image_position'] ?? '') === 'right' ? 'selected' : ''; ?>>Right Side Panel</option>
                                        <option value="left" <?php echo ($data['banner']['image_position'] ?? '') === 'left' ? 'selected' : ''; ?>>Left Side Panel</option>
                                        <option value="background" <?php echo ($data['banner']['image_position'] ?? '') === 'background' ? 'selected' : ''; ?>>Full Page Background</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-muted">Image Alternate Text (SEO Alt)</label>
                                    <input type="text" name="banner_image_alt" value="<?php echo htmlspecialchars($data['banner']['image_alt'] ?? ''); ?>" class="form-control form-control-sm" placeholder="e.g. Industrial machinery grease application">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Submission Actions -->
                <div class="d-flex align-items-center gap-3 mb-5">
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm font-weight-bold px-4">
                        <i class="fas fa-save me-2"></i>Save Landing Page
                    </button>
                    <a href="landings.php" class="btn btn-outline-secondary btn-lg px-4">Cancel</a>
                </div>

            </form>

        </main>
    </div>
</div>

<script>
// Prevent space and special chars in slug
document.getElementById('slugInput').addEventListener('input', function(e) {
    let cursorPosition = this.selectionStart;
    let originalLength = this.value.length;
    let cleanVal = this.value.toLowerCase().replace(/[^a-z0-9-]/g, '-').replace(/-+/g, '-');
    
    // Avoid leading/trailing hyphens as user types
    this.value = cleanVal;
    
    // Keep cursor in place
    let offset = this.value.length - originalLength;
    this.setSelectionRange(cursorPosition + offset, cursorPosition + offset);
});
</script>

<?php include 'includes/footer.php'; ?>
