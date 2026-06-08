<?php
$activePage = $activePage ?? 'dashboard';
$summary = $summary ?? ['total' => 0, 'image' => 0, 'file' => 0];
$navUser = $user ?? current_user() ?? [];
?>
<header class="app-shell-nav">
    <a class="brand-lockup" href="index.php">
        <span class="brand-lockup__mark"></span>
        <span>
            <strong><?= e(APP_NAME) ?></strong>
            <small><?= e(APP_PLATFORM) ?></small>
        </span>
    </a>

    <nav class="app-main-nav" aria-label="Primary navigation">
        <a class="<?= $activePage === 'dashboard' ? 'is-active' : '' ?>" href="dashboard.php">Dashboard</a>
        <a class="<?= $activePage === 'explore' ? 'is-active' : '' ?>" href="explore.php">Explore</a>
        <a class="<?= $activePage === 'profile' ? 'is-active' : '' ?>" href="profile.php">Profile</a>
    </nav>

    <div class="app-nav-meta">
        <span class="nav-pill"><?= (int)($summary['total'] ?? 0) ?> stories live</span>
        <span class="nav-pill"><?= user_initials($navUser) ?> / <?= e($navUser['username'] ?? 'guest') ?></span>
        <button
            class="theme-toggle"
            type="button"
            data-theme-toggle
            data-theme-label-light="Light"
            data-theme-label-dark="Dark"
        >
            Dark
        </button>
        <a class="nav-link" href="logout.php">Logout</a>
    </div>
</header>
