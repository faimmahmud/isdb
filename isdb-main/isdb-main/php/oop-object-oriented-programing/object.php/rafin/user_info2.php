<?php


namespace User2;

class User
{
    public $name = "samsung";
    public $model = "i70";

    public function userinfo(){
        echo "<br> This is " . $this->name;
    }
    public function usermodel(){
        echo "<br> This is " . $this->model;
    }
}
?>