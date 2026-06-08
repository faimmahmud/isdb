<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $user = [
        "name" => $name,
        "email" => $email,
        "password" => $password
    ];

    file_put_contents("user.json", json_encode($user));

    echo "Registration successful. <a href='login.php'>Login</a>";
    exit;
}
?>

<form method="POST">
    <h2>Register</h2>
    Name: <input type="text" name="name" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit">Register</button>
</form>