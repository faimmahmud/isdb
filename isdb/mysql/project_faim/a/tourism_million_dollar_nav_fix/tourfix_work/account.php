<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Account | ' . $site['brand'];
require_once __DIR__ . '/includes/header.php';
$currentUser = current_user();
?>

<section class="hero-shell" style="min-height:68vh;">
  <div class="hero-bg active" style="background-image:url('<?= e(travel_img('account-hero')) ?>');opacity:1"></div>
  <div class="hero-gradient"></div>
  <div class="container hero-content">
    <div class="row">
      <div class="col-lg-8">
        <span class="hero-kicker reveal">Account</span>
        <h1 class="hero-title mt-3 reveal text-animate" style="max-width:10ch;">Your travel profile</h1>
        <p class="hero-lead mt-3 reveal">Manage login access, booking status, and quick links to the premium travel pages from one place.</p>
      </div>
    </div>
  </div>
</section>

<section class="arc-section arc-top">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-7">
        <div class="surface p-4 p-lg-5 reveal">
          <div class="section-kicker">Profile</div>
          <h2 class="section-title mt-2 text-animate"><?= $currentUser ? e($currentUser['name'] ?? 'Traveller') : 'Sign in to unlock your account' ?></h2>
          <p class="section-lead">Use this area to reach bookings, preferences, and your travel access points quickly.</p>

          <?php if ($currentUser): ?>
            <div class="d-flex flex-wrap gap-2 mt-4">
              <span class="price-chip bg-light text-dark">Email: <?= e($currentUser['email'] ?? '') ?></span>
              <span class="price-chip bg-light text-dark">Role: <?= e($currentUser['role'] ?? 'user') ?></span>
            </div>
            <div class="mt-4 d-flex flex-wrap gap-2">
              <a href="<?= e(app_path('booking.php')) ?>" class="btn btn-gold">Go to booking</a>
              <a href="<?= e(app_path('logout.php')) ?>" class="btn btn-outline-dark">Logout</a>
            </div>
          <?php else: ?>
            <div class="mt-4 d-flex flex-wrap gap-2">
              <a href="<?= e(app_path('login.php')) ?>" class="btn btn-gold">Login</a>
              <a href="<?= e(app_path('register.php')) ?>" class="btn btn-outline-dark">Register</a>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="full-hero-card reveal" style="min-height:520px;">
          <div class="card-image" style="background-image:url('<?= e(travel_img('account-card')) ?>')"></div>
          <div class="content" style="min-height:520px;">
            <span class="eyebrow">Quick access</span>
            <h3 class="mt-3">Booking • Packages • Countries</h3>
            <p class="mt-2">A standard navigation flow for premium travel browsing and account access.</p>
            <div class="feature-list mb-4">
              <span>Secure login</span>
              <span>Fast booking</span>
              <span>Premium pages</span>
            </div>
            <a href="<?= e(app_path('booking.php')) ?>" class="btn btn-gold px-4">Buy Ticket</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
