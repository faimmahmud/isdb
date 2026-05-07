<?php

$result = fopen("first.text","r") or die("file is not found");

echo fread($result,filesize("first.text"));

fclose($result);

echo "<br>";
echo "<br>";

echo readfile("first.text");
?>