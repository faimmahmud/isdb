<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$msg = "";

// create folder if not exists
if (!is_dir("uploads")) {
    mkdir("uploads");
}

// upload file
if (isset($_POST['upload'])) {

    if (!empty($_FILES['file']['name'])) {

        $name = time() . "_" . $_FILES['file']['name'];
        $tmp = $_FILES['file']['tmp_name'];
        $path = "uploads/" . $name;

        if (move_uploaded_file($tmp, $path)) {
            $msg = "File uploaded successfully";
        } else {
            $msg = "Upload failed";
        }

    } else {
        $msg = "Select a file";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload</title>
</head>
<body>

<h2>Welcome, <?php echo $_SESSION['user']; ?></h2>

<a href="logout.php">Logout</a>

<h3>Upload File</h3>

<?php echo $msg; ?>

<form method="post" enctype="multipart/form-data">
    <br>
    <input type="file" name="file"><br><br>
    <button type="submit" name="upload">Upload</button>
</form>

<hr>

<h3>All Uploaded Files</h3>

<?php
$files = scandir("uploads");

foreach ($files as $file) {

    if ($file != "." && $file != "..") {

        $path = "uploads/" . $file;
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        // show image
        if (in_array($ext, ["jpg", "jpeg", "png", "gif"])) {
            echo "<img src='$path' width='150'><br>";
        }

        // show link
        echo "<a href='$path' target='_blank'>$file</a><br><br>";
    }
}
?>

</body>
</html>