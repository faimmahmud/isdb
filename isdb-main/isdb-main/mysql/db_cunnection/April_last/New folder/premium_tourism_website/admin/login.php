<?php
require_once __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = fetch_one("SELECT id, name, email, password, role FROM users WHERE email = ? AND role = 'admin'", 's', [$email]);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role']
        ];
        flash_set('success', 'Admin login successful.');
        header('Location: dashboard.php');
        exit;
    } else {
        flash_set('danger', 'Invalid admin credentials.');
    }
}

$page_title = 'Admin Login';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section-pad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 reveal">
                <div class="auth-card p-4 p-lg-5">
                    <h2 class="fw-black mb-2">Admin Login</h2>
                    <p class="text-muted mb-4">Manage packages, bookings, and content.</p>
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Admin Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button class="btn btn-arc w-100">Enter Dashboard</button>
                    </form>
                    <p class="mt-3 mb-0 text-muted">Demo admin: <code>admin@tourism.com</code></p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
