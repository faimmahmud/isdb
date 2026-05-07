<?php
$pageTitle = 'Luxury Travel Reimagined';
$bodyClass = 'home-page';
require_once __DIR__ . '/includes/header.php';

$featuredPackages = get_packages([], 4);
$featuredDestinations = get_destinations();
?>

<section class="hero-cinematic panel-full parallax-media" id="home">
    <img src="assets/images/destinations/maldives.webp" alt="Luxury overwater villa travel experience" loading="eager">
    <div class="hero-veil"></div>
    <div class="arc-orbit" aria-hidden="true"></div>
    <div class="container hero-content">
        <p class="eyebrow reveal">Bespoke private journeys</p>
        <h1 class="display-heading reveal">The world, composed like a masterpiece.</h1>
        <p class="hero-copy reveal">Royal Atlas designs cinematic escapes across islands, skylines, mountains, deserts, and heritage capitals.</p>
        <form class="destination-search glass-panel reveal" id="heroSearch">
            <div class="search-icon"><i data-lucide="search"></i></div>
            <input type="search" name="q" placeholder="Search Maldives, Dubai, Kyoto..." aria-label="Search destinations">
            <button class="btn btn-arc magnetic" type="submit">Discover</button>
            <div class="search-results" id="heroSearchResults" aria-live="polite"></div>
        </form>
    </div>
    <a class="scroll-cue" href="#featured" aria-label="Scroll to featured tours">
        <span></span>
    </a>
</section>

<section class="stats-ribbon" aria-label="Royal Atlas travel statistics">
    <div class="container">
        <div class="row g-3">
            <div class="col-6 col-lg-3">
                <div class="stat-card reveal">
                    <strong data-count="250">0</strong>
                    <span>Countries and territories</span>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card reveal">
                    <strong data-count="96">0</strong>
                    <span>Private guides</span>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card reveal">
                    <strong data-count="24">0</strong>
                    <span>Hour concierge</span>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card reveal">
                    <strong data-count="4.9">0</strong>
                    <span>Average client rating</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="featured" class="section-heading-wrap">
    <div class="container">
        <p class="eyebrow reveal">Featured journeys</p>
        <h2 class="section-heading reveal">One destination. One screen. Full emotion.</h2>
    </div>
</section>

<?php foreach ($featuredPackages as $index => $package): ?>
    <section class="story-panel panel-full parallax-media reveal">
        <img src="<?= e($package['image']) ?>" alt="<?= e($package['title']) ?>" loading="<?= $index === 0 ? 'eager' : 'lazy' ?>">
        <div class="panel-shade"></div>
        <div class="container">
            <div class="story-card glass-panel">
                <p class="eyebrow"><?= e($package['destination']) ?> · <?= e($package['duration']) ?></p>
                <h2><?= e($package['title']) ?></h2>
                <p><?= e($package['description']) ?></p>
                <div class="feature-pills">
                    <?php foreach (split_highlights($package['highlights']) as $highlight): ?>
                        <span><?= e($highlight) ?></span>
                    <?php endforeach; ?>
                </div>
                <div class="story-actions">
                    <span class="price-tag">$<?= number_format((float) $package['price']) ?></span>
                    <span class="rating"><i data-lucide="star"></i><?= e((string) $package['rating']) ?></span>
                    <a class="btn btn-arc magnetic" href="booking.php?package=<?= (int) $package['id'] ?>">Reserve</a>
                </div>
            </div>
        </div>
    </section>
<?php endforeach; ?>

<section class="testimonial-section panel-soft">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <p class="eyebrow reveal">Client voices</p>
                <h2 class="section-heading reveal">Designed quietly. Remembered forever.</h2>
            </div>
            <div class="col-lg-7">
                <div id="testimonialSlider" class="carousel slide reveal" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <blockquote class="testimonial-card glass-panel">
                                <p>Royal Atlas made the Maldives feel private, precise, and impossibly calm. Every detail had taste.</p>
                                <footer>Amara H. · Founder</footer>
                            </blockquote>
                        </div>
                        <div class="carousel-item">
                            <blockquote class="testimonial-card glass-panel">
                                <p>The Swiss route felt like a film: perfect pacing, beautiful hotels, and guides who knew when to disappear.</p>
                                <footer>Daniel K. · Investor</footer>
                            </blockquote>
                        </div>
                        <div class="carousel-item">
                            <blockquote class="testimonial-card glass-panel">
                                <p>Dubai was not just luxury. It was intelligent, fast, polished, and genuinely fun.</p>
                                <footer>Nadia R. · Creative Director</footer>
                            </blockquote>
                        </div>
                    </div>
                    <div class="slider-controls">
                        <button class="icon-btn magnetic" type="button" data-bs-target="#testimonialSlider" data-bs-slide="prev" aria-label="Previous testimonial">
                            <i data-lucide="arrow-left"></i>
                        </button>
                        <button class="icon-btn magnetic" type="button" data-bs-target="#testimonialSlider" data-bs-slide="next" aria-label="Next testimonial">
                            <i data-lucide="arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
