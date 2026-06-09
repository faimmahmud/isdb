<!DOCTYPE html>
<html>
<head>
    <title>Form Example</title>
</head>
<body>

<!-- HTML Form -->
<form method="POST" action="">
    
    <label for="id">ID:</label>
    <input type="text" name="id" id="id"><br><br>

    <label for="name">Name:</label>
    <input type="text" name="name" id="name"><br><br>

    <input type="submit" name="submit" value="Submit">

</form>

<?php
// PHP Part
if (isset($_POST['submit'])) {
    
    $id = $_POST['id'];
    $name = $_POST['name'];

    echo "Your ID: " . $id . "<br>";
    echo "Your Name: " . $name;
}
?>

</body>
</html>