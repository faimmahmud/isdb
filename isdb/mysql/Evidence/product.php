<?php
$conn = mysqli_connect("localhost", "root", "", "manufacter");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/* ================= INSERT ================= */

// Manufacturer Insert
if (isset($_POST['save_manufacturer'])) {
    $name    = $_POST['m_name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    mysqli_query($conn, "INSERT INTO manufacturer(name,address,contact)
                         VALUES('$name','$address','$contact')");
}

// Product Insert
if (isset($_POST['save_product'])) {
    $pname = $_POST['p_name'];
    $price = $_POST['price'];
    $mid   = $_POST['m_id'];

    mysqli_query($conn, "INSERT INTO product(Name,Price,Manufacturer_id)
                         VALUES('$pname','$price','$mid')");
}

/* ================= DELETE ================= */

if (isset($_GET['delete_m'])) {
    $id = $_GET['delete_m'];
    mysqli_query($conn, "DELETE FROM manufacturer WHERE id=$id");
}

if (isset($_GET['delete_p'])) {
    $id = $_GET['delete_p'];
    mysqli_query($conn, "DELETE FROM product WHERE id=$id");
}

/* ================= EDIT LOAD ================= */

$edit_m = null;
if (isset($_GET['edit_m'])) {
    $id = $_GET['edit_m'];
    $res = mysqli_query($conn, "SELECT * FROM manufacturer WHERE id=$id");
    $edit_m = mysqli_fetch_assoc($res);
}

$edit_p = null;
if (isset($_GET['edit_p'])) {
    $id = $_GET['edit_p'];
    $res = mysqli_query($conn, "SELECT * FROM product WHERE id=$id");
    $edit_p = mysqli_fetch_assoc($res);
}

/* ================= UPDATE ================= */

if (isset($_POST['update_manufacturer'])) {
    $id      = $_POST['id'];
    $name    = $_POST['m_name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    mysqli_query($conn, "UPDATE manufacturer 
                         SET name='$name', address='$address', contact='$contact'
                         WHERE id=$id");
}

if (isset($_POST['update_product'])) {
    $id    = $_POST['id'];
    $name  = $_POST['p_name'];
    $price = $_POST['price'];
    $mid   = $_POST['m_id'];

    mysqli_query($conn, "UPDATE product 
                         SET Name='$name', Price='$price', Manufacturer_id='$mid'
                         WHERE id=$id");
}
?>

<!DOCTYPE html>
<html>
<body>

<h2>Manufacturer Form</h2>
<form method="post">
    <input type="hidden" name="id" value="<?= $edit_m['id'] ?? '' ?>">

    Name:<br>
    <input type="text" name="m_name" value="<?= $edit_m['name'] ?? '' ?>"><br>

    Address:<br>
    <input type="text" name="address" value="<?= $edit_m['address'] ?? '' ?>"><br>

    Contact:<br>
    <input type="text" name="contact" value="<?= $edit_m['contact'] ?? '' ?>"><br><br>

    <?php if ($edit_m): ?>
        <input type="submit" name="update_manufacturer" value="Update">
    <?php else: ?>
        <input type="submit" name="save_manufacturer" value="Save">
    <?php endif; ?>
</form>

<hr>

<h2>Product Form</h2>
<form method="post">
    <input type="hidden" name="id" value="<?= $edit_p['id'] ?? '' ?>">

    Product Name:<br>
    <input type="text" name="p_name" value="<?= $edit_p['Name'] ?? '' ?>"><br>

    Price:<br>
    <input type="text" name="price" value="<?= $edit_p['Price'] ?? '' ?>"><br>

    Manufacturer:<br>
    <select name="m_id">
        <?php
        $res = mysqli_query($conn, "SELECT * FROM manufacturer");
        while ($row = mysqli_fetch_assoc($res)) {
            $selected = ($edit_p && $edit_p['Manufacturer_id'] == $row['id']) ? "selected" : "";
            echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
        }
        ?>
    </select><br><br>

    <?php if ($edit_p): ?>
        <input type="submit" name="update_product" value="Update">
    <?php else: ?>
        <input type="submit" name="save_product" value="Save">
    <?php endif; ?>
</form>

<hr>

<h2>Data List</h2>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Manufacturer</th>
    <th>Product</th>
    <th>Price</th>
    <th>Action</th>
</tr>

<?php
$q = "SELECT product.id, product.Name, Price, manufacturer.name AS mname
      FROM product
      JOIN manufacturer ON manufacturer.id = product.Manufacturer_id";

$res = mysqli_query($conn, $q);

while ($row = mysqli_fetch_assoc($res)) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['mname']}</td>
        <td>{$row['Name']}</td>
        <td>{$row['Price']}</td>
        <td>
            <a href='?edit_p={$row['id']}'>Edit</a> |
            <a href='?delete_p={$row['id']}'>Delete</a>
        </td>
    </tr>";
}
?>

</table>

</body>
</html>