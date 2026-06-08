<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $data = json_decode(file_get_contents("user.json"), true);

    if ($data && $data["email"] == $email && $data["password"] == $password) {
        $_SESSION["user"] = $data["name"];
        header("Location: fileupload.php");
        exit;
    } else {
        echo "Invalid login!";
    }
}
?>

<form method="POST">
    <h2>Login</h2>
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit">Login</button>
</form>