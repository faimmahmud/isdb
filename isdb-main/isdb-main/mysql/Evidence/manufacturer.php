<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "manufacter";

$conn = mysqli_connect("localhost", "root", "", "manufacter");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Manufacturer Insert
if (isset($_POST['save_manufacturer'])) {
    $name    = $_POST['m_name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];


     $query = "CALL manufacturer_info ('$name', '$address', '$contact')";

    if (mysqli_query($conn, $query)) {
        echo "<p style='color:green;'>Manufacturer inserted successfully!</p>";
    } else {
        echo mysqli_error($conn);
    }
}

// Product Insert
if (isset($_POST['save_product'])) {
    $pname = $_POST['p_name'];
    $price = $_POST['price'];
    $mid   = $_POST['m_id'];

    $query = "CALL product_info ('$pname', '$price', '$mid')";
    if (mysqli_query($conn, $query)) {
        echo "<p style='color:blue;'>Product inserted successfully!</p>";
    } else {
        echo mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manufacturer & Product</title>
</head>
<body>

<h2>Manufacturer Form</h2>
<form method="post">
    Name: <br>
    <input type="text" name="m_name" required><br><br>

    Address: <br>
    <input type="text" name="address" required><br><br>

    Contact: <br>
    <input type="text" name="contact" required><br><br>

    <input type="submit" name="save_manufacturer" value="Save Manufacturer">
</form>

<hr>

<h2>Product Form</h2>
<form method="post">
    Product Name: <br>
    <input type="text" name="p_name" required><br><br>

    Price: <br>
    <input type="text" name="price" required><br><br>

    Manufacturer: <br>
    <select name="m_id" required>
        <option value="">Select Manufacturer</option>
        <?php
        $res = mysqli_query($conn, "SELECT id, name FROM manufacturer");
        while ($row = mysqli_fetch_assoc($res)) {
            echo "<option value='".$row['id']."'>".$row['name']."</option>";
        }
        ?>
    </select><br><br>

    <input type="submit" name="save_product" value="Save Product">
</form>

<hr>

<h2>All Data (View)</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Manufacturer</th>
    <th>Address</th>
    <th>Contact</th>
    <th>Product</th>
    <th>Price</th>
</tr>

<?php
$query = "SELECT manufacturer.name AS mname, address, contact,
                 product.Name AS pname, Price
          FROM manufacturer
          LEFT JOIN product 
          ON manufacturer.id = product.Manufacturer_id";

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$row['mname']}</td>
        <td>{$row['address']}</td>
        <td>{$row['contact']}</td>
        <td>{$row['pname']}</td>
        <td>{$row['Price']}</td>
    </tr>";
}
?>
</table>
</body>
</html>