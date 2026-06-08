<?php
class car
{
public $name;
public $color;

public function __destruct()
{
echo "bye";
}
public function __construct()
{
    echo "hello world <br>";
}
}
$result = new car();



?>