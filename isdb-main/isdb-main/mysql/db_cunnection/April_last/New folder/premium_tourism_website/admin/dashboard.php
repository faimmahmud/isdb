<?php
require_once __DIR__ . '/../includes/db.php';
require_admin();

$packages = fetch_all("SELECT * FROM packages ORDER BY created_at DESC");
$bookings = fetch_all("SELECT b.*, p.title AS package_title FROM bookings b LEFT JOIN packages p ON p.id = b.package_id ORDER BY b.created_at DESC LIMIT 8");
$page_title = 'Admin Dashboard';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section-pad">
    <div class="container">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4 reveal">
            <div>
                <span class="hero-badge mb-3">Admin panel</span>
                <h1 class="section-title mb-2">Manage the tourism experience.</h1>
                <p class="section-subtitle">Add, edit, or delete packages and keep the booking flow organized.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="add_package.php" class="btn btn-arc">Add Package</a>
                <a href="../logout.php" class="btn btn-outline-arc">Logout</a>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4 reveal"><div class="stat-card"><div class="stat-number"><?php echo site_stat_count('packages'); ?></div><p class="mb-0 text-muted">Packages</p></div></div>
            <div class="col-md-4 reveal"><div class="stat-card"><div class="stat-number"><?php echo site_stat_count('bookings'); ?></div><p class="mb-0 text-muted">Bookings</p></div></div>
            <div class="col-md-4 reveal"><div class="stat-card"><div class="stat-number"><?php echo site_stat_count('users'); ?></div><p class="mb-0 text-muted">Users</p></div></div>
        </div>

        <div class="admin-card p-4 mb-5 reveal">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">Packages</h4>
                <a href="add_package.php" class="btn btn-outline-arc btn-sm">New package</a>
            </div>
            <div class="table-wrap">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Destination</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($packages as $pkg): ?>
                        <tr>
                            <td><img src="<?php echo e($pkg['image']); ?>" alt="" style="width:70px;height:48px;object-fit:cover;border-radius:12px"></td>
                            <td><?php echo e($pkg['title']); ?></td>
                            <td><?php echo e($pkg['destination']); ?></td>
                            <td>$<?php echo e($pkg['price']); ?></td>
                            <td><?php echo e($pkg['category']); ?></td>
                            <td>
                                <a class="btn btn-sm btn-outline-primary" href="edit_package.php?id=<?php echo (int)$pkg['id']; ?>">Edit</a>
                                <a class="btn btn-sm btn-outline-danger" href="delete_package.php?id=<?php echo (int)$pkg['id']; ?>" onclick="return confirm('Delete this package?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="admin-card p-4 reveal">
            <h4 class="fw-bold mb-3">Recent bookings</h4>
            <div class="table-wrap">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Package</th>
                            <th>Date</th>
                            <th>People</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $b): ?>
                            <tr>
                                <td><?php echo e($b['name']); ?></td>
                                <td><?php echo e($b['package_title'] ?? '—'); ?></td>
                                <td><?php echo e($b['travel_date']); ?></td>
                                <td><?php echo e($b['people']); ?></td>
                                <td><span class="badge badge-soft rounded-pill"><?php echo e($b['status']); ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
