<?php
$conn = mysqli_connect("localhost", "root", "", "manufacter");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['save_manufacturer'])) {
    $name = $_POST['m_name'];
    $address = $_POST['address'];
    $contact = $_POST['contact_no'];

    mysqli_query($conn, "CALL manufacturer_info('$name','$address','$contact')");
}

if (isset($_POST['save_product'])) {
    $pname = $_POST['p_name'];
    $price = $_POST['price'];
    $mid = $_POST['m_id'];

    mysqli_query($conn, "CALL product_info('$pname','$price','$mid')");
}

if (isset($_POST['delete_m'])) {
    $id = (int)$_POST['manufacturer_id'];

    mysqli_query($conn, "DELETE FROM product WHERE manufacturer_id=$id");
    mysqli_query($conn, "DELETE FROM manufacturer WHERE id=$id");

    echo "Deleted successfully!";
}
?>

<!DOCTYPE html>
<html>
<body>

<h2>Manufacturer Form</h2>

<form method="post">
    Name:<br>
    <input type="text" name="m_name" required><br>

    Address:<br>
    <input type="text" name="address" required><br>

    Contact:<br>
    <input type="text" name="contact_no" required><br><br>

    <input type="submit" name="save_manufacturer" value="Save Manufacturer">
</form>

<hr>

<h2>Product Form</h2>

<form method="post">
    Product Name:<br>
    <input type="text" name="p_name" required><br>

    Price:<br>
    <input type="number" name="price" required><br>

    Manufacturer:<br>
    <select name="m_id" required>
        <option value="">Select</option>
        <?php
        $res = mysqli_query($conn, "SELECT * FROM manufacturer");
        while ($row = mysqli_fetch_assoc($res)) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        ?>
    </select><br><br>

    <input type="submit" name="save_product" value="Save Product">
</form>

<hr>

<h2>Delete Manufacturer</h2>

<form method="post">
    <select name="manufacturer_id" required>
        <option value="">Select</option>
        <?php
        $res = mysqli_query($conn, "SELECT * FROM manufacturer");
        while ($row = mysqli_fetch_assoc($res)) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        ?>
    </select><br><br>

    <input type="submit" name="delete_m" value="Delete">
</form>

<hr>

<h2>Products Price > 5000</h2>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Product Name</th>
    <th>Price</th>
    <th>Manufacturer</th>
</tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM manufacturer_view");

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['product_name']}</td>
        <td>{$row['price']}</td>
        <td>{$row['manufacturer_name']}</td>
    </tr>";
}
?>

</table>

</body>
</html>