<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Include configuration and functions
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Page title
$page_title = "Add Event Post";
$active_menu = "event_add_post";

// Initialize variables
$message = '';
$messageType = '';
$formData = [];


// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $title = sanitizeInput($_POST['title'] ?? '');
    $location = sanitizeInput($_POST['location'] ?? '');
    $description = $_POST['description'] ?? ''; // Rich content
    $eventDate = sanitizeInput($_POST['event_date'] ?? '');
    $status = sanitizeInput($_POST['status'] ?? 'Draft');

    // Validation
    $errors = [];

    if (empty($title)) {
        $errors[] = "Title is required.";
    }

    if (empty($location)) {
        $errors[] = "Location is required.";
    }

    if (empty($description)) {
        $errors[] = "Description is required.";
    }

    if (empty($eventDate)) {
        $errors[] = "Event Date is required.";
    }

    if (!in_array($status, ['Draft', 'Published'])) {
        $errors[] = "Invalid status selected.";
    }

    // Handle image upload
    $imageName = '';
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/uploads/events/';
        $result = uploadAndConvertToWebp($_FILES['featured_image'], $uploadDir, 'Event');
        
        if ($result !== false) {
            $imageName = $result;
        } else {
            $errors[] = "Failed to upload or convert image. Allowed: JPG, JPEG, PNG, GIF, WebP.";
        }
    }

    // If no errors, save to database
    if (empty($errors)) {
        try {
            // Insert into database
            $insertSql = "INSERT INTO event_posts (title, location, description, event_date, image, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";

            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param("ssssss", $title, $location, $description, $eventDate, $imageName, $status);

            if ($stmt->execute()) {
                $message = "Event Post created successfully!";
                $messageType = "success";

                // Clear form data on success
                $formData = [];

                // Redirect to prevent resubmission
                header("Location: event_add_post.php?success=1");
                exit;
            } else {
                $errors[] = "Failed to save Event Post. Please try again.";
            }
        } catch (Exception $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }

    // Store form data for repopulation on error
    if (!empty($errors)) {
        $formData = $_POST;
        $message = implode('<br>', $errors);
        $messageType = "danger";
    }
}

// Check for success message
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $message = "Event Post created successfully!";
    $messageType = "success";
}
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Add New Event Post</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="event_posts.php" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Posts
                        </a>
                    </div>
                </div>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-lg-8">
                    <form id="EventPostForm" method="post"
                        action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data"
                        class="needs-validation" novalidate>

                        <!-- Basic Information Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Event Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        value="<?php echo htmlspecialchars($formData['title'] ?? ''); ?>" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid title.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="location" class="form-label">Location <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="location" name="location"
                                        value="<?php echo htmlspecialchars($formData['location'] ?? ''); ?>" required>
                                    <div class="invalid-feedback">
                                        Please provide a location.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="event_date" class="form-label">Event Date <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="event_date" name="event_date"
                                        value="<?php echo htmlspecialchars($formData['event_date'] ?? ''); ?>" required>
                                    <div class="invalid-feedback">
                                        Please provide the event date and time.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description" rows="15"
                                        required><?php echo htmlspecialchars($formData['description'] ?? ''); ?></textarea>
                                    <div class="invalid-feedback">
                                        Please provide an event description.
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>

                <div class="col-lg-4">
                    <!-- Publish Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Publish</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_draft"
                                            value="Draft" <?php echo (!isset($formData['status']) || $formData['status'] === 'Draft') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="status_draft">
                                            <i class="fas fa-edit text-warning me-1"></i> Draft
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_published"
                                            value="Published" <?php echo (isset($formData['status']) && $formData['status'] === 'Published') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="status_published">
                                            <i class="fas fa-globe text-success me-1"></i> Published
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Save Event Post
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Image</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="featured_image" class="form-label">Upload Image</label>
                                <input type="file" class="form-control" id="featured_image" name="featured_image"
                                    accept="image/*">
                                <div class="form-text">Recommended size: 1200x630px. Max file size: 5MB.</div>
                            </div>

                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <img id="previewImg" src="/placeholder.svg" alt="Preview" class="img-fluid rounded"
                                    style="max-height: 200px;">
                                <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="removeImage">
                                    <i class="fas fa-times me-1"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </form>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
    $(document).ready(function () {
        // Initialize TinyMCE for Description
        initTinyMCE('#description');

        // Image preview functionality
        $('#featured_image').on('change', function () {
            const file = this.files[0];
            if (file) {
                // Validate file size (5MB max)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size must be less than 5MB');
                    $(this).val('');
                    return;
                }

                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPEG, PNG, GIF, WebP)');
                    $(this).val('');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#previewImg').attr('src', e.target.result);
                    $('#imagePreview').show();
                };
                reader.readAsDataURL(file);
            }
        });

        // Remove image preview
        $('#removeImage').on('click', function () {
            $('#featured_image').val('');
            $('#imagePreview').hide();
            $('#previewImg').attr('src', '');
        });

        // Form validation
        $('#EventPostForm').validate({
            rules: {
                title: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                location: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                event_date: {
                    required: true
                },
                description: {
                    required: true,
                    minlength: 10
                }
            },
            messages: {
                title: {
                    required: "Please enter a title",
                    minlength: "Title must be at least 3 characters long"
                },
                location: {
                    required: "Please enter a location"
                },
                event_date: {
                    required: "Please select an event date"
                },
                description: {
                    required: "Please enter a description"
                }
            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            highlight: function (element) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function (element) {
                $(element).addClass('is-valid').removeClass('is-invalid');
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            submitHandler: function (form) {
                // Update TinyMCE content before submission
                tinymce.triggerSave();

                // Validate TinyMCE content
                const content = tinymce.get('description').getContent();
                if (content.length < 10) {
                    alert('Description must be at least 10 characters long');
                    return false;
                }

                // Show loading state
                const submitBtn = $(form).find('button[type="submit"]');
                submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i> Saving...').prop('disabled', true);

                // Submit form
                form.submit();
            }
        });

        // Auto-dismiss alerts
        setTimeout(function () {
            $('.alert').fadeOut();
        }, 5000);
    });
</script>