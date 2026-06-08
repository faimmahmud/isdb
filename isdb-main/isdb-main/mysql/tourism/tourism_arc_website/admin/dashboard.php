<?php
$pageTitle = 'Admin Dashboard | Tourism Arc';
require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-hero page-hero-admin">
    <div class="container">
        <span class="eyebrow">Admin</span>
        <h1 class="display-5 fw-bold mt-3">Dashboard starter</h1>
        <p class="text-muted col-lg-7">A simple admin layout to expand into CRUD, booking management, and analytics.</p>
    </div>
</section>

<section class="section-pad pt-4">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4"><div class="metric-card reveal"><h3>24</h3><p>Bookings</p></div></div>
            <div class="col-md-4"><div class="metric-card reveal"><h3>12</h3><p>Packages</p></div></div>
            <div class="col-md-4"><div class="metric-card reveal"><h3>98%</h3><p>Satisfaction</p></div></div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
