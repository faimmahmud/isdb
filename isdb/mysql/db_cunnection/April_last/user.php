<?php require("db.php"); ?>

<?php
if (isset($_POST['next'])) {

    $name = $_POST['name'];
    $contact = $_POST['contact'];

    mysqli_query($conn, "INSERT INTO user (name, contact) VALUES ('$name', '$contact')");

    $_SESSION['user'] = $name;

    header("Location: product.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <form method="POST" class="w-50 mx-auto border p-4 shadow">
        <h3 class="text-center">User Info</h3>

        <input type="text" name="name" class="form-control mb-3" placeholder="Name" required>
        <input type="text" name="contact" class="form-control mb-3" placeholder="Contact" required>

        <button name="next" class="btn btn-primary w-100">Next</button>
    </form>
</div>

</body>
</html>