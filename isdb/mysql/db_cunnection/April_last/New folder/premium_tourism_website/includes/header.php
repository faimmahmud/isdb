<?php require_once __DIR__ . '/db.php'; $flash = flash_get(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($page_title) ? e($page_title) . ' | ' : ''; ?>Arc Tour Luxe</title>
    <meta name="description" content="Luxury tourism website with premium UI, booking, packages, and admin dashboard.">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-white">
<nav class="navbar navbar-expand-lg navbar-light sticky-top glass-nav" id="siteNav">
    <div class="container">
        <a class="navbar-brand fw-black" href="index.php">
            <span class="brand-mark"><i class="fa-solid fa-paper-plane"></i></span>
            Arc Tour Luxe
        </a>
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="destinations.php">Destinations</a></li>
                <li class="nav-item"><a class="nav-link" href="packages.php">Tour Packages</a></li>
                <li class="nav-item"><a class="nav-link" href="booking.php">Booking</a></li>
                <?php if (is_logged_in()): ?>
                    <li class="nav-item"><span class="nav-link muted-link">Hi, <?php echo e($_SESSION['user']['name']); ?></span></li>
                    <?php if (is_admin()): ?>
                        <li class="nav-item"><a class="nav-link" href="admin/dashboard.php">Admin</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="btn btn-arc ms-lg-2" href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="btn btn-arc ms-lg-2" href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<?php if ($flash): ?>
<div class="container mt-3">
    <div class="alert alert-<?php echo e($flash['type']); ?> shadow-soft rounded-4 border-0">
        <?php echo e($flash['message']); ?>
    </div>
</div>
<?php endif; ?>
