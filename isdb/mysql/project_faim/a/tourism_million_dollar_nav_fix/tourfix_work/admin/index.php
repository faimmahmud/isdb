<?php
require_once __DIR__ . '/../includes/functions.php';
app()->auth()->requireAdmin();

$pageTitle = 'Admin Dashboard | ' . $site['brand'];
require_once __DIR__ . '/../includes/header.php';

$packages = read_packages();
$bookings = read_bookings();
?>
<section class="arc-section mt-0">
  <div class="container">
    <div class="surface p-4 p-lg-5 reveal">
      <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-center">
        <div>
          <div class="section-kicker">Admin panel</div>
          <h1 class="section-title mb-2">Manage packages and bookings</h1>
          <p class="section-lead mb-0">File-based admin tools with add, edit, delete, and image upload support.</p>
        </div>
        <div class="d-flex gap-2">
          <a class="btn btn-gold px-4" href="<?= e(app_path('admin/add-package.php')) ?>">Add package</a>
          <a class="btn btn-outline-dark px-4" href="<?= e(app_path('index.php')) ?>">View site</a>
        </div>
      </div>
    </div>

    <div class="row g-4 mt-2">
      <div class="col-lg-7">
        <div class="surface p-4 rounded-5 reveal">
          <h3 class="h4 fw-bold mb-3 text-animate">Tour packages</h3>
          <div class="table-responsive">
            <table class="table align-middle">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Country</th>
                  <th>Price</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($packages as $pkg): ?>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-3">
                        <img src="<?= e($pkg['image']) ?>" alt="" style="width:64px;height:48px;object-fit:cover;border-radius:12px;">
                        <strong><?= e($pkg['title']) ?></strong>
                      </div>
                    </td>
                    <td><?= e($pkg['country'] ?? '') ?></td>
                    <td><?= e($pkg['price'] ?? '') ?></td>
                    <td class="text-end">
                      <a class="btn btn-sm btn-outline-dark" href="<?= e(app_path('admin/edit-package.php?id=' . urlencode($pkg['id']))) ?>">Edit</a>
                      <form class="d-inline" method="post" action="<?= e(app_path('admin/delete-package.php')) ?>" onsubmit="return confirm('Delete this package?');">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= e($pkg['id']) ?>">
                        <button class="btn btn-sm btn-danger">Delete</button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="surface p-4 rounded-5 reveal">
          <h3 class="h4 fw-bold mb-3 text-animate">Recent bookings</h3>
          <div class="vstack gap-3">
            <?php foreach ($bookings as $b): ?>
              <div class="p-3 rounded-4 bg-light">
                <div class="d-flex justify-content-between gap-2">
                  <strong><?= e($b['name']) ?></strong>
                  <span class="text-muted small"><?= e($b['date']) ?></span>
                </div>
                <div class="text-muted small"><?= e($b['package']) ?> • <?= e($b['email']) ?></div>
              </div>
            <?php endforeach; ?>
            <?php if (!$bookings): ?>
              <p class="text-muted mb-0">No bookings yet.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
