<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login");
    exit;
}

// Include configuration and functions
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Page title
$page_title = "Bulk Product SEO";
$active_menu = "catalogue_product_seo";

// Fetch Products
$products = [];
$productSql = "SELECT id, name, meta_title, meta_description, meta_keywords FROM `products_v2` ORDER BY `id` ASC";
$productResult = $conn->query($productSql);
if ($productResult && $productResult->num_rows > 0) {
    while ($row = $productResult->fetch_assoc()) {
        $products[] = $row;
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Bulk Product SEO</h1>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Update SEO for all products</h5>
                    <small class="text-muted">Edit the fields and click Save for each product. Changes apply instantly.</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="seoTable" class="table table-striped table-bordered table-hover align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 5%">ID</th>
                                    <th style="width: 15%">Product Name</th>
                                    <th style="width: 25%">Meta Title</th>
                                    <th style="width: 25%">Meta Description</th>
                                    <th style="width: 20%">Meta Keywords</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($products)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No products found.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($products as $product): ?>
                                        <tr id="row-<?php echo $product['id']; ?>">
                                            <td><?php echo $product['id']; ?></td>
                                            <td><strong><?php echo htmlspecialchars($product['name']); ?></strong></td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm meta-title" value="<?php echo htmlspecialchars($product['meta_title'] ?? ''); ?>" placeholder="Meta Title">
                                            </td>
                                            <td>
                                                <textarea class="form-control form-control-sm meta-description" rows="2" placeholder="Meta Description"><?php echo htmlspecialchars($product['meta_description'] ?? ''); ?></textarea>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm meta-keywords" value="<?php echo htmlspecialchars($product['meta_keywords'] ?? ''); ?>" placeholder="Comma separated keywords">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-success save-seo-btn" data-id="<?php echo $product['id']; ?>">
                                                    <i class="fas fa-save"></i> Save
                                                </button>
                                                <span class="save-status text-success d-none mt-1"><br><i class="fas fa-check"></i> Saved</span>
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

<?php include 'includes/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable with a slight delay to avoid conflicts with global script.js
    setTimeout(function() {
        if (typeof jQuery !== 'undefined' && jQuery.fn.DataTable) {
            // Destroy any existing initialization first just in case
            if ($.fn.DataTable.isDataTable('#seoTable')) {
                $('#seoTable').DataTable().destroy();
            }
            $('#seoTable').DataTable({
                "pageLength": 25,
                "columnDefs": [
                    { "orderable": false, "targets": [2, 3, 4, 5] }
                ],
                "retrieve": true
            });
        }
    }, 100);

    // Handle Save AJAX
    const table = document.getElementById('seoTable');
    if (table) {
        table.addEventListener('click', function(e) {
            const btn = e.target.closest('.save-seo-btn');
            if (!btn) return;

            const id = btn.getAttribute('data-id');
            const row = document.getElementById('row-' + id);
            
            const metaTitle = row.querySelector('.meta-title').value;
            const metaDescription = row.querySelector('.meta-description').value;
            const metaKeywords = row.querySelector('.meta-keywords').value;
            
            const statusSpan = row.querySelector('.save-status');

            // Show saving state
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;
            statusSpan.classList.add('d-none');

            // Send AJAX request
            const formData = new FormData();
            formData.append('id', id);
            formData.append('meta_title', metaTitle);
            formData.append('meta_description', metaDescription);
            formData.append('meta_keywords', metaKeywords);

            fetch('_ajax/update_product_seo.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                btn.innerHTML = '<i class="fas fa-save"></i> Save';
                btn.disabled = false;
                
                if (data.success) {
                    statusSpan.classList.remove('d-none');
                    statusSpan.classList.replace('text-danger', 'text-success');
                    statusSpan.innerHTML = '<br><i class="fas fa-check"></i> Saved';
                    setTimeout(() => statusSpan.classList.add('d-none'), 3000);
                } else {
                    statusSpan.classList.remove('d-none');
                    statusSpan.classList.replace('text-success', 'text-danger');
                    statusSpan.innerHTML = '<br><i class="fas fa-times"></i> Error';
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                btn.innerHTML = '<i class="fas fa-save"></i> Save';
                btn.disabled = false;
                alert('An error occurred while saving.');
            });
        });
    }
});
</script>
