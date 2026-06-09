<?php
require_once __DIR__ . '/includes/db.php';

if (is_logged_in()) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = fetch_one("SELECT id, name, email, password, role FROM users WHERE email = ?", 's', [$email]);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role']
        ];
        flash_set('success', 'Welcome back, ' . $user['name'] . '!');
        header('Location: index.php');
        exit;
    } else {
        flash_set('danger', 'Invalid email or password.');
    }
}

$page_title = 'Login';
require_once __DIR__ . '/includes/header.php';
?>
<section class="section-pad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 reveal">
                <div class="auth-card p-4 p-lg-5">
                    <h2 class="fw-black mb-2">Login</h2>
                    <p class="text-muted mb-4">Access your traveler account.</p>
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button class="btn btn-arc w-100">Login</button>
                    </form>
                    <p class="mt-3 mb-0 text-muted">New here? <a href="register.php">Create an account</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
