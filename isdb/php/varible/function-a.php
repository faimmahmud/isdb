<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    //USER DEFINE

    function info($name)
    {
        echo "this our class $name";
    }
    info("pwad");
    echo "<br>";
        function add ($a , $b)
        {
            echo$a / $b;
        }
    add(33132,32);


    //anonymous function
    $add = function ($a) {
        echo "hello $a"; 
        };
     echo   "<br>";
        $add("world"); 
      echo  "<br>";

        //anonymous function -b

        $fsf = fn() => "hi";

        echo $fsf();

        $a = function () {};

        $b = fn ($a,$b) => "";
       echo "<br>";


        ///sgw
        $student = ["dfs","dfas","fga"];
        print_r($student);

    ?>
</body>
</html>