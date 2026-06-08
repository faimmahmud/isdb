<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "project";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "connected Successfully";

/* INSERT DATA */
if (isset($_POST['submit'])) {

    $name = $_POST['b'];
    $com  = $_POST['m'];

    {

$sql = "INSERT INTO brand (name, manufacturer) VALUES ('$name', '$com')";
        mysqli_query($conn, $sql);
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Brand System</title>

    <style>
        body{
            font-family: Arial;
            background:#f4f6f8;
            padding:20px;
        }
        .box{
            background:white;
            padding:20px;
            width:400px;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }
        input{
            width:100%;
            padding:10px;
            margin:8px 0;
        }
        button{
            padding:10px;
            width:100%;
            background:#007bff;
            color:white;
            border:none;
            cursor:pointer;
        }
        table{
            margin-top:20px;
            width:100%;
            background:white;
            border-collapse:collapse;
        }
        th,td{
            padding:10px;
            border:1px solid #ddd;
            text-align:left;
        }
    </style>

</head>
<body>

<h2>Brand Entry System</h2>

<div class="box">
    <form method="post">
        <input type="text" name="b" placeholder="Brand Name" required>
        <input type="text" name="m" placeholder="Manufacturer" required>
        <button type="submit" name="submit">Submit</button>
    </form>
</div>

</body>
</html>