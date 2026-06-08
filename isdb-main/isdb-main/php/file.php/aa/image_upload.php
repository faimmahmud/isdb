<!DOCTYPE html>
<html>
<head>
    <title>Creative Gallery</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Inter", sans-serif;
        }

        body {
            background: radial-gradient(circle at top, #1a1a2e, #0d0d0d);
            color: #eee;
        }

        /* BACKGROUND BLOBS */
        .bg {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .blob {
            position: absolute;
            width: 400px;
            height: 400px;
            background: #6c63ff;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.3;
            animation: move 20s infinite alternate;
        }

        .blob:nth-child(2) {
            background: #ff6ec7;
            top: 50%;
            left: 60%;
        }

        @keyframes move {
            from { transform: translate(0,0); }
            to { transform: translate(120px, -80px); }
        }

        .container {
            max-width: 1100px;
            margin: auto;
            padding: 30px 20px;
        }

        h1 {
            font-size: 34px;
        }

        p {
            color: #aaa;
            margin-top: 10px;
        }

        /* UPLOAD PANEL */
        .panel {
            margin-top: 20px;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 20px;
        }

        .upload form {
            display: flex;
            gap: 10px;
        }

        input[type="file"] {
            flex: 1;
            padding: 12px;
            border-radius: 12px;
            border: none;
            background: #111;
            color: #aaa;
        }

        button {
            padding: 12px 20px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #6c63ff, #8f7cff);
            color: white;
            cursor: pointer;
        }

        /* GRID (BIG IMAGES) */
        .grid {
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 20px;
        }

        .card {
            border-radius: 22px;
            overflow: hidden;
            cursor: pointer;
            position: relative;
            background: #111;
        }

        .card img {
            width: 100%;
            height: 220px; /* PERFECT SIZE */
            object-fit: cover;
            transition: 0.4s;
        }

        .card:hover img {
            transform: scale(1.08);
        }

        .card::after {
            content: "View";
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(0,0,0,0.5);
            padding: 5px 10px;
            border-radius: 10px;
            font-size: 12px;
        }

        /* MODAL */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.9);
            display: none;
            justify-content: center;
            align-items: center;
        }

        .modal img {
            max-width: 85%;
            max-height: 85%;
            border-radius: 20px;
            object-fit: contain;
            animation: zoom 0.4s ease;
        }

        @keyframes zoom {
            from { transform: scale(0.7); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

    </style>
</head>

<body>

<div class="bg">
    <div class="blob"></div>
    <div class="blob"></div>
</div>

<div class="container">

    <div class="topbar">
        <h2>Creative Gallery</h2>

        <!-- LOGOUT BUTTON -->
        <a href="logout.php">
            <button>Logout</button>
        </a>
    </div>

    <h1>Creative Gallery</h1>
    <p>Click any image to explore it in full immersive view.</p>

    <!-- UPLOAD -->
    <div class="panel upload">
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="filen" required>
            <button name="submitbutton">Upload</button>
        </form>
    </div>

    <?php
    $storeFile = "store.txt";
    $folder = "image/";

    echo "<div class='grid'>";

    if(file_exists($storeFile)){
        $files = file($storeFile, FILE_IGNORE_NEW_LINES);

        foreach($files as $file){
            $img = $folder . $file;

            if(file_exists($img)){
                echo "<div class='card' onclick=\"openModal('$img')\">
                        <img src='$img'>
                      </div>";
            }
        }
    }

    echo "</div>";

    // UPLOAD
    if(isset($_POST['submitbutton'])){
        $name = $_FILES['filen']['name'];
        $tmp = $_FILES['filen']['tmp_name'];
        $size = $_FILES['filen']['size'];

        if($size > 5120){
            $new = time().rand(1000,9999).$name;
            $path = $folder.$new;

            if(move_uploaded_file($tmp,$path)){
                file_put_contents($storeFile,$new.PHP_EOL,FILE_APPEND);
                echo "<p>Uploaded successfully</p>";
            }
        } else {
            echo "<p>Image too small</p>";
        }
    }
    ?>

</div>

<!-- MODAL -->
<div class="modal" id="modal" onclick="closeModal()">
    <img id="modalImg">
</div>

<script>
function openModal(src){
    document.getElementById("modal").style.display = "flex";
    document.getElementById("modalImg").src = src;
}

function closeModal(){
    document.getElementById("modal").style.display = "none";
}
</script>

</body>
</html>