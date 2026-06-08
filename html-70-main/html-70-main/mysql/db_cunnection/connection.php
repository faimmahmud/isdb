<?php

$connect = mysqli_connect("localhost", "root", "", "batch_70");

if ($connect) {
    echo "Connection sucessful";
} else {
    echo "Connection fail";
}

?>