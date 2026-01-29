<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login");
    exit;
}

require_once '../includes/config.php';
require_once '../includes/functions.php';

$page_title = "Event Registrations";
$active_menu = "enquiries_event";

// Fetch event registrations
$registrations = [];
$result = $conn->query("SELECT * FROM event_registrations ORDER BY id DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $registrations[] = $row;
    }
}
?>

<?php include 'includes/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Event Registrations</h1>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <table id="registrationTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Event Title</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Status</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($registrations as $reg): ?>
                                <tr>
                                    <td>
                                        <?= $reg['id'] ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($reg['event_title']) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($reg['first_name'] . ' ' . $reg['last_name']) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($reg['email']) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($reg['mobile']) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($reg['status']) ?>
                                    </td>
                                    <td>
                                        <?= date('Y-m-d H:i', strtotime($reg['created_at'])) ?>
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

<!-- DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#registrationTable').DataTable({
            responsive: true,
            order: [[0, 'desc']]
        });
    });
</script>