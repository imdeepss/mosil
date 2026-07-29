<?php
/**
 * Dynamic Landing Page Form Builder
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

// Default Data Structure
$data = [
    'id' => '',
    'seo' => ['title' => '', 'description' => '', 'noindex' => true],
    'hero' => [
        'headline' => '',
        'sub_headline' => '',
        'cta_text' => 'Start the CPC Check — 5 minutes',
        'micro_line' => '',
        'image' => '',
        'image_position' => 'right',
        'image_alt' => ''
    ],
    'levers' => ['intro_1' => '', 'formula' => '', 'intro_2' => '', 'items' => [], 'closing' => ''],
    'trust' => [
        'heading' => '',
        'body_1' => '',
        'body_2' => '',
        'sub_line' => '',
        'image' => '',
        'image_position' => 'right',
        'image_alt' => ''
    ],
    'form' => ['heading' => '', 'intro' => '', 'confidentiality' => ''],
    'approach' => ['intro' => '', 'stages' => []],
    'proof' => [
        'heading' => '',
        'body_1' => '',
        'body_2' => '',
        'badges' => [],
        'image' => '',
        'image_position' => 'right',
        'image_alt' => ''
    ],
    'process' => ['heading' => '', 'steps' => []],
    'faq' => []
];

$filename = isset($_GET['file']) ? basename($_GET['file']) : '';
$is_edit = false;

if ($filename && file_exists($landings_dir . $filename)) {
    $is_edit = true;
    $page_title = "Edit Landing Page";
    $json_content = @file_get_contents($landings_dir . $filename);
    $saved_data = json_decode($json_content, true);
    if (is_array($saved_data)) {
        $data = array_replace_recursive($data, $saved_data);
        if (isset($saved_data['levers']['items'])) $data['levers']['items'] = $saved_data['levers']['items'];
        if (isset($saved_data['approach']['stages'])) $data['approach']['stages'] = $saved_data['approach']['stages'];
        if (isset($saved_data['proof']['badges'])) $data['proof']['badges'] = $saved_data['proof']['badges'];
        if (isset($saved_data['process']['steps'])) $data['process']['steps'] = $saved_data['process']['steps'];
        if (isset($saved_data['faq'])) $data['faq'] = $saved_data['faq'];
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
            $newFileName = 'cpc_' . uniqid() . '.' . $ext;
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
        // Process Images
        $hero_image = processImageUpload('hero_image', $_POST['remove_hero_image'] ?? 0, $data['hero']['image'] ?? '');
        $trust_image = processImageUpload('trust_image', $_POST['remove_trust_image'] ?? 0, $data['trust']['image'] ?? '');
        $proof_image = processImageUpload('proof_image', $_POST['remove_proof_image'] ?? 0, $data['proof']['image'] ?? '');

        // Process Repeaters
        $levers = [];
        if (isset($_POST['lever_title']) && is_array($_POST['lever_title'])) {
            foreach ($_POST['lever_title'] as $i => $t) {
                if (!empty(trim($t)) || !empty(trim($_POST['lever_desc'][$i] ?? ''))) {
                    $levers[] = [
                        'title' => trim($t),
                        'description' => trim($_POST['lever_desc'][$i] ?? '')
                    ];
                }
            }
        }

        $stages = [];
        if (isset($_POST['stage_title']) && is_array($_POST['stage_title'])) {
            $stage_count = 1;
            foreach ($_POST['stage_title'] as $i => $t) {
                if (!empty(trim($t)) || !empty(trim($_POST['stage_desc'][$i] ?? ''))) {
                    $stages[] = [
                        'number' => $stage_count++,
                        'title' => trim($t),
                        'description' => trim($_POST['stage_desc'][$i] ?? '')
                    ];
                }
            }
        }

        $badges = [];
        if (isset($_POST['badges']) && is_array($_POST['badges'])) {
            foreach ($_POST['badges'] as $b) {
                if (!empty(trim($b))) {
                    $badges[] = trim($b);
                }
            }
        }

        $steps = [];
        if (isset($_POST['step_desc']) && is_array($_POST['step_desc'])) {
            foreach ($_POST['step_desc'] as $s) {
                if (!empty(trim($s))) {
                    $steps[] = ['description' => trim($s)];
                }
            }
        }

        $faqs = [];
        if (isset($_POST['faq_q']) && is_array($_POST['faq_q'])) {
            foreach ($_POST['faq_q'] as $i => $q) {
                if (!empty(trim($q)) || !empty(trim($_POST['faq_a'][$i] ?? ''))) {
                    $faqs[] = [
                        'q' => trim($q),
                        'a' => trim($_POST['faq_a'][$i] ?? '')
                    ];
                }
            }
        }

        $save_data = [
            'id' => $slug,
            'seo' => [
                'title' => trim($_POST['seo_title'] ?? ''),
                'description' => trim($_POST['seo_desc'] ?? ''),
                'noindex' => isset($_POST['seo_noindex']) ? true : false
            ],
            'hero' => [
                'headline' => trim($_POST['hero_headline'] ?? ''),
                'sub_headline' => trim($_POST['hero_sub_headline'] ?? ''),
                'cta_text' => trim($_POST['hero_cta'] ?? ''),
                'micro_line' => trim($_POST['hero_micro'] ?? ''),
                'image' => $hero_image,
                'image_position' => $_POST['hero_image_position'] ?? 'right',
                'image_alt' => trim($_POST['hero_image_alt'] ?? '')
            ],
            'levers' => [
                'intro_1' => trim($_POST['lever_intro_1'] ?? ''),
                'formula' => trim($_POST['lever_formula'] ?? ''),
                'intro_2' => trim($_POST['lever_intro_2'] ?? ''),
                'items' => $levers,
                'closing' => trim($_POST['lever_closing'] ?? '')
            ],
            'trust' => [
                'heading' => trim($_POST['trust_heading'] ?? ''),
                'body_1' => trim($_POST['trust_body_1'] ?? ''),
                'body_2' => trim($_POST['trust_body_2'] ?? ''),
                'sub_line' => trim($_POST['trust_sub'] ?? ''),
                'image' => $trust_image,
                'image_position' => $_POST['trust_image_position'] ?? 'right',
                'image_alt' => trim($_POST['trust_image_alt'] ?? '')
            ],
            'form' => [
                'heading' => trim($_POST['form_heading'] ?? ''),
                'intro' => trim($_POST['form_intro'] ?? ''),
                'confidentiality' => trim($_POST['form_conf'] ?? '')
            ],
            'approach' => [
                'intro' => trim($_POST['approach_intro'] ?? ''),
                'stages' => $stages
            ],
            'proof' => [
                'heading' => trim($_POST['proof_heading'] ?? ''),
                'body_1' => trim($_POST['proof_body_1'] ?? ''),
                'body_2' => trim($_POST['proof_body_2'] ?? ''),
                'badges' => $badges,
                'image' => $proof_image,
                'image_position' => $_POST['proof_image_position'] ?? 'right',
                'image_alt' => trim($_POST['proof_image_alt'] ?? '')
            ],
            'process' => [
                'heading' => trim($_POST['process_heading'] ?? ''),
                'steps' => $steps
            ],
            'faq' => $faqs
        ];

        $target_file = $landings_dir . $slug . '.json';
        
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
                    <a href="../<?php echo htmlspecialchars($data['id']); ?>" target="_blank" class="btn btn-outline-primary">
                        <i class="fas fa-external-link-alt me-1"></i> View Live Page
                    </a>
                <?php endif; ?>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo htmlspecialchars($messageType); ?> alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data">
                
                <!-- CARD 1: URL & SEO -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="card-title mb-0 text-dark font-weight-bold"><i class="fas fa-link text-primary me-2"></i>1. URL Slug & SEO Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold small text-secondary">URL Slug <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">/</span>
                                    <input type="text" name="slug" id="slugInput" value="<?php echo htmlspecialchars($data['id']); ?>" class="form-control font-monospace" required placeholder="cost-per-component">
                                </div>
                                <small class="text-muted">Used in URL address bar. Alphanumeric and hyphens only.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold small text-secondary">SEO Title Tag</label>
                                <input type="text" name="seo_title" value="<?php echo htmlspecialchars($data['seo']['title']); ?>" class="form-control" placeholder="Page Title for Google Search">
                            </div>
                            <div class="col-12">
                                <label class="form-label font-weight-bold small text-secondary">SEO Meta Description</label>
                                <textarea name="seo_desc" rows="2" class="form-control" placeholder="Search engine snippet description..."><?php echo htmlspecialchars($data['seo']['description']); ?></textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="seo_noindex" id="seoNoIndex" value="1" <?php echo !empty($data['seo']['noindex']) ? 'checked' : ''; ?>>
                                    <label class="form-check-label font-weight-bold text-dark" for="seoNoIndex">
                                        Unlink from main navigation & set <code>noindex, nofollow</code>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: HERO SECTION -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="card-title mb-0 text-dark font-weight-bold"><i class="fas fa-heading text-primary me-2"></i>2. Hero / Banner Section</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold small text-secondary">Headline (H1)</label>
                            <textarea name="hero_headline" rows="2" class="form-control font-weight-bold" placeholder="Main banner headline"><?php echo htmlspecialchars($data['hero']['headline']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold small text-secondary">Sub-headline</label>
                            <textarea name="hero_sub_headline" rows="2" class="form-control" placeholder="Supporting text under main headline"><?php echo htmlspecialchars($data['hero']['sub_headline']); ?></textarea>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold small text-secondary">Primary CTA Button Text</label>
                                <input type="text" name="hero_cta" value="<?php echo htmlspecialchars($data['hero']['cta_text']); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold small text-secondary">Micro-line below button</label>
                                <input type="text" name="hero_micro" value="<?php echo htmlspecialchars($data['hero']['micro_line']); ?>" class="form-control">
                            </div>
                        </div>

                        <!-- Hero Image Upload Section -->
                        <div class="p-3 bg-light rounded border">
                            <h6 class="text-primary font-weight-bold mb-2"><i class="fas fa-image me-1"></i> Hero Image Upload (Optional)</h6>
                            <div class="row g-3 align-items-center">
                                <div class="col-md-5">
                                    <label class="form-label small text-muted">Upload Image File</label>
                                    <input type="file" name="hero_image" accept="image/*" class="form-control form-control-sm">
                                    <?php if (!empty($data['hero']['image'])): ?>
                                        <div class="mt-2 d-flex align-items-center gap-2">
                                            <img src="../<?php echo htmlspecialchars($data['hero']['image']); ?>" class="rounded border" style="max-height: 45px; max-width: 75px; object-fit: cover;">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="remove_hero_image" value="1" id="remHeroImg">
                                                <label class="form-check-label text-danger small" for="remHeroImg">Remove Image</label>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small text-muted">Placement Position</label>
                                    <select name="hero_image_position" class="form-select form-select-sm">
                                        <option value="right" <?php echo ($data['hero']['image_position'] ?? '') === 'right' ? 'selected' : ''; ?>>Right Side Card</option>
                                        <option value="left" <?php echo ($data['hero']['image_position'] ?? '') === 'left' ? 'selected' : ''; ?>>Left Side Card</option>
                                        <option value="background" <?php echo ($data['hero']['image_position'] ?? '') === 'background' ? 'selected' : ''; ?>>Full Background Banner</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-muted">Image Alt Text</label>
                                    <input type="text" name="hero_image_alt" value="<?php echo htmlspecialchars($data['hero']['image_alt'] ?? ''); ?>" class="form-control form-control-sm" placeholder="Image description">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 3: COST LEVERS -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 text-dark font-weight-bold"><i class="fas fa-calculator text-primary me-2"></i>3. Cost Levers & Formula Section</h5>
                        <button type="button" onclick="addLever()" class="btn btn-sm btn-outline-primary font-weight-bold">
                            <i class="fas fa-plus me-1"></i> Add Value Lever
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold small text-secondary">Intro Line 1</label>
                            <input type="text" name="lever_intro_1" value="<?php echo htmlspecialchars($data['levers']['intro_1']); ?>" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold small text-secondary">Formula Band Equation</label>
                            <input type="text" name="lever_formula" value="<?php echo htmlspecialchars($data['levers']['formula']); ?>" class="form-control font-monospace">
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold small text-secondary">Intro Line 2</label>
                            <input type="text" name="lever_intro_2" value="<?php echo htmlspecialchars($data['levers']['intro_2']); ?>" class="form-control">
                        </div>

                        <!-- Repeatable Levers Container -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label font-weight-bold small text-primary mb-0">Value Levers List</label>
                                <span class="badge bg-secondary" id="leverCountBadge">0 items</span>
                            </div>
                            <div id="levers-container">
                                <!-- Dynamic Levers Injected via JS -->
                            </div>
                        </div>

                        <div>
                            <label class="form-label font-weight-bold small text-secondary">Section Closing Line</label>
                            <input type="text" name="lever_closing" value="<?php echo htmlspecialchars($data['levers']['closing']); ?>" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- CARD 4: TRUST BLOCK -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="card-title mb-0 text-dark font-weight-bold"><i class="fas fa-shield-alt text-primary me-2"></i>4. Specification Trust Block</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold small text-secondary">Heading</label>
                            <input type="text" name="trust_heading" value="<?php echo htmlspecialchars($data['trust']['heading']); ?>" class="form-control font-weight-bold">
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold small text-secondary">Body Paragraph 1</label>
                            <textarea name="trust_body_1" rows="2" class="form-control"><?php echo htmlspecialchars($data['trust']['body_1']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold small text-secondary">Body Paragraph 2</label>
                            <textarea name="trust_body_2" rows="2" class="form-control"><?php echo htmlspecialchars($data['trust']['body_2']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold small text-secondary">Sub-line (Callout)</label>
                            <input type="text" name="trust_sub" value="<?php echo htmlspecialchars($data['trust']['sub_line']); ?>" class="form-control">
                        </div>

                        <!-- Trust Block Image Upload -->
                        <div class="p-3 bg-light rounded border">
                            <h6 class="text-primary font-weight-bold mb-2"><i class="fas fa-image me-1"></i> Trust Section Image (Optional)</h6>
                            <div class="row g-3 align-items-center">
                                <div class="col-md-5">
                                    <label class="form-label small text-muted">Upload Image File</label>
                                    <input type="file" name="trust_image" accept="image/*" class="form-control form-control-sm">
                                    <?php if (!empty($data['trust']['image'])): ?>
                                        <div class="mt-2 d-flex align-items-center gap-2">
                                            <img src="../<?php echo htmlspecialchars($data['trust']['image']); ?>" class="rounded border" style="max-height: 45px; max-width: 75px; object-fit: cover;">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="remove_trust_image" value="1" id="remTrustImg">
                                                <label class="form-check-label text-danger small" for="remTrustImg">Remove Image</label>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small text-muted">Placement Position</label>
                                    <select name="trust_image_position" class="form-select form-select-sm">
                                        <option value="right" <?php echo ($data['trust']['image_position'] ?? '') === 'right' ? 'selected' : ''; ?>>Right Side Image</option>
                                        <option value="left" <?php echo ($data['trust']['image_position'] ?? '') === 'left' ? 'selected' : ''; ?>>Left Side Image</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-muted">Image Alt Text</label>
                                    <input type="text" name="trust_image_alt" value="<?php echo htmlspecialchars($data['trust']['image_alt'] ?? ''); ?>" class="form-control form-control-sm" placeholder="Image description">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 5: DIAGNOSTIC FORM HEADER -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="card-title mb-0 text-dark font-weight-bold"><i class="fas fa-wpforms text-primary me-2"></i>5. CPC Form Diagnostic Container</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold small text-secondary">Form Heading</label>
                            <input type="text" name="form_heading" value="<?php echo htmlspecialchars($data['form']['heading']); ?>" class="form-control font-weight-bold">
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold small text-secondary">Form Intro</label>
                            <textarea name="form_intro" rows="2" class="form-control"><?php echo htmlspecialchars($data['form']['intro']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold small text-secondary">Confidentiality Note</label>
                            <textarea name="form_conf" rows="2" class="form-control"><?php echo htmlspecialchars($data['form']['confidentiality']); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- CARD 6: QUADRA APPROACH -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 text-dark font-weight-bold"><i class="fas fa-tasks text-primary me-2"></i>6. The Quadra Approach® Section</h5>
                        <button type="button" onclick="addStage()" class="btn btn-sm btn-outline-primary font-weight-bold">
                            <i class="fas fa-plus me-1"></i> Add Stage
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold small text-secondary">Approach Intro</label>
                            <input type="text" name="approach_intro" value="<?php echo htmlspecialchars($data['approach']['intro']); ?>" class="form-control">
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label font-weight-bold small text-primary mb-0">Approach Stages</label>
                                <span class="badge bg-secondary" id="stageCountBadge">0 stages</span>
                            </div>
                            <div id="stages-container">
                                <!-- Dynamic Stages Injected via JS -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 7: PROOF / TRIBOINTEL LAB -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 text-dark font-weight-bold"><i class="fas fa-flask text-primary me-2"></i>7. Proof: TriboIntel™ Laboratory</h5>
                        <button type="button" onclick="addBadge()" class="btn btn-sm btn-outline-primary font-weight-bold">
                            <i class="fas fa-plus me-1"></i> Add Trust Badge
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold small text-secondary">Heading</label>
                            <input type="text" name="proof_heading" value="<?php echo htmlspecialchars($data['proof']['heading']); ?>" class="form-control font-weight-bold">
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold small text-secondary">Body Paragraph 1</label>
                            <textarea name="proof_body_1" rows="2" class="form-control"><?php echo htmlspecialchars($data['proof']['body_1']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold small text-secondary">Body Paragraph 2</label>
                            <textarea name="proof_body_2" rows="2" class="form-control"><?php echo htmlspecialchars($data['proof']['body_2']); ?></textarea>
                        </div>

                        <!-- Dynamic Badges -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label font-weight-bold small text-primary mb-0">Trust Badges / Key Highlights</label>
                                <span class="badge bg-secondary" id="badgeCountBadge">0 items</span>
                            </div>
                            <div id="badges-container">
                                <!-- Dynamic Badges Injected via JS -->
                            </div>
                        </div>

                        <!-- Proof Image Upload -->
                        <div class="p-3 bg-light rounded border mt-3">
                            <h6 class="text-primary font-weight-bold mb-2"><i class="fas fa-image me-1"></i> Proof/Lab Section Image (Optional)</h6>
                            <div class="row g-3 align-items-center">
                                <div class="col-md-5">
                                    <label class="form-label small text-muted">Upload Image File</label>
                                    <input type="file" name="proof_image" accept="image/*" class="form-control form-control-sm">
                                    <?php if (!empty($data['proof']['image'])): ?>
                                        <div class="mt-2 d-flex align-items-center gap-2">
                                            <img src="../<?php echo htmlspecialchars($data['proof']['image']); ?>" class="rounded border" style="max-height: 45px; max-width: 75px; object-fit: cover;">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="remove_proof_image" value="1" id="remProofImg">
                                                <label class="form-check-label text-danger small" for="remProofImg">Remove Image</label>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small text-muted">Placement Position</label>
                                    <select name="proof_image_position" class="form-select form-select-sm">
                                        <option value="right" <?php echo ($data['proof']['image_position'] ?? '') === 'right' ? 'selected' : ''; ?>>Right Side Image</option>
                                        <option value="left" <?php echo ($data['proof']['image_position'] ?? '') === 'left' ? 'selected' : ''; ?>>Left Side Image</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-muted">Image Alt Text</label>
                                    <input type="text" name="proof_image_alt" value="<?php echo htmlspecialchars($data['proof']['image_alt'] ?? ''); ?>" class="form-control form-control-sm" placeholder="Image description">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 8: PROCESS TIMELINE -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 text-dark font-weight-bold"><i class="fas fa-stream text-primary me-2"></i>8. What Happens After Submission Workflow</h5>
                        <button type="button" onclick="addStep()" class="btn btn-sm btn-outline-primary font-weight-bold">
                            <i class="fas fa-plus me-1"></i> Add Step
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold small text-secondary">Section Heading</label>
                            <input type="text" name="process_heading" value="<?php echo htmlspecialchars($data['process']['heading']); ?>" class="form-control font-weight-bold">
                        </div>

                        <!-- Dynamic Steps -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label font-weight-bold small text-primary mb-0">Workflow Steps</label>
                                <span class="badge bg-secondary" id="stepCountBadge">0 steps</span>
                            </div>
                            <div id="steps-container">
                                <!-- Dynamic Steps Injected via JS -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 9: FAQs -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 text-dark font-weight-bold"><i class="fas fa-question-circle text-primary me-2"></i>9. Frequently Asked Questions</h5>
                        <button type="button" onclick="addFaq()" class="btn btn-sm btn-outline-primary font-weight-bold">
                            <i class="fas fa-plus me-1"></i> Add FAQ
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label font-weight-bold small text-primary mb-0">FAQ Q&A Items</label>
                            <span class="badge bg-secondary" id="faqCountBadge">0 items</span>
                        </div>
                        <div id="faq-container">
                            <!-- Dynamic FAQs Injected via JS -->
                        </div>
                    </div>
                </div>

                <!-- SUBMIT BUTTON BAR -->
                <div class="card shadow-sm border-0 mb-5 p-3 sticky-bottom bg-white border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="landings.php" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary font-weight-bold px-5">
                            <i class="fas fa-save me-1"></i> Save Landing Page
                        </button>
                    </div>
                </div>

            </form>

        </main>
    </div>
</div>

<!-- JavaScript Dynamic Repeater Functions -->
<script>
// Initial Data arrays from PHP
const initialLevers = <?php echo json_encode($data['levers']['items'] ?? []); ?>;
const initialStages = <?php echo json_encode($data['approach']['stages'] ?? []); ?>;
const initialBadges = <?php echo json_encode($data['proof']['badges'] ?? []); ?>;
const initialSteps = <?php echo json_encode($data['process']['steps'] ?? []); ?>;
const initialFaqs = <?php echo json_encode($data['faq'] ?? []); ?>;

document.addEventListener('DOMContentLoaded', function() {
    // Populate Levers
    if (Array.isArray(initialLevers) && initialLevers.length > 0) {
        initialLevers.forEach(item => addLever(item.title || '', item.description || ''));
    } else {
        updateEmptyState('levers-container', 'leverCountBadge', 'No levers added yet. Click "+ Add Value Lever".');
    }

    // Populate Stages
    if (Array.isArray(initialStages) && initialStages.length > 0) {
        initialStages.forEach(stage => addStage(stage.title || '', stage.description || ''));
    } else {
        updateEmptyState('stages-container', 'stageCountBadge', 'No stages added yet. Click "+ Add Stage".');
    }

    // Populate Badges
    if (Array.isArray(initialBadges) && initialBadges.length > 0) {
        initialBadges.forEach(badge => addBadge(badge || ''));
    } else {
        updateEmptyState('badges-container', 'badgeCountBadge', 'No trust badges added yet. Click "+ Add Trust Badge".');
    }

    // Populate Steps
    if (Array.isArray(initialSteps) && initialSteps.length > 0) {
        initialSteps.forEach(step => addStep(typeof step === 'string' ? step : (step.description || '')));
    } else {
        updateEmptyState('steps-container', 'stepCountBadge', 'No workflow steps added yet. Click "+ Add Step".');
    }

    // Populate FAQs
    if (Array.isArray(initialFaqs) && initialFaqs.length > 0) {
        initialFaqs.forEach(faq => addFaq(faq.q || '', faq.a || ''));
    } else {
        updateEmptyState('faq-container', 'faqCountBadge', 'No FAQs added yet. Click "+ Add FAQ".');
    }

    // Auto-slug generator on title blur or slug input change
    const slugInput = document.getElementById('slugInput');
    if (slugInput) {
        slugInput.addEventListener('input', function() {
            this.value = this.value.toLowerCase().replace(/[^a-z0-9-]/g, '-').replace(/-+/g, '-');
        });
    }
});

// Utility to escape HTML strings
function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/&/g, "&amp;")
              .replace(/</g, "&lt;")
              .replace(/>/g, "&gt;")
              .replace(/"/g, "&quot;")
              .replace(/'/g, "&#039;");
}

// Update count badges & empty states
function updateCountBadge(containerId, badgeId, singularName) {
    const container = document.getElementById(containerId);
    const badge = document.getElementById(badgeId);
    if (!container || !badge) return;

    const items = container.querySelectorAll('.repeater-item');
    const count = items.length;
    badge.textContent = count + ' ' + (count === 1 ? singularName : singularName + 's');

    const emptyPlaceholder = container.querySelector('.empty-placeholder');
    if (count === 0 && !emptyPlaceholder) {
        container.innerHTML = `<div class="empty-placeholder text-center p-3 border border-dashed rounded text-muted small bg-light">No ${singularName}s added yet. Click the add button above to create one.</div>`;
    } else if (count > 0 && emptyPlaceholder) {
        emptyPlaceholder.remove();
    }
}

function updateEmptyState(containerId, badgeId, message) {
    const container = document.getElementById(containerId);
    const badge = document.getElementById(badgeId);
    if (badge) badge.textContent = '0 items';
    if (container && container.querySelectorAll('.repeater-item').length === 0) {
        container.innerHTML = `<div class="empty-placeholder text-center p-3 border border-dashed rounded text-muted small bg-light">${message}</div>`;
    }
}

// 1. ADD LEVER
function addLever(title = '', desc = '') {
    const container = document.getElementById('levers-container');
    const placeholder = container.querySelector('.empty-placeholder');
    if (placeholder) placeholder.remove();

    const div = document.createElement('div');
    div.className = 'repeater-item p-3 border rounded bg-light mb-3';
    div.innerHTML = `
        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
            <div class="flex-grow-1">
                <input type="text" name="lever_title[]" value="${escapeHtml(title)}" placeholder="Lever Title (e.g. Price per kilogram)" class="form-control form-control-sm font-weight-bold mb-2">
                <textarea name="lever_desc[]" rows="2" placeholder="Lever Description" class="form-control form-control-sm">${escapeHtml(desc)}</textarea>
            </div>
            <button type="button" onclick="removeSectionItem(this, 'levers-container', 'leverCountBadge', 'item')" class="btn btn-outline-danger btn-sm text-nowrap" title="Remove Lever">
                <i class="fas fa-trash-alt"></i> Remove
            </button>
        </div>
    `;
    container.appendChild(div);
    updateCountBadge('levers-container', 'leverCountBadge', 'item');
}

// 2. ADD STAGE (Quadra Approach)
function addStage(title = '', desc = '') {
    const container = document.getElementById('stages-container');
    const placeholder = container.querySelector('.empty-placeholder');
    if (placeholder) placeholder.remove();

    const div = document.createElement('div');
    div.className = 'repeater-item p-3 border rounded bg-light mb-3';
    div.innerHTML = `
        <div class="d-flex justify-content-between align-items-start gap-3">
            <div class="stage-number badge bg-primary font-weight-bold fs-6 p-2 mt-1">01</div>
            <div class="flex-grow-1">
                <input type="text" name="stage_title[]" value="${escapeHtml(title)}" placeholder="Stage Title (e.g. Application Identification)" class="form-control form-control-sm font-weight-bold mb-2">
                <textarea name="stage_desc[]" rows="2" placeholder="Stage Description" class="form-control form-control-sm">${escapeHtml(desc)}</textarea>
            </div>
            <button type="button" onclick="removeSectionItem(this, 'stages-container', 'stageCountBadge', 'stage')" class="btn btn-outline-danger btn-sm text-nowrap" title="Remove Stage">
                <i class="fas fa-trash-alt"></i> Remove
            </button>
        </div>
    `;
    container.appendChild(div);
    renumberStages();
    updateCountBadge('stages-container', 'stageCountBadge', 'stage');
}

function renumberStages() {
    const container = document.getElementById('stages-container');
    const badges = container.querySelectorAll('.stage-number');
    badges.forEach((b, idx) => {
        const num = (idx + 1).toString().padStart(2, '0');
        b.textContent = num;
    });
}

// 3. ADD BADGE (Trust Chip)
function addBadge(text = '') {
    const container = document.getElementById('badges-container');
    const placeholder = container.querySelector('.empty-placeholder');
    if (placeholder) placeholder.remove();

    const div = document.createElement('div');
    div.className = 'repeater-item d-flex gap-2 align-items-center mb-2';
    div.innerHTML = `
        <input type="text" name="badges[]" value="${escapeHtml(text)}" placeholder="Trust badge text (e.g. In-house NABL-accredited laboratory)" class="form-control form-control-sm">
        <button type="button" onclick="removeSectionItem(this, 'badges-container', 'badgeCountBadge', 'badge')" class="btn btn-outline-danger btn-sm" title="Remove Badge">
            <i class="fas fa-trash-alt"></i>
        </button>
    `;
    container.appendChild(div);
    updateCountBadge('badges-container', 'badgeCountBadge', 'badge');
}

// 4. ADD STEP (Workflow Process)
function addStep(desc = '') {
    const container = document.getElementById('steps-container');
    const placeholder = container.querySelector('.empty-placeholder');
    if (placeholder) placeholder.remove();

    const div = document.createElement('div');
    div.className = 'repeater-item d-flex gap-2 align-items-start mb-2';
    div.innerHTML = `
        <textarea name="step_desc[]" rows="2" placeholder="Process step description..." class="form-control form-control-sm">${escapeHtml(desc)}</textarea>
        <button type="button" onclick="removeSectionItem(this, 'steps-container', 'stepCountBadge', 'step')" class="btn btn-outline-danger btn-sm" title="Remove Step">
            <i class="fas fa-trash-alt"></i>
        </button>
    `;
    container.appendChild(div);
    updateCountBadge('steps-container', 'stepCountBadge', 'step');
}

// 5. ADD FAQ
function addFaq(q = '', a = '') {
    const container = document.getElementById('faq-container');
    const placeholder = container.querySelector('.empty-placeholder');
    if (placeholder) placeholder.remove();

    const div = document.createElement('div');
    div.className = 'repeater-item p-3 border rounded bg-light mb-3';
    div.innerHTML = `
        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
            <div class="flex-grow-1">
                <input type="text" name="faq_q[]" value="${escapeHtml(q)}" placeholder="Question (e.g. How long does a typical project take?)" class="form-control form-control-sm font-weight-bold mb-2">
                <textarea name="faq_a[]" rows="2" placeholder="Answer..." class="form-control form-control-sm">${escapeHtml(a)}</textarea>
            </div>
            <button type="button" onclick="removeSectionItem(this, 'faq-container', 'faqCountBadge', 'item')" class="btn btn-outline-danger btn-sm text-nowrap" title="Remove FAQ">
                <i class="fas fa-trash-alt"></i> Remove
            </button>
        </div>
    `;
    container.appendChild(div);
    updateCountBadge('faq-container', 'faqCountBadge', 'item');
}

// REMOVE ITEM HANDLER
function removeSectionItem(btn, containerId, badgeId, singularName) {
    const item = btn.closest('.repeater-item');
    if (item) {
        item.remove();
        if (containerId === 'stages-container') {
            renumberStages();
        }
        updateCountBadge(containerId, badgeId, singularName);
    }
}
</script>

<?php include 'includes/footer.php'; ?>
