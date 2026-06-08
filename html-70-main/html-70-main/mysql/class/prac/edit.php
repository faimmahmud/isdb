<?php

$connect=mysqli_connect("localhost","root","","data_connect");

if (!$connect) {
    die("connection failed");
}

/* ================= GET ID ================= */
$id = $_GET['id'] ?? null;

if (!$id) {
    header("location:view.php");
    exit();
}

/* ================= FETCH DATA ================= */
$res = mysqli_query($connect, "SELECT * FROM users WHERE id=$id");
$row = mysqli_fetch_assoc($res);

/* ================= UPDATE ================= */
if (isset($_POST['update'])) {

    $_n = $_POST['name'];
    $_c = $_POST['contact'];

    $q = "UPDATE users SET name='$_n', contact='$_c' WHERE id=$id";

    if (mysqli_query($connect, $q) == true) {
        header("location:view.php");
    } else {
        echo "data not updated";
    }
}

if($connect){
    echo "success";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

<h2 class="mb-4">Edit User Form</h2>

<form method="POST">

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control"
               value="<?php echo $row['name']; ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Contact</label>
        <input type="text" name="contact" class="form-control"
               value="<?php echo $row['contact']; ?>" required>
    </div>

    <div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="view.php" class="btn btn-secondary">Back</a>
    </div>

</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>