<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login");
    exit;
}

require_once '../includes/config.php';
require_once '../includes/functions.php';

$page_title = "Product Enquiries";
$active_menu = "tds_enquiry";

// Fetch enquiries with product name (if product table exists)
$enquiries = [];
$sql = "
    SELECT e.*, p.name AS product_name 
    FROM tds_enquiry e 
    LEFT JOIN products p ON e.product_id = p.id 
    ORDER BY e.id DESC
";
$result = $conn->query($sql);
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
                <h1 class="h2">Product Enquiries</h1>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <table id="enquiryTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Product</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Company</th>
                                <th>Pincode</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($enquiries as $enquiry): ?>
                                <tr>
                                    <td><?= $enquiry['id'] ?></td>
                                    <td><?= htmlspecialchars($enquiry['product_name'] ?? 'Unknown Product') ?></td>
                                    <td><?= htmlspecialchars($enquiry['name']) ?></td>
                                    <td><?= htmlspecialchars($enquiry['email']) ?></td>
                                    <td><?= htmlspecialchars($enquiry['contact']) ?></td>
                                    <td><?= htmlspecialchars($enquiry['company_name']) ?></td>
                                    <td><?= htmlspecialchars($enquiry['pincode']) ?></td>
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


<script>
    $(document).ready(function () {
        $('#enquiryTable').DataTable({
            responsive: true,
            order: [[0, 'desc']]
        });
    });
</script>
