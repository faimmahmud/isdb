<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: admin.php");
    exit();
}

$msg = "";
$registered = isset($_GET['registered']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $user = trim($_POST['username'] ?? '');
    $pass = trim($_POST['password'] ?? '');

    $infoFile = __DIR__ . "/info.txt";

    if (file_exists($infoFile)) {
        $data = file($infoFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($data as $line) {
            $delimiter = (strpos($line, "|") !== false) ? "|" : ",";
            $row = array_map('trim', explode($delimiter, $line));

            if (count($row) >= 7) {
                $filePass = $row[3];
                $fileUser = $row[6];
                $passwordOk = password_verify($pass, $filePass) || hash_equals($filePass, $pass);

                if ($user === $fileUser && $passwordOk) {
                    $_SESSION['user'] = $user;
                    header("Location: admin.php");
                    exit();
                }
            }
        }
    }

    $msg = "Invalid username or password.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pulse Login</title>
    <style>
        :root{
            --a:#0ea5e9;
            --b:#14b8a6;
            --c:#111827;
            --d:#020617;
        }
        *{ box-sizing:border-box; margin:0; padding:0; font-family:"Segoe UI",system-ui,Arial,sans-serif; }
        body{
            min-height:100vh;
            overflow:hidden;
            display:flex;
            align-items:center;
            justify-content:center;
            background:
                radial-gradient(circle at 20% 20%, rgba(14,165,233,.23), transparent 20%),
                radial-gradient(circle at 80% 10%, rgba(20,184,166,.22), transparent 24%),
                radial-gradient(circle at 50% 100%, rgba(168,85,247,.14), transparent 25%),
                linear-gradient(135deg, var(--d), #0f172a 42%, var(--c));
            color:#fff;
        }

        .scan{
            position:absolute; inset:0;
            background:linear-gradient(180deg, transparent, rgba(255,255,255,.04), transparent);
            background-size:100% 6px;
            opacity:.22;
            pointer-events:none;
            animation: scan 6s linear infinite;
        }
        @keyframes scan{
            0%{ transform:translateY(-100%); }
            100%{ transform:translateY(100%); }
        }

        .ring{
            position:absolute;
            border-radius:50%;
            border:1px solid rgba(255,255,255,.12);
            filter: blur(.2px);
            animation: spin 20s linear infinite;
            pointer-events:none;
        }
        .r1{ width:420px; height:420px; opacity:.3; }
        .r2{ width:540px; height:540px; opacity:.16; animation-direction:reverse; }
        @keyframes spin{
            from{ transform:rotate(0deg); }
            to{ transform:rotate(360deg); }
        }

        .wrap{
            width:min(1180px, 94vw);
            position:relative;
            z-index:2;
            display:grid;
            grid-template-columns: 1fr 460px;
            gap:28px;
            align-items:center;
        }

        .showcase{
            padding:20px 8px 20px 0;
        }
        .label{
            display:inline-flex;
            align-items:center;
            gap:10px;
            padding:10px 14px;
            border-radius:999px;
            background:rgba(255,255,255,.08);
            border:1px solid rgba(255,255,255,.10);
            letter-spacing:.16em;
            text-transform:uppercase;
            font-size:12px;
            margin-bottom:18px;
        }
        .dot{
            width:9px;height:9px;border-radius:50%;
            background:var(--b);
            box-shadow:0 0 16px var(--b);
            animation: blink 1.6s ease-in-out infinite;
        }
        @keyframes blink{
            0%,100%{ transform:scale(1); opacity:.7; }
            50%{ transform:scale(1.5); opacity:1; }
        }

        .showcase h1{
            font-size:clamp(40px,6vw,76px);
            line-height:1.0;
            max-width:9ch;
            margin-bottom:18px;
        }
        .showcase p{
            max-width:52ch;
            color:rgba(255,255,255,.74);
            line-height:1.75;
            font-size:15px;
        }
        .chips{
            display:flex;
            flex-wrap:wrap;
            gap:10px;
            margin-top:24px;
        }
        .chip{
            padding:10px 14px;
            border-radius:999px;
            background:rgba(255,255,255,.06);
            border:1px solid rgba(255,255,255,.10);
            color:rgba(255,255,255,.86);
            font-size:13px;
            backdrop-filter: blur(12px);
        }

        .card{
            position:relative;
            border-radius:30px;
            overflow:hidden;
            background:rgba(255,255,255,.08);
            border:1px solid rgba(255,255,255,.14);
            backdrop-filter: blur(22px);
            box-shadow:0 26px 80px rgba(0,0,0,.42);
        }
        .card::before{
            content:"";
            position:absolute; inset:0;
            background:
                radial-gradient(circle at top right, rgba(14,165,233,.22), transparent 30%),
                radial-gradient(circle at bottom left, rgba(20,184,166,.14), transparent 28%);
            pointer-events:none;
        }
        .card-body{
            position:relative;
            padding:34px;
            background:linear-gradient(180deg, rgba(8,15,35,.55), rgba(8,15,35,.80));
        }
        .title{
            font-size:30px;
            margin-bottom:8px;
        }
        .sub{
            color:rgba(255,255,255,.70);
            line-height:1.6;
            margin-bottom:22px;
        }

        .success, .error{
            padding:12px 14px;
            border-radius:14px;
            margin-bottom:14px;
            font-size:14px;
        }
        .success{
            background:rgba(34,197,94,.14);
            border:1px solid rgba(34,197,94,.18);
            color:#dcfce7;
        }
        .error{
            background:rgba(239,68,68,.14);
            border:1px solid rgba(239,68,68,.18);
            color:#fee2e2;
        }

        .field{ margin-bottom:14px; }
        label{
            display:block;
            margin-bottom:8px;
            font-size:13px;
            color:rgba(255,255,255,.78);
            font-weight:700;
        }
        input{
            width:100%;
            padding:15px 16px;
            border-radius:16px;
            border:1px solid rgba(255,255,255,.16);
            background:rgba(255,255,255,.08);
            color:#fff;
            outline:none;
            transition:.22s ease;
        }
        input::placeholder{ color:rgba(255,255,255,.44); }
        input:focus{
            border-color:#22d3ee;
            box-shadow:0 0 0 4px rgba(34,211,238,.14);
            transform: translateY(-1px);
        }

        button{
            width:100%;
            padding:15px 16px;
            border:none;
            border-radius:16px;
            cursor:pointer;
            color:#fff;
            font-weight:800;
            font-size:15px;
            background:linear-gradient(135deg, #0ea5e9, #14b8a6);
            box-shadow:0 16px 32px rgba(14,165,233,.20);
            transition:transform .2s ease, filter .2s ease;
            position:relative;
            overflow:hidden;
        }
        button::after{
            content:"";
            position:absolute;
            top:0; left:-60%;
            width:60%; height:100%;
            background:linear-gradient(90deg, transparent, rgba(255,255,255,.30), transparent);
            transform:skewX(-20deg);
            animation: sweep 3.8s linear infinite;
        }
        @keyframes sweep{
            0%{ left:-70%; }
            100%{ left:120%; }
        }
        button:hover{ transform:translateY(-2px); filter:saturate(1.1); }

        .footer{
            margin-top:18px;
            text-align:center;
            color:rgba(255,255,255,.74);
            font-size:14px;
        }
        .footer a{
            color:#67e8f9;
            font-weight:800;
            text-decoration:none;
        }

        .stats{
            display:grid;
            grid-template-columns:repeat(3, 1fr);
            gap:12px;
            margin-top:22px;
        }
        .stat{
            padding:15px;
            border-radius:18px;
            background:rgba(255,255,255,.06);
            border:1px solid rgba(255,255,255,.10);
        }
        .stat strong{
            display:block;
            font-size:18px;
            margin-bottom:5px;
        }
        .stat span{
            color:rgba(255,255,255,.72);
            font-size:12px;
            line-height:1.5;
        }

        @media (max-width: 980px){
            .wrap{ grid-template-columns:1fr; }
            .showcase{ padding-right:0; }
        }
        @media (max-width: 560px){
            .card-body{ padding:24px; }
            .stats{ grid-template-columns:1fr; }
        }
    </style>
</head>
<body>
    <div class="scan"></div>
    <div class="ring r1"></div>
    <div class="ring r2"></div>

    <div class="wrap">
        <section class="showcase">
            <div class="label"><span class="dot"></span> Neon Access Layer</div>
            <h1>Step into the control room.</h1>
            <p>
                This login screen uses a darker urban mood, kinetic glow, and clean motion to feel like a futuristic software console.
            </p>
            <div class="chips">
                <div class="chip">Animated scan lines</div>
                <div class="chip">Glass blur shell</div>
                <div class="chip">Soft neon gradients</div>
                <div class="chip">Premium interaction</div>
            </div>

            <div class="stats">
                <div class="stat"><strong>Secure</strong><span>Session-based access</span></div>
                <div class="stat"><strong>Smooth</strong><span>Elegant motion states</span></div>
                <div class="stat"><strong>Fast</strong><span>Focused minimal flow</span></div>
            </div>
        </section>

        <section class="card">
            <div class="card-body">
                <div class="title">Login</div>
                <div class="sub">Enter your credentials to open the dashboard.</div>

                <?php if ($registered): ?>
                    <div class="success">Registration completed successfully. Please login now.</div>
                <?php endif; ?>

                <?php if ($msg !== ""): ?>
                    <div class="error"><?php echo htmlspecialchars($msg); ?></div>
                <?php endif; ?>

                <form method="post" autocomplete="off">
                    <div class="field">
                        <label>Username</label>
                        <input type="text" name="username" placeholder="Enter your username" required>
                    </div>

                    <div class="field">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Enter your password" required>
                    </div>

                    <button type="submit" name="login">Enter Dashboard</button>
                </form>

                <div class="footer">
                    New here? <a href="register.php">Create an account</a>
                </div>
            </div>
        </section>
    </div>
</body>
</html>