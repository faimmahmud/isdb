<?php

require_once('car.php');

if (isset($_POST['submit'])) {


    $id = $_POST['id'];      
    $name = $_POST['name'];    
    $email = $_POST['email'];

    $car = new Car($id, $name, $email);

    $car->saveData();

    echo "Data Saved Successfully<br><br>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Info</title>
</head>
<body>


<form method="post">
    
    ID: <br>
    <input type="number" name="id" required><br><br>

    Name: <br>
    <input type="text" name="name" required><br><br>

    Email: <br>
    <input type="email" name="email" required><br><br>

    <input type="submit" name="submit" value="Submit">
</form>

<hr>

<?php

Car::showData();
?>

</body>
</html>