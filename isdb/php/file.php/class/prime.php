<!DOCTYPE html>
<html>
<head>
    <title>Prime Number Check</title>
</head>
<body>

<form method="post">
    <label>Enter a Number:</label>
    <input type="number" name="num" required><br><br>

    <input type="submit" name="submit" value="Check Prime">
</form>

<?php
if (isset($_POST['submit'])) {
    $num = $_POST['num'];
    $isPrime = true;

    if ($num <= 1) {
        $isPrime = false;
    } else {
        for ($i = 2; $i <= $num / 2; $i++) {
            if ($num % $i == 0) {
                $isPrime = false;
                break;
            }
        }
    }

    if ($isPrime) {
        echo "<h3>$num is a Prime Number</h3>";
    } else {
        echo "<h3>$num is NOT a Prime Number</h3>";
    }
}
?>

</body>
</html>