<?php

class user
{
    public static $name ="hello world!" . "<br>";
    const name = " hello world!" . "<br>";

    public static function info()
    {
        echo " this is static method <br>";
    }
}
// $ person = new user();
// $person->info();

echo user::info();
echo user::$name = "fahim";

?>