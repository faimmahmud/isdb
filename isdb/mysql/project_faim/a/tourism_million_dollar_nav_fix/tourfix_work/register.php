<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Register | ' . $site['brand'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf_token'] ?? null)) {
        flash_set('danger', 'Security token expired. Please refresh and try again.');
    } else {
        $name = trim((string)($_POST['name'] ?? ''));
        $email = trim((string)($_POST['email'] ?? ''));
        $password = (string)($_POST['password'] ?? '');

        if ($name === '' || $email === '' || $password === '') {
            flash_set('danger', 'All fields are required.');
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            flash_set('danger', 'Enter a valid email address.');
        } elseif (app()->auth()->register($name, $email, $password)) {
            flash_set('success', 'Account created successfully.');
            redirect(app_path('index.php'));
        } else {
            flash_set('danger', 'Email already exists.');
        }
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
            <span class="hero-kicker text-white border-0">New account</span>
            <h2 class="display-5 fw-bold mt-3">Start your luxury journey</h2>
            <p class="mb-0 text-white-50">Register to save bookings and access premium travel experiences.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-7 p-4 p-lg-5">
        <div class="section-kicker">Register</div>
        <h1 class="section-title mb-3 text-animate">Create account</h1>
        <form method="post" class="mt-4 row g-3">
          <?= csrf_field() ?>
          <div class="col-12">
            <label class="form-label">Full name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="col-12">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="col-12">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="col-12 d-flex flex-wrap gap-2 align-items-center">
            <button class="btn btn-gold px-4" type="submit">Register</button>
            <a href="<?= e(app_path('login.php')) ?>" class="btn btn-outline-dark px-4">Login</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
