<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Countries | ' . $site['brand'];
require_once __DIR__ . '/includes/header.php';

$filters = ['all' => 'All', 'Europe' => 'Europe', 'Asia' => 'Asia', 'Africa' => 'Africa', 'Americas' => 'Americas', 'Middle East' => 'Middle East', 'Oceania' => 'Oceania'];
?>

<section class="hero-shell" style="min-height:80vh;">
  <div class="hero-bg active" style="background-image:url('<?= e(travel_img('countries-hero')) ?>');opacity:1"></div>
  <div class="hero-gradient"></div>
  <div class="container hero-content">
    <div class="row">
      <div class="col-lg-8">
        <span class="hero-kicker reveal">World atlas</span>
        <h1 class="hero-title mt-3 reveal text-animate" style="max-width:11ch;">Explore the world country by country</h1>
        <p class="hero-lead mt-3 reveal">A premium travel atlas with large cinematic country cards, subtle motion, and region filters.</p>
      </div>
    </div>
  </div>
</section>

<section class="arc-section arc-top">
  <div class="container">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
      <div>
        <div class="section-kicker reveal">Countries</div>
        <h2 class="section-title reveal text-animate">Every destination in one luxury view</h2>
      </div>
      <div class="pill-filter reveal">
        <?php foreach ($filters as $key => $label): ?>
          <button type="button" class="<?= $key === 'all' ? 'active' : '' ?>" data-filter="<?= e($key) ?>"><?= e($label) ?></button>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="d-grid gap-4">
      <?php foreach ($countries as $country): ?>
        <article class="country-card reveal" data-item="<?= e($country['region']) ?>" data-search="<?= e($country['name'] . ' ' . $country['region'] . ' ' . $country['reason']) ?>">
          <div class="country-image" style="background-image:url('<?= e($country['image']) ?>')"></div>
          <div class="country-content">
            <span class="badge-soft mb-3"><?= e($country['flag']) ?> • <?= e($country['region']) ?></span>
            <h4 class="display-6 text-animate"><?= e($country['name']) ?></h4>
            <p class="mb-4"><?= e($country['reason']) ?></p>
            <div class="d-flex flex-wrap gap-2">
              <a href="<?= e(app_path('booking.php')) ?>" class="btn btn-gold">Buy Ticket</a>
              <span class="price-chip text-dark bg-white">Travel now</span>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
