<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Booking | ' . $site['brand'];
require_once __DIR__ . '/includes/header.php';

$selectedPackage = $_GET['package'] ?? '';
?>

<section class="hero-shell" style="min-height:72vh;">
  <div class="hero-bg active" style="background-image:url('<?= e(travel_img('booking-hero')) ?>');opacity:1"></div>
  <div class="hero-gradient"></div>
  <div class="container hero-content">
    <div class="row">
      <div class="col-lg-8">
        <span class="hero-kicker reveal">Booking</span>
        <h1 class="hero-title mt-3 reveal text-animate" style="max-width:11ch;">Reserve your next premium journey</h1>
        <p class="hero-lead mt-3 reveal">Fast form, clean validation, and a polished booking flow designed to feel premium and modern.</p>
      </div>
    </div>
  </div>
</section>

<section class="arc-section arc-top" id="booking">
  <div class="container">
    <div class="row g-4 align-items-stretch">
      <div class="col-lg-5">
        <div class="full-hero-card reveal" style="min-height:100%; min-height:560px;">
          <div class="card-image" style="background-image:url('<?= e(travel_img('booking-side')) ?>')"></div>
          <div class="content">
            <span class="eyebrow">Concierge support</span>
            <h3 class="mt-3">Smooth, premium, and ready to convert.</h3>
            <p class="mt-2">The entire booking experience is built to feel like a luxury brand contact point rather than a plain form.</p>
            <div class="feature-list">
              <span>AJAX submit</span>
              <span>Validation</span>
              <span>Fast response</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="form-shell p-4 p-lg-5 reveal">
          <div class="section-kicker">Booking form</div>
          <h2 class="section-title mb-3 text-animate">Plan your travel in one step</h2>
          <div id="bookingSuccess" class="alert alert-success d-none"></div>
          <div id="bookingError" class="alert alert-danger d-none"></div>
          <form id="bookingForm" action="<?= e(app_path('includes/booking-submit.php')) ?>" method="post" class="row g-3">
            <?= csrf_field() ?>
            <div class="col-12">
              <label class="form-label">Package name</label>
              <input type="text" name="package" class="form-control" value="<?= e($selectedPackage) ?>" placeholder="Choose a package" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Full name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Phone</label>
              <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Travel date</label>
              <input type="date" name="date" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Travelers</label>
              <input type="number" min="1" name="people" class="form-control" value="2">
            </div>
            <div class="col-12">
              <label class="form-label">Message</label>
              <textarea name="message" rows="5" class="form-control" placeholder="Any special request?"></textarea>
            </div>
            <div class="col-12 d-flex flex-wrap gap-2">
              <button type="submit" class="btn btn-gold px-4">Submit booking</button>
              <a href="<?= e(app_path('packages.php')) ?>" class="btn btn-outline-dark px-4">Browse packages</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
