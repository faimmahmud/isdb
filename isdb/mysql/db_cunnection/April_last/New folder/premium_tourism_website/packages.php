<?php
$page_title = 'Tour Packages';
require_once __DIR__ . '/includes/header.php';

$search = trim($_GET['q'] ?? '');
$category = trim($_GET['category'] ?? '');

$sql = "SELECT * FROM packages WHERE 1=1";
$params = [];
$types = "";

if ($search !== '') {
    $sql .= " AND (title LIKE ? OR destination LIKE ? OR description LIKE ?)";
    $like = "%{$search}%";
    $params[] = $like; $params[] = $like; $params[] = $like;
    $types .= "sss";
}
if ($category !== '' && $category !== 'all') {
    $sql .= " AND category = ?";
    $params[] = $category;
    $types .= "s";
}
$sql .= " ORDER BY created_at DESC";
$packages = fetch_all($sql, $types, $params);
?>
<section class="section-pad">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="hero-badge mb-3">Packages</span>
            <h1 class="section-title mb-3">Dynamic tour packages from the database.</h1>
            <p class="section-subtitle mx-auto">Search by destination, filter by category, and book in one smooth flow.</p>
        </div>

        <form class="row g-3 align-items-center mb-4 reveal" method="get">
            <div class="col-lg-6">
                <input type="text" class="form-control form-control-lg" name="q" value="<?php echo e($search); ?>" placeholder="Search tours, destinations, or themes">
            </div>
            <div class="col-lg-3">
                <select name="category" class="form-select form-select-lg">
                    <option value="all">All categories</option>
                    <option value="Luxury" <?php echo $category==='Luxury'?'selected':''; ?>>Luxury</option>
                    <option value="Adventure" <?php echo $category==='Adventure'?'selected':''; ?>>Adventure</option>
                    <option value="Family" <?php echo $category==='Family'?'selected':''; ?>>Family</option>
                    <option value="Romantic" <?php echo $category==='Romantic'?'selected':''; ?>>Romantic</option>
                </select>
            </div>
            <div class="col-lg-3 d-grid">
                <button class="btn btn-arc btn-lg">Filter</button>
            </div>
        </form>

        <div class="row g-4">
            <?php if (!$packages): ?>
                <div class="col-12">
                    <div class="booking-card p-5 text-center reveal">
                        <h4 class="fw-bold">No packages found</h4>
                        <p class="text-muted mb-0">Try a different search term or category.</p>
                    </div>
                </div>
            <?php endif; ?>

            <?php foreach ($packages as $pkg): ?>
                <div class="col-lg-4 col-md-6 filter-item reveal" data-category="<?php echo e($pkg['category']); ?>">
                    <div class="package-card h-100">
                        <div class="package-media">
                            <span class="package-badge"><?php echo e($pkg['category']); ?></span>
                            <img src="<?php echo e($pkg['image']); ?>" alt="<?php echo e($pkg['title']); ?>">
                            <div class="package-overlay"></div>
                        </div>
                        <div class="p-4">
                            <div class="d-flex justify-content-between gap-3 mb-2">
                                <div>
                                    <h4 class="fw-bold mb-1"><?php echo e($pkg['title']); ?></h4>
                                    <div class="package-meta"><i class="fa-solid fa-location-dot me-1"></i><?php echo e($pkg['destination']); ?></div>
                                </div>
                                <div class="fw-black fs-4">$<?php echo e($pkg['price']); ?></div>
                            </div>
                            <div class="rating mb-3">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fa-solid <?php echo $i <= round((float)$pkg['rating']) ? 'fa-star' : 'fa-star-half-stroke'; ?>"></i>
                                <?php endfor; ?>
                                <span class="ms-2 text-muted"><?php echo e($pkg['rating']); ?>/5</span>
                            </div>
                            <p class="text-muted"><?php echo e($pkg['description']); ?></p>
                            <a href="booking.php?package_id=<?php echo (int)$pkg['id']; ?>" class="btn btn-arc w-100">Book Now</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
