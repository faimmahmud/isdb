<?php
$connect = mysqli_connect("localhost", "root", "", "data_connect");

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data
$result = mysqli_query($connect, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root{
            --bg-1:#050505;
            --bg-2:#0f0f10;
            --bg-3:#17171a;
            --card:#111214cc;
            --card-2:#1a1b1fcc;
            --line:rgba(255,255,255,.12);
            --line-2:rgba(255,255,255,.2);
            --text:#f5f5f5;
            --muted:rgba(255,255,255,.72);
            --silver:#d8d8d8;
            --white:#ffffff;
            --shadow:0 30px 80px rgba(0,0,0,.55);
            --shadow-soft:0 12px 35px rgba(0,0,0,.3);
        }

        *{ box-sizing:border-box; }

        html, body{
            min-height:100%;
        }

        body{
            margin:0;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color:var(--text);
            background:
                radial-gradient(circle at 15% 12%, rgba(255,255,255,.10), transparent 22%),
                radial-gradient(circle at 85% 18%, rgba(255,255,255,.07), transparent 18%),
                radial-gradient(circle at 50% 80%, rgba(255,255,255,.05), transparent 22%),
                linear-gradient(145deg, var(--bg-1), var(--bg-2) 45%, var(--bg-3));
            overflow-x:hidden;
            position:relative;
        }

        body::before{
            content:"";
            position:fixed;
            inset:0;
            pointer-events:none;
            background:
                linear-gradient(120deg, rgba(255,255,255,.05), transparent 18%, transparent 82%, rgba(255,255,255,.04)),
                repeating-linear-gradient(
                    90deg,
                    rgba(255,255,255,.022) 0px,
                    rgba(255,255,255,.022) 1px,
                    transparent 1px,
                    transparent 90px
                ),
                repeating-linear-gradient(
                    0deg,
                    rgba(255,255,255,.018) 0px,
                    rgba(255,255,255,.018) 1px,
                    transparent 1px,
                    transparent 90px
                );
            opacity:.6;
            mix-blend-mode:screen;
        }

        body::after{
            content:"";
            position:fixed;
            inset:-25%;
            pointer-events:none;
            background:
                radial-gradient(circle at 25% 25%, rgba(255,255,255,.09), transparent 0 13%),
                radial-gradient(circle at 72% 20%, rgba(255,255,255,.07), transparent 0 12%),
                radial-gradient(circle at 76% 72%, rgba(255,255,255,.05), transparent 0 12%),
                radial-gradient(circle at 18% 78%, rgba(255,255,255,.05), transparent 0 11%);
            filter: blur(28px);
            animation: drift 14s ease-in-out infinite alternate;
            opacity:.5;
        }

        @keyframes drift{
            from{ transform:translate3d(-2%, -1%, 0) scale(1); }
            to{ transform:translate3d(2%, 1%, 0) scale(1.04); }
        }

        .page{
            min-height:100vh;
            padding:34px 18px 44px;
            position:relative;
        }

        .shell{
            max-width:1180px;
            margin:0 auto;
            position:relative;
        }

        .topbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:16px;
            padding:16px 18px;
            border:1px solid var(--line);
            border-radius:24px;
            background:linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,.04));
            backdrop-filter: blur(20px);
            box-shadow:var(--shadow-soft);
            overflow:hidden;
            position:relative;
            margin-bottom:20px;
        }

        .topbar::before{
            content:"";
            position:absolute;
            inset:0;
            background:linear-gradient(120deg, transparent 0%, rgba(255,255,255,.12) 50%, transparent 100%);
            transform:translateX(-120%);
            animation: shine 7s linear infinite;
        }

        @keyframes shine{
            0%{ transform:translateX(-120%); }
            65%{ transform:translateX(120%); }
            100%{ transform:translateX(120%); }
        }

        .brand{
            display:flex;
            align-items:center;
            gap:14px;
            position:relative;
            z-index:1;
        }

        .brand-mark{
            width:54px;
            height:54px;
            border-radius:18px;
            display:grid;
            place-items:center;
            font-weight:900;
            letter-spacing:.08em;
            color:#fff;
            background:
                linear-gradient(145deg, #ffffff 0%, #bdbdbd 18%, #2d2d2d 55%, #000000 100%);
            box-shadow:
                0 0 0 1px rgba(255,255,255,.18) inset,
                0 16px 34px rgba(0,0,0,.35);
            position:relative;
        }

        .brand-mark::after{
            content:"";
            position:absolute;
            inset:7px;
            border-radius:13px;
            border:1px solid rgba(255,255,255,.18);
        }

        .brand-text h1{
            margin:0;
            font-size:1.08rem;
            font-weight:800;
            text-transform:uppercase;
            letter-spacing:.12em;
        }

        .brand-text p{
            margin:4px 0 0;
            color:var(--muted);
            font-size:.92rem;
        }

        .status{
            display:inline-flex;
            align-items:center;
            gap:10px;
            padding:10px 14px;
            border-radius:999px;
            border:1px solid var(--line);
            background:rgba(255,255,255,.05);
            color:var(--text);
            font-size:.92rem;
            white-space:nowrap;
            position:relative;
            z-index:1;
        }

        .status-dot{
            width:10px;
            height:10px;
            border-radius:50%;
            background:#fff;
            box-shadow:0 0 18px rgba(255,255,255,.9);
            animation: pulse 1.7s ease-in-out infinite;
        }

        @keyframes pulse{
            0%,100%{ transform:scale(1); opacity:.75; }
            50%{ transform:scale(1.6); opacity:1; }
        }

        .card-arc{
            position:relative;
            border-radius:32px;
            padding:26px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,.04)),
                linear-gradient(135deg, rgba(255,255,255,.05), rgba(0,0,0,.15));
            border:1px solid var(--line);
            box-shadow:var(--shadow);
            backdrop-filter: blur(18px);
            overflow:hidden;
            animation: riseIn .8s ease both;
        }

        @keyframes riseIn{
            from{ opacity:0; transform:translateY(24px) scale(.985); }
            to{ opacity:1; transform:translateY(0) scale(1); }
        }

        .card-arc::before{
            content:"";
            position:absolute;
            inset:0;
            border-radius:32px;
            padding:1px;
            background:linear-gradient(135deg, rgba(255,255,255,.42), rgba(255,255,255,.03), rgba(255,255,255,.2));
            -webkit-mask:linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite:xor;
            mask-composite:exclude;
            pointer-events:none;
        }

        .card-arc::after{
            content:"";
            position:absolute;
            top:-120px;
            right:-120px;
            width:280px;
            height:280px;
            border-radius:50%;
            background:radial-gradient(circle, rgba(255,255,255,.18), transparent 70%);
            filter:blur(8px);
            opacity:.7;
            animation: floatGlow 8s ease-in-out infinite alternate;
            pointer-events:none;
        }

        @keyframes floatGlow{
            from{ transform:translate(0,0) scale(1); }
            to{ transform:translate(-18px, 14px) scale(1.08); }
        }

        .puzzle-grid{
            display:grid;
            grid-template-columns: 1fr auto 1fr;
            gap:14px;
            margin-bottom:24px;
            align-items:stretch;
        }

        .puzzle{
            min-height:74px;
            border-radius:24px;
            border:1px solid var(--line);
            background:
                linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,.03));
            position:relative;
            overflow:hidden;
            box-shadow:inset 0 1px 0 rgba(255,255,255,.06);
        }

        .puzzle::before,
        .puzzle::after{
            content:"";
            position:absolute;
            background:#0d0d0f;
            border:1px solid rgba(255,255,255,.10);
            box-shadow:0 0 0 1px rgba(255,255,255,.03) inset;
        }

        .puzzle.left::before{
            width:34px;
            height:34px;
            border-radius:50%;
            right:-17px;
            top:50%;
            transform:translateY(-50%);
        }

        .puzzle.left::after{
            width:26px;
            height:26px;
            border-radius:50%;
            left:-13px;
            bottom:14px;
        }

        .puzzle.center{
            display:flex;
            justify-content:center;
            align-items:center;
            text-align:center;
            padding:16px 18px;
            background:
                linear-gradient(135deg, rgba(255,255,255,.13), rgba(255,255,255,.04));
        }

        .puzzle.right::before{
            width:34px;
            height:34px;
            border-radius:50%;
            left:-17px;
            top:50%;
            transform:translateY(-50%);
        }

        .puzzle.right::after{
            width:26px;
            height:26px;
            border-radius:50%;
            right:-13px;
            bottom:14px;
        }

        .center-title{
            margin:0;
            font-size:clamp(1.8rem, 3vw, 3.2rem);
            font-weight:900;
            letter-spacing:.08em;
            text-transform:uppercase;
            line-height:1.05;
        }

        .center-title span{
            background:linear-gradient(180deg, #fff, #d9d9d9 48%, #fff);
            -webkit-background-clip:text;
            background-clip:text;
            color:transparent;
            text-shadow:0 0 22px rgba(255,255,255,.08);
        }

        .center-sub{
            margin:10px 0 0;
            color:var(--muted);
            font-size:.95rem;
            line-height:1.7;
            max-width:760px;
        }

        .info-row{
            display:grid;
            grid-template-columns:repeat(3, minmax(0, 1fr));
            gap:14px;
            margin-bottom:22px;
        }

        .info-card{
            border-radius:22px;
            border:1px solid var(--line);
            background:rgba(255,255,255,.045);
            padding:16px 18px;
            box-shadow:inset 0 1px 0 rgba(255,255,255,.04);
            transition:transform .25s ease, background .25s ease, border-color .25s ease;
            position:relative;
            overflow:hidden;
        }

        .info-card::before{
            content:"";
            position:absolute;
            inset:auto -20% -60% auto;
            width:160px;
            height:160px;
            border-radius:50%;
            background:radial-gradient(circle, rgba(255,255,255,.1), transparent 65%);
            pointer-events:none;
        }

        .info-card:hover{
            transform:translateY(-3px);
            border-color:var(--line-2);
            background:rgba(255,255,255,.06);
        }

        .info-card .k{
            display:block;
            color:var(--muted);
            text-transform:uppercase;
            letter-spacing:.14em;
            font-size:.74rem;
            margin-bottom:8px;
        }

        .info-card .v{
            font-size:1rem;
            font-weight:700;
            color:var(--white);
        }

        .table-shell{
            overflow:hidden;
            border-radius:24px;
            border:1px solid var(--line);
            background:rgba(255,255,255,.04);
            box-shadow:0 14px 42px rgba(0,0,0,.35);
            position:relative;
        }

        .table{
            margin-bottom:0;
            color:var(--text);
        }

        .table thead th{
            background:
                linear-gradient(180deg, rgba(255,255,255,.14), rgba(255,255,255,.07));
            color:#fff;
            font-weight:800;
            letter-spacing:.08em;
            text-transform:uppercase;
            border-color:var(--line) !important;
            padding:18px 16px;
        }

        .table tbody td{
            padding:18px 16px;
            border-color:rgba(255,255,255,.08) !important;
            background:rgba(255,255,255,.018);
            vertical-align:middle;
            transition:background .25s ease, transform .25s ease, filter .25s ease;
        }

        .table tbody tr{
            transition:transform .25s ease;
        }

        .table tbody tr:hover{
            transform:translateY(-1px);
        }

        .table tbody tr:hover td{
            background:rgba(255,255,255,.07);
            filter:brightness(1.05);
        }

        .table-striped > tbody > tr:nth-of-type(odd) > *{
            background:rgba(255,255,255,.03);
        }

        .id-pill{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-width:54px;
            padding:8px 12px;
            border-radius:999px;
            background:linear-gradient(135deg, rgba(255,255,255,.14), rgba(255,255,255,.06));
            border:1px solid rgba(255,255,255,.14);
            font-weight:800;
            letter-spacing:.04em;
        }

        .name-cell{
            font-weight:700;
            letter-spacing:.02em;
        }

        .contact-cell{
            color:#e8e8e8;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        }

        .empty-box{
            margin:14px;
            padding:26px 18px;
            border-radius:18px;
            border:1px dashed rgba(255,255,255,.18);
            background:rgba(255,255,255,.03);
            color:rgba(255,255,255,.8);
        }

        .footer{
            margin-top:18px;
            text-align:center;
            color:var(--muted);
            font-size:.92rem;
            letter-spacing:.04em;
        }

        .float-shape{
            position:absolute;
            pointer-events:none;
            border:1px solid rgba(255,255,255,.10);
            background:rgba(255,255,255,.03);
            backdrop-filter: blur(10px);
            box-shadow:inset 0 0 24px rgba(255,255,255,.03);
            animation: bob 10s ease-in-out infinite alternate;
        }

        .shape-1{
            width:120px;
            height:120px;
            border-radius:34px;
            left:-28px;
            top:114px;
            transform:rotate(16deg);
        }

        .shape-2{
            width:92px;
            height:92px;
            border-radius:50%;
            right:-20px;
            bottom:120px;
            animation-duration:12s;
        }

        .shape-3{
            width:64px;
            height:64px;
            border-radius:20px;
            left:42%;
            top:-18px;
            transform:rotate(45deg);
            animation-duration:11s;
        }

        @keyframes bob{
            from{ transform:translateY(0) rotate(0deg); }
            to{ transform:translateY(-16px) rotate(8deg); }
        }

        @media (max-width: 992px){
            .info-row{
                grid-template-columns:1fr;
            }

            .puzzle-grid{
                grid-template-columns:1fr;
            }

            .puzzle.left::before,
            .puzzle.left::after,
            .puzzle.right::before,
            .puzzle.right::after{
                display:none;
            }

            .puzzle.center{
                order:-1;
            }
        }

        @media (max-width: 768px){
            .page{
                padding:16px 10px 30px;
            }

            .card-arc{
                padding:16px;
                border-radius:24px;
            }

            .topbar{
                padding:14px 14px;
                flex-direction:column;
                align-items:flex-start;
            }

            .brand-text h1{
                font-size:.98rem;
            }

            .table thead th,
            .table tbody td{
                padding:14px 12px;
            }
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="shell">
            <div class="topbar">
                <div class="brand">
                    <div class="brand-mark">OA</div>
                    <div class="brand-text">
                        <h1>Open AI × World AI</h1>
                        <p>Royal monochrome architecture with premium motion</p>
                    </div>
                </div>
                <div class="status">
                    <span class="status-dot"></span>
                    Live Database View
                </div>
            </div>

            <div class="card-arc">
                <div class="float-shape shape-1"></div>
                <div class="float-shape shape-2"></div>
                <div class="float-shape shape-3"></div>

                <div class="puzzle-grid">
                    <div class="puzzle left"></div>
                    <div class="puzzle center">
                        <div>
                            <h2 class="center-title"><span>User List</span></h2>
                            <p class="center-sub">
                                A refined black-and-white royal interface with puzzle-style depth, flowing texture,
                                and a polished architecture feel.
                            </p>
                        </div>
                    </div>
                    <div class="puzzle right"></div>
                </div>

                <div class="info-row">
                    <div class="info-card">
                        <span class="k">Theme</span>
                        <div class="v">Black & White Royal</div>
                    </div>
                    <div class="info-card">
                        <span class="k">Style</span>
                        <div class="v">Arc / Puzzle / Glass</div>
                    </div>
                    <div class="info-card">
                        <span class="k">Motion</span>
                        <div class="v">Auto Glow & Float</div>
                    </div>
                </div>

                <div class="table-shell table-responsive">
                    <table class="table table-hover table-bordered text-center align-middle table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Contact</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><span class="id-pill"><?= $row['id']; ?></span></td>
                                        <td class="name-cell"><?= $row['name']; ?></td>
                                        <td class="contact-cell"><?= $row['contact']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3">
                                        <div class="empty-box">No data found</div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="footer">
                    Premium animated royal layout built for a clean, modern database display.
                </div>
            </div>
        </div>
    </div>
</body>
</html>