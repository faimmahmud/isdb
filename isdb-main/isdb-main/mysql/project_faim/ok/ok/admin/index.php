<?php
$pageTitle = 'Admin Panel';
$bodyClass = 'admin-page';
require_once __DIR__ . '/../includes/functions.php';
require_admin();
require_once __DIR__ . '/../includes/header.php';

$message = '';
$error = '';
$editId = (int) ($_GET['edit'] ?? 0);
$editing = $editId ? get_package($editId) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? null)) {
        $error = 'Security token expired. Refresh and try again.';
    } else {
        try {
            if (isset($_POST['delete_id'])) {
                delete_package((int) $_POST['delete_id']);
                $message = 'Package deleted.';
                $editing = null;
            } else {
                $uploaded = isset($_FILES['image_upload']) ? upload_package_image($_FILES['image_upload']) : null;
                $image = $uploaded ?: trim((string) ($_POST['existing_image'] ?? 'assets/images/destinations/maldives.webp'));

                $data = [
                    'title' => trim((string) ($_POST['title'] ?? '')),
                    'destination' => trim((string) ($_POST['destination'] ?? '')),
                    'category' => trim((string) ($_POST['category'] ?? 'beach')),
                    'price' => max(0, (float) ($_POST['price'] ?? 0)),
                    'rating' => min(5, max(1, (float) ($_POST['rating'] ?? 4.8))),
                    'duration' => trim((string) ($_POST['duration'] ?? '5 days')),
                    'description' => trim((string) ($_POST['description'] ?? '')),
                    'highlights' => trim((string) ($_POST['highlights'] ?? '')),
                    'image' => $image,
                    'status' => in_array(($_POST['status'] ?? 'active'), ['active', 'draft'], true) ? $_POST['status'] : 'active',
                ];

                if ($data['title'] === '' || $data['destination'] === '' || $data['description'] === '') {
                    throw new RuntimeException('Title, destination, and description are required.');
                }

                $savedId = save_package($data, (int) ($_POST['package_id'] ?? 0) ?: null);
                $message = 'Package saved.';
                $editing = get_package($savedId);
            }
        } catch (Throwable $exception) {
            $error = $exception->getMessage();
        }
    }
}

$packages = get_admin_packages();
$bookings = get_bookings();
?>

<section class="admin-shell panel-soft">
    <div class="container">
        <div class="admin-header reveal">
            <div>
                <p class="eyebrow">Operations cockpit</p>
                <h1 class="display-heading dark">Royal Atlas Admin</h1>
            </div>
            <a class="btn btn-arc magnetic" href="../packages.php"><i data-lucide="external-link"></i>View Site</a>
        </div>

        <?php if ($message): ?><div class="alert alert-success"><?= e($message) ?></div><?php endif; ?>
        <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>

        <div class="row g-4">
            <div class="col-lg-5">
                <form class="admin-form glass-panel reveal" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                    <input type="hidden" name="package_id" value="<?= (int) ($editing['id'] ?? 0) ?>">
                    <input type="hidden" name="existing_image" value="<?= e($editing['image'] ?? 'assets/images/destinations/maldives.webp') ?>">
                    <h2><?= $editing ? 'Edit Package' : 'Add Package' ?></h2>
                    <label>Title
                        <input name="title" required value="<?= e($editing['title'] ?? '') ?>">
                    </label>
                    <label>Destination
                        <input name="destination" required value="<?= e($editing['destination'] ?? '') ?>">
                    </label>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Category
                                <select name="category">
                                    <?php foreach (['beach', 'mountain', 'city', 'desert', 'island', 'heritage', 'adventure'] as $category): ?>
                                        <option value="<?= e($category) ?>" <?= ($editing['category'] ?? '') === $category ? 'selected' : '' ?>><?= e(ucfirst($category)) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label>Status
                                <select name="status">
                                    <option value="active" <?= ($editing['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="draft" <?= ($editing['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label>Price
                                <input name="price" type="number" min="0" step="50" value="<?= e((string) ($editing['price'] ?? 4200)) ?>">
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label>Rating
                                <input name="rating" type="number" min="1" max="5" step="0.1" value="<?= e((string) ($editing['rating'] ?? 4.8)) ?>">
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label>Duration
                                <input name="duration" value="<?= e($editing['duration'] ?? '6 days') ?>">
                            </label>
                        </div>
                    </div>
                    <label>Description
                        <textarea name="description" rows="4" required><?= e($editing['description'] ?? '') ?></textarea>
                    </label>
                    <label>Highlights
                        <input name="highlights" placeholder="Private guide, Yacht dinner, Spa ritual" value="<?= e($editing['highlights'] ?? '') ?>">
                    </label>
                    <label>Upload image
                        <input name="image_upload" type="file" accept="image/jpeg,image/png,image/webp">
                    </label>
                    <?php if (!empty($editing['image'])): ?>
                        <img class="admin-preview" src="../<?= e($editing['image']) ?>" alt="Current package image">
                    <?php endif; ?>
                    <button class="btn btn-arc magnetic w-100" type="submit">Save Package</button>
                    <?php if ($editing): ?>
                        <a class="btn btn-ghost w-100 mt-2" href="index.php">Cancel Edit</a>
                    <?php endif; ?>
                </form>
            </div>
            <div class="col-lg-7">
                <div class="admin-list glass-panel reveal">
                    <h2>Packages</h2>
                    <?php foreach ($packages as $package): ?>
                        <div class="admin-row">
                            <img src="../<?= e($package['image']) ?>" alt="<?= e($package['title']) ?>">
                            <div>
                                <strong><?= e($package['title']) ?></strong>
                                <span><?= e($package['destination']) ?> · $<?= number_format((float) $package['price']) ?> · <?= e($package['status'] ?? 'active') ?></span>
                            </div>
                            <div class="admin-actions">
                                <a class="icon-btn" href="index.php?edit=<?= (int) $package['id'] ?>" aria-label="Edit package"><i data-lucide="pencil"></i></a>
                                <form method="post">
                                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                                    <input type="hidden" name="delete_id" value="<?= (int) $package['id'] ?>">
                                    <button class="icon-btn danger" type="submit" aria-label="Delete package"><i data-lucide="trash-2"></i></button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="admin-list glass-panel reveal mt-4">
                    <h2>Bookings</h2>
                    <?php if (!$bookings): ?>
                        <p class="muted">No bookings yet.</p>
                    <?php endif; ?>
                    <?php foreach ($bookings as $booking): ?>
                        <div class="booking-row">
                            <div>
                                <strong><?= e($booking['name'] ?? '') ?></strong>
                                <span><?= e($booking['package_title'] ?? '') ?> · <?= e($booking['travel_date'] ?? '') ?></span>
                            </div>
                            <div>
                                <span><?= e($booking['email'] ?? '') ?></span>
                                <span><?= (int) ($booking['guests'] ?? 1) ?> guests</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
