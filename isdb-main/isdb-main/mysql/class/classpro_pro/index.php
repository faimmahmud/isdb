<?php
require_once "db.php";

$page_title = "ClassPro Pro Dashboard";
$page_body_class = "dashboard-page";
$page_css = [
    "assets/css/base.css",
    "assets/css/dashboard.css"
];
$active_page = "dashboard";

$user_count = 0;
$product_count = 0;
$avg_price = 0;
$latest_users = [];
$latest_products = [];

$user_count_res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM `user`");
if ($user_count_res) {
    $user_count = (int) mysqli_fetch_assoc($user_count_res)['total'];
}

$product_count_res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM `product`");
if ($product_count_res) {
    $product_count = (int) mysqli_fetch_assoc($product_count_res)['total'];
}

$avg_price_res = mysqli_query($conn, "SELECT COALESCE(AVG(price), 0) AS avg_price FROM `product`");
if ($avg_price_res) {
    $avg_price = (float) mysqli_fetch_assoc($avg_price_res)['avg_price'];
}

$latest_users_res = mysqli_query($conn, "SELECT id, name, address, contact_no FROM `user` ORDER BY id DESC LIMIT 3");
if ($latest_users_res) {
    while ($row = mysqli_fetch_assoc($latest_users_res)) {
        $latest_users[] = $row;
    }
}

$latest_products_res = mysqli_query($conn, "
    SELECT p.id, p.name, p.price, u.name AS manufacturer_name
    FROM `product` p
    LEFT JOIN `user` u ON u.id = p.manfacturer_id
    ORDER BY p.id DESC
    LIMIT 3
");
if ($latest_products_res) {
    while ($row = mysqli_fetch_assoc($latest_products_res)) {
        $latest_products[] = $row;
    }
}

include "partials/header.php";
?>

<section class="dashboard-hero">
    <div class="hero-panel">
        <span class="kicker">Premium Admin Experience</span>
        <h1 class="hero-title">A polished control center for users, products, and fast operations.</h1>
        <p class="hero-copy">
            This version is designed to feel like a modern production dashboard: glassmorphism panels,
            bold gradients, clear spacing, and separate visual identities for every page.
        </p>
        <div class="hero-actions">
            <a class="btn btn-primary" href="user.php">Manage Users</a>
            <a class="btn btn-ghost" href="product.php">Manage Products</a>
        </div>

        <div class="quick-grid">
            <div class="quick-card">
                <p class="quick-title">Organized workflow</p>
                <p class="quick-text">Each page uses its own visual theme while keeping the same clean system structure.</p>
            </div>
            <div class="quick-card">
                <p class="quick-title">Fast actions</p>
                <p class="quick-text">Forms, tables, and summaries are arranged for quick scanning and easy management.</p>
            </div>
            <div class="quick-card">
                <p class="quick-title">Readable interface</p>
                <p class="quick-text">Spacing, contrast, and visual hierarchy are tuned for a premium dashboard feel.</p>
            </div>
        </div>
    </div>

    <div class="info-stack">
        <div class="surface-card info-card">
            <span class="badge badge-accent">System Status</span>
            <div class="info-number"><?php echo h($user_count + $product_count); ?></div>
            <div class="info-desc">Total records currently available in the system.</div>
        </div>
        <div class="surface-card info-card">
            <span class="badge badge-green">Live Data</span>
            <div class="info-number"><?php echo h($user_count); ?></div>
            <div class="info-desc">Registered users ready to be linked with products.</div>
        </div>
        <div class="surface-card info-card">
            <span class="badge badge-orange">Catalog</span>
            <div class="info-number"><?php echo h($product_count); ?></div>
            <div class="info-desc">Products stored with manufacturer connection.</div>
        </div>
    </div>
</section>

<section class="metrics-grid">
    <div class="surface-card metric">
        <div class="metric-label">Total Users</div>
        <div class="metric-value"><?php echo h($user_count); ?></div>
        <div class="metric-note">People listed inside the ClassPro database.</div>
    </div>
    <div class="surface-card metric">
        <div class="metric-label">Total Products</div>
        <div class="metric-value"><?php echo h($product_count); ?></div>
        <div class="metric-note">Product rows stored in the product table.</div>
    </div>
    <div class="surface-card metric">
        <div class="metric-label">Average Price</div>
        <div class="metric-value"><?php echo number_format($avg_price, 2); ?></div>
        <div class="metric-note">Average product price from the current inventory.</div>
    </div>
    <div class="surface-card metric">
        <div class="metric-label">System Style</div>
        <div class="metric-value">Pro</div>
        <div class="metric-note">Modern premium interface with separate page themes.</div>
    </div>
</section>

<section class="split-grid">
    <div class="surface-card panel">
        <h2 class="section-title">Latest users</h2>
        <p class="section-subtitle">The newest records appear here so the dashboard feels active and alive.</p>
        <div class="timeline">
            <?php if ($latest_users): ?>
                <?php foreach ($latest_users as $item): ?>
                    <div class="timeline-item">
                        <div class="dot"></div>
                        <div>
                            <p class="timeline-title"><?php echo h($item['name']); ?></p>
                            <p class="timeline-text"><?php echo h($item['address']); ?> • <?php echo h($item['contact_no']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="timeline-item">
                    <div class="dot"></div>
                    <div>
                        <p class="timeline-title">No users yet</p>
                        <p class="timeline-text">Add the first user from the Users page.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="surface-card panel">
        <h2 class="section-title">Latest products</h2>
        <p class="section-subtitle">A quick snapshot of the newest catalog items and their assigned users.</p>
        <div class="timeline">
            <?php if ($latest_products): ?>
                <?php foreach ($latest_products as $item): ?>
                    <div class="timeline-item">
                        <div class="dot"></div>
                        <div>
                            <p class="timeline-title"><?php echo h($item['name']); ?></p>
                            <p class="timeline-text">
                                Price: ৳<?php echo number_format((float)$item['price'], 2); ?> •
                                Manufacturer: <?php echo h($item['manufacturer_name'] ?? 'Unassigned'); ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="timeline-item">
                    <div class="dot"></div>
                    <div>
                        <p class="timeline-title">No products yet</p>
                        <p class="timeline-text">Add the first product from the Products page.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include "partials/footer.php"; ?>
