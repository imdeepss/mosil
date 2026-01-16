<?php
// Start session
session_start();

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit;
}
// echo password_hash("123456", PASSWORD_DEFAULT);
// Include configuration and functions
require_once '../includes/config.php';
require_once '../includes/functions.php';

$error = '';
// echo password_hash("123456", PASSWORD_DEFAULT);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        // Use helper function from functions.php (uses PDO)
        $sql = "SELECT * FROM admin_users WHERE email = ? LIMIT 1";
        $admin = db_query_one($sql, [$email]);

        if ($admin) {
            if (password_verify($password, $admin['password_hash'])) {
                // Set session variables
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_email'] = $admin['email'];
                $_SESSION['admin_role'] = $admin['role'];
                $_SESSION['admin_last_activity'] = time();

                // Update last login time
                $update_sql = "UPDATE admin_users SET last_login_at = NOW() WHERE id = ?";
                db_execute($update_sql, [$admin['id']]);

                header("Location: index.php");
                exit;
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Invalid email or password.";
        }
    }
}
// Database connection is handled by db.php included in config.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/__customs.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center px-0">
        <div class="row w-100 h-100">
            <!-- Left Side (Logo) -->
            <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center bg-yellow">
                <img src="./assets/images/logo.png" alt="Logo" class="img-fluid" style="max-width: 250px;">
            </div>

            <!-- Right Side (Login Form) -->
            <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center bg-white">
                <div class="w-100 p-4" style="max-width: 400px;">
                    <h1 class="h3 fw-bold mb-4">Admin Login</h1>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form id="loginForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="mb-3">
                            <label for="email" class="form-label">email:</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>

                    <div class="mt-3">
                        <small class="text-muted">Forgot your password?
                            <a href="<?php echo BASE_URL; ?>admin/forgot-password">Reset it here</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery Validation Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function () {
            // Form validation
            $("#loginForm").validate({
                rules: {
                    email: {
                        required: true,
                        minlength: 3
                    },
                    password: {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    email: {
                        required: "Please enter your email",
                        minlength: "email must be at least 3 characters"
                    },
                    password: {
                        required: "Please enter your password",
                        minlength: "Password must be at least 6 characters"
                    }
                },
                errorElement: "div",
                errorClass: "invalid-feedback",
                highlight: function (element) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function (element) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                },
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                }
            });
        });
    </script>
</body>

</html>