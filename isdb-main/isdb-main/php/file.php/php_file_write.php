<?php

$write = file_put_contents("first.txt" , "hello\n",FILE_APPEND);

echo "sucess";

echo file_get_contents("first.txt")

$result = file("first.txt");
foreach ($result as $r){
    echo$r."<br>";
}
?>