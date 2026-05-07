<?php
session_start();

$msg = "";

if (isset($_POST['login'])) {
    $u = $_POST['username'];
    $p = $_POST['password'];

    if ($u == "admin" && $p == "12345") {
        $_SESSION['user'] = $u;
        header("Location: upload.php");
        exit();
    } else {
        $msg = "Invalid login";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>
<?php echo $msg; ?>

<form method="post">
    <br>
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit" name="login">Login</button>
</form>

</body>
</html>