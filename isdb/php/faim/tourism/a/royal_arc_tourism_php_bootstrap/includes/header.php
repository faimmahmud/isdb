<?php
if (!isset($pageTitle)) $pageTitle = "Royal Arc Tourism";
if (!isset($pageClass)) $pageClass = "page-default";

$current = basename($_SERVER['PHP_SELF']);
$nav = [
  ["Home", "index.php"],
  ["Destinations", "destinations.php"],
  ["Packages", "packages.php"],
  ["Gallery", "gallery.php"],
  ["Contact", "contact.php"]
];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body class="<?= htmlspecialchars($pageClass) ?>">
  <div class="royal-noise"></div>

  <nav class="navbar navbar-expand-lg navbar-dark sticky-top royal-nav">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
        <span class="brand-mark">RA</span>
        <span>
          <strong class="d-block brand-title">Royal Arc Tourism</strong>
          <small class="brand-subtitle">OpenAI × World AI × Royal Architecture</small>
        </span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
          <?php foreach ($nav as [$label, $href]): ?>
            <li class="nav-item">
              <a class="nav-link <?= $current === basename($href) ? 'active' : '' ?>" href="<?= $href ?>"><?= $label ?></a>
            </li>
          <?php endforeach; ?>
          <li class="nav-item ms-lg-2">
            <a class="btn btn-sm btn-outline-light royal-pill" href="user/dashboard.php">User Panel</a>
          </li>
          <li class="nav-item ms-lg-2">
            <a class="btn btn-sm btn-gold royal-pill" href="admin/dashboard.php">Admin Panel</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main>
