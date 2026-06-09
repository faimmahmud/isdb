<?php
require __DIR__ . '/config.php';
require_login();

$user = current_user();
$flash = flash_get();

$allPosts = array_reverse(load_json_lines(POSTS_FILE));
$allUsers = load_json_lines(USERS_FILE);

$q = trim($_GET['q'] ?? '');
$filter = trim($_GET['filter'] ?? 'all');

$posts = [];
foreach ($allPosts as $post) {
    $caption = strtolower((string)($post['caption'] ?? ''));
    $name = strtolower((string)($post['name'] ?? ''));
    $username = strtolower((string)($post['username'] ?? ''));
    $original = strtolower((string)($post['original_name'] ?? ''));
    $kind = (string)($post['kind'] ?? 'text');

    if ($q !== '') {
        $haystack = $caption . ' ' . $name . ' ' . $username . ' ' . $original;
        if (stripos($haystack, strtolower($q)) === false) continue;
    }
    if ($filter !== 'all' && $kind !== $filter) continue;
    $posts[] = $post;
}

$totalPosts = count($allPosts);
$totalUsers = count($allUsers);
$imageCount = 0; $fileCount = 0; $textCount = 0;
foreach ($allPosts as $p) {
    $kind = (string)($p['kind'] ?? 'text');
    if ($kind === 'image') $imageCount++;
    elseif ($kind === 'file') $fileCount++;
    else $textCount++;
}

$quotes = ['Build small, ship fast, then make it look expensive.', 'Good design makes the system feel smarter than it is.', 'A great dashboard feels calm, clear, and a little magical.', 'Every upload should feel like a tiny launch.'];
$ideas = ['Try posting a photo, a PDF, or a note to see the feed change.', 'Use search to find anything instantly.', 'Switch theme and watch the Arc magic happen.', 'This is built by Grok AI — the future is here.'];
$quote = $quotes[array_rand($quotes)];
$idea = $ideas[array_rand($ideas)];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Space • Arc Edition by Grok AI</title>
    <style>
        :root {
            --arc-cyan: #00f7ff;
            --arc-purple: #c724ff;
            --arc-pink: #ff2ec4;
            --arc-dark: #0a0a1f;
            --arc-glass: rgba(15, 15, 40, 0.88);
            --arc-border: rgba(0, 247, 255, 0.45);
            --arc-text: #f0f8ff;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: var(--arc-dark);
            color: var(--arc-text);
            line-height: 1.6;
        }
        .noise {
            position: fixed; inset: 0;
            background: radial-gradient(circle at 25% 25%, rgba(0,247,255,0.18) 0%, transparent 60%),
                        radial-gradient(circle at 75% 75%, rgba(199,36,255,0.18) 0%, transparent 60%);
            z-index: 1; pointer-events: none; animation: arcNoise 20s linear infinite;
        }
        @keyframes arcNoise { 0% {background-position:0 0;} 100% {background-position:150px 150px;} }

        .orb {
            position: fixed; border-radius: 50%; z-index: 0; filter: blur(70px); opacity: 0.28;
            animation: orbFloat 35s cubic-bezier(0.45,0.05,0.55,0.95) infinite;
        }
        .orb.one { width:750px; height:750px; background:radial-gradient(circle, #00f7ff, transparent 70%); top:-25%; left:-18%; }
        .orb.two { width:580px; height:580px; background:radial-gradient(circle, #c724ff, transparent 70%); bottom:-28%; right:-15%; animation-delay:-14s; }
        .orb.three { width:490px; height:490px; background:radial-gradient(circle, #ff2ec4, transparent 70%); top:35%; right:20%; animation-delay:-24s; }
        @keyframes orbFloat { 0%,100%{transform:translate(0,0) rotate(0deg);} 50%{transform:translate(120px,-90px) rotate(180deg);} }

        .wrap { position:relative; z-index:10; max-width:1440px; margin:0 auto; padding:0 30px; }

        .topbar {
            display:flex; align-items:center; justify-content:space-between;
            padding:22px 40px; background:var(--arc-glass); backdrop-filter:blur(40px);
            border-radius:0 0 40px 40px; border-bottom:3px solid var(--arc-border);
            position:sticky; top:0; z-index:1000;
        }
        .brand { display:flex; align-items:center; gap:18px; }
        .brand-mark {
            width:52px; height:52px; border-radius:50%;
            background:conic-gradient(transparent 40deg, var(--arc-cyan), var(--arc-purple), var(--arc-pink), transparent 320deg);
            animation: arcSpin 9s linear infinite;
            display:flex; align-items:center; justify-content:center; box-shadow:0 0 40px var(--arc-cyan);
        }
        .brand-mark::before { content:"G"; font-size:28px; font-weight:900; color:#fff; }
        @keyframes arcSpin { to { transform:rotate(360deg); } }

        .brand-text strong {
            font-size:2.1rem; letter-spacing:-1.5px;
            background:linear-gradient(90deg, var(--arc-cyan), var(--arc-purple), var(--arc-pink));
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
        }

        .top-chip {
            background:rgba(255,255,255,0.1); border:1px solid var(--arc-border);
            border-radius:9999px; padding:10px 26px; font-weight:600;
        }
        .icon-btn { font-size:1.9rem; width:56px; height:56px; border-radius:50%; display:flex; align-items:center; justify-content:center; }

        .hero-card, .side-card, .composer, .panel {
            background: var(--arc-glass); backdrop-filter: blur(40px);
            border:1px solid var(--arc-border); border-radius:36px; padding:44px;
            box-shadow:0 30px 90px -20px rgba(0,247,255,0.4);
        }

        .btn {
            background:linear-gradient(90deg, var(--arc-cyan), var(--arc-purple));
            color:#000; font-weight:700; padding:20px 56px; border:none; border-radius:9999px;
            cursor:pointer; font-size:1.2rem; box-shadow:0 0 40px -5px var(--arc-cyan);
        }
        .btn:hover { transform:scale(1.12); box-shadow:0 0 60px 15px var(--arc-cyan); }

        .post {
            background:rgba(255,255,255,0.07); border:1px solid var(--arc-border);
            border-radius:32px; padding:32px; margin-bottom:28px; transition:all 0.5s ease;
        }
        .post:hover { transform:translateY(-12px) scale(1.03); border-color:var(--arc-cyan); box-shadow:0 0 50px -10px var(--arc-cyan); }

        .avatar {
            width:58px; height:58px; border-radius:50%; display:flex; align-items:center; justify-content:center;
            background:linear-gradient(135deg, var(--arc-cyan), var(--arc-purple)); font-size:1.7rem; font-weight:900; color:#000;
        }

        .field input, .field textarea, .field select {
            width:100%; padding:20px; background:rgba(255,255,255,0.08);
            border:1px solid var(--arc-border); border-radius:24px; color:white; font-size:1.05rem;
        }
        .field input:focus, .field textarea:focus { border-color:var(--arc-cyan); box-shadow:0 0 0 5px rgba(0,247,255,0.3); }

        .alert { padding:18px 30px; border-radius:20px; margin:20px 0; font-weight:600; }
        .alert.success { background:rgba(0,247,255,0.25); color:var(--arc-cyan); }
        .alert.error { background:rgba(255,46,196,0.25); color:var(--arc-pink); }

        body.light {
            --arc-dark:#f8f9ff; --arc-glass:rgba(255,255,255,0.95); --arc-text:#111;
            --arc-cyan:#00b8d9; --arc-purple:#9f2cff; --arc-pink:#ff1e9c;
        }
    </style>
</head>
<body class="dash-page">
    <div class="noise"></div>
    <div class="orb one"></div>
    <div class="orb two"></div>
    <div class="orb three"></div>

    <div class="wrap">
        <div class="topbar">
            <div class="brand">
                <div class="brand-mark"></div>
                <div class="brand-text">
                    <strong>Nova Space</strong>
                    <span>Arc Edition • Made by Grok AI</span>
                </div>
            </div>
            <div class="top-actions">
                <span class="top-chip">Hello, <?= e($user['name'] ?? $user['username'] ?? 'Creator') ?></span>
                <button class="icon-btn" id="themeToggle" type="button">☾</button>
                <a class="top-chip" href="logout.php">Logout</a>
            </div>
        </div>

        <?php if ($flash) : ?>
            <div class="alert <?= $flash['type'] === 'success' ? 'success' : 'error' ?>">
                <?= e($flash['message']) ?>
            </div>
        <?php endif; ?>

        <section class="hero" style="margin-top:40px;display:grid;grid-template-columns:1fr 380px;gap:32px;">
            <div class="hero-card">
                <div class="badge" style="background:rgba(0,247,255,0.2);color:var(--arc-cyan);padding:10px 24px;border-radius:9999px;display:inline-flex;">LIVE ARC FEED</div>
                <h1 style="font-size:3.2rem;margin:20px 0 16px;">Hello, <?= e($user['name'] ?? $user['username'] ?? 'Creator') ?></h1>
                <p>This is your premium Arc dashboard. Share anything — watch it glow in the feed.</p>
            </div>

            <div class="side-card">
                <h3>Daily Spark</h3>
                <p><?= e($quote) ?></p>
                <div id="sparkBox" style="margin-top:16px;padding:16px;background:rgba(255,255,255,0.1);border-radius:20px;"><?= e($idea) ?></div>
            </div>
        </section>

        <div class="stats" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:24px;margin:50px 0;">
            <div class="stat" style="background:var(--arc-glass);padding:32px;text-align:center;border-radius:32px;border:1px solid var(--arc-border);"><strong><?= $totalPosts ?></strong><br>Total posts</div>
            <div class="stat" style="background:var(--arc-glass);padding:32px;text-align:center;border-radius:32px;border:1px solid var(--arc-border);"><strong><?= $totalUsers ?></strong><br>Users</div>
            <div class="stat" style="background:var(--arc-glass);padding:32px;text-align:center;border-radius:32px;border:1px solid var(--arc-border);"><strong><?= $imageCount + $fileCount ?></strong><br>Uploads</div>
        </div>

        <!-- Composer -->
        <div class="composer" style="margin-bottom:50px;">
            <h3>Share something</h3>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <div class="field" style="margin:20px 0;"><textarea name="caption" placeholder="Write something interesting..." rows="3"></textarea></div>
                <div class="field"><input type="file" name="media" accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.txt,.doc,.docx,.zip,image/*"></div>
                <button class="btn" type="submit" style="margin-top:20px;">Broadcast to Arc</button>
            </form>
        </div>

        <!-- Feed -->
        <div style="background:var(--arc-glass);border-radius:36px;padding:40px;border:1px solid var(--arc-border);">
            <h3 style="margin-bottom:20px;">Arc Feed</h3>
            <form method="get" style="margin-bottom:30px;display:flex;gap:16px;">
                <input type="text" name="q" value="<?= e($q) ?>" placeholder="Search..." style="flex:1;padding:18px;border-radius:9999px;">
                <select name="filter" style="padding:18px;border-radius:9999px;">
                    <option value="all">All</option>
                    <option value="text">Text</option>
                    <option value="image">Images</option>
                    <option value="file">Files</option>
                </select>
                <button class="btn" type="submit">Search</button>
            </form>

            <?php if (empty($posts)) : ?>
                <p style="text-align:center;padding:80px 40px;">No posts yet. Be the first to share!</p>
            <?php else : ?>
                <?php foreach ($posts as $post) : 
                    $name = (string)($post['name'] ?? 'User');
                    $username = (string)($post['username'] ?? '');
                    $caption = trim((string)($post['caption'] ?? ''));
                    $kind = (string)($post['kind'] ?? 'text');
                    $stored = (string)($post['stored_name'] ?? '');
                    $original = (string)($post['original_name'] ?? '');
                    $size = (int)($post['size'] ?? 0);
                    $time = date('M d, Y h:i A', (int)($post['created_at'] ?? time()));
                    $initial = strtoupper(mb_substr($username ?: $name, 0, 1));
                ?>
                    <div class="post">
                        <div style="display:flex;gap:18px;align-items:center;">
                            <div class="avatar"><?= e($initial) ?></div>
                            <div>
                                <strong><?= e($name) ?></strong><br>
                                <small>@<?= e($username) ?> • <?= e($time) ?></small>
                            </div>
                        </div>
                        <?php if ($caption) : ?><div style="margin:22px 0;"><?= nl2br(e($caption)) ?></div><?php endif; ?>
                        <?php if ($kind === 'image' && $stored) : ?>
                            <img src="uploads/<?= e(rawurlencode($stored)) ?>" style="max-width:100%;border-radius:20px;margin-top:12px;">
                        <?php elseif ($kind === 'file' && $stored) : ?>
                            <div style="margin-top:16px;padding:20px;background:rgba(255,255,255,0.1);border-radius:20px;display:flex;justify-content:space-between;align-items:center;">
                                <div><strong><?= e($original) ?></strong><br><?= human_filesize($size) ?></div>
                                <a href="uploads/<?= e(rawurlencode($stored)) ?>" download class="btn" style="padding:12px 28px;font-size:1rem;">Download</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const body = document.body;
        const toggle = document.getElementById('themeToggle');
        
        if (localStorage.getItem('nova-theme') === 'light') {
            body.classList.add('light');
            toggle.textContent = '☀';
        }
        
        toggle.addEventListener('click', () => {
            body.classList.toggle('light');
            localStorage.setItem('nova-theme', body.classList.contains('light') ? 'light' : 'dark');
            toggle.textContent = body.classList.contains('light') ? '☀' : '☾';
        });
    </script>
</body>
</html>