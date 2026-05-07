<?php
$conn = mysqli_connect("localhost", "root", "", "h_student");

if (!$conn) {
    die("Connection Failed");
}

session_start();
?>