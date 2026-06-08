<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    echo time();
    echo "<br>";
    echo date('d'); // date
    echo "<br>";
    echo date("D"); // week
    echo "<br>";
    echo date ("m"); //
    echo "<br>";
    echo date ("y"); //
    echo "<br>";
    echo date ("Y"); // month
    echo "<br>";
    echo date ("n"); // numeric value
    echo "<br>";
    echo date ("L"); // leap 
    echo "<br>";
    echo date ("H:i:s"); // short month
    echo "<br>";


    echo date ("a");
    echo "<br>";
    echo date ("A");
    echo "<br>";
    echo date ("a");
    echo "<br>";
    echo date_default_timezone_get(). "<br>" . date("h");
    echo "<br>";
    echo date_default_timezone_get();
    date_default_timezone_set("Asia/Dhaka");
    echo "<br>";
    echo date_default_timezone_get();
    echo "<br>";
    
  $date = date_create(".02");
$date2 = date_create("12.3.2026");

$diff = date_diff($date, $date2);

echo $diff->format("%y Years %m Months %d Days");

    ?>
</body>
</html>