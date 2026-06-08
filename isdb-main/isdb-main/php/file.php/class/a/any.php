<?php
// Car নামে একটি class তৈরি করা হয়েছে
class Car
{
    public $id;          // public property (বাইরে থেকেও access করা যাবে)
    private $name;       // private property (শুধু class এর ভিতরে ব্যবহার হবে)
    private $email;      // private property (email রাখার জন্য)

    public static $file_source = "store.txt"; // static variable (সব object এর জন্য same file)

    // Constructor function (object তৈরি হলে auto run হয়)
    public function __construct($id, $name, $email)
    {
        $this->id = $id;         // id assign করা
        $this->name = $name;     // name assign করা
        $this->email = $email;   // email assign করা
    }

    // Data file-এ save করার function
    public function saveData()
    {
        // data string বানানো (comma দিয়ে আলাদা)
        $data = $this->id . "," . $this->name . "," . $this->email . PHP_EOL;

        // file-এ data add করা (পুরনো data না মুছে নতুন add হবে)
        file_put_contents(self::$file_source, $data, FILE_APPEND);
    }

    // static function (object ছাড়াই call করা যাবে)
    public static function showData()
    {
        // যদি file না থাকে তাহলে কিছুই করবে না
        if (!file_exists(self::$file_source)) return;

        // file থেকে সব line পড়া (array আকারে)
        $lines = file(self::$file_source);

        // প্রতিটি line এক এক করে পড়া
        foreach ($lines as $line) {

            // comma দিয়ে data আলাদা করে array বানানো
            $arr = explode(",", trim($line));

            // data print করা
            echo "ID: " . $arr[0] . "<br>";
            echo "Name: " . $arr[1] . "<br>";
            echo "Email: " . $arr[2] . "<br><br>";
        }
    }
}
?>