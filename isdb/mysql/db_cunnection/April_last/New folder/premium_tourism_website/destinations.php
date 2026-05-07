<?php
$page_title = 'Destinations';
require_once __DIR__ . '/includes/header.php';
$destinations = [
    ['name' => 'Bali, Indonesia', 'cat' => 'beach', 'img' => 'https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?auto=format&fit=crop&w=1200&q=80', 'desc' => 'Tropical luxury with serene beaches, villas, and scenic sunsets.'],
    ['name' => 'Swiss Alps', 'cat' => 'mountain', 'img' => 'https://images.unsplash.com/photo-1517299321609-52687d1bc55a?auto=format&fit=crop&w=1200&q=80', 'desc' => 'Snow peaks, premium chalets, and postcard-perfect views.'],
    ['name' => 'Dubai, UAE', 'cat' => 'city', 'img' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=1200&q=80', 'desc' => 'Futuristic skyline, shopping, and luxury experiences.'],
    ['name' => 'Kyoto, Japan', 'cat' => 'culture', 'img' => 'https://images.unsplash.com/photo-1492571350019-22de08371fd3?auto=format&fit=crop&w=1200&q=80', 'desc' => 'Timeless culture, gardens, and elegant city escapes.'],
    ['name' => 'Maldives', 'cat' => 'beach', 'img' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=1200&q=80', 'desc' => 'Luxury overwater retreats with crystal-clear waters.'],
    ['name' => 'Paris, France', 'cat' => 'city', 'img' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=1200&q=80', 'desc' => 'Iconic architecture, fine dining, and romantic nights.'],
];
?>
<section class="section-pad">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="hero-badge mb-3">Destinations</span>
            <h1 class="section-title mb-3">Dream places, beautifully presented.</h1>
            <p class="section-subtitle mx-auto">Search and filter destinations for a quick premium browsing experience.</p>
        </div>

        <div class="row justify-content-center mb-4 reveal">
            <div class="col-lg-7">
                <input type="text" id="destinationSearch" class="form-control form-control-lg" placeholder="Search destinations...">
            </div>
        </div>

        <div class="d-flex flex-wrap justify-content-center gap-2 mb-4 reveal">
            <button class="filter-chip active" data-filter="all">All</button>
            <button class="filter-chip" data-filter="beach">Beach</button>
            <button class="filter-chip" data-filter="city">City</button>
            <button class="filter-chip" data-filter="mountain">Mountain</button>
            <button class="filter-chip" data-filter="culture">Culture</button>
        </div>

        <div class="row g-4">
            <?php foreach ($destinations as $d): ?>
                <div class="col-lg-4 col-md-6 destination-card reveal" data-text="<?php echo e($d['name'] . ' ' . $d['desc']); ?>" data-category="<?php echo e($d['cat']); ?>">
                    <div class="package-card h-100">
                        <div class="package-media">
                            <span class="package-badge"><?php echo e(ucfirst($d['cat'])); ?></span>
                            <img src="<?php echo e($d['img']); ?>" alt="<?php echo e($d['name']); ?>">
                            <div class="package-overlay"></div>
                        </div>
                        <div class="p-4">
                            <h4 class="fw-bold"><?php echo e($d['name']); ?></h4>
                            <p class="text-muted mb-0"><?php echo e($d['desc']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
