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

$landings_dir = '../data/landings/';
$message = '';
$error = '';

// Handle Delete Request
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['file'])) {
    $file_to_delete = basename($_GET['file']);
    $file_path = $landings_dir . $file_to_delete;
    
    if (file_exists($file_path)) {
        if (unlink($file_path)) {
            $message = "Landing page '{$file_to_delete}' deleted successfully.";
        } else {
            $error = "Failed to delete landing page file.";
        }
    } else {
        $error = "Landing page file not found.";
    }
}

// Fetch all landing page JSON files
$landings = [];
if (is_dir($landings_dir)) {
    $files = scandir($landings_dir);
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'json') {
            $json_content = file_get_contents($landings_dir . $file);
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Landing Pages | MOSIL Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 font-sans text-slate-800">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Landing Pages</h1>
                    <p class="text-slate-500 text-sm mt-1">Manage dynamic landing page copy, images, and diagnostic form templates.</p>
                </div>
                <a href="landing_form.php" class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold px-5 py-2.5 rounded-lg shadow transition flex items-center gap-2 text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Create New Landing Page</span>
                </a>
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

            <!-- Landing Pages Table -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-4">URL Slug</th>
                            <th class="px-6 py-4">Landing Page Title</th>
                            <th class="px-6 py-4">Indexing Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <?php if (count($landings) > 0): ?>
                            <?php foreach ($landings as $landing): ?>
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-6 py-4 font-mono text-amber-600 font-semibold">
                                        /<?php echo htmlspecialchars($landing['slug']); ?>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-slate-900">
                                        <?php echo htmlspecialchars($landing['title']); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if ($landing['noindex']): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                                Unlinked (noindex)
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                Public (Indexed)
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-3">
                                        <a href="../<?php echo htmlspecialchars($landing['slug']); ?>" target="_blank" class="text-slate-500 hover:text-slate-900 font-medium">View Live ↗</a>
                                        <a href="landing_form.php?file=<?php echo urlencode($landing['filename']); ?>" class="text-amber-600 hover:text-amber-700 font-semibold">Edit</a>
                                        <a href="landings.php?action=delete&file=<?php echo urlencode($landing['filename']); ?>" onclick="return confirm('Are you sure you want to delete this landing page?');" class="text-red-500 hover:text-red-700 font-medium">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                    No landing pages found. Click "Create New Landing Page" to create one.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</body>
</html>
