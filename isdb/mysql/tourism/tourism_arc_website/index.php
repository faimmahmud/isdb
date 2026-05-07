<?php
$pageTitle = 'Tourism Arc | Luxury Tourism Website';
require_once 'includes/db.php';
$packages = tourism_fetch_packages(6);
$destinations = tourism_fetch_all_destinations();
require_once 'includes/header.php';
?>

<section class="hero-section">
    <div class="hero-glow hero-glow-1"></div>
    <div class="hero-glow hero-glow-2"></div>
    <div class="container position-relative">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="eyebrow">Premium Tourism Experience</span>
                <h1 class="display-4 fw-extrabold mt-3 mb-3">Discover journeys with a sleek arc-style luxury design.</h1>
                <p class="lead text-muted mb-4">
                    Book stunning destinations, explore curated packages, and manage trips through a modern travel experience built for comfort and trust.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="packages.php" class="btn btn-glow btn-lg px-4">Explore Packages</a>
                    <a href="booking.php" class="btn btn-outline-light btn-lg px-4">Book Now</a>
                </div>

                <div class="search-panel mt-4">
                    <form class="row g-2">
                        <div class="col-md-5">
                            <input class="form-control form-control-lg" type="text" placeholder="Search destination">
                        </div>
                        <div class="col-md-4">
                            <select class="form-select form-select-lg">
                                <option>Travel Style</option>
                                <option>Beach</option>
                                <option>Nature</option>
                                <option>City</option>
                                <option>Adventure</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-grid">
                            <button class="btn btn-dark btn-lg">Search</button>
                        </div>
                    </form>
                </div>

                <div class="row g-3 mt-4 stats-row">
                    <div class="col-4">
                        <div class="stat-card">
                            <h3>120+</h3>
                            <p>Destinations</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-card">
                            <h3>4.9</h3>
                            <p>Average Rating</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-card">
                            <h3>24/7</h3>
                            <p>Support</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="hero-visual">
                    <div class="hero-card hero-card-main">
                        <img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1200&q=80" alt="Travel scene">
                        <div class="hero-card-overlay">
                            <span class="badge rounded-pill text-bg-warning mb-2">Arc Luxury</span>
                            <h4 class="mb-1">Smooth travel. Bold experiences.</h4>
                            <p class="mb-0">A premium visual system with layered curves, glass cards, and glowing accents.</p>
                        </div>
                    </div>
                    <div class="floating-chip chip-one"><i class="bi bi-calendar2-week me-2"></i>Easy booking</div>
                    <div class="floating-chip chip-two"><i class="bi bi-stars me-2"></i>Premium care</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">Featured Packages</span>
            <h2>Curated trips with modern card design</h2>
            <p>Use these cards for a premium tourism homepage, package page, or database-driven listing.</p>
        </div>

        <div class="row g-4">
            <?php foreach ($packages as $package): ?>
                <div class="col-md-6 col-xl-4">
                    <article class="tour-card reveal">
                        <div class="tour-thumb">
                            <img src="<?= htmlspecialchars($package['image']) ?>" alt="<?= htmlspecialchars($package['title']) ?>">
                            <span class="tour-badge"><?= htmlspecialchars($package['badge']) ?></span>
                        </div>
                        <div class="tour-body">
                            <div class="d-flex justify-content-between align-items-start gap-3">
                                <div>
                                    <h3 class="h5 mb-1"><?= htmlspecialchars($package['title']) ?></h3>
                                    <p class="text-muted mb-0"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($package['location']) ?></p>
                                </div>
                                <div class="text-end">
                                    <div class="rating"><i class="bi bi-star-fill"></i> <?= htmlspecialchars((string)$package['rating']) ?></div>
                                </div>
                            </div>
                            <p class="mt-3 text-muted"><?= htmlspecialchars($package['description']) ?></p>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div>
                                    <div class="small text-muted">From</div>
                                    <div class="price">৳<?= number_format((float)$package['price']) ?></div>
                                </div>
                                <a href="booking.php" class="btn btn-glow">Book</a>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section-pad section-soft">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-5">
                <div class="section-heading text-start mb-0">
                    <span class="eyebrow">Why choose us</span>
                    <h2>Designed for a premium travel experience</h2>
                    <p>Strong spacing, refined colors, gradient glow, and smooth motion create a luxury brand feel.</p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="feature-grid">
                    <div class="feature-card reveal"><i class="bi bi-lightning-charge-fill"></i><h4>Fast booking</h4><p>Simple forms and clear calls to action.</p></div>
                    <div class="feature-card reveal"><i class="bi bi-shield-check"></i><h4>Secure flow</h4><p>Clean PHP structure ready for auth and CRUD.</p></div>
                    <div class="feature-card reveal"><i class="bi bi-phone"></i><h4>Responsive</h4><p>Mobile-first layout with Bootstrap 5.</p></div>
                    <div class="feature-card reveal"><i class="bi bi-palette2"></i><h4>Arc design</h4><p>Curves, overlays, glows, and premium visual rhythm.</p></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">Popular Destinations</span>
            <h2>Explore the places in a neat card grid</h2>
        </div>

        <div class="row g-4">
            <?php foreach ($destinations as $destination): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="destination-card reveal">
                        <span class="destination-type"><?= htmlspecialchars($destination['type']) ?></span>
                        <h3 class="h5 mt-3"><?= htmlspecialchars($destination['name']) ?></h3>
                        <p class="text-muted mb-0"><?= htmlspecialchars($destination['description']) ?></p>
                        <div class="destination-footer mt-4">
                            <span><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($destination['country']) ?></span>
                            <a href="destinations.php">View</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section-pad section-soft">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">Testimonials</span>
            <h2>What travelers say</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-4"><div class="quote-card reveal"><p>“The interface feels premium, modern, and easy to understand.”</p><strong>— Ayesha</strong></div></div>
            <div class="col-lg-4"><div class="quote-card reveal"><p>“Great layout for a tourism project. The hero section is especially strong.”</p><strong>— Rahim</strong></div></div>
            <div class="col-lg-4"><div class="quote-card reveal"><p>“Perfect starter code for learning PHP, Bootstrap, and jQuery together.”</p><strong>— Farhan</strong></div></div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
