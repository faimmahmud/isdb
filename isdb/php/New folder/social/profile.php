<?php
require __DIR__ . '/config.php';
require_login();

$user = current_user_record() ?? current_user() ?? [];
$allPosts = newest_posts(load_posts());
$summary = summarize_posts($allPosts);
$myPosts = posts_for_user($allPosts, $user);
$mySummary = summarize_posts($myPosts);

$joinedAt = (int)($user['created_at'] ?? time());
$profileDetails = [
    'Email' => (string)($user['email'] ?? 'Not provided'),
    'Phone' => trim((string)($user['phone'] ?? '')) !== '' ? (string)$user['phone'] : 'Not provided',
    'Address' => trim((string)($user['address'] ?? '')) !== '' ? (string)$user['address'] : 'Not provided',
    'Member ID' => (string)($user['id'] ?? 'Unknown'),
    'Joined' => date('M d, Y', $joinedAt),
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | <?= e(APP_NAME) ?></title>
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/profile.css">
</head>
<body class="profile-page">
    <div class="page-shell">
        <?php
        $activePage = 'profile';
        include __DIR__ . '/partials/internal_nav.php';
        ?>

        <section class="profile-hero page-frame" data-reveal>
            <div class="profile-hero__identity">
                <span class="eyebrow"><span class="eyebrow__dot"></span> Personal hub</span>
                <h1 class="headline-display"><?= e($user['name'] ?? $user['username'] ?? 'Creator') ?></h1>
                <p class="lede">
                    A profile page with its own mood: more intimate, less operational, and focused on the story of the creator rather than the system.
                </p>

                <div class="kicker-row">
                    <span class="kicker">@<?= e($user['username'] ?? 'creator') ?></span>
                    <span class="kicker"><?= count($myPosts) ?> published posts</span>
                    <span class="kicker"><?= profile_completion($user) ?>% profile completion</span>
                </div>
            </div>

            <div class="profile-hero__card panel">
                <div class="profile-badge"><?= e(user_initials($user)) ?></div>
                <strong><?= e(APP_NAME) ?> Member</strong>
                <span><?= e(APP_PLATFORM) ?> / personal space</span>
                <p>Use Dashboard to publish, Explore to browse the network, and Profile to review your own identity and content archive.</p>
            </div>
        </section>

        <section class="profile-metrics" data-reveal>
            <article class="metric-card">
                <strong><?= count($myPosts) ?></strong>
                <span>Total posts you have published</span>
            </article>
            <article class="metric-card">
                <strong><?= (int)($mySummary['image'] ?? 0) ?></strong>
                <span>Image stories from your account</span>
            </article>
            <article class="metric-card">
                <strong><?= (int)($mySummary['file'] ?? 0) ?></strong>
                <span>Shared file assets</span>
            </article>
            <article class="metric-card">
                <strong><?= (int)($mySummary['text'] ?? 0) ?></strong>
                <span>Text-based notes and updates</span>
            </article>
        </section>

        <section class="profile-layout">
            <main class="profile-main stack">
                <section class="activity-panel panel" data-reveal>
                    <div class="section-heading">
                        <div>
                            <span class="eyebrow"><span class="eyebrow__dot"></span> Activity archive</span>
                            <h2 class="headline-medium">Your publishing history</h2>
                        </div>
                        <div class="profile-tabs">
                            <button class="profile-tab is-active" type="button" data-profile-tab="all">All</button>
                            <button class="profile-tab" type="button" data-profile-tab="image">Images</button>
                            <button class="profile-tab" type="button" data-profile-tab="file">Files</button>
                            <button class="profile-tab" type="button" data-profile-tab="text">Text</button>
                        </div>
                    </div>

                    <?php if (empty($myPosts)) : ?>
                        <div class="empty-state">You have not published anything yet. Create your first post from the dashboard to start building your profile story.</div>
                    <?php else : ?>
                        <div class="profile-posts">
                            <?php foreach ($myPosts as $post) : ?>
                                <?php
                                $kind = (string)($post['kind'] ?? 'text');
                                $caption = trim((string)($post['caption'] ?? ''));
                                $stored = (string)($post['stored_name'] ?? '');
                                $original = (string)($post['original_name'] ?? '');
                                $createdAt = (int)($post['created_at'] ?? time());
                                ?>
                                <article class="post-card profile-post" data-profile-kind="<?= e($kind) ?>">
                                    <div class="post-meta">
                                        <div class="avatar-token"><?= e(user_initials($user)) ?></div>
                                        <div>
                                            <strong><?= e($user['name'] ?? $user['username'] ?? 'Creator') ?></strong>
                                            <span><?= e(strtoupper($kind)) ?> / <?= e(format_post_time($createdAt)) ?></span>
                                        </div>
                                    </div>

                                    <?php if ($caption !== '') : ?>
                                        <p class="post-copy"><?= nl2br(e($caption)) ?></p>
                                    <?php endif; ?>

                                    <?php if ($kind === 'image' && $stored !== '') : ?>
                                        <div class="media-frame">
                                            <img src="uploads/<?= e(rawurlencode($stored)) ?>" alt="Profile image post">
                                        </div>
                                    <?php elseif ($kind === 'file' && $stored !== '') : ?>
                                        <div class="file-attachment">
                                            <div>
                                                <strong><?= e($original !== '' ? $original : 'Shared file') ?></strong>
                                                <span><?= e(human_filesize((int)($post['size'] ?? 0))) ?> ready for download</span>
                                            </div>
                                            <a class="mini-link" href="uploads/<?= e(rawurlencode($stored)) ?>" download>Download</a>
                                        </div>
                                    <?php endif; ?>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </section>
            </main>

            <aside class="profile-side stack">
                <section class="details-card panel" data-reveal>
                    <span class="eyebrow"><span class="eyebrow__dot"></span> Identity details</span>
                    <div class="details-list">
                        <?php foreach ($profileDetails as $label => $value) : ?>
                            <article class="details-row">
                                <span><?= e($label) ?></span>
                                <strong><?= e($value) ?></strong>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>

                <section class="details-card panel" data-reveal>
                    <span class="eyebrow"><span class="eyebrow__dot"></span> Profile note</span>
                    <p>Your profile design is intentionally softer and more personal than the dashboard. It gives the platform a second emotional register and makes the product feel more complete.</p>
                    <div class="stack quick-links">
                        <a class="button button--secondary" href="dashboard.php">Publish another post</a>
                        <a class="button button--secondary" href="explore.php">See the network</a>
                    </div>
                </section>
            </aside>
        </section>
    </div>

    <script src="assets/js/theme.js"></script>
    <script src="assets/js/profile.js"></script>
</body>
</html>
