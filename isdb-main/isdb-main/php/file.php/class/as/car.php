<?php
class Car
{
    public $id;
    private $name;
    private $email;
    public static $file_source = "store.txt";

    public function __construct($id, $name, $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public static function showData()
    {
        if (!file_exists(self::$file_source)) {
            echo "No data file found.";
            return;
        }

        // Read file safely
        $lines = file(self::$file_source, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Remove duplicates
        $unique_lines = array_unique($lines);

        foreach ($unique_lines as $line) {

            // Clean unwanted spaces
            $clean_line = trim($line);

            // Split data (ID, Name, Email)
            $arr = explode(",", $clean_line);

            // Ensure correct format
            if (count($arr) === 3) {

                $id = htmlspecialchars(trim($arr[0]));
                $name = htmlspecialchars(trim($arr[1]));
                $email = htmlspecialchars(trim($arr[2]));

                echo "<b>ID:</b> $id | <b>Name:</b> $name | <b>Email:</b> $email<br>";
            }
        }
    }
}
?>