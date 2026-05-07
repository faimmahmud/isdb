<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$uploadMessage = "";

// Upload
if (isset($_POST["upload"])) {

    $file = $_FILES["file"];
    $filename = time() . "_" . $file["name"];
    $filesize = $file["size"];
    $tmp = $file["tmp_name"];

    $minSize = 400 * 1024; // 400 KB

    if ($filesize < $minSize) {
        $uploadMessage = "❌ File too small! Minimum 400 KB required.";
    } else {

        if (!is_dir("uploads")) {
            mkdir("uploads");
        }

        move_uploaded_file($tmp, "uploads/" . $filename);
        $uploadMessage = "✅ File uploaded successfully!";
    }
}
?>

<h2>Welcome <?php echo $_SESSION["user"]; ?></h2>

<a href="logout.php">Logout</a>

<!-- Upload Form -->
<form method="POST" enctype="multipart/form-data">
    <h3>Upload File (Min 400 KB)</h3>
    <input type="file" name="file" required><br><br>
    <button type="submit" name="upload">Upload</button>
</form>

<p><?php echo $uploadMessage; ?></p>

<hr>

<h3>Uploaded Files</h3>

<div style="display:flex; flex-wrap:wrap; gap:15px;">
<?php
$dir = "uploads";

if (is_dir($dir)) {
    $files = scandir($dir);

    foreach ($files as $file) {
        if ($file != "." && $file != "..") {

            $path = "uploads/" . $file;
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            echo "<div style='border:1px solid #ccc; padding:10px; width:180px; text-align:center;'>";

            // Image preview
            if (in_array($ext, ["jpg", "jpeg", "png", "gif", "webp"])) {
                echo "<img src='$path' width='150' height='150' style='object-fit:cover;'><br>";
            } else {
                // Other file icon
                echo "📄 File<br>";
            }

            echo "<a href='$path' target='_blank'>$file</a>";

            echo "</div>";
        }
    }
} else {
    echo "No files uploaded yet.";
}
?>
</div>