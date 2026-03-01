<?php

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login");
    exit;
}


require_once '../includes/config.php';
require_once '../includes/functions.php';

$success_message = '';
$error_message = '';
$case_study = null;


$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: case_studies_list.php');
    exit();
}


try {
    $stmt = $conn->prepare("SELECT * FROM case_studies WHERE id = ?");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $case_study = $result->fetch_assoc();

    if (!$case_study) {
        throw new Exception('Case study not found.');
    }

    $stmt->close();
}
catch (Exception $e) {
    $error_message = $e->getMessage();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && $case_study) {
    try {

        $title = sanitizeInput($_POST['title']);
        $introduction = $_POST['introduction'];
        $solution = $_POST['solution'];
        $result = $_POST['result'];
        $industry_segment = sanitizeInput($_POST['industry_segment']);
        $equipment = sanitizeInput($_POST['equipment']);
        $application = sanitizeInput($_POST['application']);
        $challenge = $_POST['challenge'];
        $expectation = $_POST['expectation'];
        $recommendation = $_POST['recommendation'];
        $benefits = $_POST['benefits'];
        $status = sanitizeInput($_POST['status']);


        if (empty($title) || empty($introduction)) {
            throw new Exception('Title,  and introduction are required fields.');
        }


        // Initialize with existing values to prevent overwriting with null if no new file is uploaded
        $case_study_img = $case_study['image'];
        $case_study_file = $case_study['case_study_file'];


        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $file_type = $_FILES['image']['type'];

            if (!in_array($file_type, $allowed_types)) {
                throw new Exception('Invalid image type. Only JPEG, PNG, GIF, and WebP are allowed.');
            }

            if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
                throw new Exception('Image file size must be less than 5MB.');
            }

            $upload_dir = '../assets/uploads/case_studies/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            // Remove old image if it exists
            if ($case_study['image']) {
                $old_image_path = $upload_dir . $case_study['image'];
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }

            $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = "case_studies_" . '_' . time() . '.' . $file_extension;
            $image_path = $upload_dir . $filename;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                throw new Exception('Failed to upload image.');
            }
            $case_study_img = $filename;
        }


        if (isset($_FILES['case_study_file']) && $_FILES['case_study_file']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            $file_type = $_FILES['case_study_file']['type'];

            if (!in_array($file_type, $allowed_types)) {
                throw new Exception('Invalid file type. Only PDF and Word documents are allowed.');
            }

            if ($_FILES['case_study_file']['size'] > 10 * 1024 * 1024) {
                throw new Exception('File size must be less than 10MB.');
            }

            $upload_dir = '../assets/uploads/case_studies/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            // Remove old file if it exists
            if ($case_study['case_study_file']) {
                $old_file_path = $upload_dir . $case_study['case_study_file'];
                if (file_exists($old_file_path)) {
                    unlink($old_file_path);
                }
            }

            $file_extension = pathinfo($_FILES['case_study_file']['name'], PATHINFO_EXTENSION);
            $filename = "case_studies_" . '_' . time() . '.' . $file_extension;
            $case_study_file_path = $upload_dir . $filename;

            if (!move_uploaded_file($_FILES['case_study_file']['tmp_name'], $case_study_file_path)) {
                throw new Exception('Failed to upload case study file.');
            }
            $case_study_file = $filename;
        }


        $slug = generateSlug($title);

        $sql = "UPDATE case_studies SET title = ?, slug = ?, introduction = ?, image = ?, solution = ?, 
                result = ?, case_study_file = ?, industry_segment = ?, equipment = ?, application = ?, 
                challenge = ?, expectation = ?, recommendation = ?, benefits = ?, status = ?, 
                updated_at = NOW() WHERE id = ?";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param(
            "sssssssssssssssi",
            $title,
            $slug,
            $introduction,
            $case_study_img,
            $solution,
            $result,
            $case_study_file,
            $industry_segment,
            $equipment,
            $application,
            $challenge,
            $expectation,
            $recommendation,
            $benefits,
            $status,
            $id
        );

        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        $success_message = 'Case study updated successfully!';
        // header("Location: " . $_SERVER['REQUEST_URI']);
        // exit;

        $stmt = $conn->prepare("SELECT * FROM case_studies WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $case_study = $result->fetch_assoc();
        $stmt->close();



        logActivity('case_study_edit', "Updated case study: $title");
    }
    catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="fas fa-edit me-2"></i>Edit Case Study</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="case_studies" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i>Back to List
                    </a>
                    <a href="case_studies_add.php" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i>Add New
                    </a>
                </div>
            </div>

            <?php if ($error_message && !$case_study): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo $error_message; ?>
                </div>
                <a href="case_studies_list.php" class="btn btn-primary">Back to List</a>
            <?php
elseif ($case_study): ?>

                <!-- Alert Container -->
                <div id="alertContainer"></div>

                <?php if ($success_message): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i><?php echo $success_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php
    endif; ?>

                <?php if ($error_message): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i><?php echo $error_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php
    endif; ?>

                <form id="caseStudyForm" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-lg-8">
                            <!-- Basic Information -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Basic Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            value="<?php echo $case_study['title']; ?>" required>
                                        <div class="invalid-feedback">Please provide a valid title.</div>
                                    </div>


                                    <div class="mb-3">
                                        <label for="introduction" class="form-label">Introduction <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control tinymce-editor" id="introduction" name="introduction"
                                            rows="4" required><?php echo $case_study['introduction']; ?></textarea>
                                        <div class="invalid-feedback">Please provide an introduction.</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Case Study Details -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="fas fa-clipboard-list me-2"></i>Case Study Details
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="challenge" class="form-label">Challenge</label>
                                        <textarea class="form-control tinymce-editor" id="challenge" name="challenge"
                                            rows="4"><?php echo $case_study['challenge']; ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="expectation" class="form-label">Expectation</label>
                                        <textarea class="form-control tinymce-editor" id="expectation" name="expectation"
                                            rows="4"><?php echo $case_study['expectation']; ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="solution" class="form-label">Solution</label>
                                        <textarea class="form-control tinymce-editor" id="solution" name="solution"
                                            rows="4"><?php echo $case_study['solution']; ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="result" class="form-label">Result</label>
                                        <textarea class="form-control tinymce-editor" id="result" name="result"
                                            rows="4"><?php echo $case_study['result']; ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="recommendation" class="form-label">Recommendation</label>
                                        <textarea class="form-control tinymce-editor" id="recommendation"
                                            name="recommendation"
                                            rows="4"><?php echo $case_study['recommendation']; ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="benefits" class="form-label">Benefits</label>
                                        <textarea class="form-control tinymce-editor" id="benefits" name="benefits"
                                            rows="4"><?php echo $case_study['benefits']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-lg-4">
                            <!-- Publish Settings -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="fas fa-cog me-2"></i>Publish Settings</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="statusActive"
                                                    value="Active" <?php echo $case_study['status'] === 'Active' ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="statusActive">
                                                    <i class="fas fa-eye text-success me-1"></i>Active
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status"
                                                    id="statusInactive" value="Inactive" <?php echo $case_study['status'] === 'Inactive' ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="statusInactive">
                                                    <i class="fas fa-eye-slash text-warning me-1"></i>Inactive
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary" id="submitBtn">
                                            <i class="fas fa-save me-2"></i>Update Case Study
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Industry & Equipment -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="fas fa-industry me-2"></i>Industry & Equipment
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="industry_segment" class="form-label">Industry Segment</label>
                                        <input type="text" class="form-control" id="industry_segment"
                                            name="industry_segment" value="<?php echo $case_study['industry_segment']; ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="equipment" class="form-label">Equipment</label>
                                        <input type="text" class="form-control" id="equipment" name="equipment"
                                            value="<?php echo $case_study['equipment']; ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="application" class="form-label">Application</label>
                                        <input type="text" class="form-control" id="application" name="application"
                                            value="<?php echo $case_study['application']; ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Media -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="fas fa-image me-2"></i>Media</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Featured Image</label>
                                        <?php if (!empty($case_study['image'])): ?>
                                            <div class="mb-2">
                                                <img src="<?php echo SITE_URL; ?>/assets/uploads/case_studies/<?php echo $case_study['image']; ?>"
                                                    alt="Current Image" class="img-thumbnail" style="max-width: 200px;">
                                                <div class="form-text text-success">
                                                    <i class="fas fa-check-circle me-1"></i>Current image present
                                                </div>
                                            </div>
                                        <?php
    else: ?>
                                            <div class="form-text text-muted mb-2">No image currently uploaded</div>
                                        <?php
    endif; ?>

                                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                        <div class="form-text">Leave empty to keep current image. Max size: 5MB. Formats:
                                            JPG, PNG, GIF, WebP</div>

                                        <div class="mt-2 text-center" style="display:none;" id="previewContainer">
                                            <p class="text-sm text-muted mb-1">New Image Preview:</p>
                                            <img id="imagePreview" src="" alt="Preview" class="img-thumbnail"
                                                style="max-width: 200px;">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="case_study_file" class="form-label">Case Study File</label>
                                        <?php if (!empty($case_study['case_study_file'])): ?>
                                            <div class="mb-2">
                                                <a href="<?php echo SITE_URL; ?>/assets/uploads/case_studies/<?php echo $case_study['case_study_file']; ?>"
                                                    target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-file-pdf me-1"></i>View Current File
                                                </a>
                                                <div class="form-text text-success mt-1">
                                                    <i class="fas fa-check-circle me-1"></i>Current file present
                                                </div>
                                            </div>
                                        <?php
    else: ?>
                                            <div class="form-text text-muted mb-2">No file currently uploaded</div>
                                        <?php
    endif; ?>

                                        <input type="file" class="form-control" id="case_study_file" name="case_study_file"
                                            accept=".pdf,.doc,.docx">
                                        <div class="form-text">Leave empty to keep current file. Max size: 10MB. Formats:
                                            PDF, DOC, DOCX</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            <?php
endif; ?>
        </main>
    </div>
</div>


<?php include 'includes/footer.php'; ?>

<script>
    $(document).ready(function () {

        tinymce.init({
            selector: '.tinymce-editor',
            height: 300,
            menubar: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            }
        });



        $('#image').on('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#imagePreview').attr('src', e.target.result);
                    $('#previewContainer').show();
                };
                reader.readAsDataURL(file);
            } else {
                $('#previewContainer').hide();
            }
        });


        $('#caseStudyForm').validate({
            rules: {
                title: {
                    required: true,
                    minlength: 3
                },

                introduction: {
                    required: true
                }
            },
            messages: {
                title: {
                    required: "Please enter a title",
                    minlength: "Title must be at least 3 characters"
                },

                introduction: {
                    required: "Please enter an introduction"
                }
            },
            submitHandler: function (form) {

                tinymce.triggerSave();


                $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Updating...');

                form.submit();
            }
        });



    });
</script>