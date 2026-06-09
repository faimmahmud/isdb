<?php
require __DIR__ . '/config.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit();
}

$user = current_user();
$caption = trim($_POST['caption'] ?? '');
$file = $_FILES['media'] ?? null;
$redirectTo = trim($_POST['redirect_to'] ?? 'dashboard.php');
$allowedRedirects = ['dashboard.php', 'explore.php', 'profile.php'];

if (!in_array($redirectTo, $allowedRedirects, true)) {
    $redirectTo = 'dashboard.php';
}

$hasFile = $file && isset($file['error']) && $file['error'] !== UPLOAD_ERR_NO_FILE;

if ($caption === '' && !$hasFile) {
    flash_set('Write something or choose a file first.', 'error');
    header('Location: ' . $redirectTo);
    exit();
}

$kind = 'text';
$originalName = '';
$storedName = '';
$fileSize = 0;

if ($hasFile) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        flash_set('File upload failed. Please try again.', 'error');
        header('Location: ' . $redirectTo);
        exit();
    }

    if ($file['size'] > 10 * 1024 * 1024) {
        flash_set('File is too large. Max size is 10MB.', 'error');
        header('Location: ' . $redirectTo);
        exit();
    }

    $originalName = basename((string)$file['name']);
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'txt', 'doc', 'docx', 'zip'];
    if (!in_array($ext, $allowed, true)) {
        flash_set('Unsupported file type.', 'error');
        header('Location: ' . $redirectTo);
        exit();
    }

    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
        if (@getimagesize($file['tmp_name']) === false) {
            flash_set('The image file looks invalid.', 'error');
            header('Location: ' . $redirectTo);
            exit();
        }
        $kind = 'image';
    } else {
        $kind = 'file';
    }

    $storedName = 'nova_' . date('Ymd_His') . '_' . bin2hex(random_bytes(5)) . '.' . $ext;
    $target = UPLOAD_DIR . '/' . $storedName;

    if (!move_uploaded_file($file['tmp_name'], $target)) {
        flash_set('Could not save uploaded file.', 'error');
        header('Location: ' . $redirectTo);
        exit();
    }

    $fileSize = (int)$file['size'];
}

$post = [
    'id'            => uniqid('post_', true),
    'user_id'       => $user['id'] ?? '',
    'name'          => $user['name'] ?? '',
    'username'      => $user['username'] ?? '',
    'caption'       => $caption,
    'kind'          => $kind,
    'original_name' => $originalName,
    'stored_name'   => $storedName,
    'size'          => $fileSize,
    'created_at'    => time(),
];

append_json_line(POSTS_FILE, $post);

flash_set('Post shared successfully.', 'success');
header('Location: ' . $redirectTo);
exit();
