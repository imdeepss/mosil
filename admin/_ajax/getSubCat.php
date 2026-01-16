<?php
ob_start();

require_once '../../includes/config.php';
require_once '../../includes/functions.php';

$id = intval($_POST['id']);

$sql = "SELECT * FROM sub_category WHERE id = '$id'";
$result = $conn->query($sql);


$main_categories = $conn->query("SELECT id, mcat_name FROM main_category ORDER BY mcat_name ASC")->fetch_all(MYSQLI_ASSOC);


if ($result && $result->num_rows > 0) {
    $category = $result->fetch_assoc();
?>
<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Sub Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" action="#" class="needs-validation" enctype="multipart/form-data" novalidate>
            <div class="modal-body">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="category_id" value="<?php echo (int) $category['id']; ?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="sub_category_name" value="<?php echo htmlspecialchars($category['scat_name']); ?>" required>
                        <div class="invalid-feedback">Please provide a category name.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Select Main Category</label>
                        <select class="form-select select2" id="main_category_name<?php echo $id; ?>" name="main_category_name[]" multiple required>
                            <option value="">Select Main Category</option>
                            <?php
                            $selectedParentCats = explode(',', $category['m_cat'] ?? '');
                            foreach ($main_categories as $m_category):
                            ?>
                                <option value="<?php echo htmlspecialchars($m_category['id']); ?>" <?php echo in_array($m_category['id'], $selectedParentCats) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($m_category['mcat_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Please select a main category.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="Active" <?php echo ($category['status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                            <option value="Inactive" <?php echo ($category['status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                        <div class="invalid-feedback">Please select a status.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" value="<?php echo htmlspecialchars($category['meta_title']); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Meta Keywords</label>
                        <textarea class="form-control" name="meta_keywords" rows="3"><?php echo htmlspecialchars($category['meta_keywords']); ?></textarea>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea class="form-control" name="meta_description" rows="3"><?php echo htmlspecialchars($category['meta_description']); ?></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?php
} else {
    echo "<div class='alert alert-warning'>Sub-category not found.</div>";
}

ob_end_flush();
?>
