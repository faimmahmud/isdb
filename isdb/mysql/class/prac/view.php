<?php

$connect = mysqli_connect("localhost","root","","data_connect");

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

/* ================= DELETE ================= */
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    mysqli_query($connect, "DELETE FROM users WHERE id=$id");

    header("location:view.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

<h3>User List</h3>

<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Contact</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $result = mysqli_query($connect, "SELECT * FROM users");
        $i = 1;

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$i}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['contact']}</td>
                    <td>
                        <a href='edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='?delete={$row['id']}' class='btn btn-danger btn-sm'
                           onclick=\"return confirm('Delete this user?')\">Delete</a>
                    </td>
                  </tr>";
            $i++;
        }
        ?>
    </tbody>
</table>

<a href="facebook.com"> delete</a>
<a href="facebook.com">Edit</a>
</body>
</html>