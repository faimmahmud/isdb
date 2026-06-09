<?php
$pageTitle = 'Packages | Tourism Arc';
require_once 'includes/db.php';
$packages = tourism_fetch_packages(20);
require_once 'includes/header.php';
?>

<section class="page-hero page-hero-packages">
    <div class="container">
        <span class="eyebrow">Tour Packages</span>
        <h1 class="display-5 fw-bold mt-3">Dynamic package cards for your tourism project</h1>
        <p class="text-muted col-lg-7">This page is ready for database-powered package listings and jQuery filtering.</p>
    </div>
</section>

<section class="section-pad pt-4">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-6">
                <input type="text" id="packageSearch" class="form-control form-control-lg" placeholder="Search package or location">
            </div>
            <div class="col-lg-6 mt-3 mt-lg-0 text-lg-end">
                <span class="text-muted">Showing <strong><?= count($packages) ?></strong> packages</span>
            </div>
        </div>

        <div class="row g-4" id="packageGrid">
            <?php foreach ($packages as $package): ?>
                <div class="col-md-6 col-xl-4 package-item" data-title="<?= htmlspecialchars(strtolower($package['title'] . ' ' . $package['location'])) ?>">
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
                            <div class="small text-muted mt-2"><?= htmlspecialchars($package['duration']) ?></div>
                            <p class="mt-3 text-muted"><?= htmlspecialchars($package['description']) ?></p>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div>
                                    <div class="small text-muted">Price</div>
                                    <div class="price">৳<?= number_format((float)$package['price']) ?></div>
                                </div>
                                <a href="booking.php" class="btn btn-glow">Reserve</a>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
