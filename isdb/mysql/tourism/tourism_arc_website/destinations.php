<?php
$pageTitle = 'Destinations | Tourism Arc';
require_once 'includes/db.php';
$destinations = tourism_fetch_all_destinations();
require_once 'includes/header.php';
?>

<section class="page-hero page-hero-destination">
    <div class="container">
        <span class="eyebrow">Destinations</span>
        <h1 class="display-5 fw-bold mt-3">Search and explore elegant travel spots</h1>
        <p class="text-muted col-lg-7">A clean destination page with filter-ready cards and a premium visual style.</p>
    </div>
</section>

<section class="section-pad pt-4">
    <div class="container">
        <div class="filter-bar">
            <button class="btn btn-filter active" data-filter="all">All</button>
            <button class="btn btn-filter" data-filter="Beach">Beach</button>
            <button class="btn btn-filter" data-filter="Nature">Nature</button>
            <button class="btn btn-filter" data-filter="Island">Island</button>
            <button class="btn btn-filter" data-filter="Adventure">Adventure</button>
            <button class="btn btn-filter" data-filter="City">City</button>
            <button class="btn btn-filter" data-filter="Wellness">Wellness</button>
        </div>

        <div class="row g-4 mt-2" id="destinationGrid">
            <?php foreach ($destinations as $destination): ?>
                <div class="col-md-6 col-lg-4 destination-item" data-type="<?= htmlspecialchars($destination['type']) ?>">
                    <div class="destination-card reveal">
                        <span class="destination-type"><?= htmlspecialchars($destination['type']) ?></span>
                        <h3 class="h5 mt-3"><?= htmlspecialchars($destination['name']) ?></h3>
                        <p class="text-muted mb-0"><?= htmlspecialchars($destination['description']) ?></p>
                        <div class="destination-footer mt-4">
                            <span><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($destination['country']) ?></span>
                            <a href="booking.php">Book</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
