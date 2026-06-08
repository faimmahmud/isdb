<?php 

class student{
    public $name;
    public $age;
    public $address;
    public $id;
    public $subject;

   

    public function details($n){
     echo " my name is " . $this->name = $n;  
   }
public function __construct()
{
    echo "hello pwad ";
}

public function __destruct()
{
    echo "<br>";
}

}

class teacher extends student
{ 
    public $experience;
    public function teacherdetails()
    { 
        echo"hello teacher";
    }
}

class authority{ 
    public $number;
    public function authoritydetails(){ 
        echo "hello world";
    }

    
}
$st = new student();
$st->details("faim");

echo "<br>";

$tr = new teacher();
echo $tr->name;
"<br>";
$tr->teacherdetails();
"<br>";
$tr->details(" ali");
"<br>";

$at = new authority();
"<br>";
$at->authoritydetails();


?>