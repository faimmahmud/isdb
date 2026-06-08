<?php
$DB = mysqli_connect('localhost','root','', 'batch_70');

if (isset($_POST['submit'])) {
    
    $a = $_POST['name'];
    $b = $_POST['address'];
    $c = $_POST['email'];
    $d = $_POST['contact'];

    $DB->query("CALL ruti_khai('$a','$b','$c','$d')");
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Simple Form</title>
</head>
<body>

<h2>Input Form</h2>

<form method="POST">

    <input type="text" name="name" placeholder="Enter Name" required><br><br>

    <input type="text" name="address" placeholder="Enter Address" required><br><br>

    <input type="email" name="email" placeholder="Enter Email" required><br><br>

    <input type="text" name="contact" placeholder="Enter Contact" required><br><br>

    <button type="submit" name="submit">Submit</button>

</form>

</body>
</html>