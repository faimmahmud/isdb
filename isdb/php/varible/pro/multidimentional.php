<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $amny = array(
        array(3,6,4,2),
        array(3,45,56,23),
        array(123,45,56),
    );
    print_r($amny);

    echo "<br>";
    echo "<br>";


$arre = [ 
    ["SR","sf","as","ads"],
    ["ad","ads","as"],
];
print_r($arre);

echo "<br>";
$arr = array(
    array("A", "t", "r"),
    array("B", "C", "y"),
    array(3, 5, 2)
);

for($i = 0; $i < count($arr); $i++) {

    echo "<h3>Row number $i</h3>";
    echo "<ul>";

    for($j = 0; $j < count($arr[$i]); $j++) {
        echo "<li>" . $arr[$i][$j] . "</li>";
    }

    echo "</ul>";
}

 echo "<br>";


// Original array
$numbers = [1,2,3,4,5,6,7,8,9,10,11,12];

// Chunk size
$chunkSize = 4;

// Split array into chunks
$chunks = array_chunk($numbers, $chunkSize);

// Print each chunk
foreach ($chunks as $index => $chunk) {
    echo "Chunk " . ($index + 1) . ": ";
    print_r($chunk);
    echo "<br>";
}
echo "<br>";






























?>
</body>
</html>