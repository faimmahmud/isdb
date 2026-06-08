<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: upload.php");
    exit();
}

$usersFile = __DIR__ . "/users.txt";
if (!file_exists($usersFile)) {
    file_put_contents($usersFile, "");
}

$msg = "";

if (isset($_POST['register_btn'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $msg = "Please fill all fields.";
    } elseif (strlen($username) < 3 || strlen($password) < 3) {
        $msg = "Username and password must be at least 3 characters.";
    } else {
        $users = file($usersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $exists = false;

        foreach ($users as $line) {
            $parts = explode('|', $line, 2);
            if (($parts[0] ?? '') === $username) {
                $exists = true;
                break;
            }
        }

        if ($exists) {
            $msg = "Username already exists.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            file_put_contents($usersFile, $username . "|" . $hash . PHP_EOL, FILE_APPEND);
            $msg = "Registration successful. Welcome to the elite.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIP Register | Royal Exclusive</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background:
                radial-gradient(circle at 20% 20%, rgba(212,175,55,.14), transparent 20%),
                radial-gradient(circle at 80% 80%, rgba(255,255,255,.06), transparent 18%),
                linear-gradient(135deg, #050505, #090b12 45%, #131725);
            overflow: hidden;
            position: relative;
            color: #fff;
        }

        #vip-canvas {
            position: fixed;
            inset: 0;
            width: 100vw;
            height: 100vh;
            z-index: 0;
            pointer-events: none;
        }

        body::before,
        body::after {
            content: "";
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
            z-index: 0;
        }

        body::before {
            width: 430px;
            height: 430px;
            left: -120px;
            top: -120px;
            background: rgba(212, 175, 55, 0.16);
            animation: driftA 12s ease-in-out infinite alternate;
        }

        body::after {
            width: 520px;
            height: 520px;
            right: -160px;
            bottom: -180px;
            background: rgba(95, 156, 255, 0.14);
            animation: driftB 14s ease-in-out infinite alternate;
        }

        @keyframes driftA {
            from { transform: translate3d(0, 0, 0) scale(1); }
            to { transform: translate3d(60px, 90px, 0) scale(1.08); }
        }

        @keyframes driftB {
            from { transform: translate3d(0, 0, 0) scale(1); }
            to { transform: translate3d(-70px, -100px, 0) scale(1.06); }
        }

        .card {
            position: relative;
            z-index: 1;
            width: min(460px, 100%);
            padding: 48px 40px;
            border-radius: 18px;
            background: rgba(10, 10, 10, 0.68);
            border: 1px solid rgba(212, 175, 55, 0.28);
            box-shadow:
                0 26px 70px rgba(0,0,0,.72),
                inset 0 0 30px rgba(212,175,55,.05);
            backdrop-filter: blur(18px);
            transform: translateY(8px);
            animation: cardIn 1.1s ease forwards;
            overflow: hidden;
        }

        .card::before {
            content: "";
            position: absolute;
            inset: -2px;
            background: linear-gradient(120deg, transparent 20%, rgba(255,255,255,.12), transparent 50%);
            transform: translateX(-100%);
            animation: sweep 5s linear infinite;
            pointer-events: none;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(26px) scale(.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes sweep {
            from { transform: translateX(-120%); }
            to { transform: translateX(120%); }
        }

        .header-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .vip-badge {
            display: inline-block;
            margin-bottom: 10px;
            font-size: .72rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: rgba(212, 175, 55, 0.85);
        }

        h1 {
            font-size: 2.1rem;
            font-weight: 500;
            color: #fff;
            text-shadow: 0 0 18px rgba(212,175,55,.18);
        }

        .header-section::after {
            content: "";
            display: block;
            width: 70px;
            height: 2px;
            margin: 18px auto 0;
            background: linear-gradient(90deg, transparent, #d4af37, transparent);
        }

        .msg {
            margin-bottom: 18px;
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.08);
            color: #ffb3b3;
            text-align: center;
        }

        .msg.success {
            color: #e7d08a;
            border-color: rgba(212,175,55,.28);
            background: rgba(212,175,55,.06);
        }

        .field {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: .86rem;
            letter-spacing: 1.1px;
            text-transform: uppercase;
            color: rgba(255,255,255,.72);
        }

        input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,.12);
            background: rgba(0,0,0,.38);
            color: #fff;
            outline: none;
            transition: .25s ease;
        }

        input:focus {
            border-color: rgba(212,175,55,.62);
            box-shadow: 0 0 0 4px rgba(212,175,55,.10);
            transform: translateY(-1px);
        }

        button {
            width: 100%;
            margin-top: 6px;
            padding: 15px 16px;
            border: 1px solid rgba(212,175,55,.5);
            border-radius: 12px;
            background: linear-gradient(135deg, #b8860b, #d4af37, #f1e2a2);
            color: #080808;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: transform .25s ease, box-shadow .25s ease, filter .25s ease;
        }

        button:hover {
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 12px 30px rgba(212,175,55,.28);
            filter: brightness(1.05);
        }

        button::after {
            content: "";
            position: absolute;
            top: -50%;
            left: -130%;
            width: 60%;
            height: 200%;
            transform: skewX(-25deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.45), transparent);
            animation: shine 2.8s ease-in-out infinite;
        }

        @keyframes shine {
            0% { left: -130%; }
            100% { left: 190%; }
        }

        .small {
            margin-top: 22px;
            text-align: center;
            color: rgba(255,255,255,.65);
            font-size: .92rem;
        }

        .small a {
            color: #d4af37;
            text-decoration: none;
            font-weight: 700;
        }

        .small a:hover {
            text-shadow: 0 0 10px rgba(212,175,55,.35);
        }

        @media (max-width: 520px) {
            .card {
                padding: 34px 22px;
            }

            h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <canvas id="vip-canvas"></canvas>

    <div class="card">
        <div class="header-section">
            <span class="vip-badge">Exclusive Access</span>
            <h1>Royal Registration</h1>
        </div>

        <?php if ($msg !== ""): ?>
            <div class="msg <?php echo (strpos($msg, 'successful') !== false) ? 'success' : ''; ?>">
                <?php echo htmlspecialchars($msg); ?>
            </div>
        <?php endif; ?>

        <form method="post" autocomplete="off">
            <div class="field">
                <label>V.I.P Identity</label>
                <input type="text" name="username" required minlength="3" maxlength="50" placeholder="Enter your username">
            </div>

            <div class="field">
                <label>Passkey</label>
                <input type="password" name="password" required minlength="3" maxlength="100" placeholder="••••••••">
            </div>

            <button type="submit" name="register_btn">Request Access</button>
        </form>

        <div class="small">Already hold an invitation? <a href="login.php">Enter the vault</a></div>
    </div>

    <script>
        const canvas = document.getElementById('vip-canvas');
        const ctx = canvas.getContext('2d');
        let width, height, particles = [];

        function init() {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
            particles = [];

            const count = window.innerWidth < 768 ? 36 : 90;
            for (let i = 0; i < count; i++) {
                particles.push({
                    x: Math.random() * width,
                    y: Math.random() * height,
                    r: Math.random() * 1.7 + 0.5,
                    vx: Math.random() * 0.5 - 0.25,
                    vy: Math.random() * -0.65 - 0.15,
                    a: Math.random() * 0.5 + 0.25
                });
            }
        }

        function draw() {
            ctx.clearRect(0, 0, width, height);

            particles.forEach(p => {
                p.x += p.vx;
                p.y += p.vy;

                if (p.y < -10) p.y = height + 10;
                if (p.x < -10) p.x = width + 10;
                if (p.x > width + 10) p.x = -10;

                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(212,175,55,${p.a})`;
                ctx.shadowBlur = 12;
                ctx.shadowColor = 'rgba(212,175,55,.85)';
                ctx.fill();
            });

            requestAnimationFrame(draw);
        }

        window.addEventListener('resize', init);
        init();
        draw();
    </script>
</body>
</html>