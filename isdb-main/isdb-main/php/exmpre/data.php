<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Form</title>
</head>
<body>

<h3>Student Form</h3>

<form method="post">
    ID: <input type="text" name="id" required><br><br>
    Name: <input type="text" name="name" required><br><br>

    Batch:
    <select name="batch">
        <option value="pwad-70">pwad-70</option>
        <option value="pwad-71">pwad-71</option>
        <option value="pwad-72">pwad-72</option>
    </select>
    <br><br>

    <input type="submit" name="submit" value="Save">
</form>

<hr>

<h3>Search Student by ID</h3>

<form method="post">
    Search ID: <input type="text" name="search_id" required>
    <input type="submit" name="search" value="Search">
</form>

<?php

class Student {

    public $id, $name, $batch;

    function __construct($id, $name, $batch) {
        $this->id = $id;
        $this->name = $name;
        $this->batch = $batch;
    }

    function save() {
        file_put_contents(
            "store.txt",
            $this->id . "," . $this->name . "," . $this->batch . "\n",
            FILE_APPEND
        );
    }

    static function showAll() {

        $file = "store.txt";

        if (!file_exists($file)) {
            echo "No data found!";
            return;
        }

        echo "<h3>All Students:</h3>";

        $lines = file($file);

        foreach ($lines as $line) {
            $data = explode(",", trim($line));

            echo "ID: " . $data[0] .
                 " | Name: " . $data[1] .
                 " | Batch: " . $data[2] . "<br>";
        }
    }

    static function searchById($id) {

        $file = "store.txt";

        if (!file_exists($file)) {
            echo "No data found!";
            return;
        }

        $found = false;
        $lines = file($file);

        foreach ($lines as $line) {
            $data = explode(",", trim($line));

            if ($data[0] == $id) {
                echo "<h3>Search Result:</h3>";
                echo "ID: " . $data[0] .
                     " | Name: " . $data[1] .
                     " | Batch: " . $data[2] . "<br>";
                $found = true;
                break;
            }
        }

        if (!$found) {
            echo "<h3 style='color:red;'>Student Not Found!</h3>";
        }
    }
}

if (isset($_POST['submit'])) {

    $s = new Student($_POST['id'], $_POST['name'], $_POST['batch']);
    $s->save();
}

if (isset($_POST['search'])) {
    Student::searchById($_POST['search_id']);
}


Student::showAll();

?>

</body>
</html>