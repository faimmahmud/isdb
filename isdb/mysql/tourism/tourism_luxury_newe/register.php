<?php
$pageTitle = 'Register | ' . $site['brand'];
require_once __DIR__ . '/includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($name === '' || $email === '' || $password === '') {
        flash_set('danger', 'All fields are required.');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        flash_set('danger', 'Enter a valid email address.');
    } else {
        $users = read_users();
        foreach ($users as $user) {
            if (strcasecmp($user['email'], $email) === 0) {
                flash_set('danger', 'Email already exists.');
                goto render_register;
            }
        }
        $users[] = [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'user'
        ];
        write_users($users);
        $_SESSION['user'] = ['name' => $name, 'email' => $email, 'role' => 'user'];
        flash_set('success', 'Account created successfully.');
        redirect(app_path('index.php'));
    }
}
render_register:
?>
<div class="login-wrap">
  <div class="login-panel">
    <div class="login-visual" style="background-image:url('<?= e(travel_img('register-visual')) ?>')">
      <div class="position-relative z-2 h-100 d-flex align-items-end p-4 p-lg-5">
        <div class="text-white">
          <span class="hero-kicker">New account</span>
          <h2 class="display-5 fw-bold mt-3">Start your luxury journey</h2>
          <p class="mb-0 text-white-50">Register to save bookings and access premium travel experiences.</p>
        </div>
      </div>
    </div>
    <div class="login-body">
      <div class="section-kicker">Register</div>
      <h1 class="section-title mb-3">Create account</h1>
      <form method="post" class="mt-4 row g-3">
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
<?php require_once __DIR__ . '/includes/footer.php'; ?>
