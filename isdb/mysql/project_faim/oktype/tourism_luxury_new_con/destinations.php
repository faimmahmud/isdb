<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Destinations | ' . $site['brand'];
require_once __DIR__ . '/includes/header.php';

$filters = ['all' => 'All', 'city' => 'City', 'beach' => 'Beach', 'nature' => 'Nature', 'mountain' => 'Mountain'];
?>
<section class="hero-shell" style="min-height:78vh;">
  <div class="hero-bg active" style="background-image:url('<?= e(travel_img('destinations-hero')) ?>');opacity:1"></div>
  <div class="hero-gradient"></div>
  <div class="container hero-content">
    <div class="row">
      <div class="col-lg-8">
        <span class="hero-kicker reveal">Destinations</span>
        <h1 class="hero-title mt-3 reveal" style="max-width:12ch;">Curated places with cinematic presentation</h1>
        <p class="hero-lead mt-3 reveal">A premium destinations page with full-width cards, smooth motion, and filters for every travel mood.</p>
      </div>
    </div>
  </div>
</section>

<section class="arc-section arc-top">
  <div class="container">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
      <div>
        <div class="section-kicker reveal">Browse by vibe</div>
        <h2 class="section-title reveal">Luxury destinations, one full view at a time</h2>
      </div>
      <div class="pill-filter reveal">
        <?php foreach ($filters as $key => $label): ?>
          <button type="button" class="<?= $key === 'all' ? 'active' : '' ?>" data-filter="<?= e($key) ?>"><?= e($label) ?></button>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="d-grid gap-4">
      <?php foreach ($destinations as $dest): ?>
        <article class="destination-card reveal" data-item="<?= e($dest['color']) ?>" data-search="<?= e($dest['name'] . ' ' . $dest['country'] . ' ' . $dest['tag']) ?>">
          <div class="destination-image" style="background-image:url('<?= e($dest['image']) ?>')"></div>
          <div class="destination-content">
            <span class="badge-soft mb-3"><?= e($dest['tag']) ?></span>
            <h4 class="display-6"><?= e($dest['name']) ?></h4>
            <p class="mb-4"><?= e($dest['summary']) ?></p>
            <div class="d-flex flex-wrap gap-2">
              <span class="price-chip text-dark bg-white"><?= e($dest['country']) ?></span>
              <a class="btn btn-gold" href="<?= e(app_path('booking.php')) ?>">Book a trip</a>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
