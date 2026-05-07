<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<h3>Registration Form</h3>

<form method="post">
    ID: <input type="text" name="id" required><br><br>
    Name: <input type="text" name="name" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    
    <input type="submit" name="submit" value="Save Data">
</form>

<hr>

<?php

$file = "store.txt";

if (isset($_POST['submit'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $data = "ID: $id | Name: $name | Email: $email | Password: $password\n";

    file_put_contents($file, $data, FILE_APPEND);

}


echo "<h4>Stored Data:</h4>";

if (file_exists($file)) {
    $content = file($file);

    foreach ($content as $line) {
        echo $line . "<br>";
    }
} else {
    echo "No data found.";
}

?>

</body>
</html>