<?php
require_once __DIR__ . '/functions.php';

$pageTitle = $pageTitle ?? 'Royal Atlas';
$bodyClass = $bodyClass ?? '';
$root = app_root();
$current = basename($_SERVER['SCRIPT_NAME'] ?? '');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Royal Atlas is a premium cinematic tourism website with luxury tour packages and curated destinations.">
    <title><?= e($pageTitle) ?> | Royal Atlas</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://unpkg.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $root ?>style.css" rel="stylesheet">
</head>
<body class="<?= e($bodyClass) ?>">
<div class="cursor-dot" aria-hidden="true"></div>
<div class="cursor-ring" aria-hidden="true"></div>

<nav class="navbar navbar-expand-lg fixed-top luxury-navbar" aria-label="Primary navigation">
    <div class="container-fluid px-3 px-lg-5">
        <a class="navbar-brand brand-mark" href="<?= $root ?>index.php">
            <span class="brand-sigil">RA</span>
            <span>Royal Atlas</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link <?= $current === 'index.php' ? 'active' : '' ?>" href="<?= $root ?>index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link <?= $current === 'destinations.php' ? 'active' : '' ?>" href="<?= $root ?>destinations.php">Destinations</a></li>
                <li class="nav-item"><a class="nav-link <?= $current === 'packages.php' ? 'active' : '' ?>" href="<?= $root ?>packages.php">Packages</a></li>
                <li class="nav-item"><a class="nav-link <?= $current === 'world.php' ? 'active' : '' ?>" href="<?= $root ?>world.php">World</a></li>
                <li class="nav-item"><a class="nav-link <?= $current === 'booking.php' ? 'active' : '' ?>" href="<?= $root ?>booking.php">Booking</a></li>
                <?php if (current_user()): ?>
                    <?php if (is_admin()): ?>
                        <li class="nav-item"><a class="nav-link <?= str_contains($_SERVER['SCRIPT_NAME'] ?? '', '/admin/') ? 'active' : '' ?>" href="<?= $root ?>admin/index.php">Admin</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="<?= $root ?>logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link <?= $current === 'login.php' ? 'active' : '' ?>" href="<?= $root ?>login.php">Login</a></li>
                <?php endif; ?>
                <li class="nav-item ms-lg-2">
                    <a class="btn btn-arc btn-sm magnetic" href="<?= $root ?>booking.php">
                        <i data-lucide="send"></i>
                        Plan Trip
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main>
