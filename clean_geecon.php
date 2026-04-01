<?php
// Include the database configuration file directly to access PDO
require_once 'includes/config.php';

// Initialize variables
$action = $_POST['action'] ?? '';
$results = [
    'career' => 0,
    'contact' => 0,
    'tds' => 0,
    'total' => 0,
];
$message = '';
$status = '';

try {
    if ($action === 'delete') {
        // Execute DELETE transaction
        $db->beginTransaction();

        $stmt1 = $db->prepare("DELETE FROM career_enquiry WHERE LOWER(email) LIKE '%@imdeepsv@gmail.com'");
        $stmt1->execute();
        $deletedCareer = $stmt1->rowCount();

        $stmt2 = $db->prepare("DELETE FROM contact_enquiry WHERE LOWER(email) LIKE '%@imdeepsv@gmail.com'");
        $stmt2->execute();
        $deletedContact = $stmt2->rowCount();

        $stmt3 = $db->prepare("DELETE FROM tds_enquiry WHERE LOWER(email) LIKE '%@imdeepsv@gmail.com' OR LOWER(company_name) LIKE '%geecon%'");
        $stmt3->execute();
        $deletedTds = $stmt3->rowCount();

        $db->commit();

        $totalDeleted = $deletedCareer + $deletedContact + $deletedTds;
        $status = 'success';
        $message = "Successfully deleted {$totalDeleted} spam records.";

    } else {
        // Execute SELECT queries to get counts
        $stmt1 = $db->query("SELECT COUNT(*) FROM career_enquiry WHERE LOWER(email) LIKE '%@imdeepsv@gmail.com'");
        $results['career'] = $stmt1->fetchColumn();

        $stmt2 = $db->query("SELECT COUNT(*) FROM contact_enquiry WHERE LOWER(email) LIKE '%@imdeepsv@gmail.com'");
        $results['contact'] = $stmt2->fetchColumn();

        $stmt3 = $db->query("SELECT COUNT(*) FROM tds_enquiry WHERE LOWER(email) LIKE '%@imdeepsv@gmail.com' OR LOWER(company_name) LIKE '%geecon%'");
        $results['tds'] = $stmt3->fetchColumn();

        $results['total'] = $results['career'] + $results['contact'] + $results['tds'];
    }
} catch (Exception $e) {
    if ($db->inTransaction()) {
        $db->rollBack();
    }
    $status = 'error';
    $message = "An error occurred: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geecon Spam Cleanup Tool</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-grad-1: #0f172a;
            --bg-grad-2: #1e293b;
            --card-bg: rgba(255, 255, 255, 0.03);
            --card-border: rgba(255, 255, 255, 0.1);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --danger-color: #ef4444;
            --danger-hover: #dc2626;
            --success-color: #10b981;
            --accent-color: #3b82f6;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--bg-grad-1), var(--bg-grad-2));
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            line-height: 1.6;
        }

        /* Abstract shapes in the background */
        .shape {
            position: absolute;
            filter: blur(100px);
            z-index: 0;
            opacity: 0.5;
            border-radius: 50%;
        }

        .shape-1 {
            width: 400px;
            height: 400px;
            background: rgba(59, 130, 246, 0.3);
            top: -100px;
            left: -100px;
        }

        .shape-2 {
            width: 500px;
            height: 500px;
            background: rgba(239, 68, 68, 0.15);
            bottom: -200px;
            right: -100px;
        }

        .container {
            max-width: 650px;
            width: 100%;
            position: relative;
            z-index: 10;
        }

        .glass-panel {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .title {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
            background: linear-gradient(to right, #ffffff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            font-size: 1.1rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            line-height: 1;
        }

        .stat-value.danger {
            color: #fca5a5;
        }

        .stat-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
        }

        .total-banner {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 16px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2.5rem;
        }

        .total-banner.empty {
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.2);
        }

        .total-info h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: var(--text-main);
        }

        .total-info p {
            font-size: 0.95rem;
            color: var(--text-muted);
        }

        .total-number {
            font-size: 3rem;
            font-weight: 800;
            color: var(--danger-color);
        }

        .total-banner.empty .total-number {
            color: var(--success-color);
        }

        .action-area {
            text-align: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 1rem 2.5rem;
            font-size: 1.125rem;
            font-weight: 600;
            border-radius: 9999px;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            width: 100%;
        }

        .btn-danger {
            background: var(--danger-color);
            color: white;
            box-shadow: 0 10px 25px -5px rgba(239, 68, 68, 0.4);
        }

        .btn-danger:hover {
            background: var(--danger-hover);
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -5px rgba(239, 68, 68, 0.5);
        }

        .btn-danger:active {
            transform: translateY(1px);
        }

        .btn-danger:disabled {
            background: #475569;
            box-shadow: none;
            cursor: not-allowed;
            transform: none;
            opacity: 0.7;
        }

        .btn-outline {
            background: transparent;
            color: var(--text-main);
            border: 1px solid var(--card-border);
            margin-top: 1rem;
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .message-box {
            padding: 1.5rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            text-align: center;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .message-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #34d399;
        }

        .message-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
        }

        .message-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }

        .message-text {
            font-size: 1.25rem;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>

    <div class="container">
        <div class="glass-panel">
            <div class="header">
                <h1 class="title">Data Cleanup Tool</h1>
                <p class="subtitle">Scan and remove specific domains from enquiries</p>
            </div>

            <?php if ($status): ?>
                <!-- Result State -->
                <div class="message-box message-<?php echo $status; ?>">
                    <?php if ($status === 'success'): ?>
                        <span class="message-icon">✨</span>
                    <?php else: ?>
                        <span class="message-icon">⚠️</span>
                    <?php endif; ?>
                    <div class="message-text"><?php echo htmlspecialchars($message); ?></div>
                </div>

                <div class="action-area">
                    <a href="clean_geecon.php" class="btn btn-outline">Scan Again</a>
                </div>
            <?php else: ?>
                <!-- Pre-Delete State -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value <?php echo $results['career'] > 0 ? 'danger' : ''; ?>">
                            <?php echo $results['career']; ?>
                        </div>
                        <div class="stat-label">Career<br>Enquiries</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value <?php echo $results['contact'] > 0 ? 'danger' : ''; ?>">
                            <?php echo $results['contact']; ?>
                        </div>
                        <div class="stat-label">Contact<br>Enquiries</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value <?php echo $results['tds'] > 0 ? 'danger' : ''; ?>">
                            <?php echo $results['tds']; ?>
                        </div>
                        <div class="stat-label">TDS<br>Enquiries</div>
                    </div>
                </div>

                <div class="total-banner <?php echo $results['total'] == 0 ? 'empty' : ''; ?>">
                    <div class="total-info">
                        <h3>Match Found</h3>
                        <p>Records matching '%@imdeepsv@gmail.com' or '%geecon%'</p>
                    </div>
                    <div class="total-number">
                        <?php echo $results['total']; ?>
                    </div>
                </div>

                <div class="action-area">
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="delete">
                        <button type="submit" class="btn btn-danger" <?php echo $results['total'] == 0 ? 'disabled' : ''; ?>
                            onclick="return confirm('WARNING: You are about to permanently delete <?php echo $results['total']; ?> records. This action cannot be undone. Are you absolutely sure?');">

                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 6h18"></path>
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                            Permanently Delete <?php echo $results['total']; ?> Records
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>