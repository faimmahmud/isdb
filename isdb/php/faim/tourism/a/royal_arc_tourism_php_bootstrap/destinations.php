<?php
$pageTitle = "Destinations — Royal Arc Tourism";
$pageClass = "page-destinations";
include "includes/header.php";

$destinations = [
  ["g5", "Golden Coast Grand", "Luxury seaside route with a soft royal mood and premium stay."],
  ["g6", "White Heritage City", "Architectural trails with historical charm and curated city scenes."],
  ["g1", "Velvet Summit", "Mountain retreat with quiet atmosphere and refined views."],
  ["g2", "Mirror Lake Estate", "Calm waters, elegant paths, and private travel comfort."],
  ["g3", "Crystal Island Retreat", "Clean shoreline experiences with a premium leisure tone."],
  ["g4", "Royal Bazaar Heritage", "Cultural exploration with lively design and premium guidance."]
];
?>
<div class="container container-wide">
  <section class="page-hero reveal">
    <div class="page-card">
      <span class="eyebrow">Destination atlas</span>
      <h1 class="mt-3">A sculpted destination experience.</h1>
      <p class="lead mt-3 mb-0">
        This page uses a more architectural modular layout so each place feels like a premium exhibit.
      </p>
    </div>
  </section>

  <section class="section-block reveal">
    <div class="row g-4">
      <?php foreach ($destinations as [$class, $title, $text]): ?>
        <div class="col-lg-4 col-md-6">
          <article class="gallery-card <?= $class ?>">
            <div class="shade"></div>
            <div class="copy">
              <span class="badge text-bg-dark border border-light-subtle">Destination</span>
              <h3 class="mt-3"><?= htmlspecialchars($title) ?></h3>
              <p><?= htmlspecialchars($text) ?></p>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="section-block reveal">
    <div class="puzzle-grid">
      <div class="puzzle span-7">
        <h3>Travel design language</h3>
        <p class="text-muted mt-2">Strong contrast, clean alignment, and premium spacing for reputation and trust.</p>
      </div>
      <div class="puzzle span-5">
        <h3>Soft autoplay motion</h3>
        <p class="text-muted mt-2">Floating layers and subtle hover depth keep the page alive.</p>
      </div>
      <div class="puzzle span-4">
        <h3>White balance</h3>
        <p class="text-muted mt-2">Royal brightness and luxury clarity.</p>
      </div>
      <div class="puzzle span-4">
        <h3>Gold accent</h3>
        <p class="text-muted mt-2">Premium highlight used carefully.</p>
      </div>
      <div class="puzzle span-4">
        <h3>Architect flow</h3>
        <p class="text-muted mt-2">Structured like a gallery wall.</p>
      </div>
    </div>
  </section>
</div>
<?php include "includes/footer.php"; ?>
