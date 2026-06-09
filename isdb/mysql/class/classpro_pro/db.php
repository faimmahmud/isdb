<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "classpro");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function flash_set($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

function flash_get() {
    if (!empty($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}
?>