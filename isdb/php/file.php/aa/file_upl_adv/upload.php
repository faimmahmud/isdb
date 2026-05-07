<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$uploadDir = __DIR__ . "/uploads/";
$storeFile  = __DIR__ . "/store.txt";
$maxSize    = 5 * 1024 * 1024;

$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg', 'pdf', 'txt', 'zip', 'csv', 'doc', 'docx'];

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
if (!file_exists($storeFile)) {
    file_put_contents($storeFile, "");
}

function safeName(string $name): string {
    return preg_replace('/[^A-Za-z0-9._-]/', '_', $name);
}

function isImageFile(string $filename): bool {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'], true);
}

$msg = "";

if (isset($_POST['upload_btn'])) {
    if (!isset($_FILES['myfile']) || $_FILES['myfile']['error'] !== UPLOAD_ERR_OK) {
        $msg = "Please choose a valid file.";
    } elseif ($_FILES['myfile']['size'] > $maxSize) {
        $msg = "File too large. Max 5 MB.";
    } else {
        $originalName = basename($_FILES['myfile']['name']);
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExtensions, true)) {
            $msg = "This file type is not allowed.";
        } else {
            $savedName = time() . "_" . safeName($originalName);
            $targetPath = $uploadDir . $savedName;

            if (move_uploaded_file($_FILES['myfile']['tmp_name'], $targetPath)) {
                $type = isImageFile($savedName) ? "picture" : "file";
                $record = date("Y-m-d H:i:s") . " | original: " . $originalName . " | saved: " . $savedName . " | type: " . $type . PHP_EOL;
                file_put_contents($storeFile, $record, FILE_APPEND);
                $msg = "Upload successful.";
            } else {
                $msg = "Upload failed.";
            }
        }
    }
}

$history = [];
$lines = file($storeFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if ($lines) {
    $lines = array_reverse($lines);
    foreach ($lines as $line) {
        $parts = explode(" | ", $line);
        $entry = [
            'time' => $parts[0] ?? '',
            'original' => '',
            'saved' => '',
            'type' => ''
        ];

        foreach ($parts as $part) {
            if (str_starts_with($part, 'original: ')) $entry['original'] = trim(substr($part, 10));
            if (str_starts_with($part, 'saved: ')) $entry['saved'] = trim(substr($part, 7));
            if (str_starts_with($part, 'type: ')) $entry['type'] = trim(substr($part, 6));
        }

        $history[] = $entry;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Upload Vault</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        body {
            min-height: 100vh;
            color: #fff;
            overflow-x: hidden;
            background:
                radial-gradient(circle at top left, rgba(212,175,55,.11), transparent 22%),
                radial-gradient(circle at bottom right, rgba(95,156,255,.12), transparent 20%),
                linear-gradient(135deg, #04050a, #0a0f1a 45%, #06070d);
        }

        #stars {
            position: fixed;
            inset: 0;
            width: 100vw;
            height: 100vh;
            z-index: 0;
            pointer-events: none;
        }

        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
            z-index: 0;
            opacity: .8;
        }

        .orb.one {
            width: 420px;
            height: 420px;
            left: -120px;
            top: 12%;
            background: rgba(95,156,255,.18);
            animation: orbA 13s ease-in-out infinite alternate;
        }

        .orb.two {
            width: 520px;
            height: 520px;
            right: -160px;
            bottom: -120px;
            background: rgba(212,175,55,.14);
            animation: orbB 15s ease-in-out infinite alternate;
        }

        @keyframes orbA {
            from { transform: translate3d(0,0,0) scale(1); }
            to { transform: translate3d(80px, 80px, 0) scale(1.08); }
        }

        @keyframes orbB {
            from { transform: translate3d(0,0,0) scale(1); }
            to { transform: translate3d(-70px, -100px, 0) scale(1.06); }
        }

        .wrap {
            position: relative;
            z-index: 2;
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
            padding: 24px 0;
        }

        .top, .card {
            position: relative;
            overflow: hidden;
            background: rgba(10, 13, 20, 0.68);
            border: 1px solid rgba(255,255,255,.10);
            border-radius: 28px;
            backdrop-filter: blur(18px);
            box-shadow: 0 24px 70px rgba(0,0,0,.48);
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            padding: 20px 22px;
            margin-bottom: 20px;
        }

        .top::before,
        .card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 25%, rgba(255,255,255,.10), transparent 55%);
            transform: translateX(-120%);
            animation: shimmer 5.2s linear infinite;
            pointer-events: none;
        }

        @keyframes shimmer {
            from { transform: translateX(-120%); }
            to { transform: translateX(120%); }
        }

        h1 {
            font-size: 1.8rem;
            margin-bottom: 4px;
        }

        h2 {
            margin-bottom: 12px;
            font-size: 1.2rem;
        }

        p {
            color: rgba(255,255,255,.72);
            line-height: 1.6;
        }

        .logout {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 130px;
            text-decoration: none;
            color: #fff;
            padding: 13px 16px;
            border-radius: 14px;
            background: linear-gradient(135deg, #242a38, #0f1320);
            border: 1px solid rgba(255,255,255,.10);
            font-weight: 800;
            transition: .25s ease;
        }

        .logout:hover {
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 12px 26px rgba(0,0,0,.26);
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .card {
            padding: 24px;
        }

        .msg {
            margin-bottom: 14px;
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.08);
        }

        .field {
            margin-bottom: 14px;
        }

        input[type="file"] {
            width: 100%;
            padding: 12px;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,.12);
            background: rgba(255,255,255,.06);
            color: #fff;
        }

        button {
            width: 100%;
            margin-top: 10px;
            padding: 14px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #d7c6a2, #f1e7d2, #d9b46b);
            color: #111;
            font-weight: 900;
            letter-spacing: 1px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: .25s ease;
        }

        button:hover {
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 14px 30px rgba(212,175,55,.25);
        }

        button::after {
            content: "";
            position: absolute;
            top: -50%;
            left: -140%;
            width: 60%;
            height: 200%;
            transform: skewX(-24deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.45), transparent);
            animation: shine 2.6s ease-in-out infinite;
        }

        @keyframes shine {
            0% { left: -140%; }
            100% { left: 190%; }
        }

        .preview {
            margin-top: 14px;
            min-height: 220px;
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            text-align: center;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.10);
        }

        .preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            animation: imageRise .4s ease;
        }

        @keyframes imageRise {
            from { opacity: 0; transform: scale(1.05); }
            to { opacity: 1; transform: scale(1); }
        }

        .list {
            display: grid;
            gap: 12px;
            margin-top: 12px;
        }

        .item {
            padding: 14px;
            border-radius: 18px;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.08);
            animation: itemIn .4s ease;
            transition: transform .25s ease;
            word-break: break-word;
        }

        .item:hover {
            transform: translateY(-3px);
        }

        @keyframes itemIn {
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .badge {
            display: inline-block;
            margin-top: 10px;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(95,156,255,.12);
            color: #d9e7ff;
            font-size: .85rem;
        }

        .filelink {
            display: inline-flex;
            margin-top: 10px;
            padding: 10px 14px;
            text-decoration: none;
            color: #fff;
            border-radius: 12px;
            background: linear-gradient(135deg, #242a38, #0f1320);
            border: 1px solid rgba(255,255,255,.10);
            font-weight: 700;
        }

        @media (max-width: 900px) {
            .grid {
                grid-template-columns: 1fr;
            }

            .top {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <canvas id="stars"></canvas>
    <div class="orb one"></div>
    <div class="orb two"></div>

    <div class="wrap">
        <div class="top">
            <div>
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?></h1>
                <p>Upload picture or file. Pictures show preview and saved items appear below.</p>
            </div>
            <a class="logout" href="logout.php">Logout</a>
        </div>

        <div class="grid">
            <div class="card">
                <h2>Upload Panel</h2>

                <?php if ($msg !== ""): ?>
                    <div class="msg"><?php echo htmlspecialchars($msg); ?></div>
                <?php endif; ?>

                <form method="post" enctype="multipart/form-data">
                    <div class="field">
                        <input id="fileInput" type="file" name="myfile" required>
                    </div>
                    <button type="submit" name="upload_btn">Upload</button>
                </form>

                <div class="preview" id="previewBox">
                    Choose a picture to preview here
                </div>
            </div>

            <div class="card">
                <h2>Uploaded Items</h2>
                <div class="list">
                    <?php if (!empty($history)): ?>
                        <?php foreach (array_slice($history, 0, 10) as $item): ?>
                            <div class="item">
                                <strong><?php echo htmlspecialchars($item['original'] ?: 'Unknown'); ?></strong><br>
                                Saved as: <?php echo htmlspecialchars($item['saved']); ?><br>
                                Type: <?php echo htmlspecialchars($item['type']); ?><br>
                                Time: <?php echo htmlspecialchars($item['time']); ?>

                                <?php if (($item['type'] ?? '') === 'picture' && !empty($item['saved']) && file_exists($uploadDir . $item['saved'])): ?>
                                    <div style="margin-top:10px;overflow:hidden;border-radius:14px;">
                                        <img src="uploads/<?php echo rawurlencode($item['saved']); ?>" alt="image" style="width:100%;max-height:240px;object-fit:cover;display:block;">
                                    </div>
                                <?php else: ?>
                                    <span class="badge">File saved in uploads folder</span>
                                    <?php if (!empty($item['saved']) && file_exists($uploadDir . $item['saved'])): ?>
                                        <div>
                                            <a class="filelink" href="uploads/<?php echo rawurlencode($item['saved']); ?>" download>Download</a>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="item">No uploads yet.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        const fileInput = document.getElementById('fileInput');
        const previewBox = document.getElementById('previewBox');

        fileInput.addEventListener('change', function () {
            const file = this.files && this.files[0];
            if (!file) {
                previewBox.innerHTML = 'Choose a picture to preview here';
                return;
            }

            if (file.type && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = e => {
                    previewBox.innerHTML = '<img src="' + e.target.result + '" alt="preview">';
                };
                reader.readAsDataURL(file);
            } else {
                previewBox.innerHTML = '<div><strong>' + file.name + '</strong><br><br>No image preview for this file type.</div>';
            }
        });

        const canvas = document.getElementById('stars');
        const ctx = canvas.getContext('2d');
        let stars = [];

        function resizeStars() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            stars = [];

            const count = window.innerWidth < 800 ? 70 : 140;
            for (let i = 0; i < count; i++) {
                stars.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    r: Math.random() * 1.8 + 0.2,
                    s: Math.random() * 0.7 + 0.15
                });
            }
        }

        function drawStars() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            stars.forEach(star => {
                ctx.beginPath();
                ctx.arc(star.x, star.y, star.r, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(255,255,255,0.8)';
                ctx.fill();

                star.y -= star.s;
                if (star.y < -5) star.y = canvas.height + 5;
            });
            requestAnimationFrame(drawStars);
        }

        window.addEventListener('resize', resizeStars);
        resizeStars();
        drawStars();
    </script>
</body>
</html>