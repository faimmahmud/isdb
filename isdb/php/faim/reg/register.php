<?php
session_start();

$msg = "";

function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

$infoFile = __DIR__ . "/info.txt";
if (!file_exists($infoFile)) {
    file_put_contents($infoFile, "");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $id       = trim($_POST['id'] ?? '');
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $pass     = trim($_POST['pass'] ?? '');
    $repass   = trim($_POST['repass'] ?? '');
    $address  = trim($_POST['address'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $username = trim($_POST['username'] ?? '');

    $nameLen = mb_strlen($name);
    $userLen = mb_strlen($username);

    if ($id === '' || $name === '' || $email === '' || $pass === '' || $repass === '' || $username === '') {
        $msg = "Please fill all required fields.";
    } elseif (!ctype_digit($id)) {
        $msg = "ID must contain only numbers.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Please enter a valid email address.";
    } elseif (mb_strlen($pass) < 6) {
        $msg = "Password must be at least 6 characters.";
    } elseif ($pass !== $repass) {
        $msg = "Password does not match.";
    } elseif ($nameLen < 2) {
        $msg = "Please enter a valid full name.";
    } elseif ($userLen < 3) {
        $msg = "Username must be at least 3 characters.";
    } else {
        $existing = file($infoFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $duplicate = false;

        foreach ($existing as $line) {
            $parts = explode("|", $line);
            $oldId = $parts[0] ?? '';
            $oldEmail = $parts[2] ?? '';
            $oldUsername = $parts[6] ?? '';

            if ($oldId === $id) {
                $msg = "This ID is already registered.";
                $duplicate = true;
                break;
            }
            if (strcasecmp($oldEmail, $email) === 0) {
                $msg = "This email is already registered.";
                $duplicate = true;
                break;
            }
            if (strcasecmp($oldUsername, $username) === 0) {
                $msg = "This username is already taken.";
                $duplicate = true;
                break;
            }
        }

        if (!$duplicate) {
            $hash = password_hash($pass, PASSWORD_DEFAULT);

            // id|name|email|password_hash|address|phone|username
            $data = implode("|", [
                $id,
                $name,
                $email,
                $hash,
                $address,
                $phone,
                $username
            ]) . PHP_EOL;

            file_put_contents($infoFile, $data, FILE_APPEND | LOCK_EX);

            header("Location: login.php?registered=1");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Nova Register</title>
    <style>
        :root{
            --bg1:#040816;
            --bg2:#0b1220;
            --card:rgba(255,255,255,.08);
            --card2:rgba(255,255,255,.12);
            --text:#f8fafc;
            --muted:rgba(248,250,252,.72);
            --line:rgba(255,255,255,.14);
            --accent:#8b5cf6;
            --accent2:#22d3ee;
            --accent3:#f59e0b;
            --shadow:0 30px 90px rgba(0,0,0,.45);
        }

        *{ box-sizing:border-box; margin:0; padding:0; font-family: "Segoe UI", system-ui, Arial, sans-serif; }
        body{
            min-height:100vh;
            color:var(--text);
            background:
                radial-gradient(circle at 15% 20%, rgba(34,211,238,.18), transparent 22%),
                radial-gradient(circle at 80% 15%, rgba(139,92,246,.22), transparent 25%),
                radial-gradient(circle at 50% 100%, rgba(245,158,11,.12), transparent 28%),
                linear-gradient(135deg, var(--bg1), var(--bg2) 55%, #111827);
            overflow-x:hidden;
        }

        .noise{
            position:fixed;
            inset:0;
            pointer-events:none;
            opacity:.32;
            background-image:
                linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 42px 42px;
            mask-image: linear-gradient(to bottom, rgba(0,0,0,.8), transparent 96%);
        }

        .orb{
            position:fixed;
            border-radius:50%;
            filter: blur(48px);
            opacity:.55;
            pointer-events:none;
            animation: drift 10s ease-in-out infinite;
        }
        .orb.one{ width:230px; height:230px; left:8%; top:10%; background:rgba(34,211,238,.85); }
        .orb.two{ width:280px; height:280px; right:8%; top:14%; background:rgba(139,92,246,.85); animation-delay:2s; }
        .orb.three{ width:180px; height:180px; left:20%; bottom:8%; background:rgba(245,158,11,.75); animation-delay:4s; }

        @keyframes drift{
            0%,100%{ transform:translate(0,0) scale(1); }
            50%{ transform:translate(16px,-18px) scale(1.08); }
        }

        .wrap{
            width:min(1200px, 94vw);
            margin:0 auto;
            min-height:100vh;
            display:grid;
            place-items:center;
            padding:28px 0;
            position:relative;
            z-index:2;
        }

        .shell{
            width:100%;
            display:grid;
            grid-template-columns: 1fr .95fr;
            border-radius:32px;
            overflow:hidden;
            border:1px solid rgba(255,255,255,.12);
            background:linear-gradient(180deg, rgba(255,255,255,.10), rgba(255,255,255,.05));
            backdrop-filter: blur(22px);
            box-shadow:var(--shadow);
        }

        .left{
            padding:44px;
            position:relative;
            background:
                radial-gradient(circle at top right, rgba(255,255,255,.14), transparent 28%),
                linear-gradient(180deg, rgba(15,23,42,.22), rgba(15,23,42,.70));
        }

        .badge{
            display:inline-flex;
            align-items:center;
            gap:10px;
            padding:10px 16px;
            border-radius:999px;
            background:rgba(255,255,255,.08);
            border:1px solid rgba(255,255,255,.14);
            text-transform:uppercase;
            letter-spacing:.16em;
            font-size:12px;
            margin-bottom:20px;
        }
        .badge i{
            width:10px;
            height:10px;
            border-radius:50%;
            background:var(--accent2);
            box-shadow:0 0 18px var(--accent2);
            animation:pulse 1.8s ease-in-out infinite;
        }
        @keyframes pulse{
            0%,100%{ transform:scale(1); opacity:.8; }
            50%{ transform:scale(1.5); opacity:1; }
        }

        h1{
            font-size:clamp(34px, 4.6vw, 62px);
            line-height:1.02;
            margin-bottom:16px;
            max-width:11ch;
        }

        .lead{
            max-width:48ch;
            color:var(--muted);
            line-height:1.7;
            font-size:15px;
        }

        .cards{
            display:grid;
            grid-template-columns:repeat(2, minmax(0,1fr));
            gap:14px;
            margin-top:32px;
        }

        .mini{
            padding:18px;
            border-radius:20px;
            background:rgba(255,255,255,.06);
            border:1px solid rgba(255,255,255,.10);
            transition:.25s ease;
        }
        .mini:hover{ transform:translateY(-4px); }
        .mini strong{
            display:block;
            font-size:18px;
            margin-bottom:6px;
        }
        .mini span{
            color:rgba(255,255,255,.72);
            font-size:13px;
            line-height:1.5;
        }

        .right{
            padding:30px;
            background:rgba(255,255,255,.95);
            color:#111827;
        }

        .panel{
            height:100%;
            border-radius:26px;
            padding:30px;
            position:relative;
            overflow:hidden;
            background:
                linear-gradient(180deg, rgba(255,255,255,.80), rgba(255,255,255,.94)),
                radial-gradient(circle at top right, rgba(139,92,246,.08), transparent 28%);
            border:1px solid rgba(17,24,39,.08);
            box-shadow:0 18px 42px rgba(15,23,42,.10);
        }

        .panel::after{
            content:"";
            position:absolute;
            inset:auto -30% -40% auto;
            width:250px;
            height:250px;
            border-radius:50%;
            background:radial-gradient(circle, rgba(139,92,246,.16), transparent 62%);
            animation: float 8s ease-in-out infinite;
        }
        @keyframes float{
            0%,100%{ transform:translateY(0); }
            50%{ transform:translateY(-16px); }
        }

        .panel h2{
            font-size:30px;
            margin-bottom:8px;
        }
        .panel p.sub{
            color:#6b7280;
            margin-bottom:22px;
            line-height:1.6;
            max-width:40ch;
        }

        .alert{
            padding:13px 14px;
            border-radius:14px;
            margin-bottom:16px;
            background:#fef2f2;
            border:1px solid #fecaca;
            color:#b91c1c;
            font-size:14px;
        }

        form{
            position:relative;
            z-index:1;
        }

        .grid{
            display:grid;
            grid-template-columns:repeat(2, minmax(0,1fr));
            gap:12px;
        }

        .field{
            display:flex;
            flex-direction:column;
            gap:8px;
            margin-bottom:12px;
        }
        .full{ grid-column:1 / -1; }

        label{
            font-size:13px;
            font-weight:700;
            color:#374151;
        }

        input{
            width:100%;
            padding:14px 15px;
            border-radius:15px;
            border:1px solid #d1d5db;
            outline:none;
            background:#fff;
            color:#111827;
            transition:.25s ease;
        }
        input::placeholder{ color:#9ca3af; }
        input:focus{
            border-color:var(--accent);
            box-shadow:0 0 0 4px rgba(139,92,246,.12);
            transform:translateY(-1px);
        }

        button{
            width:100%;
            padding:14px 16px;
            border:0;
            border-radius:15px;
            color:#fff;
            font-weight:800;
            font-size:15px;
            cursor:pointer;
            background:linear-gradient(135deg, #6d28d9, #06b6d4);
            box-shadow:0 18px 30px rgba(109,40,217,.20);
            transition: transform .2s ease, filter .2s ease;
            position:relative;
            overflow:hidden;
            margin-top:6px;
        }
        button::before{
            content:"";
            position:absolute;
            inset:0;
            background:linear-gradient(120deg, transparent 0%, rgba(255,255,255,.35) 50%, transparent 100%);
            transform:translateX(-120%);
            transition:transform .7s ease;
        }
        button:hover::before{ transform:translateX(120%); }
        button:hover{ transform:translateY(-2px); filter:saturate(1.08); }

        .info-strip{
            display:flex;
            justify-content:space-between;
            gap:10px;
            margin-top:18px;
            padding:14px 16px;
            border-radius:16px;
            background:linear-gradient(135deg, rgba(139,92,246,.08), rgba(34,211,238,.08));
            border:1px solid rgba(139,92,246,.12);
            color:#4b5563;
            font-size:13px;
            position:relative;
            z-index:1;
        }

        .bottom{
            margin-top:16px;
            text-align:center;
            color:#6b7280;
            font-size:14px;
            position:relative;
            z-index:1;
        }
        .bottom a{
            color:#6d28d9;
            text-decoration:none;
            font-weight:800;
        }

        @media (max-width: 980px){
            .shell{ grid-template-columns:1fr; }
            .left{ padding:34px; }
        }

        @media (max-width: 640px){
            .wrap{ width:min(96vw, 96vw); }
            .right{ padding:16px; }
            .panel{ padding:22px; }
            .left{ padding:24px; }
            .cards, .grid{ grid-template-columns:1fr; }
            .info-strip{ flex-direction:column; align-items:center; text-align:center; }
        }
    </style>
</head>
<body>
    <div class="noise"></div>
    <div class="orb one"></div>
    <div class="orb two"></div>
    <div class="orb three"></div>

    <div class="wrap">
        <div class="shell">
            <section class="left">
                <div class="badge"><i></i> Royal Nova Access</div>
                <h1>Create a premium account</h1>
                <p class="lead">
                    A cinematic registration page with glass layers, glowing motion, and a polished layout designed to feel modern, rich, and clean.
                </p>

                <div class="cards">
                    <div class="mini">
                        <strong>Clean signup</strong>
                        <span>Simple input flow with strong validation and clear field labels.</span>
                    </div>
                    <div class="mini">
                        <strong>Modern look</strong>
                        <span>Dark luxury background with soft neon highlights and depth.</span>
                    </div>
                    <div class="mini">
                        <strong>Safer backend</strong>
                        <span>Password hashing, duplicate checking, and file handling.</span>
                    </div>
                    <div class="mini">
                        <strong>Responsive design</strong>
                        <span>Works smoothly on laptop, tablet, and mobile screens.</span>
                    </div>
                </div>
            </section>

            <section class="right">
                <div class="panel">
                    <h2>Registration</h2>
                    <p class="sub">Fill your details below to create your account.</p>

                    <?php if (!empty($msg)) : ?>
                        <div class="alert"><?php echo e($msg); ?></div>
                    <?php endif; ?>

                    <form method="post" autocomplete="off">
                        <div class="grid">
                            <div class="field">
                                <label for="id">ID *</label>
                                <input type="number" id="id" name="id" value="<?php echo e($_POST['id'] ?? ''); ?>" placeholder="Your ID" required>
                            </div>

                            <div class="field">
                                <label for="name">Full Name *</label>
                                <input type="text" id="name" name="name" value="<?php echo e($_POST['name'] ?? ''); ?>" placeholder="Your full name" required>
                            </div>

                            <div class="field full">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" value="<?php echo e($_POST['email'] ?? ''); ?>" placeholder="Your email address" required>
                            </div>

                            <div class="field">
                                <label for="pass">Password *</label>
                                <input type="password" id="pass" name="pass" placeholder="Create password" required>
                            </div>

                            <div class="field">
                                <label for="repass">Retype Password *</label>
                                <input type="password" id="repass" name="repass" placeholder="Confirm password" required>
                            </div>

                            <div class="field full">
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address" value="<?php echo e($_POST['address'] ?? ''); ?>" placeholder="Your address">
                            </div>

                            <div class="field">
                                <label for="phone">Phone</label>
                                <input type="text" id="phone" name="phone" value="<?php echo e($_POST['phone'] ?? ''); ?>" placeholder="Phone number">
                            </div>

                            <div class="field">
                                <label for="username">Username *</label>
                                <input type="text" id="username" name="username" value="<?php echo e($_POST['username'] ?? ''); ?>" placeholder="Choose username" required>
                            </div>
                        </div>

                        <button type="submit" name="register">Create Account</button>
                    </form>

                    <div class="info-strip">
                        <span>Glass UI</span>
                        <span>Fast signup</span>
                        <span>Premium style</span>
                    </div>

                    <div class="bottom">
                        Already have an account? <a href="login.php">Login here</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
</html>