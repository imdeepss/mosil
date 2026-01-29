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
$page_title = "Add News Post";
$active_menu = "news_add_post";

// Initialize variables
$message = '';
$messageType = '';
$formData = [];


// Fetch News categories
$categories = [];
$categorySql = "SELECT id, name FROM news_categories ORDER BY name";
$categoryResult = $conn->query($categorySql);
if ($categoryResult && $categoryResult->num_rows > 0) {
    while ($row = $categoryResult->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Function to generate unique slug
function generateUniqueSlug($conn, $title, $excludeId = null)
{
    $baseSlug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    $baseSlug = trim($baseSlug, '-');

    $slug = $baseSlug;
    $counter = 1;

    while (true) {
        $checkSql = "SELECT id FROM news_posts WHERE slug = ?";
        if ($excludeId) {
            $checkSql .= " AND id != ?";
        }

        $stmt = $conn->prepare($checkSql);
        if ($excludeId) {
            $stmt->bind_param("si", $slug, $excludeId);
        } else {
            $stmt->bind_param("s", $slug);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            break;
        }

        $slug = $baseSlug . '-' . $counter;
        $counter++;
    }

    return $slug;
}

// Handle AJAX slug check
if (isset($_GET['action']) && $_GET['action'] === 'check_slug') {
    header('Content-Type: application/json');

    $slug = sanitizeInput($_GET['slug'] ?? '');
    $excludeId = isset($_GET['exclude_id']) ? (int) $_GET['exclude_id'] : null;

    if (empty($slug)) {
        echo json_encode(['available' => false, 'message' => 'Slug cannot be empty']);
        exit;
    }

    $checkSql = "SELECT id FROM news_posts WHERE slug = ?";
    if ($excludeId) {
        $checkSql .= " AND id != ?";
    }

    $stmt = $conn->prepare($checkSql);
    if ($excludeId) {
        $stmt->bind_param("si", $slug, $excludeId);
    } else {
        $stmt->bind_param("s", $slug);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Suggest alternative slug
        $suggestedSlug = generateUniqueSlug($conn, $slug, $excludeId);
        echo json_encode([
            'available' => false,
            'message' => 'Slug already exists',
            'suggested' => $suggestedSlug
        ]);
    } else {
        echo json_encode(['available' => true, 'message' => 'Slug is available']);
    }
    exit;
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $title = sanitizeInput($_POST['title'] ?? '');
    $slug = sanitizeInput($_POST['slug'] ?? '');
    $shortDescription = sanitizeInput($_POST['short_description'] ?? '');
    $content = $_POST['content'] ?? ''; // Don't sanitize rich content
    $categoryId = (int) ($_POST['category_id'] ?? 0);
    $tags = sanitizeInput($_POST['tags'] ?? '');
    $status = sanitizeInput($_POST['status'] ?? 'Draft');
    $metaTitle = sanitizeInput($_POST['meta_title'] ?? '');
    $metaDescription = sanitizeInput($_POST['meta_description'] ?? '');

    // Validation
    $errors = [];

    if (empty($title)) {
        $errors[] = "Title is required.";
    }

    if (empty($slug)) {
        $errors[] = "Slug is required.";
    } else {
        // Check if slug already exists
        $checkSlugSql = "SELECT id FROM news_posts WHERE slug = ?";
        $stmt = $conn->prepare($checkSlugSql);
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "Slug already exists. Please choose a different one.";
        }
    }

    if (empty($content)) {
        $errors[] = "Content is required.";
    }

    if ($categoryId <= 0) {
        $errors[] = "Please select a valid category.";
    }

    if (!in_array($status, ['Draft', 'Published'])) {
        $errors[] = "Invalid status selected.";
    }

    // Handle image upload
    $imageName = '';
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/uploads/news/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = $_FILES['featured_image']['name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($fileExt, $allowedExtensions)) {
            $imageName = 'News_' . time() . '_' . uniqid() . '.' . $fileExt;
            $uploadPath = $uploadDir . $imageName;

            if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $uploadPath)) {
                $errors[] = "Failed to upload image.";
                $imageName = '';
            }
        } else {
            $errors[] = "Invalid image format. Allowed: JPG, JPEG, PNG, GIF, WebP.";
        }
    }

    // If no errors, save to database
    if (empty($errors)) {
        try {
            // Insert into database
            $insertSql = "INSERT INTO news_posts (title, slug, short_description, content, image, category_id, tags, status, meta_title, meta_description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param("sssssissss", $title, $slug, $shortDescription, $content, $imageName, $categoryId, $tags, $status, $metaTitle, $metaDescription);

            if ($stmt->execute()) {
                $message = "News Post created successfully!";
                $messageType = "success";

                // Clear form data on success
                $formData = [];

                // Redirect to prevent resubmission
                header("Location: news_add_post.php?success=1");
                exit;
            } else {
                $errors[] = "Failed to save News Post. Please try again.";
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
    $message = "News Post created successfully!";
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
                <h1 class="h2">Add New News Post</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="news_posts.php" class="btn btn-sm btn-outline-secondary">
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
                    <form id="NewsPostForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                        enctype="multipart/form-data" class="needs-validation" novalidate>

                        <!-- Basic Information Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Basic Information</h5>
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
                                    <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="slug" name="slug"
                                            value="<?php echo htmlspecialchars($formData['slug'] ?? ''); ?>" required>
                                        <button type="button" class="btn btn-outline-secondary" id="generateSlug">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </div>
                                    <div id="slugFeedback" class="form-text"></div>
                                    <div class="invalid-feedback">
                                        Please provide a valid slug.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="short_description" class="form-label">Short Description</label>
                                    <textarea class="form-control" id="short_description" name="short_description"
                                        rows="3"
                                        placeholder="Brief description of the News Post..."><?php echo htmlspecialchars($formData['short_description'] ?? ''); ?></textarea>
                                    <div class="form-text">This will be used as excerpt in News listings.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="form-label">Content <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="content" name="content" rows="15"
                                        required><?php echo htmlspecialchars($formData['content'] ?? ''); ?></textarea>
                                    <div class="invalid-feedback">
                                        Please provide News content.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Information Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">SEO Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input type="text" class="form-control" id="meta_title" name="meta_title"
                                        value="<?php echo htmlspecialchars($formData['meta_title'] ?? ''); ?>"
                                        maxlength="60">
                                    <div class="form-text">Recommended length: 50-60 characters. Leave empty to use post
                                        title.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description"
                                        rows="3" maxlength="160"
                                        placeholder="Brief description for search engines..."><?php echo htmlspecialchars($formData['meta_description'] ?? ''); ?></textarea>
                                    <div class="form-text">Recommended length: 150-160 characters.</div>
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
                                    <i class="fas fa-save me-1"></i> Save News Post
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Category Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Category</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Select Category <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Choose a category...</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['id']; ?>" <?php echo (isset($formData['category_id']) && $formData['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a category.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tags Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Tags</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                <input type="text" class="form-control" id="tags" name="tags"
                                    value="<?php echo htmlspecialchars($formData['tags'] ?? ''); ?>"
                                    placeholder="technology, web development, php">
                                <div class="form-text">Separate tags with commas.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Featured Image</h5>
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

<!-- Include TinyMCE -->
<script src="https://cdn.tiny.cloud/1/r5jlbs90sue98amwj0ur2zlo39grg8cbd8g0dypglitvqd3e/tinymce/7/tinymce.min.js"
    referrerpolicy="origin"></script>

<!-- Include jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
    $(document).ready(function () {
        let slugCheckTimeout;

        // Initialize TinyMCE
        tinymce.init({
            selector: '#content',
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
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px }',
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                    $('#content').trigger('blur'); // Trigger validation
                });
            }
        });

        // Auto-generate slug from title
        function generateSlug(text) {
            return text
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '') // Remove special characters
                .replace(/[\s_-]+/g, '-') // Replace spaces and underscores with hyphens
                .replace(/^-+|-+$/g, ''); // Remove leading/trailing hyphens
        }

        // Check slug availability
        function checkSlugAvailability(slug) {
            if (!slug) {
                $('#slugFeedback').html('').removeClass('text-success text-danger text-warning');
                return;
            }

            $('#slugFeedback').html('<i class="fas fa-spinner fa-spin"></i> Checking availability...').removeClass('text-success text-danger text-warning').addClass('text-info');

            $.get('news_add_post.php', {
                action: 'check_slug',
                slug: slug
            })
                .done(function (response) {
                    if (response.available) {
                        $('#slugFeedback').html('<i class="fas fa-check text-success"></i> ' + response.message).removeClass('text-info text-danger text-warning').addClass('text-success');
                        $('#slug').removeClass('is-invalid').addClass('is-valid');
                    } else {
                        let message = '<i class="fas fa-times text-danger"></i> ' + response.message;
                        if (response.suggested) {
                            message += ' <button type="button" class="btn btn-sm btn-outline-primary ms-2" onclick="useSuggestedSlug(\'' + response.suggested + '\')">Use: ' + response.suggested + '</button>';
                        }
                        $('#slugFeedback').html(message).removeClass('text-info text-success text-warning').addClass('text-danger');
                        $('#slug').removeClass('is-valid').addClass('is-invalid');
                    }
                })
                .fail(function () {
                    $('#slugFeedback').html('<i class="fas fa-exclamation-triangle text-warning"></i> Error checking slug availability').removeClass('text-info text-success text-danger').addClass('text-warning');
                });
        }

        // Use suggested slug
        window.useSuggestedSlug = function (suggestedSlug) {
            $('#slug').val(suggestedSlug);
            checkSlugAvailability(suggestedSlug);
        };

        // Auto-generate slug from title
        $('#title').on('input', function () {
            const title = $(this).val();
            const slug = generateSlug(title);
            $('#slug').val(slug);

            // Clear previous timeout
            clearTimeout(slugCheckTimeout);

            // Check slug availability after 500ms delay
            slugCheckTimeout = setTimeout(function () {
                checkSlugAvailability(slug);
            }, 500);
        });

        // Manual slug input
        $('#slug').on('input', function () {
            const slug = $(this).val();

            // Clear previous timeout
            clearTimeout(slugCheckTimeout);

            // Check slug availability after 500ms delay
            slugCheckTimeout = setTimeout(function () {
                checkSlugAvailability(slug);
            }, 500);
        });

        // Generate slug button
        $('#generateSlug').on('click', function () {
            const title = $('#title').val();
            if (title) {
                const slug = generateSlug(title);
                $('#slug').val(slug);
                checkSlugAvailability(slug);
            } else {
                alert('Please enter a title first');
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
        $('#NewsPostForm').validate({
            rules: {
                title: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                slug: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                content: {
                    required: true,
                    minlength: 50
                },
                category_id: {
                    required: true,
                    min: 1
                },
                meta_title: {
                    maxlength: 60
                },
                meta_description: {
                    maxlength: 160
                },
                tags: {
                    maxlength: 500
                }
            },
            messages: {
                title: {
                    required: "Please enter a News title",
                    minlength: "Title must be at least 3 characters long",
                    maxlength: "Title cannot exceed 255 characters"
                },
                slug: {
                    required: "Please enter a slug",
                    minlength: "Slug must be at least 3 characters long",
                    maxlength: "Slug cannot exceed 255 characters"
                },
                content: {
                    required: "Please enter News content",
                    minlength: "Content must be at least 50 characters long"
                },
                category_id: {
                    required: "Please select a category",
                    min: "Please select a valid category"
                },
                meta_title: {
                    maxlength: "Meta title cannot exceed 60 characters"
                },
                meta_description: {
                    maxlength: "Meta description cannot exceed 160 characters"
                },
                tags: {
                    maxlength: "Tags cannot exceed 500 characters"
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
                const content = tinymce.get('content').getContent();
                if (content.length < 50) {
                    alert('Content must be at least 50 characters long');
                    return false;
                }

                // Check if slug is valid
                if ($('#slug').hasClass('is-invalid')) {
                    alert('Please fix the slug before submitting');
                    return false;
                }

                // Show loading state
                const submitBtn = $(form).find('button[type="submit"]');
                const originalText = submitBtn.html();
                submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i> Saving...').prop('disabled', true);

                // Submit form
                form.submit();
            }
        });

        // Character counter for meta fields
        function updateCharCounter(inputId, counterId, maxLength) {
            const input = $('#' + inputId);
            const counter = $('#' + counterId);

            input.on('input', function () {
                const currentLength = $(this).val().length;
                const remaining = maxLength - currentLength;
                counter.text(remaining + ' characters remaining');

                if (remaining < 0) {
                    counter.addClass('text-danger').removeClass('text-muted');
                } else if (remaining < 10) {
                    counter.addClass('text-warning').removeClass('text-danger text-muted');
                } else {
                    counter.addClass('text-muted').removeClass('text-danger text-warning');
                }
            });
        }

        // Add character counters
        $('#meta_title').after('<div id="meta_title_counter" class="form-text text-muted">60 characters remaining</div>');
        $('#meta_description').after('<div id="meta_description_counter" class="form-text text-muted">160 characters remaining</div>');

        updateCharCounter('meta_title', 'meta_title_counter', 60);
        updateCharCounter('meta_description', 'meta_description_counter', 160);

        // Auto-dismiss alerts
        setTimeout(function () {
            $('.alert').fadeOut();
        }, 5000);
    });
</script>