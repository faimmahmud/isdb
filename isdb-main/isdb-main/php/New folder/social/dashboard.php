<?php
require __DIR__ . '/config.php';
require_login();

$user = current_user_record() ?? current_user() ?? [];
$flash = flash_get();

$allPosts = newest_posts(load_posts());
$allUsers = load_users();
$summary = summarize_posts($allPosts);

$query = trim($_GET['q'] ?? '');
$filter = trim($_GET['filter'] ?? 'all');
$posts = filter_posts($allPosts, $query, $filter);
$myPosts = posts_for_user($allPosts, $user);
$mySummary = summarize_posts($myPosts);

$pulseMessages = [
    'Post from here, then open Explore to see the content reframed as a discovery gallery.',
    'Your profile page now tracks completion, publishing mix, and personal feed history.',
    'Each major page has a separate art direction while the product still feels connected.',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | <?= e(APP_NAME) ?></title>
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body class="dashboard-page">
    <div class="page-shell">
        <?php
        $activePage = 'dashboard';
        include __DIR__ . '/partials/internal_nav.php';
        ?>

        <?php if ($flash) : ?>
            <div class="notice notice--<?= ($flash['type'] ?? 'error') === 'success' ? 'success' : 'error' ?>" data-reveal>
                <?= e($flash['message'] ?? '') ?>
            </div>
        <?php endif; ?>

        <section class="dash-hero page-frame" data-reveal>
            <div class="dash-hero__copy">
                <span class="eyebrow"><span class="eyebrow__dot"></span> Dashboard command</span>
                <h1 class="headline-display">Publish, monitor, and shape the feed from one place.</h1>
                <p class="lede">
                    This is the redesigned operator view for <?= e(APP_PLATFORM) ?>. It combines posting, stats, search, and live content management in a calmer, more premium workspace.
                </p>

                <div class="kicker-row">
                    <span class="kicker"><?= count($allUsers) ?> registered members</span>
                    <span class="kicker"><?= (int)($summary['total'] ?? 0) ?> total stories</span>
                    <span class="kicker"><?= count($myPosts) ?> by you</span>
                </div>
            </div>

            <div class="dash-hero__metrics">
                <article class="metric-card">
                    <strong><?= (int)($summary['image'] ?? 0) ?></strong>
                    <span>Image stories across the platform</span>
                </article>
                <article class="metric-card">
                    <strong><?= (int)($summary['file'] ?? 0) ?></strong>
                    <span>File uploads ready for download</span>
                </article>
                <article class="metric-card">
                    <strong><?= profile_completion($user) ?>%</strong>
                    <span>Your profile completion right now</span>
                </article>
            </div>
        </section>

        <section class="dash-layout">
            <aside class="composer-panel panel" data-reveal>
                <div class="section-heading">
                    <div>
                        <span class="eyebrow"><span class="eyebrow__dot"></span> Broadcast</span>
                        <h2 class="headline-medium">Share a new moment</h2>
                    </div>
                </div>

                <form action="upload.php" method="post" enctype="multipart/form-data" class="composer-form">
                    <input type="hidden" name="redirect_to" value="dashboard.php">

                    <div class="field">
                        <label for="caption">Post text</label>
                        <textarea class="form-control" id="caption" name="caption" placeholder="Write a note, release a thought, or describe your upload."></textarea>
                    </div>

                    <div class="field">
                        <label for="media">Image or file</label>
                        <input class="form-control" type="file" id="media" name="media" accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.txt,.doc,.docx,.zip,image/*">
                    </div>

                    <p class="helper-text" id="dashboardFileHint">Supported: JPG, PNG, GIF, WEBP, PDF, TXT, DOC, DOCX, ZIP. Max size 10MB.</p>

                    <button class="button button--primary composer-submit" type="submit">Publish to Feed</button>
                </form>

                <div class="composer-stats">
                    <article>
                        <strong><?= count($myPosts) ?></strong>
                        <span>Your total posts</span>
                    </article>
                    <article>
                        <strong><?= (int)($mySummary['image'] ?? 0) ?></strong>
                        <span>Your image shares</span>
                    </article>
                    <article>
                        <strong><?= (int)($mySummary['file'] ?? 0) ?></strong>
                        <span>Your file drops</span>
                    </article>
                </div>
            </aside>

            <main class="feed-panel stack">
                <section class="filter-panel panel" data-reveal>
                    <div class="section-heading">
                        <div>
                            <span class="eyebrow"><span class="eyebrow__dot"></span> Feed control</span>
                            <h2 class="headline-medium">Search and filter</h2>
                        </div>
                        <p class="muted">Find posts by caption, person, username, or original filename.</p>
                    </div>

                    <form method="get" class="filter-form">
                        <div class="field">
                            <label for="q">Search</label>
                            <input class="form-control" type="text" id="q" name="q" value="<?= e($query) ?>" placeholder="Search the live feed">
                        </div>

                        <div class="field">
                            <label for="filter">Type</label>
                            <select class="form-control" id="filter" name="filter">
                                <option value="all" <?= $filter === 'all' ? 'selected' : '' ?>>All posts</option>
                                <option value="text" <?= $filter === 'text' ? 'selected' : '' ?>>Text only</option>
                                <option value="image" <?= $filter === 'image' ? 'selected' : '' ?>>Images</option>
                                <option value="file" <?= $filter === 'file' ? 'selected' : '' ?>>Files</option>
                            </select>
                        </div>

                        <button class="button button--secondary filter-submit" type="submit">Apply view</button>
                    </form>
                </section>

                <section class="posts-stack" data-reveal>
                    <?php if (empty($posts)) : ?>
                        <div class="empty-state">No posts matched this search. Try a broader keyword or publish something new from the composer.</div>
                    <?php else : ?>
                        <?php foreach ($posts as $post) : ?>
                            <?php
                            $name = (string)($post['name'] ?? 'User');
                            $username = (string)($post['username'] ?? 'user');
                            $caption = trim((string)($post['caption'] ?? ''));
                            $kind = (string)($post['kind'] ?? 'text');
                            $original = (string)($post['original_name'] ?? '');
                            $stored = (string)($post['stored_name'] ?? '');
                            $size = (int)($post['size'] ?? 0);
                            $createdAt = (int)($post['created_at'] ?? time());
                            ?>
                            <article class="post-card">
                                <div class="post-meta">
                                    <div class="avatar-token"><?= e(user_initials(['name' => $name, 'username' => $username])) ?></div>
                                    <div>
                                        <strong><?= e($name) ?></strong>
                                        <span>@<?= e($username) ?> / <?= e(time_ago($createdAt)) ?> / <?= e(format_post_time($createdAt)) ?></span>
                                    </div>
                                </div>

                                <div class="kicker-row">
                                    <span class="kicker"><?= e(strtoupper($kind)) ?></span>
                                    <?php if ($original !== '') : ?>
                                        <span class="kicker"><?= e($original) ?></span>
                                    <?php endif; ?>
                                </div>

                                <?php if ($caption !== '') : ?>
                                    <p class="post-copy"><?= nl2br(e($caption)) ?></p>
                                <?php endif; ?>

                                <?php if ($kind === 'image' && $stored !== '') : ?>
                                    <div class="media-frame">
                                        <img src="uploads/<?= e(rawurlencode($stored)) ?>" alt="Uploaded image">
                                    </div>
                                <?php elseif ($kind === 'file' && $stored !== '') : ?>
                                    <div class="file-attachment">
                                        <div>
                                            <strong><?= e($original !== '' ? $original : 'Uploaded file') ?></strong>
                                            <span><?= e(human_filesize($size)) ?> ready for download</span>
                                        </div>
                                        <a class="mini-link" href="uploads/<?= e(rawurlencode($stored)) ?>" download>Download</a>
                                    </div>
                                <?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </section>
            </main>

            <aside class="insight-rail stack">
                <section class="insight-card panel" data-reveal>
                    <span class="eyebrow"><span class="eyebrow__dot"></span> Live note</span>
                    <h2 class="headline-medium">Platform pulse</h2>
                    <p id="dashboardPulse"><?= e($pulseMessages[0]) ?></p>
                </section>

                <section class="insight-card panel" data-reveal>
                    <span class="eyebrow"><span class="eyebrow__dot"></span> Quick routes</span>
                    <div class="stack quick-links">
                        <a class="button button--secondary" href="explore.php">Open Explore</a>
                        <a class="button button--secondary" href="profile.php">Open Profile</a>
                    </div>
                </section>

                <section class="insight-card panel" data-reveal>
                    <span class="eyebrow"><span class="eyebrow__dot"></span> Design credit</span>
                    <p>The product language now runs as a full concept: Open AI x World AI, page-specific art direction, shared brand DNA, and a cleaner code structure.</p>
                </section>
            </aside>
        </section>
    </div>

    <script src="assets/js/theme.js"></script>
    <script src="assets/js/dashboard.js"></script>
</body>
</html>
