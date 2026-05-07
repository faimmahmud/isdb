<?php
require __DIR__ . '/config.php';

if (current_user()) {
    header('Location: dashboard.php');
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $id = trim($_POST['id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = trim($_POST['pass'] ?? '');
    $repass = trim($_POST['repass'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $username = trim($_POST['username'] ?? '');

    if ($id === '' || $name === '' || $email === '' || $pass === '' || $repass === '' || $username === '') {
        $message = 'Please fill all required fields.';
    } elseif (!ctype_digit($id)) {
        $message = 'ID must contain only numbers.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
    } elseif (mb_strlen($pass) < 6) {
        $message = 'Password must be at least 6 characters.';
    } elseif ($pass !== $repass) {
        $message = 'Password does not match.';
    } elseif (mb_strlen($username) < 3) {
        $message = 'Username must be at least 3 characters.';
    } else {
        $users = load_users();
        $duplicate = false;

        foreach ($users as $user) {
            if ((string)($user['id'] ?? '') === $id) {
                $message = 'This ID is already registered.';
                $duplicate = true;
                break;
            }
            if (strcasecmp((string)($user['email'] ?? ''), $email) === 0) {
                $message = 'This email is already registered.';
                $duplicate = true;
                break;
            }
            if (strcasecmp((string)($user['username'] ?? ''), $username) === 0) {
                $message = 'This username is already taken.';
                $duplicate = true;
                break;
            }
        }

        if (!$duplicate) {
            $row = [
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'password_hash' => password_hash($pass, PASSWORD_DEFAULT),
                'address' => $address,
                'phone' => $phone,
                'username' => $username,
                'created_at' => time(),
            ];

            append_json_line(USERS_FILE, $row);
            flash_set('Account created successfully. Please log in.', 'success');
            header('Location: login.php?registered=1');
            exit();
        }
    }
}

$trustItems = [
    'Separate profile data and activity views from day one',
    'File-safe posting with validation and hashed passwords',
    'A design system that still respects your simple PHP foundation',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | <?= e(APP_NAME) ?></title>
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/register.css">
</head>
<body class="register-page">
    <div class="page-shell">
        <header class="marketing-nav panel" data-reveal>
            <a class="brand-lockup" href="index.php">
                <span class="brand-lockup__mark"></span>
                <span>
                    <strong><?= e(APP_NAME) ?></strong>
                    <small><?= e(APP_PLATFORM) ?></small>
                </span>
            </a>

            <div class="cluster">
                <button
                    class="theme-toggle"
                    type="button"
                    data-theme-toggle
                    data-theme-label-light="Light"
                    data-theme-label-dark="Dark"
                >
                    Dark
                </button>
                <a class="button button--secondary" href="login.php">Already a member</a>
            </div>
        </header>

        <section class="register-stage page-frame" data-reveal>
            <div class="register-stage__intro">
                <span class="eyebrow"><span class="eyebrow__dot"></span> Onboarding flow</span>
                <h1 class="headline-display">Build your creator identity.</h1>
                <p class="lede">
                    Registration now feels like joining a designed platform. It explains the value, guides the form, and creates a much stronger first impression.
                </p>

                <div class="register-rail">
                    <?php foreach ($trustItems as $item) : ?>
                        <article class="register-rail__item">
                            <strong><?= e($item) ?></strong>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="register-stage__form">
                <div class="register-card panel">
                    <div class="section-heading">
                        <div>
                            <span class="eyebrow"><span class="eyebrow__dot"></span> Join <?= e(APP_PLATFORM) ?></span>
                            <h2 class="headline-medium">Create your account</h2>
                        </div>
                        <p class="muted">Required fields are grouped first, then personal details complete the profile.</p>
                    </div>

                    <?php if ($message !== '') : ?>
                        <div class="notice notice--error"><?= e($message) ?></div>
                    <?php endif; ?>

                    <form method="post" class="register-form" autocomplete="off">
                        <div class="register-form__grid">
                            <div class="field">
                                <label for="id">ID</label>
                                <input class="form-control" type="number" id="id" name="id" value="<?= e($_POST['id'] ?? '') ?>" placeholder="Numeric ID" required>
                            </div>

                            <div class="field">
                                <label for="username">Username</label>
                                <input class="form-control" type="text" id="username" name="username" value="<?= e($_POST['username'] ?? '') ?>" placeholder="Unique handle" required>
                            </div>

                            <div class="field register-form__wide">
                                <label for="name">Full Name</label>
                                <input class="form-control" type="text" id="name" name="name" value="<?= e($_POST['name'] ?? '') ?>" placeholder="Your public name" required>
                            </div>

                            <div class="field register-form__wide">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" id="email" name="email" value="<?= e($_POST['email'] ?? '') ?>" placeholder="name@example.com" required>
                            </div>

                            <div class="field">
                                <label for="pass">Password</label>
                                <div class="password-wrap">
                                    <input class="form-control" type="password" id="pass" name="pass" placeholder="At least 6 characters" required>
                                    <button class="password-toggle" type="button" data-password-toggle data-target="pass">Show</button>
                                </div>
                            </div>

                            <div class="field">
                                <label for="repass">Confirm Password</label>
                                <div class="password-wrap">
                                    <input class="form-control" type="password" id="repass" name="repass" placeholder="Retype password" required>
                                    <button class="password-toggle" type="button" data-password-toggle data-target="repass">Show</button>
                                </div>
                            </div>

                            <div class="field register-form__wide">
                                <label for="address">Address</label>
                                <input class="form-control" type="text" id="address" name="address" value="<?= e($_POST['address'] ?? '') ?>" placeholder="City, district, or full address">
                            </div>

                            <div class="field">
                                <label for="phone">Phone</label>
                                <input class="form-control" type="text" id="phone" name="phone" value="<?= e($_POST['phone'] ?? '') ?>" placeholder="Phone number">
                            </div>

                            <div class="field">
                                <label for="platform_role">Creative Mode</label>
                                <input class="form-control" type="text" id="platform_role" value="Creator / Publisher" disabled>
                            </div>
                        </div>

                        <button class="button button--primary register-submit" type="submit" name="register">Launch My Account</button>
                    </form>

                    <div class="register-footer">
                        <article>
                            <strong>Structured profile setup</strong>
                            <p>Identity, credentials, and optional contact details are clearly separated.</p>
                        </article>
                        <article>
                            <strong>Designed to scale</strong>
                            <p>This base can expand into followers, comments, likes, and profile editing later.</p>
                        </article>
                    </div>

                    <p class="helper-text">Already have access? <a href="login.php">Go to login</a>.</p>
                </div>
            </div>
        </section>
    </div>

    <script src="assets/js/theme.js"></script>
    <script src="assets/js/auth.js"></script>
</body>
</html>
