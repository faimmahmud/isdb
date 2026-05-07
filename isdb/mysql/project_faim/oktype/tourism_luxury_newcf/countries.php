<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Countries Atlas | ' . $site['brand'];
require_once __DIR__ . '/includes/header.php';
?>
<section class="hero-shell" style="min-height:76vh;">
  <div class="hero-bg active" style="background-image:url('<?= e(travel_img('world-hero')) ?>');opacity:1"></div>
  <div class="hero-gradient"></div>
  <div class="container hero-content">
    <div class="row">
      <div class="col-lg-8">
        <span class="hero-kicker reveal">Countries Atlas</span>
        <h1 class="hero-title mt-3 reveal" style="max-width:11ch;">World travel in a royal full-screen view</h1>
        <p class="hero-lead mt-3 reveal">A premium country explorer built for luxury travel marketing, with large cinematic imagery and elegant booking prompts.</p>
        <div class="booking-shortcuts reveal">
          <a href="<?= e(app_path('booking.php')) ?>" class="shortcut-chip"><i class="bi bi-airplane"></i> Book Flight</a>
          <a href="<?= e(app_path('booking.php')) ?>" class="shortcut-chip"><i class="bi bi-ticket-perforated"></i> Buy Ticket</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="country-atlas">
  <div class="container">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
      <div>
        <div class="section-kicker reveal">Featured countries</div>
        <h2 class="section-title reveal">World travel collection</h2>
      </div>
      <div class="pill-filter reveal">
        <button type="button" class="active" data-filter="all">All</button>
        <button type="button" data-filter="Europe">Europe</button>
        <button type="button" data-filter="Asia">Asia</button>
        <button type="button" data-filter="Africa">Africa</button>
        <button type="button" data-filter="Americas">Americas</button>
      </div>
    </div>

    <div class="atlas-grid">
      <?php foreach ($countries as $country): ?>
        <article class="atlas-card country-card reveal" data-item="<?= e($country['region']) ?>" data-search="<?= e($country['name'] . ' ' . $country['region'] . ' ' . $country['reason']) ?>">
          <div class="atlas-image country-image" style="background-image:url('<?= e($country['image']) ?>')"></div>
          <div class="atlas-content country-content">
            <span class="badge-soft mb-3"><?= e($country['flag']) ?> • <?= e($country['region']) ?></span>
            <h4 class="display-6"><?= e($country['name']) ?></h4>
            <p class="mb-4"><?= e($country['reason']) ?></p>
            <div class="d-flex flex-wrap gap-2">
              <a href="<?= e(app_path('booking.php')) ?>" class="btn btn-ticket">Buy Ticket</a>
              <span class="price-chip text-dark bg-white">Scenic views</span>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
