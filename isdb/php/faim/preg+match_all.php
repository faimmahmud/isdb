<?php

// /patten/mpdifier(i-case-insensative)
$str = "this regular exprsion";
$pattern = "/i/i";
echo preg_match_all($pattern,$str);
echo preg_match($pattern,$str); //return 1
echo"<br>";
$data = "we have a plan";
$p = "/plan/i";
echo preg_replace($p, "idea", $data)


?>