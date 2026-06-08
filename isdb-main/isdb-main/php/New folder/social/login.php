<?php
require __DIR__ . '/config.php';

if (current_user()) {
    header('Location: dashboard.php');
    exit();
}

$message = '';
$messageType = 'error';

if (isset($_GET['registered'])) {
    $message = 'Registration complete. Log in now.';
    $messageType = 'success';
}

$flash = flash_get();
if ($flash) {
    $message = (string)($flash['message'] ?? '');
    $messageType = (string)($flash['type'] ?? 'error');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $login = trim($_POST['login_value'] ?? '');
    $pass = trim($_POST['pass'] ?? '');

    if ($login === '' || $pass === '') {
        $message = 'Please enter your login and password.';
        $messageType = 'error';
    } else {
        $users = load_users();
        $found = false;

        foreach ($users as $candidate) {
            $email = (string)($candidate['email'] ?? '');
            $username = (string)($candidate['username'] ?? '');
            $hash = (string)($candidate['password_hash'] ?? '');

            if (strcasecmp($login, $email) === 0 || strcasecmp($login, $username) === 0) {
                if (password_verify($pass, $hash)) {
                    $_SESSION['user'] = [
                        'id' => $candidate['id'] ?? '',
                        'name' => $candidate['name'] ?? '',
                        'email' => $email,
                        'username' => $username,
                    ];

                    header('Location: dashboard.php');
                    exit();
                }

                $found = true;
                break;
            }
        }

        $message = $found ? 'Wrong password.' : 'Invalid login details.';
        $messageType = 'error';
    }
}

$users = load_users();
$posts = load_posts();
$summary = summarize_posts($posts);
$loginSignals = [
    'Personal dashboard with live publishing and search',
    'Separate visual identity on every major page',
    'Built on PHP files, but presented like a product launch',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | <?= e(APP_NAME) ?></title>
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body class="login-page">
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
                <a class="button button--secondary" href="register.php">Create account</a>
            </div>
        </header>

        <section class="login-layout page-frame" data-reveal>
            <div class="login-layout__story">
                <span class="eyebrow"><span class="eyebrow__dot"></span> Entry sequence</span>
                <h1 class="headline-display">Step into the control room.</h1>
                <p class="lede">
                    The login page now acts like a polished product checkpoint, not a plain form. It introduces the system, sets the tone, and gets people into the feed quickly.
                </p>

                <div class="signal-grid">
                    <?php foreach ($loginSignals as $signal) : ?>
                        <article class="signal-card">
                            <strong><?= e($signal) ?></strong>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div class="login-metrics panel">
                    <div class="metric-card">
                        <strong><?= count($users) ?></strong>
                        <span>Registered people</span>
                    </div>
                    <div class="metric-card">
                        <strong><?= (int)($summary['total'] ?? 0) ?></strong>
                        <span>Stories already live</span>
                    </div>
                    <div class="metric-card">
                        <strong><?= unique_creator_count($posts) ?></strong>
                        <span>Creators publishing</span>
                    </div>
                </div>
            </div>

            <div class="login-layout__form">
                <div class="auth-card panel">
                    <div class="auth-card__intro">
                        <span class="eyebrow"><span class="eyebrow__dot"></span> Member login</span>
                        <h2 class="headline-medium">Welcome back</h2>
                        <p class="muted">Use your username or email, then continue into your dashboard, discovery pages, and profile workspace.</p>
                    </div>

                    <?php if ($message !== '') : ?>
                        <div class="notice notice--<?= $messageType === 'success' ? 'success' : 'error' ?>"><?= e($message) ?></div>
                    <?php endif; ?>

                    <form method="post" class="auth-form" autocomplete="off">
                        <div class="field">
                            <label for="login_value">Username or Email</label>
                            <input
                                class="form-control"
                                type="text"
                                id="login_value"
                                name="login_value"
                                value="<?= e($_POST['login_value'] ?? '') ?>"
                                placeholder="name@example.com or @username"
                                required
                            >
                        </div>

                        <div class="field">
                            <label for="pass">Password</label>
                            <div class="password-wrap">
                                <input class="form-control" type="password" id="pass" name="pass" placeholder="Enter password" required>
                                <button class="password-toggle" type="button" data-password-toggle data-target="pass">Show</button>
                            </div>
                        </div>

                        <button class="button button--primary auth-submit" type="submit" name="login">Enter Dashboard</button>
                    </form>

                    <div class="auth-mini-grid">
                        <article>
                            <strong>Fast session flow</strong>
                            <p>Login lands directly inside the redesigned app shell.</p>
                        </article>
                        <article>
                            <strong>Visual consistency</strong>
                            <p>Brand, motion, and details stay aligned across the product.</p>
                        </article>
                    </div>

                    <p class="helper-text">No account yet? <a href="register.php">Create one now</a> and join the Open AI x World AI concept feed.</p>
                </div>
            </div>
        </section>
    </div>

    <script src="assets/js/theme.js"></script>
    <script src="assets/js/auth.js"></script>
</body>
</html>
