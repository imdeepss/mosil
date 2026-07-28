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
    $json_content = file_get_contents($landings_dir . $filename);
    $saved_data = json_decode($json_content, true);
    if (is_array($saved_data)) {
        $data = array_replace_recursive($data, $saved_data);
    }
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
$error = '';

// Form Submit Handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slug = trim($_POST['slug']);
    $slug = strtolower(preg_replace('/[^a-zA-Z0-9-]/', '-', $slug));
    
    if (empty($slug)) {
        $error = "URL slug is required.";
    } else {
        // Process Images
        $hero_image = processImageUpload('hero_image', $_POST['remove_hero_image'] ?? 0, $data['hero']['image'] ?? '');
        $trust_image = processImageUpload('trust_image', $_POST['remove_trust_image'] ?? 0, $data['trust']['image'] ?? '');
        $proof_image = processImageUpload('proof_image', $_POST['remove_proof_image'] ?? 0, $data['proof']['image'] ?? '');

        // Repeaters
        $levers = [];
        if (isset($_POST['lever_title'])) {
            foreach ($_POST['lever_title'] as $i => $t) {
                if (!empty(trim($t))) {
                    $levers[] = [
                        'title' => trim($t),
                        'description' => trim($_POST['lever_desc'][$i] ?? '')
                    ];
                }
            }
        }

        $stages = [];
        if (isset($_POST['stage_title'])) {
            foreach ($_POST['stage_title'] as $i => $t) {
                if (!empty(trim($t))) {
                    $stages[] = [
                        'number' => $i + 1,
                        'title' => trim($t),
                        'description' => trim($_POST['stage_desc'][$i] ?? '')
                    ];
                }
            }
        }

        $badges = [];
        if (isset($_POST['badges'])) {
            foreach ($_POST['badges'] as $b) {
                if (!empty(trim($b))) {
                    $badges[] = trim($b);
                }
            }
        }

        $steps = [];
        if (isset($_POST['step_desc'])) {
            foreach ($_POST['step_desc'] as $s) {
                if (!empty(trim($s))) {
                    $steps[] = ['description' => trim($s)];
                }
            }
        }

        $faqs = [];
        if (isset($_POST['faq_q'])) {
            foreach ($_POST['faq_q'] as $i => $q) {
                if (!empty(trim($q))) {
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
                'title' => $_POST['seo_title'],
                'description' => $_POST['seo_desc'],
                'noindex' => isset($_POST['seo_noindex']) ? true : false
            ],
            'hero' => [
                'headline' => $_POST['hero_headline'],
                'sub_headline' => $_POST['hero_sub_headline'],
                'cta_text' => $_POST['hero_cta'],
                'micro_line' => $_POST['hero_micro'],
                'image' => $hero_image,
                'image_position' => $_POST['hero_image_position'] ?? 'right',
                'image_alt' => $_POST['hero_image_alt'] ?? ''
            ],
            'levers' => [
                'intro_1' => $_POST['lever_intro_1'],
                'formula' => $_POST['lever_formula'],
                'intro_2' => $_POST['lever_intro_2'],
                'items' => $levers,
                'closing' => $_POST['lever_closing']
            ],
            'trust' => [
                'heading' => $_POST['trust_heading'],
                'body_1' => $_POST['trust_body_1'],
                'body_2' => $_POST['trust_body_2'],
                'sub_line' => $_POST['trust_sub'],
                'image' => $trust_image,
                'image_position' => $_POST['trust_image_position'] ?? 'right',
                'image_alt' => $_POST['trust_image_alt'] ?? ''
            ],
            'form' => [
                'heading' => $_POST['form_heading'],
                'intro' => $_POST['form_intro'],
                'confidentiality' => $_POST['form_conf']
            ],
            'approach' => [
                'intro' => $_POST['approach_intro'],
                'stages' => $stages
            ],
            'proof' => [
                'heading' => $_POST['proof_heading'],
                'body_1' => $_POST['proof_body_1'],
                'body_2' => $_POST['proof_body_2'],
                'badges' => $badges,
                'image' => $proof_image,
                'image_position' => $_POST['proof_image_position'] ?? 'right',
                'image_alt' => $_POST['proof_image_alt'] ?? ''
            ],
            'process' => [
                'heading' => $_POST['process_heading'],
                'steps' => $steps
            ],
            'faq' => $faqs
        ];

        $target_file = $landings_dir . $slug . '.json';
        
        if ($is_edit && $filename !== $slug . '.json' && file_exists($landings_dir . $filename)) {
            unlink($landings_dir . $filename);
        }

        if (file_put_contents($target_file, json_encode($save_data, JSON_PRETTY_PRINT))) {
            $message = "Landing page saved successfully!";
            $data = $save_data;
            $filename = $slug . '.json';
            $is_edit = true;
        } else {
            $error = "Failed to save landing page file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $is_edit ? 'Edit Landing Page' : 'Create Landing Page'; ?> | MOSIL Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 font-sans text-slate-800 pb-20">

    <div class="flex min-h-screen">
        <?php include 'includes/sidebar.php'; ?>

        <div class="flex-1 p-8 max-w-5xl mx-auto">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <a href="landings.php" class="text-xs font-bold text-amber-600 uppercase tracking-wider hover:underline mb-1 inline-block">← Back to Landing Pages</a>
                    <h1 class="text-3xl font-bold text-slate-900"><?php echo $is_edit ? 'Edit Landing Page' : 'Create Landing Page'; ?></h1>
                </div>
                <?php if ($is_edit): ?>
                    <a href="../<?php echo htmlspecialchars($data['id']); ?>" target="_blank" class="bg-slate-800 hover:bg-slate-900 text-white font-medium px-4 py-2 rounded-lg text-sm transition">
                        View Live Page ↗
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($message): ?>
                <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-lg mb-6 text-sm">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg mb-6 text-sm">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data" class="space-y-8">
                
                <!-- CARD 1: URL & SEO -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
                    <h2 class="text-lg font-bold text-slate-900 border-b pb-2">1. URL Slug & SEO Settings</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">URL Slug (e.g. cost-per-component) *</label>
                            <input type="text" name="slug" value="<?php echo htmlspecialchars($data['id']); ?>" class="w-full p-2.5 border rounded-lg text-sm bg-slate-50 font-mono" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">SEO Title Tag</label>
                            <input type="text" name="seo_title" value="<?php echo htmlspecialchars($data['seo']['title']); ?>" class="w-full p-2.5 border rounded-lg text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">SEO Meta Description</label>
                            <textarea name="seo_desc" rows="2" class="w-full p-2.5 border rounded-lg text-sm"><?php echo htmlspecialchars($data['seo']['description']); ?></textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="seo_noindex" value="1" <?php echo !empty($data['seo']['noindex']) ? 'checked' : ''; ?> class="w-4 h-4 text-amber-500 rounded">
                                <span class="text-sm font-semibold text-slate-800">Unlink from main navigation & set <code>noindex, nofollow</code></span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: HERO SECTION -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
                    <h2 class="text-lg font-bold text-slate-900 border-b pb-2">2. Hero / Banner Section</h2>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Headline (H1)</label>
                        <textarea name="hero_headline" rows="2" class="w-full p-2.5 border rounded-lg text-sm font-semibold"><?php echo htmlspecialchars($data['hero']['headline']); ?></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Sub-headline</label>
                        <textarea name="hero_sub_headline" rows="3" class="w-full p-2.5 border rounded-lg text-sm"><?php echo htmlspecialchars($data['hero']['sub_headline']); ?></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Primary CTA Button Text</label>
                            <input type="text" name="hero_cta" value="<?php echo htmlspecialchars($data['hero']['cta_text']); ?>" class="w-full p-2.5 border rounded-lg text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Micro-line below button</label>
                            <input type="text" name="hero_micro" value="<?php echo htmlspecialchars($data['hero']['micro_line']); ?>" class="w-full p-2.5 border rounded-lg text-sm">
                        </div>
                    </div>

                    <!-- Hero Image Upload Section -->
                    <div class="pt-4 border-t border-slate-100 grid grid-cols-1 md:grid-cols-3 gap-4 bg-slate-50 p-4 rounded-lg">
                        <div class="md:col-span-3 font-semibold text-xs text-slate-700 uppercase">Optional Hero Image</div>
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Upload Image</label>
                            <input type="file" name="hero_image" accept="image/*" class="text-xs">
                            <?php if (!empty($data['hero']['image'])): ?>
                                <div class="mt-2 flex items-center gap-2">
                                    <img src="../<?php echo htmlspecialchars($data['hero']['image']); ?>" class="w-16 h-12 object-cover rounded border">
                                    <label class="text-xs text-red-600 font-medium"><input type="checkbox" name="remove_hero_image" value="1"> Remove</label>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Placement Position</label>
                            <select name="hero_image_position" class="w-full p-2 border rounded text-xs bg-white">
                                <option value="right" <?php echo ($data['hero']['image_position'] ?? '') === 'right' ? 'selected' : ''; ?>>Right Side Card</option>
                                <option value="left" <?php echo ($data['hero']['image_position'] ?? '') === 'left' ? 'selected' : ''; ?>>Left Side Card</option>
                                <option value="background" <?php echo ($data['hero']['image_position'] ?? '') === 'background' ? 'selected' : ''; ?>>Full Background Banner</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Image Alt Text</label>
                            <input type="text" name="hero_image_alt" value="<?php echo htmlspecialchars($data['hero']['image_alt'] ?? ''); ?>" class="w-full p-2 border rounded text-xs">
                        </div>
                    </div>
                </div>

                <!-- CARD 3: COST LEVERS -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
                    <h2 class="text-lg font-bold text-slate-900 border-b pb-2">3. Cost Levers & Formula Section</h2>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Intro Line 1</label>
                        <input type="text" name="lever_intro_1" value="<?php echo htmlspecialchars($data['levers']['intro_1']); ?>" class="w-full p-2.5 border rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Formula Band Equation</label>
                        <input type="text" name="lever_formula" value="<?php echo htmlspecialchars($data['levers']['formula']); ?>" class="w-full p-2.5 border rounded-lg text-sm font-mono bg-slate-900 text-amber-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Intro Line 2</label>
                        <input type="text" name="lever_intro_2" value="<?php echo htmlspecialchars($data['levers']['intro_2']); ?>" class="w-full p-2.5 border rounded-lg text-sm">
                    </div>

                    <!-- Repeatable Levers -->
                    <div class="space-y-3">
                        <label class="block text-xs font-bold text-slate-700 uppercase">3 Value Levers</label>
                        <div id="levers-container" class="space-y-3">
                            <?php foreach ($data['levers']['items'] as $item): ?>
                                <div class="p-3 border rounded-lg bg-slate-50 flex gap-3">
                                    <div class="flex-1 space-y-2">
                                        <input type="text" name="lever_title[]" value="<?php echo htmlspecialchars($item['title']); ?>" placeholder="Lever Title" class="w-full p-2 border rounded text-sm font-semibold">
                                        <textarea name="lever_desc[]" rows="2" placeholder="Lever Description" class="w-full p-2 border rounded text-xs"><?php echo htmlspecialchars($item['description']); ?></textarea>
                                    </div>
                                    <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 text-xs font-bold self-start">Remove</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Section Closing Line</label>
                        <input type="text" name="lever_closing" value="<?php echo htmlspecialchars($data['levers']['closing']); ?>" class="w-full p-2.5 border rounded-lg text-sm">
                    </div>
                </div>

                <!-- CARD 4: TRUST BLOCK -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
                    <h2 class="text-lg font-bold text-slate-900 border-b pb-2">4. Specification Trust Block</h2>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Heading</label>
                        <input type="text" name="trust_heading" value="<?php echo htmlspecialchars($data['trust']['heading']); ?>" class="w-full p-2.5 border rounded-lg text-sm font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Body Paragraph 1</label>
                        <textarea name="trust_body_1" rows="2" class="w-full p-2.5 border rounded-lg text-sm"><?php echo htmlspecialchars($data['trust']['body_1']); ?></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Body Paragraph 2</label>
                        <textarea name="trust_body_2" rows="2" class="w-full p-2.5 border rounded-lg text-sm"><?php echo htmlspecialchars($data['trust']['body_2']); ?></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Sub-line (Callout)</label>
                        <input type="text" name="trust_sub" value="<?php echo htmlspecialchars($data['trust']['sub_line']); ?>" class="w-full p-2.5 border rounded-lg text-sm font-semibold">
                    </div>

                    <!-- Trust Block Image Upload -->
                    <div class="pt-4 border-t border-slate-100 grid grid-cols-1 md:grid-cols-3 gap-4 bg-slate-50 p-4 rounded-lg">
                        <div class="md:col-span-3 font-semibold text-xs text-slate-700 uppercase">Optional Trust Section Image</div>
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Upload Image</label>
                            <input type="file" name="trust_image" accept="image/*" class="text-xs">
                            <?php if (!empty($data['trust']['image'])): ?>
                                <div class="mt-2 flex items-center gap-2">
                                    <img src="../<?php echo htmlspecialchars($data['trust']['image']); ?>" class="w-16 h-12 object-cover rounded border">
                                    <label class="text-xs text-red-600 font-medium"><input type="checkbox" name="remove_trust_image" value="1"> Remove</label>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Placement Position</label>
                            <select name="trust_image_position" class="w-full p-2 border rounded text-xs bg-white">
                                <option value="right" <?php echo ($data['trust']['image_position'] ?? '') === 'right' ? 'selected' : ''; ?>>Right Side Image</option>
                                <option value="left" <?php echo ($data['trust']['image_position'] ?? '') === 'left' ? 'selected' : ''; ?>>Left Side Image</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Image Alt Text</label>
                            <input type="text" name="trust_image_alt" value="<?php echo htmlspecialchars($data['trust']['image_alt'] ?? ''); ?>" class="w-full p-2 border rounded text-xs">
                        </div>
                    </div>
                </div>

                <!-- CARD 5: DIAGNOSTIC FORM HEADER -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
                    <h2 class="text-lg font-bold text-slate-900 border-b pb-2">5. CPC Form Diagnostic Container</h2>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Form Heading</label>
                        <input type="text" name="form_heading" value="<?php echo htmlspecialchars($data['form']['heading']); ?>" class="w-full p-2.5 border rounded-lg text-sm font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Form Intro</label>
                        <textarea name="form_intro" rows="2" class="w-full p-2.5 border rounded-lg text-sm"><?php echo htmlspecialchars($data['form']['intro']); ?></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Confidentiality Note</label>
                        <textarea name="form_conf" rows="2" class="w-full p-2.5 border rounded-lg text-sm"><?php echo htmlspecialchars($data['form']['confidentiality']); ?></textarea>
                    </div>
                </div>

                <!-- CARD 6: QUADRA APPROACH -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
                    <h2 class="text-lg font-bold text-slate-900 border-b pb-2">6. The Quadra Approach® Section</h2>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Approach Intro</label>
                        <input type="text" name="approach_intro" value="<?php echo htmlspecialchars($data['approach']['intro']); ?>" class="w-full p-2.5 border rounded-lg text-sm">
                    </div>
                    <div id="stages-container" class="space-y-3">
                        <?php foreach ($data['approach']['stages'] as $idx => $stage): ?>
                            <div class="p-3 border rounded-lg bg-slate-50 flex gap-3">
                                <div class="font-bold text-amber-600 text-sm">0<?php echo $idx + 1; ?></div>
                                <div class="flex-1 space-y-2">
                                    <input type="text" name="stage_title[]" value="<?php echo htmlspecialchars($stage['title']); ?>" placeholder="Stage Title" class="w-full p-2 border rounded text-sm font-semibold">
                                    <textarea name="stage_desc[]" rows="2" placeholder="Stage Description" class="w-full p-2 border rounded text-xs"><?php echo htmlspecialchars($stage['description']); ?></textarea>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- CARD 7: PROOF / TRIBOINTEL LAB -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
                    <h2 class="text-lg font-bold text-slate-900 border-b pb-2">7. Proof: TriboIntel™ Laboratory</h2>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Heading</label>
                        <input type="text" name="proof_heading" value="<?php echo htmlspecialchars($data['proof']['heading']); ?>" class="w-full p-2.5 border rounded-lg text-sm font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Body Paragraph 1</label>
                        <textarea name="proof_body_1" rows="2" class="w-full p-2.5 border rounded-lg text-sm"><?php echo htmlspecialchars($data['proof']['body_1']); ?></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Body Paragraph 2</label>
                        <textarea name="proof_body_2" rows="2" class="w-full p-2.5 border rounded-lg text-sm"><?php echo htmlspecialchars($data['proof']['body_2']); ?></textarea>
                    </div>

                    <!-- Repeatable Badges -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Trust Badges / Chips</label>
                        <div id="badges-container" class="space-y-2">
                            <?php foreach ($data['proof']['badges'] as $badge): ?>
                                <div class="flex gap-2">
                                    <input type="text" name="badges[]" value="<?php echo htmlspecialchars($badge); ?>" class="flex-1 p-2 border rounded text-xs">
                                    <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 text-xs font-bold">Remove</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Proof Image Upload -->
                    <div class="pt-4 border-t border-slate-100 grid grid-cols-1 md:grid-cols-3 gap-4 bg-slate-50 p-4 rounded-lg">
                        <div class="md:col-span-3 font-semibold text-xs text-slate-700 uppercase">Optional Proof/Lab Image</div>
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Upload Image</label>
                            <input type="file" name="proof_image" accept="image/*" class="text-xs">
                            <?php if (!empty($data['proof']['image'])): ?>
                                <div class="mt-2 flex items-center gap-2">
                                    <img src="../<?php echo htmlspecialchars($data['proof']['image']); ?>" class="w-16 h-12 object-cover rounded border">
                                    <label class="text-xs text-red-600 font-medium"><input type="checkbox" name="remove_proof_image" value="1"> Remove</label>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Placement Position</label>
                            <select name="proof_image_position" class="w-full p-2 border rounded text-xs bg-white">
                                <option value="right" <?php echo ($data['proof']['image_position'] ?? '') === 'right' ? 'selected' : ''; ?>>Right Side Image</option>
                                <option value="left" <?php echo ($data['proof']['image_position'] ?? '') === 'left' ? 'selected' : ''; ?>>Left Side Image</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Image Alt Text</label>
                            <input type="text" name="proof_image_alt" value="<?php echo htmlspecialchars($data['proof']['image_alt'] ?? ''); ?>" class="w-full p-2 border rounded text-xs">
                        </div>
                    </div>
                </div>

                <!-- CARD 8: PROCESS TIMELINE -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
                    <h2 class="text-lg font-bold text-slate-900 border-b pb-2">8. What Happens After Submission Workflow</h2>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Section Heading</label>
                        <input type="text" name="process_heading" value="<?php echo htmlspecialchars($data['process']['heading']); ?>" class="w-full p-2.5 border rounded-lg text-sm font-bold">
                    </div>
                    <div id="steps-container" class="space-y-2">
                        <?php foreach ($data['process']['steps'] as $step): ?>
                            <div class="flex gap-2">
                                <textarea name="step_desc[]" rows="2" class="flex-1 p-2 border rounded text-xs"><?php echo htmlspecialchars($step['description']); ?></textarea>
                                <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 text-xs font-bold self-start">Remove</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- CARD 9: FAQs -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
                    <h2 class="text-lg font-bold text-slate-900 border-b pb-2">9. Frequently Asked Questions</h2>
                    <div id="faq-container" class="space-y-4">
                        <?php foreach ($data['faq'] as $faq): ?>
                            <div class="p-3 border rounded-lg bg-slate-50 space-y-2">
                                <input type="text" name="faq_q[]" value="<?php echo htmlspecialchars($faq['q']); ?>" placeholder="Question" class="w-full p-2 border rounded text-sm font-semibold">
                                <textarea name="faq_a[]" rows="2" placeholder="Answer" class="w-full p-2 border rounded text-xs"><?php echo htmlspecialchars($faq['a']); ?></textarea>
                                <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 text-xs font-bold">Remove FAQ</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- SUBMIT BUTTON -->
                <div class="flex justify-end gap-4 pt-4">
                    <a href="landings.php" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-6 py-3 rounded-lg text-sm transition">Cancel</a>
                    <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold px-8 py-3 rounded-lg text-sm shadow transition">
                        Save Landing Page
                    </button>
                </div>

            </form>

        </div>
    </div>

</body>
</html>
