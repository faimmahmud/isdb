<?php
class car
 {
    public $model = "sd12";
    public $color = "black";
    public $name = "bmw";
    public $date = "1.2.2001";

function info($c)
{ 
    $this->color = $c;
    return $this->color;

}
 }

 $result = new car();

 echo $result->model;
 echo "<br>";
 $result->color;
  echo "<br>";
  echo $result->info("red");
?>