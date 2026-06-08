<?php
// Database Connection[cite: 1]
$conn = mysqli_connect("localhost", "root", "", "h_student");

if (!$conn) {
    die("Connection Failed");
}

session_start(); //[cite: 1]

// Logic for User Insertion (from user.php)[cite: 4]
if (isset($_POST['next'])) {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    mysqli_query($conn, "INSERT INTO user (name, contact) VALUES ('$name', '$contact')");
    $_SESSION['user'] = $name;
    header("Location: main_interface.php?step=product"); // Redirect to product step
    exit();
}

// Logic for Product Insertion (from product.php)[cite: 2]
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $brand = $_POST['Brand_id'];
    $img = $_FILES['Product_image']['name'];
    $tmp = $_FILES['Product_image']['tmp_name'];

    move_uploaded_file($tmp, "uploads/" . $img);
    mysqli_query($conn, "INSERT INTO product_list (name, price, Brand_id, Product_image)
                        VALUES ('$name', '$price', '$brand', '$img')");
    header("Location: main_interface.php?step=view"); // Redirect to view list
    exit();
}
?>