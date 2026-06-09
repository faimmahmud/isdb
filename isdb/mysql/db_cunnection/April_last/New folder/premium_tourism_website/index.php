<?php
$page_title = 'Home';
require_once __DIR__ . '/includes/header.php';

$featured = fetch_all("SELECT * FROM packages ORDER BY created_at DESC LIMIT 3");
$stats = [
    ['label' => 'Destinations', 'value' => 48, 'icon' => 'fa-map-location-dot'],
    ['label' => 'Packages', 'value' => site_stat_count('packages'), 'icon' => 'fa-suitcase-rolling'],
    ['label' => 'Bookings', 'value' => site_stat_count('bookings'), 'icon' => 'fa-calendar-check'],
    ['label' => 'Reviews', 'value' => 1200, 'icon' => 'fa-star'],
];
?>
<section class="hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 reveal">
                <span class="hero-badge mb-4"><i class="fa-solid fa-sparkles"></i> Luxury travel, reimagined</span>
                <h1 class="hero-title mb-4">Discover your next <span class="accent">arc</span> of adventure.</h1>
                <p class="lead text-muted mb-4">Premium tourism experiences with elegant design, curated destinations, and seamless booking flow.</p>

                <div class="search-panel mb-4">
                    <input class="form-control" type="text" placeholder="Destination">
                    <input class="form-control" type="date" placeholder="Travel date">
                    <select class="form-select">
                        <option>Adventure</option>
                        <option>Luxury</option>
                        <option>Family</option>
                        <option>Romantic</option>
                    </select>
                    <select class="form-select">
                        <option>2 Travelers</option>
                        <option>1 Traveler</option>
                        <option>4 Travelers</option>
                    </select>
                    <a href="packages.php" class="btn btn-arc">Search Tours</a>
                </div>

                <div class="d-flex flex-wrap gap-3">
                    <a href="packages.php" class="btn btn-arc">Explore Packages</a>
                    <a href="booking.php" class="btn btn-outline-arc">Book a Trip</a>
                </div>
            </div>

            <div class="col-lg-6 reveal">
                <div class="hero-visual">
                    <div class="arc-shape s1"></div>
                    <div class="arc-shape s2"></div>
                    <div class="arc-shape s3"></div>
                    <div class="floating-card card-1">
                        <div class="small text-muted">Starting from</div>
                        <div class="fw-bold fs-4">$299</div>
                        <div class="small text-muted">Luxury weekend escape</div>
                    </div>
                    <div class="floating-card card-2">
                        <div class="d-flex align-items-center gap-3">
                            <div class="feature-icon"><i class="fa-solid fa-star"></i></div>
                            <div>
                                <div class="fw-bold">4.9/5 Rating</div>
                                <div class="small text-muted">Loved by travelers</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pb-5">
    <div class="container">
        <div class="stats-grid">
            <?php foreach ($stats as $item): ?>
                <div class="stat-card reveal">
                    <div class="feature-icon mx-auto mb-3"><i class="fa-solid <?php echo e($item['icon']); ?>"></i></div>
                    <div class="stat-number"><?php echo e($item['value']); ?>+</div>
                    <p class="mb-0 text-muted"><?php echo e($item['label']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="hero-badge mb-3">Why choose us</span>
            <h2 class="section-title mb-3">Modern luxury, smooth booking, unforgettable journeys.</h2>
            <p class="section-subtitle mx-auto">Curated tours, elegant interfaces, and backend tools that make travel management feel effortless.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4 reveal">
                <div class="feature-card">
                    <div class="feature-icon mb-4"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                    <h4 class="fw-bold">Arc-style design</h4>
                    <p class="text-muted mb-0">Curved sections, layered cards, premium shadows, and polished motion for a futuristic feel.</p>
                </div>
            </div>
            <div class="col-md-4 reveal">
                <div class="feature-card">
                    <div class="feature-icon mb-4"><i class="fa-solid fa-bolt"></i></div>
                    <h4 class="fw-bold">Fast interactions</h4>
                    <p class="text-muted mb-0">Smooth scrolling, animated reveals, and AJAX-powered booking interactions with jQuery.</p>
                </div>
            </div>
            <div class="col-md-4 reveal">
                <div class="feature-card">
                    <div class="feature-icon mb-4"><i class="fa-solid fa-shield-halved"></i></div>
                    <h4 class="fw-bold">Secure backend</h4>
                    <p class="text-muted mb-0">Login, register, booking, and admin CRUD built in PHP and MySQL with prepared statements.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-pad bg-white">
    <div class="container">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4 reveal">
            <div>
                <span class="hero-badge mb-3">Featured tours</span>
                <h2 class="section-title mb-2">Curated packages with premium energy.</h2>
            </div>
            <a href="packages.php" class="btn btn-outline-arc">View all packages</a>
        </div>

        <div class="row g-4">
            <?php foreach ($featured as $pkg): ?>
                <div class="col-lg-4 col-md-6 reveal">
                    <div class="package-card h-100">
                        <div class="package-media">
                            <span class="package-badge"><?php echo e($pkg['category']); ?></span>
                            <img src="<?php echo e($pkg['image']); ?>" alt="<?php echo e($pkg['title']); ?>">
                            <div class="package-overlay"></div>
                        </div>
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h4 class="fw-bold mb-1"><?php echo e($pkg['title']); ?></h4>
                                    <div class="package-meta"><i class="fa-solid fa-location-dot me-1"></i><?php echo e($pkg['destination']); ?></div>
                                </div>
                                <div class="fw-black fs-4 text-end">$<?php echo e($pkg['price']); ?></div>
                            </div>
                            <div class="rating mb-3">
                                <?php
                                    $rating = (float)$pkg['rating'];
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo '<i class="fa-solid ' . ($i <= round($rating) ? 'fa-star' : 'fa-star-half-stroke') . '"></i>';
                                    }
                                ?>
                                <span class="ms-2 text-muted"><?php echo e($rating); ?>/5</span>
                            </div>
                            <p class="text-muted"><?php echo e($pkg['description']); ?></p>
                            <a href="booking.php?package_id=<?php echo (int)$pkg['id']; ?>" class="btn btn-arc w-100">Book this tour</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="hero-badge mb-3">Testimonials</span>
            <h2 class="section-title mb-3">What travelers say</h2>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="testimonial-card testimonial-item reveal">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img class="avatar" src="https://i.pravatar.cc/120?img=12" alt="Traveler 1">
                        <div>
                            <h5 class="mb-0 fw-bold">Ariana S.</h5>
                            <small class="text-muted">Luxury explorer</small>
                        </div>
                    </div>
                    <p class="mb-0 fs-5">“The design feels premium and the booking flow is incredibly smooth. It looks like a real high-end startup product.”</p>
                </div>

                <div class="testimonial-card testimonial-item reveal mt-3">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img class="avatar" src="https://i.pravatar.cc/120?img=32" alt="Traveler 2">
                        <div>
                            <h5 class="mb-0 fw-bold">Milan R.</h5>
                            <small class="text-muted">Family traveler</small>
                        </div>
                    </div>
                    <p class="mb-0 fs-5">“The UI looks clean, modern, and easy to navigate. The package cards and animations really stand out.”</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
