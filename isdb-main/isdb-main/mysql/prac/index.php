<?php
$conn = mysqli_connect("localhost","root","","exam_db");

if(isset($_POST['add_manufacturer'])){
    $n=$_POST['m_name'];
    $a=$_POST['m_address'];
    $c=$_POST['m_contact'];
    mysqli_query($conn,"CALL InsertManufacturer('$n','$a','$c')");
}

if(isset($_POST['add_product'])){
    $n=$_POST['p_name'];
    $p=$_POST['price'];
    $id=$_POST['manufacturer_id'];
    mysqli_query($conn,"INSERT INTO Product(name,price,manufacturer_id) VALUES('$n','$p','$id')");
}

if(isset($_GET['delete'])){
    $id=$_GET['delete'];
    mysqli_query($conn,"DELETE FROM Manufacturer WHERE id=$id");
}
?>

<!DOCTYPE html>
<html>
<body>

<h2>Manufacturer Form</h2>
<form method="POST">
<input name="m_name" placeholder="Name"><br>
<input name="m_address" placeholder="Address"><br>
<input name="m_contact" placeholder="Contact"><br>
<button name="add_manufacturer">Save</button>
</form>

<h2>Product Form</h2>
<form method="POST">
<input name="p_name" placeholder="Name"><br>
<input name="price" placeholder="Price"><br>
<input name="manufacturer_id" placeholder="Manufacturer ID"><br>
<button name="add_product">Save</button>
</form>

<h2>Manufacturer List</h2>
<ul>
<?php
$r=mysqli_query($conn,"SELECT * FROM Manufacturer");
while($row=mysqli_fetch_assoc($r)){
echo "<li>
{$row['id']} - {$row['name']} - {$row['address']} - {$row['contact_no']}
<a href='?delete={$row['id']}'>Delete</a>
</li>";
}
?>
</ul>

<h2>Product List</h2>
<ul>
<?php
$r=mysqli_query($conn,"SELECT * FROM Product");
while($row=mysqli_fetch_assoc($r)){
echo "<li>
{$row['id']} - {$row['name']} - {$row['price']} - {$row['manufacturer_id']}
</li>";
}
?>
</ul>

<h2>Price > 500 Products (View)</h2>
<ul>
<?php
$r=mysqli_query($conn,"SELECT * FROM high_price_products");
while($row=mysqli_fetch_assoc($r)){
echo "<li>
{$row['id']} - {$row['name']} - {$row['price']} - {$row['manufacturer_id']}
</li>";
}
?>
</ul>

</body>
</html>