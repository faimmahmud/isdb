<?php
session_start();

$validUser = 'admin';
$validPass = '12345';
$maxUploadBytes = 5 * 1024 * 1024; // 5 MB
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg', 'pdf', 'txt', 'zip', 'csv', 'doc', 'docx'];

$uploadDir = __DIR__ . '/uploads';
$storeFile = __DIR__ . '/store.txt';

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

function isAllowedUpload(string $filename, array $allowedExtensions): bool {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($ext, $allowedExtensions, true);
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}

$loginError = '';
$uploadMessage = '';
$history = [];

if (isset($_POST['login_btn'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $loginError = 'Please fill in both username and password.';
    } elseif (strlen($username) < 3 || strlen($password) < 3) {
        $loginError = 'Username and password must be at least 3 characters.';
    } elseif ($username === $validUser && $password === $validPass) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
        exit;
    } else {
        $loginError = 'Invalid username or password.';
    }
}

if (isset($_POST['upload_btn']) && !empty($_SESSION['logged_in'])) {
    if (!isset($_FILES['myfile']) || empty($_FILES['myfile']['name'])) {
        $uploadMessage = 'Please choose a file first.';
    } elseif ($_FILES['myfile']['error'] !== UPLOAD_ERR_OK) {
        $uploadMessage = 'There was an error while uploading the file.';
    } elseif ($_FILES['myfile']['size'] > $maxUploadBytes) {
        $uploadMessage = 'File is too large. Maximum size is 5 MB.';
    } else {
        $originalName = basename($_FILES['myfile']['name']);
        $tmpName = $_FILES['myfile']['tmp_name'];
        $safeOriginal = safeName($originalName);
        $savedName = time() . '_' . $safeOriginal;
        $targetPath = $uploadDir . '/' . $savedName;
        $type = isImageFile($savedName) ? 'picture' : 'file';

        if (!isAllowedUpload($savedName, $allowedExtensions)) {
            $uploadMessage = 'This file type is not allowed.';
        } elseif (move_uploaded_file($tmpName, $targetPath)) {
            $record = date('Y-m-d H:i:s') . " | original: {$originalName} | saved: {$savedName} | type: {$type}" . PHP_EOL;
            file_put_contents($storeFile, $record, FILE_APPEND);
            $uploadMessage = 'Upload successful.';
        } else {
            $uploadMessage = 'File upload failed.';
        }
    }
}

$lines = file($storeFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if ($lines) {
    $lines = array_reverse($lines);
    foreach ($lines as $line) {
        $parts = explode(' | ', $line);
        $entry = ['time' => $parts[0] ?? '', 'original' => '', 'saved' => '', 'type' => ''];
        foreach ($parts as $part) {
            if (str_starts_with($part, 'original: ')) $entry['original'] = trim(substr($part, 10));
            if (str_starts_with($part, 'saved: ')) $entry['saved'] = trim(substr($part, 7));
            if (str_starts_with($part, 'type: ')) $entry['type'] = trim(substr($part, 6));
        }
        $history[] = $entry;
    }
}

$loggedIn = !empty($_SESSION['logged_in']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>data.php</title>
    <style>
        :root {
            --bg0: #06070b;
            --bg1: #0b0e16;
            --bg2: #121624;
            --card: rgba(255,255,255,0.80);
            --line: rgba(255,255,255,0.10);
            --text: #f8f6f0;
            --text-dark: #0f172a;
            --muted: rgba(248,246,240,0.72);
            --accent: #d7c6a2;
            --accent2: #8f7a57;
            --accent3: #d9b46b;
            --success: #86efac;
            --danger: #fda4af;
            --shadow: 0 24px 70px rgba(0,0,0,0.45);
            --radius-xl: 34px;
            --radius-lg: 24px;
            --radius-md: 18px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            overflow-x: hidden;
            color: var(--text);
            background:
                radial-gradient(circle at 18% 18%, rgba(215,198,162,0.14), transparent 20%),
                radial-gradient(circle at 82% 16%, rgba(217,180,107,0.10), transparent 18%),
                radial-gradient(circle at 50% 88%, rgba(143,122,87,0.10), transparent 24%),
                linear-gradient(180deg, var(--bg0), var(--bg1) 45%, var(--bg2));
        }

        .scene {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
        }

        .luxury-surface,
        .luxury-surface-2,
        .luxury-halo,
        .luxury-halo-2,
        .luxury-ribbon,
        .luxury-ribbon-2,
        .grain {
            position: fixed;
            inset: 0;
            pointer-events: none;
        }

        .grain {
            opacity: 0.04;
            background-image: radial-gradient(rgba(255,255,255,0.85) 0.7px, transparent 0.7px);
            background-size: 4px 4px;
            mix-blend-mode: soft-light;
        }

        .luxury-halo {
            width: 720px;
            height: 720px;
            border-radius: 50%;
            left: -180px;
            top: -220px;
            background: radial-gradient(circle, rgba(215,198,162,0.18), rgba(215,198,162,0.04) 48%, transparent 70%);
            filter: blur(28px);
            opacity: 0.85;
            animation: haloDrift 18s ease-in-out infinite;
        }

        .luxury-halo-2 {
            width: 860px;
            height: 860px;
            border-radius: 50%;
            right: -260px;
            bottom: -280px;
            left: auto;
            top: auto;
            background: radial-gradient(circle, rgba(217,180,107,0.12), rgba(217,180,107,0.03) 50%, transparent 72%);
            filter: blur(34px);
            opacity: 0.75;
            animation: haloDrift2 22s ease-in-out infinite;
        }

        .luxury-surface {
            background:
                linear-gradient(120deg, transparent 34%, rgba(255,255,255,0.07) 44%, transparent 54%),
                linear-gradient(180deg, rgba(255,255,255,0.04), transparent 40%);
            background-size: 220% 220%, 100% 100%;
            animation: silkSweep 10s ease-in-out infinite;
            opacity: 0.8;
        }

        .luxury-surface-2 {
            background:
                radial-gradient(ellipse at 50% 50%, rgba(255,255,255,0.05), transparent 60%),
                conic-gradient(from 180deg at 50% 50%, rgba(215,198,162,0.00), rgba(215,198,162,0.12), rgba(143,122,87,0.00), rgba(217,180,107,0.10), rgba(215,198,162,0.00));
            filter: blur(50px);
            opacity: 0.32;
            animation: crownRotate 34s linear infinite;
        }

        .luxury-ribbon,
        .luxury-ribbon-2 {
            width: 140%;
            height: 220px;
            left: -20%;
            top: 14%;
            transform: rotate(-8deg);
            background: linear-gradient(90deg,
                transparent 0%,
                rgba(215,198,162,0.00) 20%,
                rgba(215,198,162,0.12) 35%,
                rgba(255,255,255,0.10) 50%,
                rgba(217,180,107,0.12) 65%,
                transparent 80%);
            filter: blur(16px);
            opacity: 0.55;
            animation: ribbonSlide 16s ease-in-out infinite;
        }

        .luxury-ribbon-2 {
            top: auto;
            bottom: 10%;
            transform: rotate(9deg);
            opacity: 0.32;
            animation-duration: 20s;
        }

        .shell {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
        }

        .app {
            width: min(1140px, 100%);
            background: rgba(13, 16, 24, 0.62);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 34px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(18px);
            overflow: hidden;
            animation: popIn 420ms ease both;
            position: relative;
        }

        .app::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(115deg, transparent 0%, rgba(255,255,255,0.10) 48%, transparent 56%),
                linear-gradient(180deg, rgba(255,255,255,0.05), transparent 26%);
            background-size: 220% 220%, 100% 100%;
            animation: shimmer 11s ease-in-out infinite;
            pointer-events: none;
            opacity: 0.55;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 22px 26px;
            background: rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            position: relative;
            overflow: hidden;
        }

        .topbar::after {
            content: '';
            position: absolute;
            inset: auto -10% 0 -10%;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(215,198,162,0.95), rgba(255,255,255,0.65), rgba(217,180,107,0.95), transparent);
            animation: sweep 7s linear infinite;
            filter: blur(0.2px);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            z-index: 1;
        }

        .mark {
            width: 46px;
            height: 46px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--accent), var(--accent2), var(--accent3));
            background-size: 200% 200%;
            animation: gradientFlow 9s ease-in-out infinite;
            box-shadow: 0 10px 24px rgba(215,198,162,0.14);
            position: relative;
            overflow: hidden;
        }

        .mark::before {
            content: '';
            position: absolute;
            inset: 11px;
            border-radius: 10px;
            border: 2px solid rgba(255,255,255,0.86);
        }

        .brand h1 {
            font-size: 1.1rem;
            line-height: 1.2;
            letter-spacing: 0.2px;
            animation: breathe 5s ease-in-out infinite;
        }

        .brand p {
            color: rgba(248,246,240,0.68);
            font-size: 0.92rem;
            margin-top: 2px;
        }

        .status-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: #22c55e;
            box-shadow: 0 0 0 0 rgba(34,197,94,0.55);
            animation: pulseDot 1.8s infinite;
            margin-right: 8px;
            vertical-align: middle;
        }

        .pill {
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.10);
            color: rgba(248,246,240,0.72);
            font-size: 0.92rem;
            position: relative;
            z-index: 1;
        }

        .grid {
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
        }

        .panel {
            padding: 34px;
        }

        .panel.left {
            border-right: 1px solid rgba(255,255,255,0.08);
            background: linear-gradient(180deg, rgba(255,255,255,0.06), rgba(255,255,255,0.03));
            position: relative;
            overflow: hidden;
        }

        .panel.left::before {
            content: '';
            position: absolute;
            inset: auto -60px 10% auto;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(215,198,162,0.12), transparent 68%);
            animation: haloDrift 12s ease-in-out infinite;
        }

        .panel.right {
            position: relative;
        }

        .hero h2 {
            font-size: clamp(2rem, 3.8vw, 3.7rem);
            line-height: 1.05;
            letter-spacing: -0.03em;
            max-width: 11ch;
        }

        .hero p {
            margin-top: 16px;
            font-size: 1rem;
            line-height: 1.7;
            color: rgba(248,246,240,0.72);
            max-width: 56ch;
        }

        .feature-grid {
            margin-top: 28px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .feature {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.10);
            border-radius: var(--radius-md);
            padding: 18px;
            min-height: 118px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
            animation: floatCard 8s ease-in-out infinite;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .feature::after {
            content: '';
            position: absolute;
            inset: auto -20% -20% auto;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(215,198,162,0.10), transparent 70%);
            animation: tinyGlow 4.5s ease-in-out infinite;
        }

        .feature:nth-child(2n) { animation-delay: -2s; }
        .feature:nth-child(3n) { animation-delay: -4s; }

        .feature:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.14);
            border-color: rgba(215,198,162,0.26);
        }

        .feature strong {
            display: block;
            font-size: 0.98rem;
            margin-bottom: 8px;
            color: #fff;
        }

        .feature span {
            color: rgba(248,246,240,0.72);
            font-size: 0.93rem;
            line-height: 1.6;
        }

        .form-card {
            max-width: 430px;
            margin: 0 auto;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.10);
            border-radius: 28px;
            padding: 26px;
            box-shadow: 0 12px 28px rgba(0,0,0,0.15);
            animation: cardLift 6s ease-in-out infinite;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(12px);
        }

        .form-card::before {
            content: '';
            position: absolute;
            inset: -35% -30% auto auto;
            width: 160px;
            height: 160px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(215,198,162,0.10), transparent 70%);
            animation: haloDrift 13s ease-in-out infinite;
        }

        .form-card h3, .upload-card h3 {
            font-size: 1.35rem;
            margin-bottom: 8px;
            color: #fff;
        }

        .form-card p, .upload-card p {
            color: rgba(248,246,240,0.68);
            line-height: 1.6;
            margin-bottom: 18px;
            font-size: 0.95rem;
        }

        .field { margin-bottom: 14px; }

        .field label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.92rem;
            color: rgba(248,246,240,0.86);
        }

        .field input[type="text"],
        .field input[type="password"],
        .field input[type="file"] {
            width: 100%;
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(255,255,255,0.06);
            color: #fff;
            border-radius: 16px;
            padding: 13px 15px;
            outline: none;
            transition: border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
            backdrop-filter: blur(10px);
        }

        .field input::placeholder { color: rgba(255,255,255,0.45); }

        .field input:focus {
            border-color: rgba(215,198,162,0.45);
            box-shadow: 0 0 0 4px rgba(215,198,162,0.10);
            transform: translateY(-1px);
        }

        .btn {
            width: 100%;
            border: none;
            border-radius: 16px;
            padding: 13px 16px;
            font-size: 0.98rem;
            font-weight: 700;
            cursor: pointer;
            color: #141414;
            background: linear-gradient(135deg, var(--accent), var(--accent3), #f1e7d2);
            background-size: 200% 200%;
            box-shadow: 0 10px 22px rgba(215,198,162,0.16);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
            animation: gradientFlow 9s ease-in-out infinite;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 26px rgba(215,198,162,0.22);
        }

        .btn.secondary {
            display: block;
            text-decoration: none;
            text-align: center;
            margin-top: 10px;
            background: linear-gradient(135deg, #4b5563, #111827);
            color: #fff;
            background-size: 200% 200%;
        }

        .message {
            padding: 12px 14px;
            border-radius: 16px;
            margin-bottom: 14px;
            font-size: 0.95rem;
            animation: fadeSlide 260ms ease both;
        }

        .message.error {
            background: rgba(253,164,175,0.08);
            color: #fecdd3;
            border: 1px solid rgba(253,164,175,0.15);
        }

        .message.success {
            background: rgba(134,239,172,0.08);
            color: #bbf7d0;
            border: 1px solid rgba(134,239,172,0.15);
        }

        .upload-page {
            padding: 32px;
        }

        .upload-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .logout-link {
            text-decoration: none;
            color: #fff;
            background: linear-gradient(135deg, #3f3f46, #18181b);
            padding: 10px 14px;
            border-radius: 999px;
            font-size: 0.92rem;
            white-space: nowrap;
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .logout-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(0,0,0,0.16);
        }

        .upload-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            align-items: start;
        }

        .upload-card {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.10);
            border-radius: 28px;
            padding: 24px;
            animation: cardLift 7s ease-in-out infinite;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(12px);
        }

        .upload-card::after {
            content: '';
            position: absolute;
            inset: auto auto -35px -35px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(215,198,162,0.10), transparent 70%);
            animation: haloDrift 12s ease-in-out infinite;
        }

        .preview-box {
            margin-top: 14px;
            border-radius: 20px;
            min-height: 190px;
            border: 1px solid rgba(255,255,255,0.12);
            background:
                linear-gradient(180deg, rgba(255,255,255,0.08), rgba(255,255,255,0.03)),
                radial-gradient(circle at top left, rgba(215,198,162,0.10), transparent 40%),
                rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: rgba(248,246,240,0.68);
            text-align: center;
            padding: 16px;
            transition: transform 0.18s ease;
            position: relative;
        }

        .preview-box::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.20), transparent);
            transform: translateX(-100%);
            animation: shine 8s ease-in-out infinite;
            pointer-events: none;
            opacity: 0.45;
        }

        .preview-box:hover {
            transform: scale(1.01);
        }

        .preview-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .history {
            display: grid;
            gap: 10px;
            margin-top: 16px;
        }

        .history-item {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.10);
            border-radius: 18px;
            padding: 12px 14px;
            color: rgba(248,246,240,0.72);
            word-break: break-word;
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .history-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.12);
        }

        .history-item strong { color: #fff; }

        .chip {
            display: inline-block;
            margin-top: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(215,198,162,0.10);
            color: #f6e7c5;
            font-size: 0.84rem;
        }

        .helper {
            margin-top: 14px;
            color: rgba(248,246,240,0.68);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .fade-in {
            animation: fadeIn 420ms ease both;
        }

        @keyframes haloDrift {
            0%, 100% { transform: translate3d(0,0,0) scale(1); }
            50% { transform: translate3d(18px,-16px,0) scale(1.08); }
        }

        @keyframes haloDrift2 {
            0%, 100% { transform: translate3d(0,0,0) scale(1); }
            50% { transform: translate3d(-14px,18px,0) scale(1.07); }
        }

        @keyframes popIn {
            from { opacity: 0; transform: translateY(14px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeSlide {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes gradientFlow {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        @keyframes shimmer {
            0% { transform: translateX(-30%) skewX(-18deg); }
            50% { transform: translateX(30%) skewX(-18deg); }
            100% { transform: translateX(70%) skewX(-18deg); }
        }

        @keyframes sweep {
            from { transform: translateX(-100%); }
            to { transform: translateX(100%); }
        }

        @keyframes floatCard {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-4px); }
        }

        @keyframes cardLift {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-3px); }
        }

        @keyframes breathe {
            0%, 100% { transform: translateY(0); opacity: 1; }
            50% { transform: translateY(-1px); opacity: 0.94; }
        }

        @keyframes pulseDot {
            0% { box-shadow: 0 0 0 0 rgba(134,239,172,0.55); transform: scale(1); }
            70% { box-shadow: 0 0 0 10px rgba(134,239,172,0); transform: scale(1.08); }
            100% { box-shadow: 0 0 0 0 rgba(134,239,172,0); transform: scale(1); }
        }

        @keyframes tinyGlow {
            0%, 100% { transform: scale(1); opacity: 0.55; }
            50% { transform: scale(1.08); opacity: 0.9; }
        }

        @keyframes silkSweep {
            0%, 100% { transform: translateX(-2%) translateY(0); }
            50% { transform: translateX(2%) translateY(4px); }
        }

        @keyframes crownRotate {
            from { transform: rotate(0deg) scale(1); }
            to { transform: rotate(360deg) scale(1); }
        }

        @keyframes ribbonSlide {
            0%, 100% { transform: translateX(-2%) rotate(-8deg); }
            50% { transform: translateX(2%) rotate(-8deg); }
        }

        @media (max-width: 980px) {
            .grid,
            .upload-grid {
                grid-template-columns: 1fr;
            }
            .panel.left {
                border-right: none;
                border-bottom: 1px solid rgba(255,255,255,0.08);
            }
        }

        @media (max-width: 640px) {
            .shell { padding: 14px; }
            .topbar,
            .panel,
            .upload-page { padding: 18px; }
            .feature-grid { grid-template-columns: 1fr; }
            .pill { display: none; }
            .upload-head { flex-direction: column; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.001ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.001ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>
<body>
    <div class="grain"></div>
    <div class="luxury-surface"></div>
    <div class="luxury-surface-2"></div>
    <div class="luxury-halo"></div>
    <div class="luxury-halo-2"></div>
    <div class="luxury-ribbon"></div>
    <div class="luxury-ribbon-2"></div>

    <div class="scene">
        <div class="app fade-in">
            <div class="topbar">
                <div class="brand">
                    <div class="mark"></div>
                    <div>
                        <h1><span class="status-dot"></span>Soft Arc Portal</h1>
                        <p>Luxury motion inspired by premium automotive design</p>
                    </div>
                </div>
                <div class="pill">data.php</div>
            </div>

            <?php if (!$loggedIn): ?>
                <div class="grid">
                    <section class="panel left">
                        <div class="hero">
                            <h2>Quiet luxury, smooth motion.</h2>
                            <p>
                                A refined background with silk-like movement, metallic glow, soft halos, and elegant depth.
                                It is designed to feel premium, calm, and visually expensive.
                            </p>
                        </div>

                        <div class="feature-grid">
                            <div class="feature">
                                <strong>Luxury layers</strong>
                                <span>Soft ribbons and halos drift slowly for a premium atmosphere.</span>
                            </div>
                            <div class="feature">
                                <strong>Elegant contrast</strong>
                                <span>Dark background with warm champagne highlights gives a classy look.</span>
                            </div>
                            <div class="feature">
                                <strong>File preview</strong>
                                <span>Pictures show instantly before upload, right inside the upload panel.</span>
                            </div>
                            <div class="feature">
                                <strong>Saved history</strong>
                                <span>Original and stored names are written into <strong>store.txt</strong>.</span>
                            </div>
                        </div>
                    </section>

                    <section class="panel right">
                        <div class="form-card">
                            <h3>Login</h3>
                            <p>Demo account: <strong>admin</strong> / <strong>12345</strong></p>

                            <?php if ($loginError): ?>
                                <div class="message error"><?php echo htmlspecialchars($loginError); ?></div>
                            <?php endif; ?>

                            <form method="post" novalidate>
                                <div class="field">
                                    <label>Username</label>
                                    <input type="text" name="username" placeholder="Enter username" minlength="3" maxlength="50" required>
                                </div>
                                <div class="field">
                                    <label>Password</label>
                                    <input type="password" name="password" placeholder="Enter password" minlength="3" maxlength="50" required>
                                </div>
                                <button class="btn" type="submit" name="login_btn">Sign In</button>
                            </form>
                        </div>
                    </section>
                </div>
            <?php else: ?>
                <div class="upload-page">
                    <div class="upload-head">
                        <div>
                            <h2 style="font-size:clamp(1.7rem, 3vw, 2.4rem);line-height:1.1;">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>.</h2>
                            <p style="margin-top:8px;color:rgba(248,246,240,0.68);">Upload a file or picture. Images preview below, and every upload is saved into <strong>store.txt</strong>.</p>
                        </div>
                        <a class="logout-link" href="?logout=1">Logout</a>
                    </div>

                    <div class="upload-grid">
                        <div class="upload-card">
                            <?php if ($uploadMessage): ?>
                                <div class="message <?php echo $uploadMessage === 'Upload successful.' ? 'success' : 'error'; ?>">
                                    <?php echo htmlspecialchars($uploadMessage); ?>
                                </div>
                            <?php endif; ?>

                            <form method="post" enctype="multipart/form-data" novalidate>
                                <div class="field">
                                    <label>Select file or picture</label>
                                    <input id="fileInput" type="file" name="myfile" required>
                                </div>
                                <button class="btn" type="submit" name="upload_btn">Upload Now</button>
                                <a class="btn secondary" href="?logout=1">Logout</a>
                            </form>

                            <div class="preview-box" id="previewBox">
                                <span>Choose a picture to preview it here</span>
                            </div>

                            <div class="helper">
                                Files are stored in <strong>uploads</strong>. The original file name and saved file name are recorded in <strong>store.txt</strong>.
                            </div>
                        </div>

                        <div class="upload-card">
                            <h3>Recent Uploads</h3>
                            <p>Latest items from store.txt</p>

                            <div class="history">
                                <?php if (!empty($history)): ?>
                                    <?php foreach (array_slice($history, 0, 8) as $item): ?>
                                        <div class="history-item">
                                            <strong><?php echo htmlspecialchars($item['original'] ?: 'Unknown file'); ?></strong><br>
                                            Saved as: <?php echo htmlspecialchars($item['saved']); ?><br>
                                            Type: <?php echo htmlspecialchars($item['type']); ?><br>
                                            Time: <?php echo htmlspecialchars($item['time']); ?>

                                            <?php if ($item['type'] === 'picture' && !empty($item['saved']) && file_exists($uploadDir . '/' . $item['saved'])): ?>
                                                <div style="margin-top:10px;border-radius:14px;overflow:hidden;">
                                                    <img src="uploads/<?php echo rawurlencode($item['saved']); ?>" alt="uploaded image" style="width:100%;max-height:220px;object-fit:cover;display:block;">
                                                </div>
                                            <?php else: ?>
                                                <span class="chip">Stored safely</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="history-item">No uploads yet.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const fileInput = document.getElementById('fileInput');
        const previewBox = document.getElementById('previewBox');

        if (fileInput && previewBox) {
            fileInput.addEventListener('change', function () {
                const file = this.files && this.files[0];
                if (!file) {
                    previewBox.innerHTML = '<span>Choose a picture to preview it here</span>';
                    return;
                }

                if (file.type && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewBox.innerHTML = '<img src="' + e.target.result + '" alt="preview">';
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewBox.innerHTML = '<div><strong>' + file.name + '</strong><br><br>No image preview for this file type.</div>';
                }
            });
        }

        const app = document.querySelector('.app');
        const leftPanel = document.querySelector('.panel.left');
        const rightPanel = document.querySelector('.panel.right');
        const ribbons = document.querySelectorAll('.luxury-ribbon, .luxury-ribbon-2');
        const halos = document.querySelectorAll('.luxury-halo, .luxury-halo-2');

        document.addEventListener('mousemove', (e) => {
            const x = (e.clientX / window.innerWidth - 0.5) * 12;
            const y = (e.clientY / window.innerHeight - 0.5) * 12;

            if (app) app.style.transform = `translate3d(${x * 0.18}px, ${y * 0.18}px, 0)`;
            if (leftPanel) leftPanel.style.transform = `translate3d(${x * 0.28}px, ${y * 0.20}px, 0)`;
            if (rightPanel) rightPanel.style.transform = `translate3d(${x * -0.18}px, ${y * -0.12}px, 0)`;

            halos.forEach((halo, index) => {
                const speed = 0.10 + (index * 0.03);
                halo.style.transform = `translate3d(${x * speed}px, ${y * speed}px, 0)`;
            });

            ribbons.forEach((ribbon, index) => {
                const speed = 0.06 + (index * 0.02);
                ribbon.style.transform = `translate3d(${x * speed}px, ${y * speed}px, 0) rotate(${index === 0 ? -8 : 9}deg)`;
            });
        });

        document.addEventListener('mouseleave', () => {
            if (app) app.style.transform = '';
            if (leftPanel) leftPanel.style.transform = '';
            if (rightPanel) rightPanel.style.transform = '';
            halos.forEach((halo) => halo.style.transform = '');
            ribbons.forEach((ribbon, index) => ribbon.style.transform = index === 0 ? 'rotate(-8deg)' : 'rotate(9deg)');
        });
    </script>
</body>
</html>