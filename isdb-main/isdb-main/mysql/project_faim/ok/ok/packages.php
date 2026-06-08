<?php
$pageTitle = 'Tour Packages';
$bodyClass = 'packages-page';
require_once __DIR__ . '/includes/header.php';

$search = trim((string) ($_GET['search'] ?? ''));
$packages = get_packages(['search' => $search]);
?>

<section class="page-intro panel-soft">
    <div class="container">
        <div class="row align-items-end g-4">
            <div class="col-lg-7">
                <p class="eyebrow reveal">Signature tour packages</p>
                <h1 class="display-heading dark reveal">Fullscreen journeys, not crowded cards.</h1>
            </div>
            <div class="col-lg-5">
                <form class="package-toolbar glass-panel reveal" id="packageFilters">
                    <input type="search" name="search" value="<?= e($search) ?>" placeholder="Search packages or destinations">
                    <select name="category" aria-label="Filter by category">
                        <option value="">All categories</option>
                        <option value="beach">Beach</option>
                        <option value="mountain">Mountain</option>
                        <option value="city">City</option>
                        <option value="desert">Desert</option>
                        <option value="island">Island</option>
                        <option value="heritage">Heritage</option>
                        <option value="adventure">Adventure</option>
                    </select>
                    <button class="btn btn-arc magnetic" type="submit"><i data-lucide="sliders-horizontal"></i>Filter</button>
                </form>
            </div>
        </div>
    </div>
</section>

<div id="packageResults" class="package-results">
    <?php foreach ($packages as $index => $package): ?>
        <section class="package-story panel-full parallax-media reveal">
            <img src="<?= e($package['image']) ?>" alt="<?= e($package['title']) ?>" loading="<?= $index === 0 ? 'eager' : 'lazy' ?>">
            <div class="panel-shade"></div>
            <div class="container">
                <article class="package-detail glass-panel">
                    <div class="package-meta">
                        <span><?= e($package['destination']) ?></span>
                        <span><i data-lucide="star"></i><?= e((string) $package['rating']) ?></span>
                        <span><?= e($package['duration']) ?></span>
                    </div>
                    <h2><?= e($package['title']) ?></h2>
                    <p><?= e($package['description']) ?></p>
                    <div class="feature-pills">
                        <?php foreach (split_highlights($package['highlights']) as $highlight): ?>
                            <span><?= e($highlight) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <div class="story-actions">
                        <span class="price-tag">$<?= number_format((float) $package['price']) ?></span>
                        <a class="btn btn-arc magnetic" href="booking.php?package=<?= (int) $package['id'] ?>">Book Now</a>
                    </div>
                </article>
            </div>
        </section>
    <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
