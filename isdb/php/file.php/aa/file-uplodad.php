<?php

echo "file Name" . $_FILES['filen']['name'];
echo "<br>";
echo "file Name" . $_FILES['filen']['tmp_name'];
echo "<br>";
echo "file Name" . $_FILES['filen']['size'];
echo "<br>";
echo "file Name" . $_FILES['filen']['error'];
echo "<br>";
echo "file Name" . $_FILES['filen']['full_path'];


?>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="filen">
    <input type="submit">
</form>