<?php
require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_product'])) {
    $name = trim($_POST['pname'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $manufacturer_id = (int)($_POST['manufacturer_id'] ?? 0);

    if ($name === '' || $price === '' || $manufacturer_id <= 0) {
        flash_set('error', 'Please fill in all product fields.');
        header("Location: product.php");
        exit;
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO `product` (name, price, manfacturer_id) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sdi", $name, $price, $manufacturer_id);

    if (mysqli_stmt_execute($stmt)) {
        flash_set('success', 'Product saved successfully.');
    } else {
        flash_set('error', 'Product save failed: ' . mysqli_error($conn));
    }

    mysqli_stmt_close($stmt);
    header("Location: product.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $id = (int)($_POST['product_id'] ?? 0);

    if ($id > 0) {
        $stmt = mysqli_prepare($conn, "DELETE FROM `product` WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            flash_set('info', 'Product removed from the catalog.');
        } else {
            flash_set('error', 'Product delete failed.');
        }

        mysqli_stmt_close($stmt);
    }

    header("Location: product.php");
    exit;
}

$page_title = "ClassPro Pro — Products";
$page_body_class = "products-page";
$page_css = [
    "assets/css/base.css",
    "assets/css/product.css"
];
$active_page = "products";

$users = [];
$res = mysqli_query($conn, "SELECT id, name FROM `user` ORDER BY name ASC");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $users[] = $row;
    }
}

$products = [];
$res2 = mysqli_query($conn, "
    SELECT p.id, p.name, p.price, u.name AS user_name
    FROM `product` p
    LEFT JOIN `user` u ON u.id = p.manfacturer_id
    ORDER BY p.id DESC
");
if ($res2) {
    while ($row = mysqli_fetch_assoc($res2)) {
        $products[] = $row;
    }
}

include "partials/header.php";
?>

<section class="product-layout">
    <div class="product-hero">
        <span class="kicker">Product Studio</span>
        <h1>Premium product interface with a distinct, modern catalog design.</h1>
        <p>
            This page is intentionally styled differently from the Users page to make the system feel like a
            real multi-section admin application. The form is simple, the list is clear, and the visual style is bold.
        </p>

        <div class="feature-list">
            <div class="feature">
                <div class="badge badge-orange">01</div>
                <div>
                    <strong>Manufacturer linking</strong>
                    <span>Products are connected to existing users using the manufacturer field.</span>
                </div>
            </div>
            <div class="feature">
                <div class="badge badge-green">02</div>
                <div>
                    <strong>Catalog visibility</strong>
                    <span>Stored products are shown below with prices and assigned names.</span>
                </div>
            </div>
            <div class="feature">
                <div class="badge badge-accent">03</div>
                <div>
                    <strong>Bold presentation</strong>
                    <span>Orange and purple accents give this page its own premium identity.</span>
                </div>
            </div>
        </div>
    </div>

    <div class="surface-card product-card">
        <h2 class="section-title">Add new product</h2>
        <p class="section-subtitle">Store name, price, and manufacturer connection into the <code>product</code> table.</p>

        <form method="POST" class="grid" style="margin-top:18px">
            <div class="product-grid">
                <div class="full">
                    <label class="label">Product Name</label>
                    <input class="input" type="text" name="pname" placeholder="Enter product name" required>
                </div>
                <div>
                    <label class="label">Price</label>
                    <input class="input" type="number" step="0.01" name="price" placeholder="Enter price" required>
                </div>
                <div>
                    <label class="label">Manufacturer</label>
                    <select class="select" name="manufacturer_id" required>
                        <option value="">Select user</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo h($user['id']); ?>"><?php echo h($user['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-actions">
                <button class="btn btn-primary" type="submit" name="save_product">Save Product</button>
                <a class="btn btn-ghost" href="index.php">Back to Dashboard</a>
            </div>
        </form>
    </div>
</section>

<section class="surface-card inventory-card" style="margin-top:22px">
    <h2 class="section-title">Catalog inventory</h2>
    <p class="section-subtitle">The table below shows all products with their linked manufacturer name.</p>

    <div class="inventory-list">
        <?php if ($products): ?>
            <?php foreach ($products as $product): ?>
                <div class="inventory-item">
                    <div class="inventory-head">
                        <div>
                            <div class="inventory-name"><?php echo h($product['name']); ?></div>
                            <div class="inventory-meta">Manufacturer: <?php echo h($product['user_name'] ?? 'Unassigned'); ?></div>
                        </div>
                        <div class="price">৳<?php echo number_format((float)$product['price'], 2); ?></div>
                    </div>

                    <form method="POST" onsubmit="return confirm('Delete this product?');">
                        <input type="hidden" name="product_id" value="<?php echo h($product['id']); ?>">
                        <button class="btn btn-danger" type="submit" name="delete_product">Delete Product</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="inventory-item">
                <div class="inventory-name">No products found yet.</div>
                <div class="inventory-meta">Create the first product using the form above.</div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include "partials/footer.php"; ?>
