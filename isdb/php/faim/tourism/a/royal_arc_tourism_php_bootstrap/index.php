<?php
$pageTitle = "Royal Arc Tourism — OpenAI × World AI";
$pageClass = "page-home";
include "includes/header.php";

$features = [
  ["01", "Architectural Luxury", "Black-and-white luxury styling with royal gold accents and sculptural spacing."],
  ["02", "Soft Motion", "Subtle animation, floating geometry, and smooth reveal effects for a premium feel."],
  ["03", "User + Admin", "Separate user and admin spaces designed as distinct experience layers."]
];

$places = [
  ["g1", "Coastal Pearl", "Luxury waterfront escapes with calm premium energy."],
  ["g2", "Royal Heritage City", "Historic architecture with elegant city routes."],
  ["g3", "Velvet Mountain", "Quiet luxury in a refined alpine atmosphere."],
  ["g4", "Crystal Island", "Private retreat with soft sea views and polished service."]
];
?>
<div class="container container-wide">
  <section class="hero-shell reveal">
    <div class="hero-content">
      <div class="page-hero">
        <span class="eyebrow">Royal architecture tourism system</span>
        <h1 class="mt-3">Tourism built like a luxury monument.</h1>
        <p class="lead mt-4">
          A premium PHP + Bootstrap website concept inspired by royal collaboration aesthetics,
          with puzzle-style layouts, black/white contrast, gold refinement, and a professional
          architectural feel.
        </p>

        <div class="d-flex gap-2 flex-wrap mt-4">
          <a href="destinations.php" class="btn btn-gold">Explore Destinations</a>
          <a href="packages.php" class="btn btn-outline-light">View Packages</a>
        </div>
      </div>

      <div class="hero-grid">
        <div class="hero-panel glass-card animate-float">
          <h2>OpenAI × World AI</h2>
          <p class="text-white-50 mt-3">
            An elegant design language for a modern tourism brand that needs reputation, clarity,
            and a premium studio-level presentation.
          </p>

          <div class="row g-3 mt-4">
            <div class="col-4"><div class="metric"><strong>120+</strong><span>Routes</span></div></div>
            <div class="col-4"><div class="metric"><strong>4.9</strong><span>Rating</span></div></div>
            <div class="col-4"><div class="metric"><strong>24/7</strong><span>Support</span></div></div>
          </div>
        </div>

        <div class="hero-panel glass-card">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <small class="text-uppercase text-warning-emphasis">Featured experience</small>
              <h3 class="mt-2">Puzzle Royal Layout</h3>
            </div>
            <span class="badge text-bg-dark border border-secondary-subtle">Live</span>
          </div>

          <div class="puzzle-grid mt-4">
            <div class="puzzle span-7 animate-float-slow">
              <h3>Luxury Flow</h3>
              <p class="text-white-50 mt-2">Travel pages arranged like architectural modules.</p>
            </div>
            <div class="puzzle span-5">
              <h3>Royal Texture</h3>
              <p class="text-white-50 mt-2">Glass, shadow, and contrast across the interface.</p>
            </div>
            <div class="puzzle span-5">
              <h3>Smart Control</h3>
              <p class="text-white-50 mt-2">Admin and user spaces separated cleanly.</p>
            </div>
            <div class="puzzle span-7">
              <h3>Soft Motion</h3>
              <p class="text-white-50 mt-2">Elegant motion that feels premium, not noisy.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section-block reveal">
    <div class="section-head">
      <div>
        <span class="eyebrow">Core modules</span>
        <h2 class="mt-3">Professional features shaped for reputation.</h2>
      </div>
      <p>Each block uses a distinct presence so the site feels intentionally designed, not repeated.</p>
    </div>

    <div class="card-grid mt-4">
      <?php foreach ($features as [$no, $title, $text]): ?>
        <article class="feature-card">
          <div class="icon-badge"><?= htmlspecialchars($no) ?></div>
          <h3><?= htmlspecialchars($title) ?></h3>
          <p class="text-muted mt-3"><?= htmlspecialchars($text) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="section-block reveal">
    <div class="section-head">
      <div>
        <span class="eyebrow">Signature places</span>
        <h2 class="mt-3">Royal destinations with a cinematic touch.</h2>
      </div>
    </div>

    <div class="row g-4 mt-1">
      <?php foreach ($places as [$class, $title, $text]): ?>
        <div class="col-lg-3 col-md-6">
          <article class="gallery-card <?= $class ?>">
            <div class="shade"></div>
            <div class="copy">
              <span class="badge text-bg-light text-dark">Destination</span>
              <h3 class="mt-3"><?= htmlspecialchars($title) ?></h3>
              <p><?= htmlspecialchars($text) ?></p>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="section-block reveal">
    <div class="page-card">
      <div class="row align-items-center g-3">
        <div class="col-lg-8">
          <span class="eyebrow">User + Admin experience</span>
          <h2 class="mt-3">Two different control systems, one premium tourism brand.</h2>
          <p class="lead mt-3 mb-0">
            User panel for booking and trip tracking. Admin panel for management, analytics, and package control.
          </p>
        </div>
        <div class="col-lg-4 d-flex gap-2 justify-content-lg-end flex-wrap">
          <a href="user/dashboard.php" class="btn btn-outline-light">User Panel</a>
          <a href="admin/dashboard.php" class="btn btn-gold">Admin Panel</a>
        </div>
      </div>
    </div>
  </section>
</div>
<?php include "includes/footer.php"; ?>
