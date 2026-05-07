<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/travel-data.php';

function site_root(): string {
    $dir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
    if (preg_match('~/(admin|includes)$~', $dir)) {
        $dir = dirname($dir);
    }
    return $dir === '/' ? '' : $dir;
}

function app_path(string $file = ''): string {
    $root = site_root();
    return $root . '/' . ltrim($file, '/');
}

function asset(string $path): string {
    return app_path($path);
}

function load_json(string $file, array $default = []): array {
    if (!file_exists($file)) {
        return $default;
    }
    $json = file_get_contents($file);
    $data = json_decode($json, true);
    return is_array($data) ? $data : $default;
}

function save_json(string $file, array $data): bool {
    $dir = dirname($file);
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
    return file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) !== false;
}

function current_user(): ?array {
    return $_SESSION['user'] ?? null;
}

function is_admin(): bool {
    return isset($_SESSION['user']) && (($_SESSION['user']['role'] ?? 'user') === 'admin');
}

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function flash_set(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function flash_get(): ?array {
    if (!isset($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function redirect(string $path): void {
    header('Location: ' . $path);
    exit;
}

function user_store_path(): string {
    return __DIR__ . '/../data/users.json';
}

function booking_store_path(): string {
    return __DIR__ . '/../data/bookings.json';
}

function package_store_path(): string {
    return __DIR__ . '/../data/packages.json';
}

function read_packages(): array {
    return load_json(package_store_path(), []);
}

function write_packages(array $packages): bool {
    return save_json(package_store_path(), array_values($packages));
}

function read_users(): array {
    return load_json(user_store_path(), []);
}

function write_users(array $users): bool {
    return save_json(user_store_path(), array_values($users));
}

function read_bookings(): array {
    return load_json(booking_store_path(), []);
}

function write_bookings(array $bookings): bool {
    return save_json(booking_store_path(), array_values($bookings));
}

function handle_image_upload(string $field, string $existing = ''): string {
    if (!isset($_FILES[$field]) || ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return $existing;
    }

    $tmp = $_FILES[$field]['tmp_name'];
    $name = basename($_FILES[$field]['name']);
    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

    if (!in_array($ext, $allowed, true)) {
        return $existing;
    }

    $uploadDir = __DIR__ . '/../uploads';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0775, true);
    }

    $newName = uniqid('img_', true) . '.' . $ext;
    $target = $uploadDir . '/' . $newName;
    if (move_uploaded_file($tmp, $target)) {
        return app_path('uploads/' . $newName);
    }

    return $existing;
}

function ensure_storage(): void {
    foreach ([__DIR__ . '/../data', __DIR__ . '/../uploads'] as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
    }
}
