<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "project";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected Successfully";

/* INSERT DATA */
if (isset($_POST['addsubmit'])) {

    $name  = $_POST['name'];
    $price = $_POST['price'];

    $sql = "INSERT INTO product (name, price) VALUES ('$name', '$price')";

    if (mysqli_query($conn, $sql)) {
        echo "<p style='color:green;'>Data Inserted Successfully</p>";
    } else {
        echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Entry</title>

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
            background:green;
            color:white;
            border:none;
            cursor:pointer;
        }
    </style>

</head>
<body>

<h2>Product Entry System</h2>

<div class="box">
    <form method="post">
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="number" name="price" placeholder="Price" required>
        <button type="submit" name="addsubmit">Add Submit</button>
    </form>
</div>

</body>
</html>