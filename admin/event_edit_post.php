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
$page_title = "Edit Event Post";
$active_menu = "event_posts";

// Initialize variables
$message = '';
$messageType = '';
$formData = [];
$postId = isset($_GET['id']) ? (int) $_GET['id'] : 0;


// Fetch Event Post data
$post = null;
if ($postId > 0) {
    $postSql = "SELECT * FROM event_posts WHERE id = ?";
    $stmt = $conn->prepare($postSql);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
        $formData = $post; // Pre-populate form with existing data
    } else {
        header("Location: event_posts.php?error=Post not found");
        exit;
    }
} else {
    header("Location: event_posts.php?error=Invalid post ID");
    exit;
}

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
    $imageName = $post['image']; // Keep existing image by default
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/uploads/events/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = $_FILES['featured_image']['name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($fileExt, $allowedExtensions)) {
            $newImageName = 'Event_' . time() . '_' . uniqid() . '.' . $fileExt;
            $uploadPath = $uploadDir . $newImageName;

            if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $uploadPath)) {
                // Delete old image if it exists
                if (!empty($post['image']) && file_exists($uploadDir . $post['image'])) {
                    unlink($uploadDir . $post['image']);
                }
                $imageName = $newImageName;
            } else {
                $errors[] = "Failed to upload image.";
            }
        } else {
            $errors[] = "Invalid image format. Allowed: JPG, JPEG, PNG, GIF, WebP.";
        }
    }

    // If no errors, update database
    if (empty($errors)) {
        try {
            // Update database
            $updateSql = "UPDATE event_posts SET title = ?, location = ?, description = ?, event_date = ?, image = ?, status = ?, updated_at = NOW() WHERE id = ?";

            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("ssssssi", $title, $location, $description, $eventDate, $imageName, $status, $postId);

            if ($stmt->execute()) {
                $message = "Event Post updated successfully!";
                $messageType = "success";

                // Refresh post data
                $postSql = "SELECT * FROM event_posts WHERE id = ?";
                $stmt = $conn->prepare($postSql);
                $stmt->bind_param("i", $postId);
                $stmt->execute();
                $result = $stmt->get_result();
                $post = $result->fetch_assoc();
                $formData = $post;

                // Redirect to prevent resubmission
                header("Location: event_edit_post.php?id=" . $postId . "&success=1");
                exit;
            } else {
                $errors[] = "Failed to update Event Post. Please try again.";
            }
        } catch (Exception $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }

    // Store form data for repopulation on error
    if (!empty($errors)) {
        $formData = array_merge($post, $_POST);
        $message = implode('<br>', $errors);
        $messageType = "danger";
    }
}

// Check for success message
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $message = "Event Post updated successfully!";
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
                <h1 class="h2">Edit Event Post</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="event_posts.php" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Posts
                        </a>
                        <a href="event_add_post.php" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-plus me-1"></i> Add New Post
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
                        action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $postId; ?>"
                        enctype="multipart/form-data" class="needs-validation" novalidate>

                        <!-- Event Details Card -->
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
                                            value="Draft" <?php echo ($formData['status'] === 'Draft') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="status_draft">
                                            <i class="fas fa-edit text-warning me-1"></i> Draft
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_published"
                                            value="Published" <?php echo ($formData['status'] === 'Published') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="status_published">
                                            <i class="fas fa-globe text-success me-1"></i> Published
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Update Event Post
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
                            <?php if (!empty($post['image'])): ?>
                                <div class="mb-3">
                                    <label class="form-label">Current Image</label>
                                    <div>
                                        <img src="../assets/uploads/events/<?php echo htmlspecialchars($post['image']); ?>"
                                            alt="Current featured image" class="img-fluid rounded"
                                            style="max-height: 200px;">
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <label for="featured_image" class="form-label">Upload New Image</label>
                                <input type="file" class="form-control" id="featured_image" name="featured_image"
                                    accept="image/*">
                                <input type="hidden" class="existing_image"
                                    value="../assets/uploads/events/<?php echo htmlspecialchars($post['image']); ?>" />
                                <div class="form-text">Leave empty to keep current image. Recommended size: 1200x630px.
                                    Max file size: 5MB.</div>
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

<!-- Include TinyMCE -->
<script src="https://cdn.tiny.cloud/1/r5jlbs90sue98amwj0ur2zlo39grg8cbd8g0dypglitvqd3e/tinymce/7/tinymce.min.js"
    referrerpolicy="origin"></script>

<!-- Include jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
    $(document).ready(function () {
        const postId = <?php echo $postId; ?>;

        // Initialize TinyMCE for Description
        tinymce.init({
            selector: '#description',
            height: 400,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body {font - family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px }',
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                    $('#description').trigger('blur'); // Trigger validation
                });
            }
        });

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
                submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i> Updating...').prop('disabled', true);

                // Submit form
                form.submit();
            }
        });

        // Auto-dismiss alerts
        setTimeout(function () {
            $('.alert').fadeOut();
        }, 5000);

        prePopulateImage()
        function prePopulateImage() {
            const fileInputs = document.querySelectorAll('input[type="file"]');

            fileInputs.forEach((fileInput) => {
                const existingImageInput = fileInput.parentElement.querySelector('.existing_image');
                if (existingImageInput) {
                    const existingFileUrl = existingImageInput.value;
                    if (existingFileUrl) {
                        fetch(existingFileUrl)
                            .then((response) => response.blob())
                            .then((blob) => {
                                const fileName = existingFileUrl.substring(
                                    existingFileUrl.lastIndexOf("/") + 1
                                );
                                const myFile = new File([blob], fileName, { type: blob.type });
                                const dataTransfer = new DataTransfer();
                                dataTransfer.items.add(myFile);

                                // 🔐 This line will NOT work in most browsers
                                fileInput.files = dataTransfer.files;

                                // Optional: Set file name as a data attribute (cosmetic use only)
                                fileInput.dataset.file = fileName;
                            })
                            .catch((error) => {
                                console.error("Error loading existing file:", error);
                            });
                    }
                }
            });
        }
    });

</script>