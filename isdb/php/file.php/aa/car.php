<?php
class Car
{
    public static $file_source = "store.txt";

    public static function showData()
    {
        // 🚫 BLOCK ACCESS IF NOT LOGGED IN
        if (!isset($_SESSION['user_id'])) {
            echo "Access denied. Please login.";
            return;
        }

        if (!file_exists(self::$file_source)) {
            echo "No data found.";
            return;
        }

        $lines = file(self::$file_source, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $unique_lines = array_unique($lines);

        foreach ($unique_lines as $line) {
            $arr = explode(",", trim($line));

            if (count($arr) === 3) {
                echo "<b>ID:</b> " . htmlspecialchars($arr[0]) . " | ";
                echo "<b>Name:</b> " . htmlspecialchars($arr[1]) . " | ";
                echo "<b>Email:</b> " . htmlspecialchars($arr[2]) . "<br>";
            }
        }
    }
}
?>