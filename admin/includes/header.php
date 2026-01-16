<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME; ?></title>
    <!-- Bootstrap CSS (must come before DataTables) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome (safe to load early) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css">

    <!-- Your Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">

</head>

<body class="dark">
    <header class="navbar navbar-dark sticky-top bg-dark p-0 shadow">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <!-- Logo / Brand -->
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="./assets/images/logo.png" alt="Logo" width="100" height="30">
            </a>

            <!-- Toggler for Mobile (Sidebar) -->
            <button class="navbar-toggler d-md-none border-0 me-3" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- User Info & Sign Out -->
            <div class="d-flex align-items-center text-white me-3">
                <i class="bi bi-person-circle fs-5 me-2"></i>
                <span class="me-3">
                    <?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?>
                </span>
                <a class="btn btn-outline-light btn-sm" href="logout.php">Sign out</a>
            </div>
        </div>
    </header>