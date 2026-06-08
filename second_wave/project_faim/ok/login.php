<?php
$pageTitle = 'Login';
$bodyClass = 'auth-page';
require_once __DIR__ . '/includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $error = 'Enter a valid email and password.';
    } else {
        $user = find_user_by_email($email);

        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id' => (int) $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
            ];

            header('Location: ' . ($user['role'] === 'admin' ? 'admin/index.php' : 'index.php'));
            exit;
        }

        $error = 'The login details do not match our records.';
    }
}
?>

<section class="auth-shell panel-full parallax-media">
    <img src="assets/images/destinations/dubai.webp" alt="Luxury skyline login background" loading="eager">
    <div class="panel-shade"></div>
    <div class="auth-card glass-panel reveal">
        <p class="eyebrow">Client access</p>
        <h1>Login to Royal Atlas</h1>
        <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
        <form method="post" class="stack-form">
            <label>Email
                <input name="email" type="email" required autocomplete="email">
            </label>
            <label>Password
                <input name="password" type="password" required autocomplete="current-password">
            </label>
            <button class="btn btn-arc magnetic w-100" type="submit">Login</button>
        </form>
        <p class="auth-note">New traveler? <a href="register.php">Create an account</a></p>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
