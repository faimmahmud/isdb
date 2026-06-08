<?php
$pageTitle = 'Destinations';
$bodyClass = 'destinations-page';
require_once __DIR__ . '/includes/header.php';

$destinations = get_destinations();
$categories = ['all' => 'All', 'beach' => 'Beach', 'mountain' => 'Mountain', 'city' => 'City', 'desert' => 'Desert', 'island' => 'Island', 'heritage' => 'Heritage', 'adventure' => 'Adventure'];
?>

<section class="route-hero panel-full">
    <div class="route-map" aria-hidden="true">
        <span class="globe-core"></span>
        <span class="route-line route-one"></span>
        <span class="route-line route-two"></span>
        <span class="route-line route-three"></span>
        <span class="route-dot dot-one"></span>
        <span class="route-dot dot-two"></span>
        <span class="route-dot dot-three"></span>
    </div>
    <div class="container route-content">
        <p class="eyebrow reveal">Royal Atlas network</p>
        <h1 class="display-heading reveal">A global stage, choreographed for your next departure.</h1>
        <p class="hero-copy reveal">Explore curated routes with airline-grade polish, private transfers, and live-feeling motion inspired by premium travel campaigns.</p>
        <div class="filter-bar glass-panel reveal" data-filter-group="destinations">
            <?php foreach ($categories as $value => $label): ?>
                <button class="filter-btn <?= $value === 'all' ? 'active' : '' ?>" type="button" data-filter="<?= e($value) ?>"><?= e($label) ?></button>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php foreach ($destinations as $index => $destination): ?>
    <section class="destination-panel panel-full parallax-media reveal" data-category="<?= e($destination['category']) ?>">
        <img src="<?= e($destination['image']) ?>" alt="<?= e($destination['title']) ?>" loading="<?= $index === 0 ? 'eager' : 'lazy' ?>">
        <div class="panel-shade"></div>
        <div class="container">
            <div class="destination-copy glass-panel">
                <p class="eyebrow"><?= e($destination['country']) ?> · <?= e(ucfirst($destination['category'])) ?></p>
                <h2><?= e($destination['title']) ?></h2>
                <p><?= e($destination['summary']) ?></p>
                <a class="btn btn-arc magnetic" href="packages.php?search=<?= urlencode((string) $destination['country']) ?>">
                    <i data-lucide="map-pin"></i>
                    View Packages
                </a>
            </div>
        </div>
    </section>
<?php endforeach; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
