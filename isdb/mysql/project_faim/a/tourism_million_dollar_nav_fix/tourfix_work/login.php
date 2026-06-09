<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Login | ' . $site['brand'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf_token'] ?? null)) {
        flash_set('danger', 'Security token expired. Please refresh and try again.');
    } else {
        $email = trim((string)($_POST['email'] ?? ''));
        $password = (string)($_POST['password'] ?? '');
        if (app()->auth()->login($email, $password)) {
            flash_set('success', 'Welcome back!');
            redirect(app_path('index.php'));
        }
        flash_set('danger', 'Invalid email or password.');
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="auth-wrap">
  <div class="auth-card">
    <div class="row g-0">
      <div class="col-lg-5 auth-side">
        <div class="content h-100 d-flex align-items-end">
          <div>
            <span class="hero-kicker text-white border-0">Secure access</span>
            <h2 class="display-5 fw-bold mt-3">Enter the concierge space</h2>
            <p class="mb-0 text-white-50">Luxury bookings, admin tools, and premium travel management.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-7 p-4 p-lg-5">
        <div class="section-kicker">Login</div>
        <h1 class="section-title mb-3 text-animate">Welcome back</h1>
        <p class="section-lead">Use the demo admin account or your registered user account.</p>
        <form method="post" class="mt-4 row g-3">
          <?= csrf_field() ?>
          <div class="col-12">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="col-12">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="col-12 d-flex flex-wrap gap-2 align-items-center">
            <button class="btn btn-gold px-4" type="submit">Login</button>
            <a href="<?= e(app_path('register.php')) ?>" class="btn btn-outline-dark px-4">Create account</a>
          </div>
        </form>
        <div class="mt-4 small text-muted">
          Admin demo: <strong>admin@demo.com</strong> / <strong>admin123</strong>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
