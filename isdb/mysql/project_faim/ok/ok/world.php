<?php
$pageTitle = 'World Travel Atlas';
$bodyClass = 'world-page';
require_once __DIR__ . '/includes/header.php';

$countries = read_json_file(__DIR__ . '/assets/data/countries.json');
?>

<section class="world-hero panel-full parallax-media">
    <img src="assets/images/destinations/patagonia.webp" alt="World travel atlas landscape" loading="eager">
    <div class="panel-shade"></div>
    <div class="container">
        <div class="world-hero-content">
            <p class="eyebrow reveal">World travel atlas</p>
            <h1 class="display-heading reveal">Every country, presented like a cinematic invitation.</h1>
            <p class="hero-copy reveal">Top travel icons appear first, followed by a searchable atlas of countries and territories with bundled visual covers.</p>
            <div class="country-search glass-panel reveal">
                <i data-lucide="search"></i>
                <input id="countrySearch" type="search" placeholder="Search any country or region..." aria-label="Search countries">
            </div>
        </div>
    </div>
</section>

<section class="section-heading-wrap">
    <div class="container">
        <p class="eyebrow reveal">Top travel first</p>
        <h2 class="section-heading reveal">Scroll through the world one destination at a time.</h2>
    </div>
</section>

<div class="country-atlas" id="countryAtlas">
    <?php foreach ($countries as $index => $country): ?>
        <article class="country-panel <?= !empty($country['featured']) ? 'featured-country' : '' ?> reveal" data-country="<?= e(strtolower($country['name'] . ' ' . ($country['region'] ?? ''))) ?>">
            <img src="<?= e($country['image']) ?>" alt="<?= e($country['name']) ?> travel image" loading="<?= $index < 3 ? 'eager' : 'lazy' ?>">
            <div class="country-panel-shade"></div>
            <div class="container">
                <div class="country-copy glass-panel">
                    <p class="eyebrow"><?= e($country['region'] ?? 'Global') ?></p>
                    <h2><?= e($country['name']) ?></h2>
                    <p><?= e($country['tagline'] ?? 'A curated travel cover from the Royal Atlas world collection.') ?></p>
                    <div class="country-meta">
                        <span><?= e($country['capital'] ?? 'Capital varies') ?></span>
                        <span><?= number_format((float) ($country['population'] ?? 0)) ?> people</span>
                        <span><?= !empty($country['featured']) ? 'Featured' : 'Atlas' ?></span>
                    </div>
                </div>
            </div>
        </article>
    <?php endforeach; ?>
</div>

<?php if (!$countries): ?>
    <section class="panel-soft">
        <div class="container">
            <div class="empty-state glass-panel">
                <h2>Country atlas data is being generated.</h2>
                <p>Run the asset generator or keep the included ZIP contents together so <code>assets/data/countries.json</code> can load.</p>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
