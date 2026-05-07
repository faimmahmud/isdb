<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   
<?php
//array

    $a = array("fahim","rafin","rakib");
    var_dump($a);
    echo "<br>";

    //object example 1.
    
    class Student2
    { 
        public $name = "fahim";
    }
    $obj2 = new Student2();
    var_dump($obj2);
        // assigment
    $x = 5;
    $x += 6;
    echo $x;

    $e = 10;
    echo ++$e;
    // echo --$r;
    echo "<br>";
    $t = 4;

    echo $t++;
    echo "<br>";
  

?>


</body>
</html>