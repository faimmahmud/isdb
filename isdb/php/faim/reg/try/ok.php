<?php
// Function to validate password
function validatePassword($password) {
    $errors = [];
    if (strlen($password) < 8) {
        $errors[] = "Minimum 8 characters required";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "At least 1 uppercase letter required";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "At least 1 lowercase letter required";
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = "At least 1 number required";
    }
    if (!preg_match('/[!@#$%^&*()\-_=.+-{};:,<.>]/', $password)) {
        $errors[] = "At least 1 special character required";
    }
    return $errors;
}

// Function to validate email
function validateEmail($email) {
    $errors = [];
    if (substr_count($email, '@') !== 1) {
        $errors[] = "Must contain exactly one @ symbol";
    } else {
        list($username, $domain) = explode('@', $email);
        if (!preg_match('/^[a-zA-Z0-9._%+\-]+$/', $username)) {
            $errors[] = "Username contains invalid characters";
        }
        if (!preg_match('/^[a-zA-Z0-9\-\.]+$/', $domain)) {
            $errors[] = "Domain contains invalid characters";
        }
        if (!preg_match('/\.[a-zA-Z]{2,}$/', $domain)) {
            $errors[] = "Top-Level-Domain must be at least 2 letters";
        }
    }
    if (strpos($email, ' ') !== false) {
        $errors[] = "No spaces allowed anywhere";
    }
    return $errors;
}

$status_message = '';
$all_errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $email_errors = validateEmail($email);
    $password_errors = validatePassword($password);

    $all_errors = array_merge($email_errors, $password_errors);

    if (empty($all_errors)) {
        $success = true;
        $status_message = "Authentication Successful. Welcome to the Syndicate.";
    } else {
        $status_message = "Access Denied. Validation Failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VVIP Corporate Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    
    <style>
        /* Royal Theme & Textures */
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #050505;
            /* Royal textured gradient background */
            background-image: 
                radial-gradient(circle at 50% 0%, #1a1a24 0%, transparent 50%),
                radial-gradient(circle at 50% 100%, #1a1a24 0%, transparent 50%),
                repeating-linear-gradient(45deg, #0a0a0a 0px, #0a0a0a 2px, #050505 2px, #050505 4px);
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .font-royal { font-family: 'Cinzel', serif; }

        /* Metallic Gold Gradient Text */
        .text-gold {
            background: linear-gradient(to right, #bf953f, #fcf6ba, #b38728, #fbf5b7, #aa771c);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* VVIP Card Styling with Live Animation Glassmorphism */
        .vvip-card {
            background: rgba(15, 15, 20, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(191, 149, 63, 0.3);
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.8), 
                        inset 0 0 20px rgba(191, 149, 63, 0.05);
            position: relative;
        }

        .vvip-card::before {
            content: '';
            position: absolute;
            top: 0; left: -100%; width: 50%; height: 100%;
            background: linear-gradient(to right, transparent, rgba(252, 246, 186, 0.1), transparent);
            transform: skewX(-25deg);
            animation: shine 6s infinite;
        }

        @keyframes shine {
            0% { left: -100%; }
            20% { left: 200%; }
            100% { left: 200%; }
        }

        /* Gmail-style floating labels with Gold accent */
        .input-group { position: relative; margin-bottom: 2rem; }
        
        .input-group input {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid #4a4a5a;
            padding: 10px 0;
            color: #fff;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .input-group label {
            position: absolute;
            top: 10px; left: 0;
            color: #888;
            font-size: 1rem;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .input-group input:focus,
        .input-group input:not(:placeholder-shown) {
            border-bottom: 1px solid #bf953f;
            box-shadow: 0 1px 0 0 #bf953f;
        }

        .input-group input:focus ~ label,
        .input-group input:not(:placeholder-shown) ~ label {
            top: -20px;
            font-size: 0.75rem;
            color: #bf953f;
            letter-spacing: 1px;
        }

        /* Custom Gold Button */
        .btn-gold {
            background: linear-gradient(to right, #8a6a27, #bf953f, #8a6a27);
            background-size: 200% auto;
            color: #000;
            transition: 0.5s;
            border: 1px solid #fcf6ba;
        }

        .btn-gold:hover {
            background-position: right center;
            box-shadow: 0 0 20px rgba(191, 149, 63, 0.5);
        }

        /* Ambient background glow */
        .ambient-glow {
            position: absolute;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(191, 149, 63, 0.08) 0%, transparent 60%);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            animation: pulse-glow 4s ease-in-out infinite alternate;
        }

        @keyframes pulse-glow {
            0% { transform: translate(-50%, -50%) scale(0.8); opacity: 0.5; }
            100% { transform: translate(-50%, -50%) scale(1.1); opacity: 1; }
        }
    </style>
</head>
<body>

    <div class="ambient-glow"></div>

    <div class="vvip-card w-full max-w-md p-10 rounded-sm z-10">
        
        <div class="text-center mb-10">
            <div class="flex justify-center mb-4">
                <div class="w-12 h-12 border-2 border-[#bf953f] rotate-45 flex items-center justify-center animate-pulse">
                    <div class="w-6 h-6 bg-gradient-to-br from-[#bf953f] to-[#aa771c]"></div>
                </div>
            </div>
            <h1 class="font-royal text-3xl tracking-widest text-gold uppercase mb-2">Syndicate</h1>
            <p class="text-xs tracking-[0.2em] text-gray-400 uppercase">VVIP Authentication Portal</p>
        </div>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div class="mb-6 p-4 border <?php echo $success ? 'border-green-800 bg-green-900/20' : 'border-red-900 bg-red-900/20'; ?>">
                <p class="text-sm font-royal tracking-wider text-center <?php echo $success ? 'text-green-400' : 'text-red-400'; ?>">
                    <?php echo $status_message; ?>
                </p>
                <?php if (!empty($all_errors)): ?>
                    <ul class="mt-3 list-disc list-inside text-xs text-red-300 space-y-1">
                        <?php foreach ($all_errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            
            <div class="input-group">
                <input type="text" name="email" id="email" placeholder=" " autocomplete="off" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <label for="email" class="font-royal">Corporate Identifier (Email)</label>
            </div>

            <div class="input-group">
                <input type="password" name="password" id="password" placeholder=" ">
                <label for="password" class="font-royal">Security Cipher (Password)</label>
            </div>

            <button type="submit" class="btn-gold w-full py-3 mt-4 font-royal font-bold tracking-widest uppercase text-sm">
                Authorize Access
            </button>
        </form>

        <div class="mt-8 text-center border-t border-[#bf953f]/20 pt-4">
            <p class="text-[10px] text-gray-500 uppercase tracking-widest">Restricted Area • Global Executives Only</p>
        </div>
    </div>

</body>
</html>