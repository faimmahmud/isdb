<?php

trait main{
    public function info(){ 
        echo "this main class"."<br>";

    }
}

class child { 
    use main;
    public function save(){
        echo "this is child class";
    }
}
$m = new child();
$m->info();
$m->save();

?>