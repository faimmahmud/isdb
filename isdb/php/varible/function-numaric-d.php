<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    //numeric[is_numberic(),round,]
    $num = "1243123.4233653";
    var_dump(is_numeric($num));
    echo "<br>";
    //convert dec to int
    echo intval($num);
    echo "<br>";
    echo round($num);
    echo "<br>";
    echo floatval($num);
    echo "<br>";
    echo pow(2,2);

    ?>
</body>
</html>