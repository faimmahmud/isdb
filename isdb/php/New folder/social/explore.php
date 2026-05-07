<?php
require __DIR__ . '/config.php';
require_login();

$user = current_user_record() ?? current_user() ?? [];
$allPosts = newest_posts(load_posts());
$summary = summarize_posts($allPosts);

$query = trim($_GET['q'] ?? '');
$filter = trim($_GET['filter'] ?? 'all');
$results = filter_posts($allPosts, $query, $filter);

$imagePosts = array_values(array_filter($allPosts, static fn(array $post): bool => (string)($post['kind'] ?? 'text') === 'image'));
$filePosts = array_values(array_filter($allPosts, static fn(array $post): bool => (string)($post['kind'] ?? 'text') === 'file'));
$textPosts = array_values(array_filter($allPosts, static fn(array $post): bool => (string)($post['kind'] ?? 'text') === 'text'));
$spotlight = $allPosts[0] ?? null;

$creatorCounts = [];
foreach ($allPosts as $post) {
    $key = (string)($post['username'] ?? $post['name'] ?? '');
    if ($key === '') {
        continue;
    }
    $creatorCounts[$key] = ($creatorCounts[$key] ?? 0) + 1;
}
arsort($creatorCounts);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore | <?= e(APP_NAME) ?></title>
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/explore.css">
</head>
<body class="explore-page">
    <div class="page-shell">
        <?php
        $activePage = 'explore';
        include __DIR__ . '/partials/internal_nav.php';
        ?>

        <section class="explore-hero page-frame" data-reveal>
            <div class="explore-hero__copy">
                <span class="eyebrow"><span class="eyebrow__dot"></span> Discovery surface</span>
                <h1 class="headline-display">Browse the platform like a curated media gallery.</h1>
                <p class="lede">
                    Explore reframes the same content as discovery-first browsing. It is intentionally different from the dashboard so the product feels wider, richer, and more considered.
                </p>

                <div class="kicker-row">
                    <span class="kicker"><?= (int)($summary['image'] ?? 0) ?> image stories</span>
                    <span class="kicker"><?= (int)($summary['file'] ?? 0) ?> document drops</span>
                    <span class="kicker"><?= (int)($summary['text'] ?? 0) ?> text notes</span>
                </div>
            </div>

            <form method="get" class="explore-search panel">
                <div class="field">
                    <label for="explore_q">Search content</label>
                    <input class="form-control" type="text" id="explore_q" name="q" value="<?= e($query) ?>" placeholder="Search by caption, creator, or filename">
                </div>

                <div class="field">
                    <label for="explore_filter">Focus mode</label>
                    <select class="form-control" id="explore_filter" name="filter">
                        <option value="all" <?= $filter === 'all' ? 'selected' : '' ?>>All content</option>
                        <option value="image" <?= $filter === 'image' ? 'selected' : '' ?>>Images</option>
                        <option value="file" <?= $filter === 'file' ? 'selected' : '' ?>>Files</option>
                        <option value="text" <?= $filter === 'text' ? 'selected' : '' ?>>Text</option>
                    </select>
                </div>

                <button class="button button--primary" type="submit">Refresh discovery</button>
            </form>
        </section>

        <section class="explore-layout">
            <div class="explore-main stack">
                <?php if ($spotlight) : ?>
                    <?php
                    $spotlightCaption = trim((string)($spotlight['caption'] ?? ''));
                    $spotlightStored = (string)($spotlight['stored_name'] ?? '');
                    $spotlightOriginal = (string)($spotlight['original_name'] ?? '');
                    ?>
                    <article class="spotlight-card panel" data-reveal>
                        <div class="spotlight-card__copy">
                            <span class="eyebrow"><span class="eyebrow__dot"></span> Spotlight</span>
                            <h2 class="headline-medium"><?= e($spotlight['name'] ?? $spotlight['username'] ?? 'Creator') ?></h2>
                            <p><?= e($spotlightCaption !== '' ? $spotlightCaption : ($spotlightOriginal !== '' ? $spotlightOriginal : 'Latest live post from the network.')) ?></p>
                            <div class="kicker-row">
                                <span class="kicker">@<?= e($spotlight['username'] ?? 'creator') ?></span>
                                <span class="kicker"><?= e(time_ago((int)($spotlight['created_at'] ?? time()))) ?></span>
                            </div>
                        </div>

                        <?php if ((string)($spotlight['kind'] ?? 'text') === 'image' && $spotlightStored !== '') : ?>
                            <div class="spotlight-card__media">
                                <img src="uploads/<?= e(rawurlencode($spotlightStored)) ?>" alt="Spotlight post">
                            </div>
                        <?php else : ?>
                            <div class="spotlight-card__meta">
                                <strong><?= e(strtoupper((string)($spotlight['kind'] ?? 'text'))) ?></strong>
                                <span><?= e(format_post_time((int)($spotlight['created_at'] ?? time()))) ?></span>
                            </div>
                        <?php endif; ?>
                    </article>
                <?php endif; ?>

                <?php if ($query !== '' || $filter !== 'all') : ?>
                    <section class="curation-block" data-reveal>
                        <div class="section-heading">
                            <div>
                                <span class="eyebrow"><span class="eyebrow__dot"></span> Search results</span>
                                <h2 class="headline-medium">Matching posts</h2>
                            </div>
                            <p class="muted"><?= count($results) ?> results for the current discovery view.</p>
                        </div>

                        <?php if (empty($results)) : ?>
                            <div class="empty-state">Nothing matched this search. Clear the filter or try a broader keyword.</div>
                        <?php else : ?>
                            <div class="preview-grid preview-grid--results">
                                <?php foreach ($results as $post) : ?>
                                    <?php
                                    $kind = (string)($post['kind'] ?? 'text');
                                    $caption = trim((string)($post['caption'] ?? ''));
                                    $stored = (string)($post['stored_name'] ?? '');
                                    ?>
                                    <article class="preview-card panel">
                                        <div class="preview-card__top">
                                            <span class="kicker"><?= e(strtoupper($kind)) ?></span>
                                            <span class="muted"><?= e(time_ago((int)($post['created_at'] ?? time()))) ?></span>
                                        </div>
                                        <h3><?= e($post['name'] ?? $post['username'] ?? 'Creator') ?></h3>
                                        <p><?= e($caption !== '' ? $caption : ((string)($post['original_name'] ?? 'Live feed content'))) ?></p>

                                        <?php if ($kind === 'image' && $stored !== '') : ?>
                                            <div class="preview-card__media">
                                                <img src="uploads/<?= e(rawurlencode($stored)) ?>" alt="Discovery result">
                                            </div>
                                        <?php endif; ?>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </section>
                <?php endif; ?>

                <section class="curation-block" data-reveal>
                    <div class="section-heading">
                        <div>
                            <span class="eyebrow"><span class="eyebrow__dot"></span> Curated channels</span>
                            <h2 class="headline-medium">Three ways to browse the same network</h2>
                        </div>
                        <p class="muted">Images, files, and text now each get their own presentation rhythm.</p>
                    </div>

                    <div class="channel-grid">
                        <article class="channel-card panel">
                            <h3>Visual Stories</h3>
                            <p>Image-first content displayed in a gallery-led layout.</p>
                            <div class="channel-card__stack">
                                <?php foreach (array_slice($imagePosts, 0, 3) as $post) : ?>
                                    <span><?= e($post['name'] ?? $post['username'] ?? 'Creator') ?> / <?= e(time_ago((int)($post['created_at'] ?? time()))) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </article>

                        <article class="channel-card panel">
                            <h3>Document Drops</h3>
                            <p>Files framed as assets and deliverables rather than generic attachments.</p>
                            <div class="channel-card__stack">
                                <?php foreach (array_slice($filePosts, 0, 3) as $post) : ?>
                                    <span><?= e($post['original_name'] ?? 'Uploaded file') ?> / <?= e(human_filesize((int)($post['size'] ?? 0))) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </article>

                        <article class="channel-card panel">
                            <h3>Text Notes</h3>
                            <p>Short messages stay readable and calm without being buried under chrome.</p>
                            <div class="channel-card__stack">
                                <?php foreach (array_slice($textPosts, 0, 3) as $post) : ?>
                                    <span><?= e(trim((string)($post['caption'] ?? 'Shared note'))) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </article>
                    </div>
                </section>
            </div>

            <aside class="explore-side stack">
                <section class="leaderboard-card panel" data-reveal>
                    <span class="eyebrow"><span class="eyebrow__dot"></span> Activity board</span>
                    <h2 class="headline-medium">Top creators</h2>
                    <div class="leaderboard-list">
                        <?php if (empty($creatorCounts)) : ?>
                            <div class="empty-state">Publishing activity will appear here as soon as creators start posting.</div>
                        <?php else : ?>
                            <?php foreach (array_slice($creatorCounts, 0, 5, true) as $creator => $count) : ?>
                                <article class="leaderboard-item">
                                    <div class="avatar-token"><?= e(user_initials(['username' => $creator])) ?></div>
                                    <div>
                                        <strong>@<?= e($creator) ?></strong>
                                        <span><?= (int)$count ?> published posts</span>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </section>

                <section class="leaderboard-card panel" data-reveal>
                    <span class="eyebrow"><span class="eyebrow__dot"></span> Next step</span>
                    <p>Explore gives the app a discovery identity. Use Dashboard to publish more content, then Profile to review your own footprint.</p>
                    <div class="stack quick-links">
                        <a class="button button--secondary" href="dashboard.php">Return to Dashboard</a>
                        <a class="button button--secondary" href="profile.php">Open Profile</a>
                    </div>
                </section>
            </aside>
        </section>
    </div>

    <script src="assets/js/theme.js"></script>
    <script src="assets/js/explore.js"></script>
</body>
</html>
