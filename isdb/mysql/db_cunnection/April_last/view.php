<?php require("db.php"); ?>

<?php
$result = mysqli_query($conn, "SELECT * FROM product_list ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        img {
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>

<body>

<div class="container mt-5">

    <h2 class="text-center mb-4">Product List</h2>

    <table class="table table-bordered text-center">

        <tr class="table-dark">
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Brand</th>
            <th>Image</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)) { ?>

        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['Brand_id']; ?></td>

            <td>
                <?php
                $img = "uploads/" . $row['Product_image'];

                // SHOW IMAGE DIRECTLY (no blocking check)
                if (!empty($row['Product_image'])) {
                    echo "<img src='$img' width='80' height='80'>";
                } else {
                    echo "No Image";
                }
                ?>
            </td>

        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>