<?php

$connect=mysqli_connect("localhost","root","","data_connect");

if (isset($_POST['submit'])){
    $_n = $_POST['name'];
    $_c = $_POST['contact'];

    $q = "INSERT INTO users (name,contact)VALUES('$_n','$_c')";
if (mysqli_query($connect,$q) == true){
    echo "submit hoice";
    header("location:view.php");
}
    else {"data not inserted";
    }

}

if($connect){
    echo "submit hoice";

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Form</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>User Form</h2>

<form method="POST">
    <div class="mb-3">
        Name
        <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
    </div>

    <div class="mb-4">
        Email address
        <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
    </div>
    <div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </div>
 
    
   
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>