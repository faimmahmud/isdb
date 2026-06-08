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

if (isset($_POST['login_btn'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $msg = "Please fill all fields.";
    } else {
        $ok = false;
        $users = file($usersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($users as $line) {
            $parts = explode('|', $line, 2);
            $savedUser = $parts[0] ?? '';
            $savedHash = $parts[1] ?? '';

            if ($savedUser === $username && password_verify($password, $savedHash)) {
                session_regenerate_id(true);
                $_SESSION['user'] = $username;
                $ok = true;
                break;
            }
        }

        if ($ok) {
            header("Location: upload.php");
            exit();
        } else {
            $msg = "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIP Login | Royal Vault</title>
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
            overflow: hidden;
            background:
                radial-gradient(circle at 30% 20%, rgba(95,156,255,.16), transparent 20%),
                radial-gradient(circle at 70% 80%, rgba(212,175,55,.12), transparent 22%),
                linear-gradient(135deg, #03040a, #070b15 48%, #0d1120);
            color: #fff;
            position: relative;
        }

        #login-canvas {
            position: fixed;
            inset: 0;
            width: 100vw;
            height: 100vh;
            z-index: 0;
            pointer-events: none;
        }

        .scanlines {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background: repeating-linear-gradient(
                to bottom,
                rgba(255,255,255,0.03) 0px,
                rgba(255,255,255,0.03) 1px,
                transparent 1px,
                transparent 4px
            );
            mix-blend-mode: screen;
            opacity: .28;
            animation: scanMove 8s linear infinite;
        }

        @keyframes scanMove {
            from { transform: translateY(0); }
            to { transform: translateY(24px); }
        }

        body::before {
            content: "";
            position: fixed;
            width: 620px;
            height: 620px;
            left: -220px;
            top: -220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(95,156,255,.18), transparent 70%);
            filter: blur(120px);
            z-index: 0;
            animation: floatL 12s ease-in-out infinite alternate;
        }

        body::after {
            content: "";
            position: fixed;
            width: 580px;
            height: 580px;
            right: -200px;
            bottom: -220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(212,175,55,.13), transparent 68%);
            filter: blur(120px);
            z-index: 0;
            animation: floatR 13s ease-in-out infinite alternate;
        }

        @keyframes floatL {
            from { transform: translateY(0) translateX(0); }
            to { transform: translateY(60px) translateX(50px); }
        }

        @keyframes floatR {
            from { transform: translateY(0) translateX(0); }
            to { transform: translateY(-60px) translateX(-50px); }
        }

        .card {
            position: relative;
            z-index: 1;
            width: min(470px, 100%);
            padding: 42px;
            border-radius: 22px;
            background: rgba(10, 12, 18, 0.74);
            border: 1px solid rgba(95,156,255,.24);
            box-shadow: 0 24px 80px rgba(0,0,0,.7), inset 0 0 30px rgba(95,156,255,.06);
            backdrop-filter: blur(18px);
            animation: riseIn .9s ease forwards;
            transform: translateY(24px);
            opacity: 0;
            overflow: hidden;
        }

        .card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 25%, rgba(255,255,255,.10), transparent 55%);
            transform: translateX(-120%);
            animation: shimmer 4.2s linear infinite;
            pointer-events: none;
        }

        @keyframes riseIn {
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes shimmer {
            from { transform: translateX(-120%); }
            to { transform: translateX(120%); }
        }

        h1 {
            font-size: 2rem;
            color: #fff;
            margin-bottom: 10px;
            text-shadow: 0 0 14px rgba(95,156,255,.18);
        }

        p {
            color: rgba(255,255,255,.68);
            line-height: 1.6;
            margin-bottom: 22px;
        }

        .msg {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.08);
            color: #ffbcbc;
        }

        .field {
            margin-bottom: 16px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: rgba(255,255,255,.76);
            font-size: .9rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,.12);
            background: rgba(255,255,255,.06);
            color: #fff;
            outline: none;
            transition: .25s ease;
        }

        input:focus {
            border-color: rgba(95,156,255,.55);
            box-shadow: 0 0 0 4px rgba(95,156,255,.12);
            transform: translateY(-1px);
        }

        button,
        a.btn {
            display: block;
            width: 100%;
            text-align: center;
            border: none;
            text-decoration: none;
            padding: 14px 16px;
            border-radius: 12px;
            font-weight: 800;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: .25s ease;
            margin-top: 8px;
        }

        button {
            background: linear-gradient(135deg, #65d3ff, #9ddcff, #e7f7ff);
            color: #091018;
        }

        a.btn {
            background: linear-gradient(135deg, #252a38, #101523);
            color: #fff;
            border: 1px solid rgba(255,255,255,.10);
        }

        button:hover,
        a.btn:hover {
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 12px 28px rgba(0,0,0,.28);
        }

        button::after,
        a.btn::after {
            content: "";
            position: absolute;
            top: -50%;
            left: -140%;
            width: 60%;
            height: 200%;
            transform: skewX(-24deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.45), transparent);
            animation: sweep 2.8s ease-in-out infinite;
        }

        @keyframes sweep {
            0% { left: -140%; }
            100% { left: 190%; }
        }

        .small {
            margin-top: 18px;
            color: rgba(255,255,255,.68);
            text-align: center;
            font-size: .95rem;
        }

        @media (max-width: 520px) {
            .card { padding: 30px 20px; }
            h1 { font-size: 1.75rem; }
        }
    </style>
</head>
<body>
    <canvas id="login-canvas"></canvas>
    <div class="scanlines"></div>

    <div class="card">
        <h1>Login</h1>
        <p>Enter the vault with your registered identity.</p>

        <?php if ($msg !== ""): ?>
            <div class="msg"><?php echo htmlspecialchars($msg); ?></div>
        <?php endif; ?>

        <form method="post" autocomplete="off">
            <div class="field">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="field">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" name="login_btn">Enter Vault</button>
            <a class="btn" href="register.php">Create Account</a>
        </form>

        <div class="small">After login, the upload room opens instantly.</div>
    </div>

    <script>
        const canvas = document.getElementById('login-canvas');
        const ctx = canvas.getContext('2d');

        let w, h, bars = [];

        function resize() {
            w = canvas.width = window.innerWidth;
            h = canvas.height = window.innerHeight;
            bars = [];
            const count = Math.floor(w / 28);

            for (let i = 0; i < count; i++) {
                bars.push({
                    x: i * 28,
                    y: Math.random() * h,
                    len: 60 + Math.random() * 120,
                    speed: 0.8 + Math.random() * 1.6,
                    alpha: 0.08 + Math.random() * 0.18
                });
            }
        }

        function draw() {
            ctx.clearRect(0, 0, w, h);

            bars.forEach(b => {
                const grad = ctx.createLinearGradient(b.x, b.y, b.x, b.y + b.len);
                grad.addColorStop(0, `rgba(95,156,255,0)`);
                grad.addColorStop(0.5, `rgba(95,156,255,${b.alpha})`);
                grad.addColorStop(1, `rgba(212,175,55,0)`);
                ctx.fillStyle = grad;
                ctx.fillRect(b.x, b.y, 2, b.len);

                b.y += b.speed;
                if (b.y > h + b.len) b.y = -b.len;
            });

            requestAnimationFrame(draw);
        }

        window.addEventListener('resize', resize);
        resize();
        draw();
    </script>
</body>
</html>