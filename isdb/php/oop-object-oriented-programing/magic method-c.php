<?php
// class car 
// {
//     public function __destruct()
//     {
//         echo " <br>bye";
//     }

//     public function __construct($n, $c)
//     {
//         echo "so " . $this->name = $n . " is " . $this->color = $c;
//     }
// }

// $result = new car("toyata", "red");
class car {
public $name;
public $color;
public function setName($nam)
{ 
    $this->name = $nam;
}
public function getname()
{
return $this->name;
}
public function __distruct(){                                                            

}

}



?>