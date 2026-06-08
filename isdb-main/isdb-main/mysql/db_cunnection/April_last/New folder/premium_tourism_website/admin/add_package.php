<?php
require_once __DIR__ . '/../includes/db.php';
require_admin();

$package = [
    'title' => '',
    'destination' => '',
    'price' => '',
    'rating' => 4.8,
    'category' => 'Luxury',
    'description' => '',
    'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80'
];

$editing = false;
$savePath = __DIR__ . '/../assets/uploads/';

if (false) {
    $id = (int)$_GET['id'];
    $existing = fetch_one("SELECT * FROM packages WHERE id = ?", 'i', [$id]);
    if (!$existing) {
        flash_set('danger', 'Package not found.');
        header('Location: dashboard.php');
        exit;
    }
    $package = $existing;
    $editing = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $destination = trim($_POST['destination'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $rating = (float)($_POST['rating'] ?? 0);
    $category = trim($_POST['category'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image = $package['image'];

    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($ext, $allowed, true)) {
            $filename = 'tour_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            $target = $savePath . $filename;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $image = 'assets/uploads/' . $filename;
            }
        }
    }

    if ($title === '' || $destination === '' || $price <= 0 || $description === '') {
        flash_set('danger', 'Please fill all required fields.');
    } else {
        if ($editing) {
            $stmt = db()->prepare("UPDATE packages SET title=?, destination=?, price=?, rating=?, category=?, description=?, image=? WHERE id=?");
            $stmt->bind_param('ssddsssi', $title, $destination, $price, $rating, $category, $description, $image, $package['id']);
            $stmt->execute();
            $stmt->close();
            flash_set('success', 'Package updated successfully.');
        } else {
            $stmt = db()->prepare("INSERT INTO packages (title, destination, price, rating, category, description, image, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param('ssddsss', $title, $destination, $price, $rating, $category, $description, $image);
            $stmt->execute();
            $stmt->close();
            flash_set('success', 'Package added successfully.');
        }
        header('Location: dashboard.php');
        exit;
    }
}

$page_title = 'Add Package';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section-pad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 reveal">
                <div class="admin-card p-4 p-lg-5">
                    <h2 class="fw-bold mb-3">Add Package</h2>
                    <form method="post" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" value="<?php echo e($package['title']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Destination</label>
                                <input type="text" name="destination" class="form-control" value="<?php echo e($package['destination']); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Price</label>
                                <input type="number" step="0.01" name="price" class="form-control" value="<?php echo e($package['price']); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Rating</label>
                                <input type="number" step="0.1" min="0" max="5" name="rating" class="form-control" value="<?php echo e($package['rating']); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select">
                                    <option value="Luxury" <?php echo ($package['category']==='Luxury')?'selected':''; ?>>Luxury</option>
                                    <option value="Adventure" <?php echo ($package['category']==='Adventure')?'selected':''; ?>>Adventure</option>
                                    <option value="Family" <?php echo ($package['category']==='Family')?'selected':''; ?>>Family</option>
                                    <option value="Romantic" <?php echo ($package['category']==='Romantic')?'selected':''; ?>>Romantic</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="5" required><?php echo e($package['description']); ?></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Image</label>
                                <input type="file" name="image" class="form-control">
                                <small class="text-muted d-block mt-2">Current image: <?php echo e($package['image']); ?></small>
                            </div>
                            <div class="col-12 d-grid d-md-flex gap-2">
                                <button class="btn btn-arc"><?php echo $submit_label; ?></button>
                                <a href="dashboard.php" class="btn btn-outline-arc">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
