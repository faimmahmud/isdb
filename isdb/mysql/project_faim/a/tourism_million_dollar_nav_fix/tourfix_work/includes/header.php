<?php
require_once __DIR__ . '/functions.php';
ensure_storage();

$pageTitle = $pageTitle ?? $site['brand'];
$currentUser = current_user();
$flash = flash_get();
$currentPath = basename(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: ($_SERVER['SCRIPT_NAME'] ?? 'index.php'));
if ($currentPath === '') { $currentPath = 'index.php'; }

function nav_active(string $file, string $currentPath): string {
    return $currentPath === $file ? 'active' : '';
}
?>
<!doctype html>
<html lang="en" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?></title>
  <meta name="description" content="Luxury tourism platform with full-screen visuals, premium motion, and secure file-based architecture.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= e(asset('assets/css/style.css')) ?>">
</head>
<body class="lux-body">
<div class="lux-cursor" aria-hidden="true"></div>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top luxury-nav">
  <div class="container-fluid px-4 px-lg-5">
    <a class="navbar-brand fw-black text-uppercase letter-wide" href="<?= e(app_path('index.php')) ?>"><?= e($site['brand']) ?></a>
    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#topNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="topNav">
      <ul class="navbar-nav mx-auto gap-lg-2">
        <li class="nav-item"><a class="nav-link <?= nav_active('index.php', $currentPath) ?>" href="<?= e(app_path('index.php')) ?>">Home</a></li>
        <li class="nav-item"><a class="nav-link <?= nav_active('destinations.php', $currentPath) ?>" href="<?= e(app_path('destinations.php')) ?>">Destinations</a></li>
        <li class="nav-item"><a class="nav-link <?= nav_active('packages.php', $currentPath) ?>" href="<?= e(app_path('packages.php')) ?>">Packages</a></li>
        <li class="nav-item"><a class="nav-link <?= nav_active('countries.php', $currentPath) ?>" href="<?= e(app_path('countries.php')) ?>">Countries</a></li>
        <li class="nav-item"><a class="nav-link <?= nav_active('account.php', $currentPath) ?>" href="<?= e(app_path('account.php')) ?>">Account</a></li>
        <li class="nav-item"><a class="nav-link <?= nav_active('booking.php', $currentPath) ?>" href="<?= e(app_path('booking.php')) ?>">Booking</a></li>
      </ul>
      <div class="d-flex gap-2 align-items-center">
        <?php if ($currentUser): ?>
          <div class="nav-user">
            <span class="small text-white-50">Welcome</span>
            <strong class="d-block"><?= e($currentUser['name'] ?? '') ?></strong>
          </div>
          <a class="btn btn-outline-light btn-sm rounded-pill px-3" href="<?= e(app_path('logout.php')) ?>">Logout</a>
        <?php else: ?>
          <a class="btn btn-outline-light btn-sm rounded-pill px-3" href="<?= e(app_path('login.php')) ?>">Login</a>
          <a class="btn btn-gold btn-sm rounded-pill px-3" href="<?= e(app_path('register.php')) ?>">Register</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<main>

<?php if ($flash): ?>
<div class="lux-toast-stack position-fixed top-0 end-0 p-3">
  <div class="toast lux-toast show align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body d-flex align-items-start gap-3">
      <div class="toast-icon"><i class="bi bi-stars"></i></div>
      <div class="flex-grow-1">
        <div class="toast-title text-uppercase"><?= e($flash['type']) ?></div>
        <div class="toast-message"><?= e($flash['message']) ?></div>
      </div>
      <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
<?php endif; ?>
