<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urban 2050 Prime Core</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        :root {
            --cyan: rgba(0, 255, 255, 0.9);
            --pink: rgba(255, 0, 180, 0.78);
            --blue: rgba(0, 120, 255, 0.9);
            --glass: rgba(255,255,255,0.08);
            --glass-border: rgba(255,255,255,0.16);
        }

        body {
            min-height: 100vh;
            overflow: hidden;
            color: #fff;
            background:
                radial-gradient(circle at 20% 20%, rgba(0,255,255,0.15), transparent 22%),
                radial-gradient(circle at 80% 18%, rgba(255,0,180,0.12), transparent 24%),
                radial-gradient(circle at 50% 100%, rgba(0,120,255,0.18), transparent 32%),
                linear-gradient(135deg, #02050d 0%, #06101c 45%, #0a1a2c 100%);
        }

        .scene {
            position: relative;
            width: 100vw;
            height: 100vh;
        }

        canvas {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        .mesh {
            position: fixed;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            background:
                radial-gradient(circle at 20% 30%, rgba(0,255,255,0.10), transparent 18%),
                radial-gradient(circle at 80% 25%, rgba(255,0,180,0.08), transparent 18%),
                radial-gradient(circle at 50% 70%, rgba(0,120,255,0.10), transparent 22%),
                linear-gradient(120deg, rgba(255,255,255,0.02), transparent 35%, rgba(255,255,255,0.03));
            filter: blur(2px);
            animation: meshMove 14s ease-in-out infinite alternate;
        }

        @keyframes meshMove {
            0%   { transform: translate3d(0, 0, 0) scale(1); }
            50%  { transform: translate3d(-12px, 10px, 0) scale(1.03); }
            100% { transform: translate3d(12px, -8px, 0) scale(1.06); }
        }

        .grid {
            position: fixed;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 56px 56px;
            opacity: 0.24;
            mask-image: radial-gradient(circle at center, black 32%, transparent 100%);
        }

        .fog {
            position: fixed;
            width: 760px;
            height: 760px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.07), rgba(0,255,255,0.03), transparent 68%);
            filter: blur(50px);
            opacity: 0.8;
            pointer-events: none;
            z-index: 1;
            animation: fogDrift 20s ease-in-out infinite;
        }

        .fog.one {
            left: -220px;
            top: -180px;
        }

        .fog.two {
            right: -260px;
            bottom: -220px;
            animation-duration: 26s;
            animation-direction: reverse;
        }

        @keyframes fogDrift {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(18px, -12px) scale(1.06); }
        }

        .beams {
            position: fixed;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            background:
                linear-gradient(110deg, transparent 0%, rgba(0,255,255,0.04) 45%, transparent 60%),
                linear-gradient(70deg, transparent 0%, rgba(255,0,180,0.03) 50%, transparent 65%);
            mix-blend-mode: screen;
            animation: beamSweep 12s linear infinite;
            opacity: 0.9;
        }

        @keyframes beamSweep {
            0% { transform: translateX(-8%) translateY(0); }
            100% { transform: translateX(8%) translateY(0); }
        }

        .cityline {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            height: 28vh;
            z-index: 2;
            pointer-events: none;
            background:
                linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.18) 45%, rgba(0,0,0,0.42) 100%),
                repeating-linear-gradient(
                    90deg,
                    rgba(255,255,255,0.03) 0 14px,
                    transparent 14px 44px
                );
            mask-image: linear-gradient(to top, black 0%, black 60%, transparent 100%);
        }

        .tower {
            position: absolute;
            bottom: 0;
            background: linear-gradient(180deg, rgba(255,255,255,0.08), rgba(0,0,0,0.22));
            border-top: 1px solid rgba(255,255,255,0.10);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.06);
            animation: towerPulse 6s ease-in-out infinite;
        }

        .tower::before {
            content: "";
            position: absolute;
            inset: 10% 16%;
            background:
                repeating-linear-gradient(
                    to top,
                    rgba(0,255,255,0.18) 0 4px,
                    transparent 4px 14px
                );
            opacity: 0.24;
            filter: blur(0.2px);
        }

        .tower.t1 { left: 6%; width: 74px; height: 26vh; animation-delay: 0s; }
        .tower.t2 { left: 15%; width: 104px; height: 18vh; animation-delay: 1s; }
        .tower.t3 { left: 28%; width: 86px; height: 22vh; animation-delay: 2s; }
        .tower.t4 { right: 18%; width: 120px; height: 20vh; animation-delay: 1.5s; }
        .tower.t5 { right: 8%; width: 72px; height: 28vh; animation-delay: 0.5s; }

        @keyframes towerPulse {
            0%, 100% { transform: translateY(0); opacity: 0.78; }
            50% { transform: translateY(-6px); opacity: 0.96; }
        }

        .glow {
            position: fixed;
            width: 360px;
            height: 360px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0,255,255,0.24), transparent 65%);
            filter: blur(12px);
            pointer-events: none;
            z-index: 2;
            transform: translate(-50%, -50%);
            transition: left 0.03s linear, top 0.03s linear;
        }

        .stage {
            position: relative;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3;
            perspective: 1200px;
        }

        .arc {
            position: absolute;
            border-radius: 999px;
            border: 1px solid transparent;
            pointer-events: none;
            transform-origin: center;
            filter: drop-shadow(0 0 12px rgba(0,255,255,0.22));
        }

        .arc.one {
            width: 980px;
            height: 320px;
            border-top-color: rgba(0,255,255,0.88);
            border-right-color: rgba(0,255,255,0.10);
            transform: rotate(-12deg);
            animation: driftA 9s ease-in-out infinite, spin 24s linear infinite;
        }

        .arc.two {
            width: 800px;
            height: 260px;
            border-top-color: rgba(255,0,180,0.70);
            border-left-color: rgba(255,255,255,0.06);
            transform: rotate(16deg);
            animation: driftB 11s ease-in-out infinite, spinReverse 28s linear infinite;
        }

        .arc.three {
            width: 620px;
            height: 200px;
            border-top-color: rgba(255,255,255,0.38);
            transform: rotate(-28deg);
            animation: driftA 8s ease-in-out infinite, spin 18s linear infinite;
        }

        .arc.four {
            width: 460px;
            height: 150px;
            border-top-color: rgba(0,120,255,0.92);
            border-right-color: rgba(255,255,255,0.08);
            transform: rotate(36deg);
            animation: driftB 10s ease-in-out infinite, spinReverse 16s linear infinite;
        }

        .arc.five {
            width: 1180px;
            height: 390px;
            border-top-color: rgba(0,255,255,0.12);
            transform: rotate(4deg);
            animation: driftA 14s ease-in-out infinite, spin 38s linear infinite;
        }

        .arc.six {
            width: 1060px;
            height: 340px;
            border-top-color: rgba(255,255,255,0.07);
            transform: rotate(-8deg);
            animation: driftB 13s ease-in-out infinite, spinReverse 34s linear infinite;
        }

        .arc.seven {
            width: 320px;
            height: 110px;
            border-top-color: rgba(255,0,180,0.58);
            transform: rotate(-42deg);
            animation: driftA 7s ease-in-out infinite, spin 16s linear infinite;
        }

        .arc.eight {
            width: 250px;
            height: 88px;
            border-top-color: rgba(0,255,255,0.56);
            transform: rotate(40deg);
            animation: driftB 8s ease-in-out infinite, spinReverse 12s linear infinite;
        }

        .halo {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.08);
            box-shadow:
                0 0 20px rgba(0,255,255,0.10),
                inset 0 0 18px rgba(255,255,255,0.04);
            animation: spin 30s linear infinite;
            pointer-events: none;
        }

        .halo.h1 { width: 660px; height: 660px; }
        .halo.h2 {
            width: 440px;
            height: 440px;
            border-color: rgba(0,255,255,0.15);
            animation-direction: reverse;
            animation-duration: 24s;
        }
        .halo.h3 {
            width: 260px;
            height: 260px;
            border-color: rgba(255,0,180,0.11);
            animation-duration: 18s;
        }
        .halo.h4 {
            width: 860px;
            height: 860px;
            border-color: rgba(255,255,255,0.05);
            animation-duration: 42s;
        }

        .panel {
            position: relative;
            width: min(92vw, 560px);
            padding: 34px 30px 26px;
            border-radius: 30px;
            background:
                linear-gradient(180deg, rgba(255,255,255,0.12), rgba(255,255,255,0.05)),
                linear-gradient(135deg, rgba(0,255,255,0.05), rgba(255,0,180,0.03));
            border: 1px solid rgba(255,255,255,0.15);
            box-shadow:
                0 24px 90px rgba(0,0,0,0.46),
                0 0 44px rgba(0,255,255,0.10),
                inset 0 1px 0 rgba(255,255,255,0.08);
            backdrop-filter: blur(20px);
            transform-style: preserve-3d;
            transition: transform 0.12s ease-out;
            z-index: 4;
            overflow: hidden;
        }

        .panel::before {
            content: "";
            position: absolute;
            inset: -2px;
            border-radius: 32px;
            padding: 2px;
            background: linear-gradient(135deg, rgba(0,255,255,0.75), rgba(255,0,180,0.45), rgba(0,120,255,0.55));
            -webkit-mask:
                linear-gradient(#fff 0 0) content-box,
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0.65;
            pointer-events: none;
        }

        .panel::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 18%, rgba(255,255,255,0.08), transparent 18%),
                radial-gradient(circle at 80% 16%, rgba(255,255,255,0.06), transparent 14%),
                linear-gradient(120deg, transparent 0%, rgba(255,255,255,0.05) 45%, transparent 70%);
            pointer-events: none;
            opacity: 0.8;
        }

        .scanline {
            position: absolute;
            left: 0;
            right: 0;
            height: 2px;
            top: 0;
            background: linear-gradient(90deg, transparent, rgba(0,255,255,0.95), transparent);
            animation: scan 4.8s linear infinite;
            opacity: 0.75;
            pointer-events: none;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 14px;
        }

        .dots {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255,255,255,0.28);
            box-shadow: 0 0 10px rgba(255,255,255,0.08);
        }

        .dot.c1 { background: rgba(0,255,255,0.95); }
        .dot.c2 { background: rgba(255,0,180,0.75); }
        .dot.c3 { background: rgba(0,120,255,0.95); }

        .chip {
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(0,0,0,0.20);
            border: 1px solid rgba(255,255,255,0.10);
            font-size: 12px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.78);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(0,0,0,0.24);
            border: 1px solid rgba(255,255,255,0.10);
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.82);
            margin-bottom: 18px;
        }

        .title {
            font-size: clamp(30px, 4vw, 48px);
            line-height: 1.05;
            letter-spacing: 1px;
            margin-bottom: 10px;
            text-shadow: 0 0 18px rgba(0,255,255,0.18);
        }

        .subtitle {
            font-size: 15px;
            line-height: 1.7;
            color: rgba(255,255,255,0.72);
            margin-bottom: 18px;
        }

        .meta-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 18px;
        }

        .meta {
            padding: 12px 10px;
            border-radius: 16px;
            background: rgba(0,0,0,0.18);
            border: 1px solid rgba(255,255,255,0.08);
            text-align: center;
        }

        .meta span {
            display: block;
            font-size: 11px;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.48);
            margin-bottom: 6px;
        }

        .meta strong {
            font-size: 14px;
            color: rgba(255,255,255,0.88);
        }

        form {
            display: grid;
            gap: 14px;
        }

        input[type="number"] {
            width: 100%;
            padding: 16px 18px;
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(2, 10, 25, 0.80);
            color: #fff;
            outline: none;
            font-size: 16px;
            box-shadow: inset 0 0 0 1px rgba(0,255,255,0.05);
            transition: 0.25s ease;
        }

        input[type="number"]:focus {
            border-color: rgba(0,255,255,0.5);
            box-shadow:
                0 0 0 4px rgba(0,255,255,0.08),
                inset 0 0 0 1px rgba(0,255,255,0.12);
            transform: translateY(-1px);
        }

        input[type="number"]::placeholder {
            color: rgba(255,255,255,0.35);
        }

        input[type="submit"] {
            padding: 16px 18px;
            border: none;
            border-radius: 18px;
            background: linear-gradient(135deg, #00e5ff, #7c4dff 50%, #ff2ea6);
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.25s ease;
            box-shadow: 0 10px 30px rgba(0, 229, 255, 0.18);
            position: relative;
            overflow: hidden;
        }

        input[type="submit"]::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent, rgba(255,255,255,0.28), transparent);
            transform: translateX(-120%);
            animation: shine 3.8s ease-in-out infinite;
        }

        input[type="submit"]:hover {
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 0 28px rgba(0, 229, 255, 0.36);
        }

        .result {
            margin-top: 18px;
            padding: 18px;
            border-radius: 18px;
            background: rgba(0,0,0,0.24);
            border: 1px solid rgba(255,255,255,0.10);
            text-align: center;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.3px;
            animation: pulse 1.8s ease-in-out infinite;
        }

        .prime {
            color: #7dffcf;
            text-shadow: 0 0 18px rgba(125,255,207,0.25);
        }

        .not-prime {
            color: #ff8ab9;
            text-shadow: 0 0 18px rgba(255,138,185,0.25);
        }

        .footer {
            margin-top: 16px;
            text-align: center;
            font-size: 12px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.45);
        }

        .mouse-ripple {
            position: fixed;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: 1px solid rgba(0,255,255,0.7);
            box-shadow: 0 0 18px rgba(0,255,255,0.35);
            pointer-events: none;
            z-index: 5;
            transform: translate(-50%, -50%) scale(0.4);
            opacity: 0;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes spinReverse {
            from { transform: rotate(360deg); }
            to { transform: rotate(0deg); }
        }

        @keyframes driftA {
            0%, 100% { translate: 0 0; }
            50% { translate: 0 -14px; }
        }

        @keyframes driftB {
            0%, 100% { translate: 0 0; }
            50% { translate: 0 12px; }
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 10px rgba(0,255,255,0.18); }
            50% { box-shadow: 0 0 24px rgba(0,255,255,0.32); }
        }

        @keyframes scan {
            0% { transform: translateY(0); opacity: 0; }
            10% { opacity: 0.9; }
            50% { opacity: 0.2; }
            100% { transform: translateY(360px); opacity: 0; }
        }

        @keyframes shine {
            0% { transform: translateX(-120%); }
            55% { transform: translateX(120%); }
            100% { transform: translateX(120%); }
        }

        @media (max-width: 600px) {
            .panel {
                padding: 24px 16px 20px;
            }

            .meta-row {
                grid-template-columns: 1fr;
            }

            .arc.one { width: 560px; height: 190px; }
            .arc.two { width: 460px; height: 160px; }
            .arc.three { width: 350px; height: 125px; }
            .arc.four { width: 240px; height: 85px; }
            .arc.five { width: 700px; height: 250px; }
            .arc.six { width: 620px; height: 210px; }

            .halo.h1 { width: 440px; height: 440px; }
            .halo.h2 { width: 300px; height: 300px; }
            .halo.h3 { width: 190px; height: 190px; }
            .halo.h4 { width: 620px; height: 620px; }
        }
    </style>
</head>
<body>
<div class="scene">
    <canvas id="stars"></canvas>
    <div class="mesh"></div>
    <div class="grid"></div>
    <div class="fog one"></div>
    <div class="fog two"></div>
    <div class="beams"></div>

    <div class="cityline">
        <div class="tower t1"></div>
        <div class="tower t2"></div>
        <div class="tower t3"></div>
        <div class="tower t4"></div>
        <div class="tower t5"></div>
    </div>

    <div class="glow" id="glow"></div>
    <div class="mouse-ripple" id="ripple"></div>

    <div class="stage">
        <div class="halo h4"></div>
        <div class="halo h1"></div>
        <div class="halo h2"></div>
        <div class="halo h3"></div>

        <div class="arc one"></div>
        <div class="arc two"></div>
        <div class="arc three"></div>
        <div class="arc four"></div>
        <div class="arc five"></div>
        <div class="arc six"></div>
        <div class="arc seven"></div>
        <div class="arc eight"></div>

        <div class="panel" id="card">
            <div class="scanline"></div>

            <div class="topbar">
                <div class="dots">
                    <span class="dot c1"></span>
                    <span class="dot c2"></span>
                    <span class="dot c3"></span>
                </div>
                <div class="chip">comfort mode</div>
            </div>

            <div class="badge">Urban 2050 • Prime Core</div>
            <div class="title">Prime Number Reactor</div>
            <div class="subtitle">
                A calm futuristic arc-built interface with soft depth, glowing layers, and a premium urban feel.
            </div>

            <div class="meta-row">
                <div class="meta">
                    <span>Style</span>
                    <strong>Comfy Future</strong>
                </div>
                <div class="meta">
                    <span>Motion</span>
                    <strong>Soft Float</strong>
                </div>
                <div class="meta">
                    <span>Core</span>
                    <strong>Prime Scan</strong>
                </div>
            </div>

            <form method="post">
                <input type="number" name="number" placeholder="Enter a number" required>
                <input type="submit" name="check" value="Analyze Prime Signal">
            </form>

            <?php
            if (isset($_POST['check'])) {
                $num = (int)$_POST['number'];
                $isPrime = true;

                if ($num <= 1) {
                    $isPrime = false;
                } else {
                    for ($i = 2; $i <= sqrt($num); $i++) {
                        if ($num % $i == 0) {
                            $isPrime = false;
                            break;
                        }
                    }
                }

                echo "<div class='result'>";
                if ($isPrime) {
                    echo "<span class='prime'>◆ $num is a PRIME number</span>";
                } else {
                    echo "<span class='not-prime'>◆ $num is NOT a prime number</span>";
                }
                echo "</div>";
            }
            ?>

            <div class="footer">Arc design • neon glass • motion intelligence</div>
        </div>
    </div>
</div>

<script>
const card = document.getElementById("card");
const glow = document.getElementById("glow");
const ripple = document.getElementById("ripple");

let pointerX = window.innerWidth / 2;
let pointerY = window.innerHeight / 2;
let targetX = pointerX;
let targetY = pointerY;

document.addEventListener("mousemove", (e) => {
    targetX = e.clientX;
    targetY = e.clientY;

    glow.style.left = targetX + "px";
    glow.style.top = targetY + "px";

    ripple.style.left = targetX + "px";
    ripple.style.top = targetY + "px";
    ripple.style.opacity = "1";
    ripple.style.transform = "translate(-50%, -50%) scale(1.8)";

    clearTimeout(ripple._hideTimer);
    ripple._hideTimer = setTimeout(() => {
        ripple.style.opacity = "0";
        ripple.style.transform = "translate(-50%, -50%) scale(0.4)";
    }, 90);

    const x = (window.innerWidth / 2 - e.clientX) / 22;
    const y = (window.innerHeight / 2 - e.clientY) / 22;
    card.style.transform = `rotateY(${x}deg) rotateX(${y}deg) translateY(-2px)`;
});

document.addEventListener("mouseleave", () => {
    card.style.transform = "rotateY(0deg) rotateX(0deg)";
});

const canvas = document.getElementById("stars");
const ctx = canvas.getContext("2d");

let w, h;
function resize() {
    w = canvas.width = window.innerWidth;
    h = canvas.height = window.innerHeight;
}
resize();
window.addEventListener("resize", resize);

const particles = [];
const PARTICLE_COUNT = 160;

for (let i = 0; i < PARTICLE_COUNT; i++) {
    particles.push({
        x: Math.random() * w,
        y: Math.random() * h,
        r: Math.random() * 1.7 + 0.4,
        vx: (Math.random() - 0.5) * 0.55,
        vy: (Math.random() - 0.5) * 0.55,
        alpha: Math.random() * 0.55 + 0.18
    });
}

function drawParticles() {
    ctx.clearRect(0, 0, w, h);

    for (const p of particles) {
        p.x += p.vx;
        p.y += p.vy;

        if (p.x < 0) p.x = w;
        if (p.x > w) p.x = 0;
        if (p.y < 0) p.y = h;
        if (p.y > h) p.y = 0;

        const dx = p.x - pointerX;
        const dy = p.y - pointerY;
        const dist = Math.sqrt(dx * dx + dy * dy);

        const boost = Math.max(0, 1 - dist / 280);
        const radius = p.r + boost * 2.4;
        const alpha = Math.min(1, p.alpha + boost * 0.75);

        ctx.beginPath();
        ctx.arc(p.x, p.y, radius, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(0, 255, 255, ${alpha})`;
        ctx.fill();
    }

    const dx = targetX - pointerX;
    const dy = targetY - pointerY;
    pointerX += dx * 0.08;
    pointerY += dy * 0.08;

    requestAnimationFrame(drawParticles);
}
drawParticles();
</script>
</body>
</html>