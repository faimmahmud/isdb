<?php
class student
{ 
    public $name = "fahim";
    private $age = "24";
    protected $degree = "BSC";

    public function fullinfo()
    { 
        echo $this->name;
        echo $this->age;
        echo $this->degree;
        

    }
}
$result = new student();

echo $result->name;
echo "<br>";
echo $result->degree;
?>