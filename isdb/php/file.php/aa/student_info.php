<?php
session_start();
require_once('car.php');

// Authorized credentials
 $authorized_id = "777";
 $authorized_email = "admin@test.com";
 $authorized_pass = "12345"; // NEW PASSWORD

// LOGIN
if (isset($_POST['login_btn'])) {

    $input_id = $_POST['login_id'] ?? '';
    $input_email = $_POST['login_email'] ?? '';
    $input_pass = $_POST['login_pass'] ?? '';

    if (
        $input_id === $authorized_id &&
        $input_email === $authorized_email &&
        $input_pass === $authorized_pass
    ) {
        $_SESSION['user_id'] = $input_id;
        header("Location:image_upload.php");
        exit();
    } else {
        $error_msg = "Access Denied: Wrong ID, Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Secure Data Portal</title>
</head>
<body>

<?php if (!isset($_SESSION['user_id'])): ?>

    <h2>Admin Login</h2>
    <?php if (isset($error_msg)) echo "<p style='color:red'>$error_msg</p>"; ?>

    <form method="post">
        ID:<br>
        <input type="number" name="login_id" required><br><br>

        Email:<br>
        <input type="email" name="login_email" required><br><br>

        Password:<br>
        <input type="password" name="login_pass" required><br><br>

        <input type="submit" name="login_btn" value="Login">
    </form>

<?php else: ?>

    <h2>Dashboard</h2>
    <p>Logged in as ID: <b><?php echo $_SESSION['user_id']; ?></b></p>

    <a href="?action=logout">Logout</a>

    <hr>

    <h3>Stored Student Records:</h3>
    <?php Car::showData(); ?>

<?php endif; ?>

</body>
</html>