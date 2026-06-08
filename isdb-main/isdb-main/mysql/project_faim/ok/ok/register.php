<?php
$pageTitle = 'Register';
$bodyClass = 'auth-page';
require_once __DIR__ . '/includes/header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($_POST['name'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
        $error = 'Use a name, valid email, and a password with at least 8 characters.';
    } else {
        try {
            create_user_account($name, $email, $password);
            $success = 'Your account is ready. You can now login.';
        } catch (Throwable $exception) {
            $error = $exception->getMessage();
        }
    }
}
?>

<section class="auth-shell panel-full parallax-media">
    <img src="assets/images/destinations/kyoto.webp" alt="Luxury heritage register background" loading="eager">
    <div class="panel-shade"></div>
    <div class="auth-card glass-panel reveal">
        <p class="eyebrow">Private profile</p>
        <h1>Create your account</h1>
        <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
        <?php if ($success): ?><div class="alert alert-success"><?= e($success) ?></div><?php endif; ?>
        <form method="post" class="stack-form">
            <label>Name
                <input name="name" type="text" required autocomplete="name">
            </label>
            <label>Email
                <input name="email" type="email" required autocomplete="email">
            </label>
            <label>Password
                <input name="password" type="password" minlength="8" required autocomplete="new-password">
            </label>
            <button class="btn btn-arc magnetic w-100" type="submit">Register</button>
        </form>
        <p class="auth-note">Already registered? <a href="login.php">Login</a></p>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
