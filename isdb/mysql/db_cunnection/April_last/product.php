<?php require("db.php"); ?>

<?php
if (!isset($_SESSION['user'])) {
    header("Location: user.php");
    exit();
}

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $brand = $_POST['Brand_id'];

    $img = $_FILES['Product_image']['name'];
    $tmp = $_FILES['Product_image']['tmp_name'];

    move_uploaded_file($tmp, "uploads/" . $img);

    mysqli_query($conn, "INSERT INTO product_list (name, price, Brand_id, Product_image)
                        VALUES ('$name', '$price', '$brand', '$img')");

    // ✅ REDIRECT WORKING
    header("Location: view.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <form method="POST" enctype="multipart/form-data" class="w-50 mx-auto border p-4 shadow">
        <h3 class="text-center">Product Info</h3>

        <input type="text" name="name" class="form-control mb-3" placeholder="Product Name" required>
        <input type="text" name="price" class="form-control mb-3" placeholder="Price" required>
        <input type="number" name="Brand_id" class="form-control mb-3" placeholder="Brand ID" required>

        <input type="file" name="Product_image" class="form-control mb-3" required>

        <button name="submit" class="btn btn-success w-100">Upload</button>
    </form>
</div>

</body>
</html>