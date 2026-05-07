<?php
// keep your existing PHP code exactly as it is above this point
// database connect, insert, update, delete logic should stay unchanged
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassPro | Royal AI Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root{
            --bg:#050505;
            --bg2:#0c0c0c;
            --card:#111111cc;
            --card2:#171717;
            --line:rgba(255,255,255,.12);
            --text:#f4f4f4;
            --muted:rgba(255,255,255,.68);
            --white:#ffffff;
            --black:#000000;
            --shadow:0 25px 70px rgba(0,0,0,.55);
            --radius:28px;
        }

        *{
            box-sizing:border-box;
        }

        html,body{
            height:100%;
        }

        body{
            margin:0;
            font-family:'Inter',sans-serif;
            background:
                radial-gradient(circle at top left, rgba(255,255,255,.12), transparent 28%),
                radial-gradient(circle at top right, rgba(255,255,255,.08), transparent 22%),
                radial-gradient(circle at bottom left, rgba(255,255,255,.06), transparent 20%),
                linear-gradient(135deg, #000 0%, #0a0a0a 45%, #111 100%);
            color:var(--text);
            overflow-x:hidden;
            position:relative;
        }

        body::before{
            content:"";
            position:fixed;
            inset:0;
            pointer-events:none;
            background:
                linear-gradient(120deg, transparent 0%, rgba(255,255,255,.03) 50%, transparent 100%);
            mix-blend-mode:screen;
            animation:shineMove 10s linear infinite;
        }

        body::after{
            content:"";
            position:fixed;
            inset:0;
            pointer-events:none;
            background-image:
                linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
            background-size:42px 42px;
            opacity:.18;
            mask-image:radial-gradient(circle at center, black 45%, transparent 100%);
        }

        @keyframes shineMove{
            0%{transform:translateX(-40%)}
            100%{transform:translateX(40%)}
        }

        .bg-orb{
            position:fixed;
            border-radius:50%;
            filter:blur(18px);
            opacity:.35;
            pointer-events:none;
            animation:floatOrb 12s ease-in-out infinite;
        }

        .orb-1{
            width:260px;height:260px;
            top:-70px;left:-70px;
            background:radial-gradient(circle, rgba(255,255,255,.7), rgba(255,255,255,.08) 60%, transparent 75%);
        }

        .orb-2{
            width:320px;height:320px;
            bottom:-120px;right:-120px;
            background:radial-gradient(circle, rgba(255,255,255,.55), rgba(255,255,255,.05) 58%, transparent 74%);
            animation-delay:-4s;
        }

        @keyframes floatOrb{
            0%,100%{transform:translate3d(0,0,0) scale(1)}
            50%{transform:translate3d(0,-18px,0) scale(1.04)}
        }

        .shell{
            width:min(1480px, calc(100% - 24px));
            margin:18px auto;
            padding:0;
            position:relative;
            z-index:2;
        }

        .hero{
            position:relative;
            overflow:hidden;
            border:1px solid var(--line);
            background:linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,.03));
            backdrop-filter:blur(18px);
            border-radius:34px;
            box-shadow:var(--shadow);
            padding:28px;
        }

        .hero::before{
            content:"";
            position:absolute;
            inset:0;
            background:
                linear-gradient(135deg, rgba(255,255,255,.11), transparent 40%),
                linear-gradient(315deg, rgba(255,255,255,.05), transparent 35%);
            pointer-events:none;
        }

        .brand-row{
            display:flex;
            flex-wrap:wrap;
            gap:16px;
            align-items:center;
            justify-content:space-between;
            margin-bottom:22px;
            position:relative;
            z-index:1;
        }

        .brand{
            display:flex;
            align-items:center;
            gap:14px;
        }

        .brand-mark{
            width:56px;
            height:56px;
            border-radius:18px;
            display:grid;
            place-items:center;
            background:
                linear-gradient(135deg, rgba(255,255,255,.98), rgba(255,255,255,.72));
            color:#000;
            font-weight:900;
            letter-spacing:.08em;
            box-shadow:0 14px 38px rgba(255,255,255,.08);
            position:relative;
            overflow:hidden;
        }

        .brand-mark::after{
            content:"";
            position:absolute;
            inset:-2px;
            border-radius:inherit;
            border:1px solid rgba(0,0,0,.1);
        }

        .brand h1{
            margin:0;
            font-size:clamp(1.45rem, 2vw, 2.4rem);
            font-weight:800;
            letter-spacing:.02em;
        }

        .brand p{
            margin:4px 0 0;
            color:var(--muted);
            font-size:.95rem;
        }

        .royal-badge{
            padding:11px 16px;
            border:1px solid rgba(255,255,255,.18);
            border-radius:999px;
            background:rgba(255,255,255,.05);
            color:var(--text);
            letter-spacing:.12em;
            text-transform:uppercase;
            font-size:.72rem;
            font-weight:700;
            box-shadow:inset 0 1px 0 rgba(255,255,255,.08);
        }

        .page-grid{
            display:grid;
            grid-template-columns: 290px 1fr;
            gap:18px;
            margin-top:18px;
        }

        .nav-panel,
        .content-panel{
            border:1px solid var(--line);
            background:linear-gradient(180deg, rgba(255,255,255,.07), rgba(255,255,255,.03));
            backdrop-filter:blur(18px);
            border-radius:var(--radius);
            box-shadow:var(--shadow);
            position:relative;
            overflow:hidden;
        }

        .nav-panel::before,
        .content-panel::before{
            content:"";
            position:absolute;
            inset:0;
            background:
                radial-gradient(circle at top right, rgba(255,255,255,.08), transparent 26%),
                radial-gradient(circle at bottom left, rgba(255,255,255,.04), transparent 28%);
            pointer-events:none;
        }

        .nav-panel{
            padding:22px;
        }

        .nav-title{
            font-size:.82rem;
            text-transform:uppercase;
            letter-spacing:.18em;
            color:var(--muted);
            margin-bottom:14px;
        }

        .nav-chip{
            display:block;
            width:100%;
            text-align:left;
            padding:14px 16px;
            margin-bottom:10px;
            border-radius:18px;
            border:1px solid rgba(255,255,255,.10);
            background:linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.02));
            color:var(--text);
            text-decoration:none;
            transition:.28s ease;
            position:relative;
            overflow:hidden;
        }

        .nav-chip::after{
            content:"";
            position:absolute;
            top:0;left:-120%;
            width:60%;
            height:100%;
            background:linear-gradient(90deg, transparent, rgba(255,255,255,.16), transparent);
            transform:skewX(-18deg);
            transition:.7s ease;
        }

        .nav-chip:hover{
            transform:translateY(-2px) scale(1.01);
            border-color:rgba(255,255,255,.22);
            box-shadow:0 16px 30px rgba(0,0,0,.28);
        }

        .nav-chip:hover::after{
            left:150%;
        }

        .content-panel{
            padding:22px;
        }

        .section-head{
            display:flex;
            flex-wrap:wrap;
            gap:12px;
            justify-content:space-between;
            align-items:center;
            margin-bottom:18px;
        }

        .section-head h2{
            margin:0;
            font-size:1.15rem;
            font-weight:800;
            letter-spacing:.03em;
        }

        .section-head small{
            display:block;
            color:var(--muted);
            margin-top:4px;
        }

        .glass-card{
            border:1px solid rgba(255,255,255,.10);
            background:linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,.03));
            backdrop-filter:blur(14px);
            border-radius:24px;
            padding:20px;
            margin-bottom:18px;
            position:relative;
            overflow:hidden;
        }

        .glass-card::before{
            content:"";
            position:absolute;
            inset:-1px;
            border-radius:inherit;
            border:1px solid rgba(255,255,255,.08);
            pointer-events:none;
        }

        .form-label{
            color:rgba(255,255,255,.80);
            font-weight:600;
            margin-bottom:8px;
        }

        .form-control, .form-select{
            background:rgba(0,0,0,.38) !important;
            border:1px solid rgba(255,255,255,.13) !important;
            color:var(--text) !important;
            border-radius:18px !important;
            padding:13px 16px !important;
            box-shadow:none !important;
            transition:.25s ease !important;
        }

        .form-control::placeholder{
            color:rgba(255,255,255,.38);
        }

        .form-control:focus, .form-select:focus{
            border-color:rgba(255,255,255,.40) !important;
            box-shadow:0 0 0 .25rem rgba(255,255,255,.08) !important;
            transform:translateY(-1px);
        }

        .btn-royal{
            border:0;
            border-radius:16px;
            padding:12px 18px;
            font-weight:700;
            letter-spacing:.03em;
            transition:.25s ease;
            position:relative;
            overflow:hidden;
        }

        .btn-royal::after{
            content:"";
            position:absolute;
            inset:0;
            background:linear-gradient(120deg, transparent 0%, rgba(255,255,255,.18) 50%, transparent 100%);
            transform:translateX(-130%);
            transition:.7s ease;
        }

        .btn-royal:hover::after{
            transform:translateX(130%);
        }

        .btn-royal:hover{
            transform:translateY(-2px);
        }

        .btn-light-royal{
            background:#fff;
            color:#000;
            box-shadow:0 14px 34px rgba(255,255,255,.10);
        }

        .btn-dark-royal{
            background:#101010;
            color:#fff;
            border:1px solid rgba(255,255,255,.14);
        }

        .btn-outline-royal{
            background:transparent;
            color:#fff;
            border:1px solid rgba(255,255,255,.20);
        }

        .table-royal{
            width:100%;
            border-collapse:separate;
            border-spacing:0 10px;
        }

        .table-royal thead th{
            color:rgba(255,255,255,.72);
            font-size:.78rem;
            text-transform:uppercase;
            letter-spacing:.14em;
            padding:0 16px 10px;
            border:0;
        }

        .table-royal tbody tr{
            background:linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,.03));
            transition:.25s ease;
        }

        .table-royal tbody tr:hover{
            transform:translateY(-2px);
        }

        .table-royal td{
            padding:16px;
            border-top:1px solid rgba(255,255,255,.08);
            border-bottom:1px solid rgba(255,255,255,.08);
            color:var(--text);
            vertical-align:middle;
        }

        .table-royal tbody tr td:first-child{
            border-left:1px solid rgba(255,255,255,.08);
            border-top-left-radius:18px;
            border-bottom-left-radius:18px;
        }

        .table-royal tbody tr td:last-child{
            border-right:1px solid rgba(255,255,255,.08);
            border-top-right-radius:18px;
            border-bottom-right-radius:18px;
        }

        .pill{
            display:inline-flex;
            align-items:center;
            gap:8px;
            border:1px solid rgba(255,255,255,.14);
            border-radius:999px;
            padding:8px 12px;
            font-size:.82rem;
            color:var(--text);
            background:rgba(255,255,255,.05);
        }

        .page-user .hero,
        .page-user .nav-panel,
        .page-user .content-panel{ border-radius:34px; }

        .page-product .brand-mark{ border-radius:22px; }
        .page-product .hero{ border-radius:40px; }
        .page-product .nav-chip{ border-radius:22px; }
        .page-product .glass-card{ border-radius:28px; }

        .page-manufacturer .hero{
            border-radius:28px;
        }

        .page-manufacturer .brand-mark{
            clip-path:polygon(20% 0,80% 0,100% 20%,100% 80%,80% 100%,20% 100%,0 80%,0 20%);
            border-radius:14px;
        }

        .page-manufacturer .nav-chip{
            border-radius:14px;
        }

        .page-manufacturer .glass-card{
            border-radius:18px;
        }

        .arc-frame{
            position:relative;
            border-radius:28px;
            padding:1px;
            background:linear-gradient(135deg, rgba(255,255,255,.26), transparent 35%, rgba(255,255,255,.10) 70%, transparent 100%);
        }

        .arc-frame > div{
            border-radius:inherit;
        }

        .page-footer{
            margin-top:18px;
            text-align:center;
            color:rgba(255,255,255,.52);
            font-size:.88rem;
            letter-spacing:.04em;
            padding:18px 8px 4px;
        }

        .fade-in{
            animation:fadeUp .75s ease both;
        }

        @keyframes fadeUp{
            from{opacity:0; transform:translateY(18px)}
            to{opacity:1; transform:translateY(0)}
        }

        .float-1{ animation:floatUp 5s ease-in-out infinite; }
        .float-2{ animation:floatUp 7s ease-in-out infinite; animation-delay:-2s; }

        @keyframes floatUp{
            0%,100%{transform:translateY(0)}
            50%{transform:translateY(-8px)}
        }

        @media (max-width: 992px){
            .page-grid{
                grid-template-columns:1fr;
            }
        }

        @media (max-width: 576px){
            .hero, .nav-panel, .content-panel{
                padding:16px;
                border-radius:24px;
            }
            .brand{
                align-items:flex-start;
            }
            .brand-mark{
                width:48px;
                height:48px;
                border-radius:16px;
            }
        }
    </style>
</head>

<body class="page-user">
    <div class="bg-orb orb-1"></div>
    <div class="bg-orb orb-2"></div>

    <div class="shell">
        <section class="hero fade-in">
            <div class="brand-row">
                <div class="brand">
                    <div class="brand-mark">AI</div>
                    <div>
                        <h1>Open AI × World AI</h1>
                        <p>Royal black-and-white arc system for your ClassPro dashboard</p>
                    </div>
                </div>
                <div class="royal-badge">Premium Professional Layout</div>
            </div>

            <div class="page-grid">
                <aside class="nav-panel float-1">
                    <div class="nav-title">Navigation</div>
                    <a href="#user" class="nav-chip">User Page</a>
                    <a href="#product" class="nav-chip">Product Page</a>
                    <a href="#manufacturer" class="nav-chip">Manufacturer Page</a>
                    <a href="#table" class="nav-chip">Data Table View</a>
                </aside>

                <main class="content-panel float-2">
                    <div class="section-head">
                        <div>
                            <h2>Royal Dashboard Surface</h2>
                            <small>Keep your existing PHP form names and database logic exactly the same.</small>
                        </div>
                        <span class="pill">Auto Animation • Arc Design • Luxury UI</span>
                    </div>

                    <!-- USER SECTION -->
                    <section id="user" class="glass-card fade-in">
                        <div class="section-head">
                            <div>
                                <h2>User Module</h2>
                                <small>Black & white professional style</small>
                            </div>
                        </div>

                        <!-- keep your existing user form action / name attributes -->
                        <form method="post" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter name">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" placeholder="Enter address">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Contact No</label>
                                <input type="text" name="contact_no" class="form-control" placeholder="Enter contact no">
                            </div>
                            <div class="col-12 d-flex gap-2 flex-wrap mt-2">
                                <button type="submit" name="user_submit" class="btn btn-royal btn-light-royal">Save User</button>
                                <button type="reset" class="btn btn-royal btn-dark-royal">Reset</button>
                            </div>
                        </form>
                    </section>

                    <!-- PRODUCT SECTION -->
                    <section id="product" class="glass-card fade-in">
                        <div class="section-head">
                            <div>
                                <h2>Product Module</h2>
                                <small>Separate style zone, same logic, stronger premium look</small>
                            </div>
                        </div>

                        <form method="post" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="p_name" class="form-control" placeholder="Enter product name">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Price</label>
                                <input type="text" name="price" class="form-control" placeholder="Enter price">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Manufacturer ID</label>
                                <input type="text" name="manufacturer_id" class="form-control" placeholder="Enter manufacturer ID">
                            </div>
                            <div class="col-12 d-flex gap-2 flex-wrap mt-2">
                                <button type="submit" name="product_submit" class="btn btn-royal btn-light-royal">Save Product</button>
                                <button type="reset" class="btn btn-royal btn-outline-royal">Reset</button>
                            </div>
                        </form>
                    </section>

                    <!-- MANUFACTURER SECTION -->
                    <section id="manufacturer" class="glass-card fade-in">
                        <div class="section-head">
                            <div>
                                <h2>Manufacturer Module</h2>
                                <small>Clean arc panel with royal visual separation</small>
                            </div>
                        </div>

                        <form method="post" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Manufacturer Name</label>
                                <input type="text" name="m_name" class="form-control" placeholder="Enter manufacturer name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Address</label>
                                <input type="text" name="m_address" class="form-control" placeholder="Enter manufacturer address">
                            </div>
                            <div class="col-12 d-flex gap-2 flex-wrap mt-2">
                                <button type="submit" name="btnManufacturer" class="btn btn-royal btn-light-royal">Save Manufacturer</button>
                                <button type="reset" class="btn btn-royal btn-dark-royal">Reset</button>
                            </div>
                        </form>
                    </section>

                    <!-- TABLE SECTION -->
                    <section id="table" class="glass-card fade-in">
                        <div class="section-head">
                            <div>
                                <h2>Data Table</h2>
                                <small>Use this style for your existing table data output</small>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table-royal">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Contact / Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Sample</td>
                                        <td>Sample Address</td>
                                        <td>0000</td>
                                        <td>
                                            <button class="btn btn-sm btn-light-royal btn-royal">Edit</button>
                                            <button class="btn btn-sm btn-dark-royal btn-royal">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </main>
            </div>

            <div class="page-footer">
                Built with a royal black-white arc system, premium motion, and a clean professional layout.
            </div>
        </section>
    </div>

    <script>
        // tiny motion polish
        document.querySelectorAll('.glass-card, .nav-chip').forEach((el, i) => {
            el.style.animationDelay = (i * 80) + 'ms';
        });
    </script>
</body>
</html>