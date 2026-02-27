<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login");
    exit;
}

require_once '../includes/config.php';
require_once '../includes/functions.php';

$page_title = "Career Enquiries";
$active_menu = "enquiries_career";

// Fetch enquiries
$enquiries = [];
$result = $conn->query("SELECT * FROM career_enquiry ORDER BY id DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $enquiries[] = $row;
    }
}
?>

<?php include 'includes/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Career Enquiries</h1>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <table id="enquiryTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>City</th>
                                <th>Pincode</th>
                                <th>Resume</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($enquiries as $enquiry): ?>
                                <tr>
                                    <td><?= $enquiry['id'] ?></td>
                                    <td><?= htmlspecialchars($enquiry['name']) ?></td>
                                    <td><?= htmlspecialchars($enquiry['position']) ?></td>
                                    <td><?= htmlspecialchars($enquiry['email']) ?></td>
                                    <td><?= htmlspecialchars($enquiry['mobile']) ?></td>
                                    <td><?= htmlspecialchars($enquiry['city']) ?></td>
                                    <td><?= htmlspecialchars($enquiry['pincode']) ?></td>

                                    <td>
                                        <?php if (!empty($enquiry['resume'])): ?>
                                            <a href="<?= HOME_URL; ?><?= htmlspecialchars($enquiry['resume']) ?>" target="_blank"
                                                class="badge bg-success">View</a>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('Y-m-d H:i', strtotime($enquiry['created_at'])) ?></td>
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

<!-- DataTables + Export -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#enquiryTable').DataTable({
            responsive: true,
            order: [[0, 'desc']]
        });
    });
</script>