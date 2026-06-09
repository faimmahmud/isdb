<?php
$pageTitle = "Packages — Royal Arc Tourism";
$pageClass = "page-packages";
include "includes/header.php";

$packages = [
  ["Grand Weekend", "$199", "Short luxury escape with boutique stay and guided sightseeing.", "Starter"],
  ["Royal Signature", "$599", "Balanced premium trip with transfers, planning, and refined support.", "Popular"],
  ["Palace Privilege", "$1299", "VIP-style travel with private routing and custom service layers.", "Elite"]
];
?>
<div class="container container-wide">
  <section class="page-hero reveal">
    <div class="page-card">
      <span class="eyebrow">Package system</span>
      <h1 class="mt-3">Luxury plans with clean order.</h1>
      <p class="lead mt-3 mb-0">
        The package page is designed more like a premium service catalog with strong hierarchy and simple conversion flow.
      </p>
    </div>
  </section>

  <section class="section-block reveal">
    <div class="row g-4">
      <?php foreach ($packages as [$name, $price, $desc, $feature]): ?>
        <div class="col-lg-4">
          <article class="feature-card h-100">
            <span class="badge text-bg-dark border border-light-subtle"><?= htmlspecialchars($feature) ?></span>
            <h3 class="mt-3"><?= htmlspecialchars($name) ?></h3>
            <p class="text-muted mt-3"><?= htmlspecialchars($desc) ?></p>
            <div class="d-flex align-items-end justify-content-between mt-4">
              <h2 class="mb-0"><?= htmlspecialchars($price) ?></h2>
              <a href="contact.php" class="btn btn-gold">Book Now</a>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="section-block reveal">
    <div class="timeline">
      <div class="timeline-item">
        <strong>Day 1</strong>
        <div>
          <h3>Arrival & royal check-in</h3>
          <p class="text-muted mt-2">Premium welcome, transfer coordination, and itinerary setup.</p>
        </div>
      </div>
      <div class="timeline-item">
        <strong>Day 2</strong>
        <div>
          <h3>Scenic exploration</h3>
          <p class="text-muted mt-2">Architectural route, calm pacing, and curated destination moments.</p>
        </div>
      </div>
      <div class="timeline-item">
        <strong>Day 3</strong>
        <div>
          <h3>Luxury finish</h3>
          <p class="text-muted mt-2">Private experiences, leisure time, and premium service close-out.</p>
        </div>
      </div>
    </div>
  </section>
</div>
<?php include "includes/footer.php"; ?>
