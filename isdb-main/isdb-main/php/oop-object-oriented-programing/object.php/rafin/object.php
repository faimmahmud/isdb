<?php



require_once("car.php");
require_once("user_info.php");
require_once("user_info2.php");

use User1\User;
use User2\User as UserInfo2;


$result = new car();
$result->Carinfo();


$result = new User();
$result->userinfo();
$result->usermodel();


$result2 = new UserInfo2();
$result2->userinfo();
$result2->usermodel();

?>