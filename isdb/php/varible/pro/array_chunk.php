<?php


$c = array("ab", "bc", "ca", "bd", "rg", "tk", "ab", "bc", "ca");
$h = array_chunk($c, 2);
print_r($h);

echo "<br>";
echo "<br>";
echo json_encode($h);

echo "<br>";
echo "<br>";

$array1 = array("apple", "banana", "orange", "grape");
$array2 = array("banana", "grape", "kiwi");
$array3 = array("orange", "mango");

// Find values in $array1 that are NOT in $array2 and $array3
$result = array_diff($array1, $array2, $array3);

print_r($result);
echo "<br>";
echo "<br>";

$arr1 = []
?>