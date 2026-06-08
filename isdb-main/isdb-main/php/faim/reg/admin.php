<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$uploadDir = __DIR__ . "/upload";
$filesFile  = __DIR__ . "/files.txt";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0775, true);
}

if (!file_exists($filesFile)) {
    file_put_contents($filesFile, "");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
    $id   = trim($_POST['id'] ?? '');
    $name = trim($_POST['name'] ?? '');

    if ($id === '' || $name === '' || empty($_FILES['file']['name'])) {
        $_SESSION['flash'] = "Please fill ID, Name, and choose a file.";
        header("Location: admin.php");
        exit();
    }

    $originalName = basename($_FILES['file']['name']);
    $safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', $originalName);
    $storedName = uniqid('file_', true) . '_' . $safeName;

    $tmp  = $_FILES['file']['tmp_name'];
    $dest = $uploadDir . "/" . $storedName;

    if (move_uploaded_file($tmp, $dest)) {
        // id|name|stored_file|original_name|time
        $data = implode("|", [$id, $name, $storedName, $originalName, date('Y-m-d H:i:s')]) . PHP_EOL;
        file_put_contents($filesFile, $data, FILE_APPEND | LOCK_EX);

        $_SESSION['flash'] = "File uploaded successfully.";
        header("Location: admin.php");
        exit();
    } else {
        $_SESSION['flash'] = "Upload failed. Please try again.";
        header("Location: admin.php");
        exit();
    }
}

$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

$records = [];
$lines = file_exists($filesFile) ? file($filesFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

foreach ($lines as $line) {
    $delimiter = (strpos($line, "|") !== false) ? "|" : ",";
    $row = array_map('trim', explode($delimiter, $line));

    if ($delimiter === "|" && count($row) >= 5) {
        $records[] = [
            'id' => $row[0],
            'name' => $row[1],
            'stored' => $row[2],
            'original' => $row[3],
            'time' => $row[4],
        ];
    } elseif ($delimiter === "," && count($row) >= 3) {
        $records[] = [
            'id' => $row[0],
            'name' => $row[1],
            'stored' => $row[2],
            'original' => $row[2],
            'time' => '',
        ];
    }
}

function isImageFile(string $filename): bool {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'avif'], true);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urban File Command</title>
    <style>
        :root{
            --bg:#020617;
            --panel:rgba(255,255,255,.06);
            --line:rgba(255,255,255,.12);
            --text:#e5e7eb;
            --muted:rgba(229,231,235,.70);
            --blue:#38bdf8;
            --violet:#8b5cf6;
            --orange:#f97316;
            --green:#22c55e;
            --shadow:0 24px 70px rgba(0,0,0,.40);
        }
        *{box-sizing:border-box;margin:0;padding:0;font-family:"Segoe UI",system-ui,Arial,sans-serif}
        body{
            min-height:100vh;
            color:var(--text);
            background:
                radial-gradient(circle at 20% 18%, rgba(56,189,248,.18), transparent 18%),
                radial-gradient(circle at 80% 12%, rgba(249,115,22,.16), transparent 20%),
                radial-gradient(circle at 70% 90%, rgba(139,92,246,.14), transparent 22%),
                linear-gradient(135deg, #020617 0%, #0f172a 35%, #111827 100%);
            overflow-x:hidden;
        }

        .fx{
            position:fixed;
            inset:0;
            pointer-events:none;
        }
        .grid{
            background-image:
                linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 46px 46px;
            opacity:.35;
            mask-image: linear-gradient(to bottom, rgba(0,0,0,.8), transparent 96%);
        }
        .beam{
            position:absolute;
            top:-20%;
            left:-30%;
            width:70vw;
            height:50vh;
            background:linear-gradient(120deg, transparent, rgba(56,189,248,.14), transparent);
            transform: rotate(12deg);
            filter: blur(12px);
            animation: move 12s ease-in-out infinite;
        }
        @keyframes move{
            0%,100%{ transform:translateX(0) rotate(12deg); opacity:.55; }
            50%{ transform:translateX(24vw) rotate(12deg); opacity:.85; }
        }

        .noise{
            position:absolute; inset:0;
            background-image: radial-gradient(rgba(255,255,255,.08) 1px, transparent 1px);
            background-size: 3px 3px;
            opacity:.08;
            mix-blend-mode:screen;
        }

        .wrap{
            width:min(1320px, 96vw);
            margin:0 auto;
            padding:28px 0 42px;
            position:relative;
            z-index:2;
        }

        .hero{
            display:flex;
            align-items:flex-end;
            justify-content:space-between;
            gap:20px;
            padding:24px 24px 22px;
            border-radius:28px;
            border:1px solid var(--line);
            background:linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,.04));
            backdrop-filter: blur(18px);
            box-shadow:var(--shadow);
            margin-bottom:22px;
        }
        .hero h1{
            font-size:clamp(26px, 4vw, 42px);
            line-height:1.05;
            margin-bottom:8px;
        }
        .hero p{
            color:var(--muted);
            font-size:14px;
            max-width:60ch;
            line-height:1.6;
        }
        .pill{
            display:inline-flex;
            align-items:center;
            gap:10px;
            padding:10px 14px;
            border-radius:999px;
            background:rgba(255,255,255,.08);
            border:1px solid rgba(255,255,255,.10);
            margin-bottom:14px;
            letter-spacing:.16em;
            text-transform:uppercase;
            font-size:12px;
        }
        .pulse{
            width:10px;height:10px;border-radius:50%;
            background:var(--green);
            box-shadow:0 0 18px var(--green);
            animation: pulse 1.8s ease-in-out infinite;
        }
        @keyframes pulse{
            0%,100%{ transform:scale(1); opacity:.65; }
            50%{ transform:scale(1.55); opacity:1; }
        }

        .logout{
            flex:none;
            padding:13px 18px;
            border-radius:16px;
            background:linear-gradient(135deg, #ef4444, #f97316);
            color:#fff;
            text-decoration:none;
            font-weight:800;
            box-shadow:0 16px 30px rgba(239,68,68,.18);
        }

        .layout{
            display:grid;
            grid-template-columns: 390px 1fr;
            gap:22px;
            align-items:start;
        }

        .panel{
            border-radius:28px;
            overflow:hidden;
            border:1px solid var(--line);
            background:linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,.04));
            backdrop-filter: blur(18px);
            box-shadow:var(--shadow);
        }
        .panel-head{
            padding:18px 20px;
            background:rgba(255,255,255,.03);
            border-bottom:1px solid rgba(255,255,255,.08);
        }
        .panel-head h2{
            font-size:20px;
            margin-bottom:6px;
        }
        .panel-head p{
            color:var(--muted);
            font-size:13px;
            line-height:1.5;
        }
        .panel-body{ padding:20px; }

        .flash{
            margin-bottom:16px;
            padding:13px 14px;
            border-radius:14px;
            background:rgba(34,197,94,.12);
            border:1px solid rgba(34,197,94,.18);
            color:#dcfce7;
            font-size:14px;
        }

        .field{ margin-bottom:14px; }
        label{
            display:block;
            margin-bottom:8px;
            color:#dbeafe;
            font-size:13px;
            font-weight:700;
        }
        input{
            width:100%;
            padding:14px 15px;
            border-radius:15px;
            border:1px solid rgba(255,255,255,.12);
            outline:none;
            background:rgba(15,23,42,.58);
            color:#fff;
            transition:.22s ease;
        }
        input:focus{
            border-color:var(--blue);
            box-shadow:0 0 0 4px rgba(56,189,248,.12);
            transform:translateY(-1px);
        }
        .btn{
            width:100%;
            padding:14px 16px;
            border:0;
            border-radius:15px;
            font-weight:800;
            color:#fff;
            cursor:pointer;
            background:linear-gradient(135deg, #0ea5e9, #7c3aed);
            box-shadow:0 18px 30px rgba(14,165,233,.20);
            transition:.2s ease;
        }
        .btn:hover{ transform:translateY(-2px); }

        .records{
            display:grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap:16px;
        }

        .card{
            position:relative;
            overflow:hidden;
            border-radius:24px;
            border:1px solid rgba(255,255,255,.10);
            background:
                radial-gradient(circle at top right, rgba(56,189,248,.10), transparent 32%),
                radial-gradient(circle at bottom left, rgba(249,115,22,.08), transparent 32%),
                rgba(255,255,255,.05);
            transition:transform .25s ease, border-color .25s ease;
        }
        .card:hover{
            transform:translateY(-5px);
            border-color:rgba(255,255,255,.18);
        }

        .thumb{
            height:190px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:linear-gradient(135deg, rgba(14,165,233,.18), rgba(124,58,237,.18));
            overflow:hidden;
            position:relative;
        }
        .thumb::after{
            content:"";
            position:absolute;
            inset:0;
            background:linear-gradient(180deg, transparent, rgba(2,6,23,.28));
            pointer-events:none;
        }
        .thumb img{
            width:100%;
            height:100%;
            object-fit:cover;
            display:block;
            transform:scale(1.01);
            transition:transform .45s ease;
        }
        .card:hover .thumb img{ transform:scale(1.06); }

        .filemark{
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            gap:10px;
        }
        .glyph{
            width:86px;height:86px;
            border-radius:24px;
            display:grid;
            place-items:center;
            background:linear-gradient(135deg, rgba(56,189,248,.18), rgba(124,58,237,.18));
            border:1px solid rgba(255,255,255,.10);
            font-weight:900;
            letter-spacing:.16em;
            box-shadow: inset 0 1px 0 rgba(255,255,255,.12);
        }

        .content{
            padding:16px;
        }
        .content h3{
            font-size:17px;
            line-height:1.35;
            margin-bottom:8px;
            word-break:break-word;
        }
        .meta{
            color:rgba(229,231,235,.72);
            font-size:13px;
            line-height:1.7;
            margin-bottom:14px;
        }
        .buttons{
            display:flex;
            gap:10px;
        }
        .view, .del{
            flex:1;
            text-align:center;
            text-decoration:none;
            padding:11px 12px;
            border-radius:13px;
            font-weight:800;
            font-size:13px;
        }
        .view{
            color:#fff;
            background:linear-gradient(135deg, #2563eb, #0ea5e9);
        }
        .del{
            color:#fff;
            background:linear-gradient(135deg, #ef4444, #f97316);
        }

        .empty{
            padding:32px;
            border-radius:20px;
            text-align:center;
            border:1px dashed rgba(255,255,255,.18);
            background:rgba(255,255,255,.04);
            color:var(--muted);
        }

        @media (max-width: 1020px){
            .layout{ grid-template-columns:1fr; }
            .hero{ align-items:flex-start; flex-direction:column; }
        }
    </style>
</head>
<body>
    <div class="fx grid"></div>
    <div class="fx noise"></div>
    <div class="fx beam"></div>

    <div class="wrap">
        <div class="hero">
            <div>
                <div class="pill"><span class="pulse"></span> File Command Center</div>
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?></h1>
                <p>
                    A richer dashboard with urban glass layers, motion gradients, and file cards that feel like a futuristic workspace.
                </p>
            </div>
            <a class="logout" href="logout.php">Logout</a>
        </div>

        <div class="layout">
            <section class="panel">
                <div class="panel-head">
                    <h2>Upload Studio</h2>
                    <p>Drop a file into the system and it will appear in the live archive below.</p>
                </div>
                <div class="panel-body">
                    <?php if ($flash !== ''): ?>
                        <div class="flash"><?php echo htmlspecialchars($flash); ?></div>
                    <?php endif; ?>

                    <form method="post" enctype="multipart/form-data">
                        <div class="field">
                            <label>ID</label>
                            <input type="text" name="id" placeholder="Enter ID" required>
                        </div>

                        <div class="field">
                            <label>Name</label>
                            <input type="text" name="name" placeholder="Enter name" required>
                        </div>

                        <div class="field">
                            <label>File</label>
                            <input type="file" name="file" required>
                        </div>

                        <button class="btn" type="submit" name="upload">Upload Now</button>
                    </form>
                </div>
            </section>

            <section class="panel">
                <div class="panel-head">
                    <h2>Live Archive</h2>
                    <p>Every card has its own hover motion, texture, and file preview style.</p>
                </div>
                <div class="panel-body">
                    <?php if (count($records) > 0): ?>
                        <div class="records">
                            <?php foreach ($records as $row): ?>
                                <?php
                                    $stored = $row['stored'];
                                    $original = $row['original'];
                                    $viewUrl = "upload/" . rawurlencode($stored);
                                    $isImage = isImageFile($stored);
                                ?>
                                <article class="card">
                                    <div class="thumb">
                                        <?php if ($isImage): ?>
                                            <img src="<?php echo $viewUrl; ?>" alt="<?php echo htmlspecialchars($original); ?>">
                                        <?php else: ?>
                                            <div class="filemark">
                                                <div class="glyph">FILE</div>
                                                <div style="font-size:12px;color:rgba(255,255,255,.72);letter-spacing:.12em;">OPEN TYPE</div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="content">
                                        <h3><?php echo htmlspecialchars($original); ?></h3>
                                        <div class="meta">
                                            <div><strong>ID:</strong> <?php echo htmlspecialchars($row['id']); ?></div>
                                            <div><strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?></div>
                                            <?php if (!empty($row['time'])): ?>
                                                <div><strong>Time:</strong> <?php echo htmlspecialchars($row['time']); ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="buttons">
                                            <a class="view" href="<?php echo $viewUrl; ?>" target="_blank">View</a>
                                            <a class="del" href="delete.php?file=<?php echo rawurlencode($stored); ?>" onclick="return confirm('Delete this file?')">Delete</a>
                                        </div>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty">No files uploaded yet.</div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>
</body>
</html>