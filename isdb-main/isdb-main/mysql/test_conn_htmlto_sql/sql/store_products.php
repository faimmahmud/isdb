<?php
$conn = mysqli_connect("localhost", "root", "", "procidure db");

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

if (isset($_POST['btnsubmit'])) {

    $name    = $_POST['mname'];
    $address = $_POST['maddress'];
    $con     = $_POST['mcontact'];

    // FIXED QUERY
    $sql = "CALL add_manu('$name', '$address', '$con')";

    if ($conn->query($sql)) {
        echo "<p style='color:green;'>Inserted Successfully</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manufacturer Form</title>
</head>
<body>

<fieldset>
    <h2>Add Manufacturer</h2>

    <form method="post">
        Name:
        <input type="text" name="mname" required> <br><br>

        Address:
        <input type="text" name="maddress" required> <br><br> 

        Contact:
        <input type="text" name="mcontact" required> <br><br>

        <input type="submit" name="btnsubmit" value="Submit Manufacturer">
    </form>

</fieldset>

<fieldset>
    <h2>Add Manufacturer</h2>

    <form method="post">
        Name:
        <input type="text" name="mname" required> <br><br>

        Price:
        <input type="text" name="maddress" required> <br><br> 

        Manufacturer:
        <select name="manuf">
            <?php
            $manu = $conn->query("select * form manufacturers");
            while (list($id, $n) = $manu-> fetch_row ()) {
                echo"product inserted successfully";
            }
            ?>
        </select>

        <input type="submit" name="btnsubmit" value="Submit Manufacturer">
    </form>

</fieldset>

</body>
</html>