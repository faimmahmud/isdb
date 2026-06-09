<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = $site['brand'] . ' | Luxury Tourism';
require_once __DIR__ . '/includes/header.php';
?>

<section class="hero-shell">
  <?php foreach ($heroSlides as $i => $slide): ?>
    <div class="hero-bg <?= $i === 0 ? 'active' : '' ?>" style="background-image:url('<?= e($slide['image']) ?>')"></div>
  <?php endforeach; ?>
  <div class="hero-gradient"></div>
  <div class="container hero-content">
    <div class="row align-items-center gy-4">
      <div class="col-lg-7">
        <span class="hero-kicker reveal">Premium travel • cinematic design • modern motion</span>
        <h1 class="hero-title mt-3 reveal"><?= e($heroSlides[0]['title']) ?></h1>
        <p class="hero-lead mt-3 reveal"><?= e($heroSlides[0]['subtitle']) ?></p>

        <form id="heroSearch" class="search-panel mt-4 reveal">
          <div class="input-group flex-grow-1">
            <span class="input-group-text border-0"><i class="bi bi-search"></i></span>
            <input id="searchInput" type="text" class="form-control" placeholder="Search destinations, tours, countries...">
          </div>
          <a href="<?= e(app_path('booking.php')) ?>" class="btn btn-gold px-4">Buy Ticket</a>
          <a href="#packages" class="btn btn-outline-dark px-4">View packages</a>
        </form>

        <div class="quick-book-strip reveal mt-3">
          <a class="quick-book-card" href="<?= e(app_path('booking.php')) ?>">
            <i class="bi bi-ticket-perforated"></i>
            <div>
              <strong>Buy ticket fast</strong>
              <span>Jump straight to booking</span>
            </div>
          </a>
          <a class="quick-book-card" href="<?= e(app_path('packages.php')) ?>">
            <i class="bi bi-layers"></i>
            <div>
              <strong>Choose a package</strong>
              <span>Full-screen tour cards</span>
            </div>
          </a>
          <a class="quick-book-card" href="<?= e(app_path('destinations.php')) ?>">
            <i class="bi bi-geo-alt"></i>
            <div>
              <strong>Explore destinations</strong>
              <span>Find the right vibe</span>
            </div>
          </a>
        </div>

        <div class="hero-meta mt-4 reveal">
          <?php foreach ($stats as $stat): ?>
            <div class="stat-card">
              <div class="value"><?= e($stat['value']) ?></div>
              <div class="label"><?= e($stat['label']) ?></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="surface rounded-5 p-4 reveal">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
              <div class="section-kicker">Featured journey</div>
              <h2 class="h3 fw-bold mb-0">One-image storytelling</h2>
            </div>
            <span class="badge-soft">Live</span>
          </div>
          <div class="full-hero-card">
            <div class="card-image" style="background-image:url('<?= e($heroSlides[1]['image']) ?>')"></div>
            <div class="content">
              <span class="eyebrow">Luxury arc design</span>
              <h3 class="mt-3"><?= e($heroSlides[1]['title']) ?></h3>
              <p class="mt-2 mb-4"><?= e($heroSlides[1]['subtitle']) ?></p>
              <div class="d-flex flex-wrap gap-2 meta">
                <span><i class="bi bi-globe2 me-1"></i> Worldwide</span>
                <span><i class="bi bi-stars me-1"></i> Premium curation</span>
                <span><i class="bi bi-mouse me-1"></i> Smooth interaction</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="arc-section arc-top">
  <div class="container">
    <div class="row align-items-end mb-4 gy-3">
      <div class="col-lg-8">
        <div class="section-kicker reveal">Featured tours</div>
        <h2 class="section-title reveal">Tour packages with a full-screen premium feel</h2>
        <p class="section-lead reveal">Large imagery, elegant typography, and feature-rich content laid out like a modern luxury brand rather than a basic grid.</p>
      </div>
      <div class="col-lg-4 text-lg-end reveal">
        <a class="btn btn-outline-dark rounded-pill px-4" href="<?= e(app_path('packages.php')) ?>">See all packages</a>
      </div>
    </div>

    <div class="d-grid gap-4">
      <?php foreach (array_slice($featuredTours, 0, 3) as $tour): ?>
        <article class="full-hero-card reveal" data-search="<?= e($tour['title'] . ' ' . $tour['category']) ?>">
          <div class="card-image" style="background-image:url('<?= e($tour['image']) ?>')"></div>
          <div class="content">
            <span class="eyebrow"><?= e(ucfirst($tour['category'])) ?> experience</span>
            <h3 class="mt-3"><?= e($tour['title']) ?></h3>
            <p class="mt-2"><?= e($tour['description']) ?></p>
            <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
              <span class="rating text-white"><i class="bi bi-star-fill text-warning"></i> <?= e($tour['rating']) ?></span>
              <span><i class="bi bi-calendar3 me-1"></i> <?= e($tour['days']) ?></span>
              <span class="price-chip bg-white text-dark"><?= e($tour['price']) ?></span>
            </div>
            <div class="feature-list mb-4">
              <?php foreach ($tour['features'] as $feature): ?>
                <span><?= e($feature) ?></span>
              <?php endforeach; ?>
            </div>
            <div>
              <a href="<?= e(app_path('booking.php')) ?>" class="btn btn-gold px-4 me-2">Book this journey</a>
              <a href="<?= e(app_path('destinations.php')) ?>" class="btn btn-outline-light px-4">View destinations</a>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="arc-section">
  <div class="container">
    <div class="row align-items-end mb-4 gy-3">
      <div class="col-lg-8">
        <div class="section-kicker reveal">Testimonials</div>
        <h2 class="section-title reveal">Trusted by travelers who value premium experiences</h2>
      </div>
    </div>

    <div id="testimonialsCarousel" class="carousel slide reveal" data-bs-ride="carousel">
      <div class="carousel-inner">
        <?php foreach ($testimonials as $index => $item): ?>
          <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
            <div class="testimonial-card">
              <div class="quotes-mark">“</div>
              <div class="row align-items-center g-4">
                <div class="col-md-2">
                  <img src="<?= e($item['image']) ?>" alt="<?= e($item['name']) ?>" class="avatar">
                </div>
                <div class="col-md-10">
                  <p class="quote mb-3"><?= e($item['quote']) ?></p>
                  <div class="fw-bold"><?= e($item['name']) ?></div>
                  <div class="text-muted"><?= e($item['role']) ?></div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
  </div>
</section>

<section class="arc-section">
  <div class="container">
    <div class="surface p-4 p-lg-5 rounded-5 reveal">
      <div class="row align-items-center gy-4">
        <div class="col-lg-7">
          <div class="section-kicker">Concierge</div>
          <h2 class="section-title mb-3">Built to feel like a luxury startup</h2>
          <p class="section-lead mb-0">Curved sections, layered glass effects, smooth micro-interactions, and image-led storytelling for every major page.</p>
        </div>
        <div class="col-lg-5 text-lg-end">
          <a href="<?= e(app_path('booking.php')) ?>" class="btn btn-gold px-4 me-2">Start booking</a>
          <a href="<?= e(app_path('world.php')) ?>" class="btn btn-outline-dark px-4">Explore the world</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
