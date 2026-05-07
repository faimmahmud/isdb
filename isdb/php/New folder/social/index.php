<?php
require __DIR__ . '/config.php';

$viewer = current_user();
$users = load_users();
$posts = newest_posts(load_posts());
$summary = summarize_posts($posts);

$creatorCounts = [];
foreach ($posts as $post) {
    $key = (string)($post['username'] ?? $post['name'] ?? '');
    if ($key === '') {
        continue;
    }
    $creatorCounts[$key] = ($creatorCounts[$key] ?? 0) + 1;
}
arsort($creatorCounts);

$featuredCreators = [];
foreach (array_slice(array_keys($creatorCounts), 0, 3) as $username) {
    foreach ($users as $candidate) {
        if (strcasecmp((string)($candidate['username'] ?? ''), $username) === 0) {
            $featuredCreators[] = $candidate;
            break;
        }
    }
}

$featuredPosts = array_slice($posts, 0, 3);
$exploreHref = $viewer ? 'explore.php' : 'login.php';
$primaryHref = $viewer ? 'dashboard.php' : 'register.php';
$primaryLabel = $viewer ? 'Open Dashboard' : 'Create Account';
$secondaryHref = $viewer ? 'profile.php' : 'login.php';
$secondaryLabel = $viewer ? 'View Profile' : 'Login';

$tracks = [
    [
        'title' => 'Landing page with editorial impact',
        'copy' => 'A homepage that sells the story before the product even asks for a login.',
    ],
    [
        'title' => 'Distinct page art direction',
        'copy' => 'Login, register, dashboard, explore, and profile each get their own atmosphere.',
    ],
    [
        'title' => 'File-based PHP made premium',
        'copy' => 'The backend stays simple while the interface feels launch-ready and deliberate.',
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e(APP_NAME) ?> | <?= e(APP_PLATFORM) ?></title>
    <meta name="description" content="<?= e(APP_TAGLINE) ?>">
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/home.css">
</head>
<body class="home-page">
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
                <a class="nav-link" href="<?= e($exploreHref) ?>">Explore</a>
                <button
                    class="theme-toggle"
                    type="button"
                    data-theme-toggle
                    data-theme-label-light="Light"
                    data-theme-label-dark="Dark"
                >
                    Dark
                </button>
                <a class="button button--primary" href="<?= e($primaryHref) ?>"><?= e($primaryLabel) ?></a>
            </div>
        </header>

        <section class="home-hero page-frame" data-reveal>
            <div class="home-hero__copy">
                <span class="eyebrow"><span class="eyebrow__dot"></span> Open AI x World AI Edition</span>
                <h1 class="headline-display">A social media platform shaped like a product launch, not a classroom demo.</h1>
                <p class="lede">
                    <?= e(APP_PLATFORM) ?> turns your PHP social app into a cinematic, detail-rich experience with a different visual identity on every page while keeping the logic compact and readable.
                </p>

                <div class="cluster hero-actions">
                    <a class="button button--primary" href="<?= e($primaryHref) ?>"><?= e($primaryLabel) ?></a>
                    <a class="button button--secondary" href="<?= e($secondaryHref) ?>"><?= e($secondaryLabel) ?></a>
                </div>

                <div class="kicker-row">
                    <span class="kicker"><?= count($users) ?> registered creators</span>
                    <span class="kicker"><?= (int)($summary['total'] ?? 0) ?> stories in the system</span>
                    <span class="kicker"><?= human_filesize((int)($summary['bytes'] ?? 0)) ?> media delivered</span>
                </div>
            </div>

            <aside class="hero-board">
                <div class="hero-board__panel hero-board__panel--primary">
                    <p class="hero-board__label">Creative direction</p>
                    <h2>Every screen is intentionally different.</h2>
                    <p>Landing feels editorial, auth feels premium, dashboard feels operational, explore feels curatorial, and profile feels personal.</p>
                </div>

                <div class="hero-board__grid">
                    <div class="hero-stat">
                        <span>Text drops</span>
                        <strong><?= (int)($summary['text'] ?? 0) ?></strong>
                    </div>
                    <div class="hero-stat">
                        <span>Image stories</span>
                        <strong><?= (int)($summary['image'] ?? 0) ?></strong>
                    </div>
                    <div class="hero-stat">
                        <span>File assets</span>
                        <strong><?= (int)($summary['file'] ?? 0) ?></strong>
                    </div>
                    <div class="hero-stat">
                        <span>Active creators</span>
                        <strong><?= unique_creator_count($posts) ?></strong>
                    </div>
                </div>

                <div class="rotating-note panel">
                    <p class="hero-board__label">System pulse</p>
                    <strong id="homePulse">Distinct interfaces, one unified platform language.</strong>
                </div>
            </aside>
        </section>

        <section class="design-track" data-reveal>
            <div class="section-heading">
                <div>
                    <span class="eyebrow"><span class="eyebrow__dot"></span> What changed</span>
                    <h2 class="headline-medium">The experience now behaves like a real product system.</h2>
                </div>
                <p class="muted">Separate assets, clearer structure, stronger typography, richer storytelling, and more intentional UI rhythm.</p>
            </div>

            <div class="track-grid">
                <?php foreach ($tracks as $track) : ?>
                    <article class="track-card panel">
                        <h3><?= e($track['title']) ?></h3>
                        <p><?= e($track['copy']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="preview-band" data-reveal>
            <div class="section-heading">
                <div>
                    <span class="eyebrow"><span class="eyebrow__dot"></span> Live preview</span>
                    <h2 class="headline-medium">Real content already powers the presentation.</h2>
                </div>
                <p class="muted">These cards come from your stored feed, so the landing page reflects the actual system rather than placeholder copy.</p>
            </div>

            <?php if (empty($featuredPosts)) : ?>
                <div class="empty-state">No live posts yet. Publish from the dashboard and the platform preview will start filling in automatically.</div>
            <?php else : ?>
                <div class="preview-grid">
                    <?php foreach ($featuredPosts as $post) : ?>
                        <?php
                        $kind = (string)($post['kind'] ?? 'text');
                        $caption = trim((string)($post['caption'] ?? ''));
                        $original = (string)($post['original_name'] ?? '');
                        $stored = (string)($post['stored_name'] ?? '');
                        ?>
                        <article class="preview-card panel">
                            <div class="preview-card__top">
                                <span class="kicker"><?= e(strtoupper($kind)) ?></span>
                                <span class="muted"><?= e(time_ago((int)($post['created_at'] ?? time()))) ?></span>
                            </div>
                            <h3><?= e($post['name'] ?? $post['username'] ?? 'Creator') ?></h3>
                            <p><?= e($caption !== '' ? $caption : ($original !== '' ? $original : 'Shared directly from the feed.')) ?></p>

                            <?php if ($kind === 'image' && $stored !== '') : ?>
                                <div class="preview-card__media">
                                    <img src="uploads/<?= e(rawurlencode($stored)) ?>" alt="Preview from the feed">
                                </div>
                            <?php else : ?>
                                <div class="preview-card__foot">
                                    <span>@<?= e($post['username'] ?? 'creator') ?></span>
                                    <span><?= e(format_post_time((int)($post['created_at'] ?? time()))) ?></span>
                                </div>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <section class="creator-strip panel" data-reveal>
            <div>
                <span class="eyebrow"><span class="eyebrow__dot"></span> Creator signal</span>
                <h2 class="headline-medium">The product highlights people, not just posts.</h2>
            </div>

            <div class="creator-strip__list">
                <?php if (empty($featuredCreators)) : ?>
                    <div class="empty-state">Creators will appear here after they start publishing.</div>
                <?php else : ?>
                    <?php foreach ($featuredCreators as $creator) : ?>
                        <?php $creatorPosts = posts_for_user($posts, $creator); ?>
                        <article class="creator-card">
                            <div class="avatar-token"><?= e(user_initials($creator)) ?></div>
                            <strong><?= e($creator['name'] ?? 'Creator') ?></strong>
                            <span>@<?= e($creator['username'] ?? 'creator') ?></span>
                            <p><?= count($creatorPosts) ?> published moments, <?= profile_completion($creator) ?>% profile completion.</p>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <footer class="footer-note">
            <span><?= e(APP_NAME) ?> x <?= e(APP_PLATFORM) ?> is now structured as a multi-page, design-forward social media product.</span>
            <a class="button button--soft" href="<?= e($primaryHref) ?>">Continue into the app</a>
        </footer>
    </div>

    <script src="assets/js/theme.js"></script>
    <script src="assets/js/home.js"></script>
</body>
</html>
