<?php
if (isset($_POST['submit'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];

    $file = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];

    move_uploaded_file($tmp, "uploads/" . $file);

    $text = $id . " - " . $name . " - " . $file . "\n";
    file_put_contents("upload.txt", $text, FILE_APPEND);

    echo "Done!";
}
?>

<!DOCTYPE html>
<html>
<body>

<form method="post" enctype="multipart/form-data">
    ID: <input type="text" name="id"><br><br>
    Name: <input type="text" name="name"><br><br>
    File: <input type="file" name="file"><br><br>
    <input type="submit" name="submit" value="Upload">
</form>

</body>
</html>