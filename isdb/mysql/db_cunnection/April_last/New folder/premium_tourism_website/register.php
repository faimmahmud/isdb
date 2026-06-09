<?php
require_once __DIR__ . '/includes/db.php';

if (is_logged_in()) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6 || $password !== $confirm) {
        flash_set('danger', 'Please enter valid details and make sure passwords match.');
    } else {
        $exists = fetch_one("SELECT id FROM users WHERE email = ?", 's', [$email]);
        if ($exists) {
            flash_set('danger', 'Email already exists.');
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = db()->prepare("INSERT INTO users (name, email, password, role, created_at) VALUES (?, ?, ?, 'user', NOW())");
            $stmt->bind_param('sss', $name, $email, $hash);
            $stmt->execute();
            $stmt->close();
            flash_set('success', 'Registration successful. Please log in.');
            header('Location: login.php');
            exit;
        }
    }
}

$page_title = 'Register';
require_once __DIR__ . '/includes/header.php';
?>
<section class="section-pad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 reveal">
                <div class="auth-card p-4 p-lg-5">
                    <h2 class="fw-black mb-2">Register</h2>
                    <p class="text-muted mb-4">Create your traveler account.</p>
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="confirm" class="form-control" required>
                        </div>
                        <button class="btn btn-arc w-100">Create Account</button>
                    </form>
                    <p class="mt-3 mb-0 text-muted">Already registered? <a href="login.php">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
