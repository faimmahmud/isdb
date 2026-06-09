<!DOCTYPE html>
<html>
<head>
    <title>Validation Example</title>
    <style>
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>

<?php
// PHP code starts here
// Function to validate password based on image requirements
function validatePassword($password) {
    $errors = [];
    if (strlen($password) < 8) {
        $errors[] = "Minimum 8 characters";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "At least 1 uppercase letter";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "At least 1 lowercase letter";
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = "At least 1 number";
    }
    if (!preg_match('/[!@#$%^&*()\-_=.+-{};:,<.>]/', $password)) {
        $errors[] = "At least 1 special character";
    }
    return $errors;
}

// Function to validate email based on image requirements
function validateEmail($email) {
    $errors = [];
    // Must contain exactly one @ symbol
    if (substr_count($email, '@') !== 1) {
        $errors[] = "Must contain exactly one @ symbol.";
    } else {
        list($username, $domain) = explode('@', $email);

        // Username part can contain letters, numbers, dots, underscores, percents, plus, minus
        if (!preg_match('/^[a-zA-Z0-9._%+\-]+$/', $username)) {
            $errors[] = "Username part contains invalid characters.";
        }

        // Domain part can contain letters, numbers, dots, hyphens
        if (!preg_match('/^[a-zA-Z0-9\-\.]+$/', $domain)) {
            $errors[] = "Domain part contains invalid characters.";
        }

        // Top-Level-Domain (TLD) must be at least 2 letters
        if (!preg_match('/\.[a-zA-Z]{2,}$/', $domain)) {
            $errors[] = "Top-Level-Domain (TLD) must be at least 2 letters.";
        }
    }
    // No spaces allowed anywhere
    if (strpos($email, ' ') !== false) {
        $errors[] = "No spaces allowed anywhere.";
    }

    return $errors;
}

$password_message = $email_message = '';
$password_errors = $email_errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['password'])) {
        $password_errors = validatePassword($_POST['password']);
        if (empty($password_errors)) {
            $password_message = "<span class='success'>Password is valid!</span>";
        } else {
            $password_message = "<span class='error'>Password validation failed:</span>";
        }
    }

    if (isset($_POST['email'])) {
        $email_errors = validateEmail($_POST['email']);
        if (empty($email_errors)) {
            $email_message = "<span class='success'>Email is valid!</span>";
        } else {
            $email_message = "<span class='error'>Email validation failed:</span>";
        }
    }
}
// PHP code ends here
?>

    <h2>1. Password Requirements</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Password: <input type="text" name="password">
        <input type="submit" value="Validate Password">
    </form>
    <?php
    echo $password_message;
    if (!empty($password_errors)) {
        echo "<ul>";
        foreach ($password_errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
    ?>

    <h2>2. Email Requirements</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Email: <input type="text" name="email">
        <input type="submit" value="Validate Email">
    </form>
    <?php
    echo $email_message;
    if (!empty($email_errors)) {
        echo "<ul>";
        foreach ($email_errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
    ?>

</body>
</html>