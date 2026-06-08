<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$file = basename($_GET['file'] ?? '');
if ($file === '') {
    header("Location: admin.php");
    exit();
}

$uploadDir = __DIR__ . "/upload";
$filesFile  = __DIR__ . "/files.txt";
$path = $uploadDir . "/" . $file;

if (file_exists($path)) {
    unlink($path);
}

if (file_exists($filesFile)) {
    $lines = file($filesFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $newLines = [];

    foreach ($lines as $line) {
        $delimiter = (strpos($line, "|") !== false) ? "|" : ",";
        $row = array_map('trim', explode($delimiter, $line));

        if ($delimiter === "|" && count($row) >= 5) {
            $stored = $row[2];
        } elseif ($delimiter === "," && count($row) >= 3) {
            $stored = $row[2];
        } else {
            $newLines[] = $line;
            continue;
        }

        if ($stored !== $file) {
            $newLines[] = $line;
        }
    }

    file_put_contents($filesFile, implode(PHP_EOL, $newLines) . (count($newLines) ? PHP_EOL : ""), LOCK_EX);
}

header("Location: admin.php");
exit();
?>