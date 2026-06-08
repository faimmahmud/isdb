<?php
$array = [
    [1,"fahim",40,"e@gmail.com","+5676577"],
    [2,"fahim",40,"e@gmail.com","+5676577"],
    [3,"fahim",40,"e@gmail.com","+5676577"],
    [4,"fahim",40,"e@gmail.com","+5676577"],
];
$array = file("data.txt");
foreach($array as $file){
    list($x,$y,$z) = explode(",","$file");
echo "ID:" . $x . "" . "Name:" . $y . "" . "address" . $x . "<br>";
}



?>

