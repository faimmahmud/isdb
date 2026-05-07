<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

function app()
{
    return $GLOBALS['app'];
}

function site_root(): string
{
    $dir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
    if (preg_match('~/(admin|includes)$~', $dir)) {
        $dir = dirname($dir);
    }
    return $dir === '/' ? '' : $dir;
}

function app_path(string $file = ''): string
{
    $root = site_root();
    return $root . '/' . ltrim($file, '/');
}

function asset(string $path): string
{
    return app_path($path);
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function flash_set(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function flash_get(): ?array
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function current_user(): ?array
{
    return app()->auth()->currentUser();
}

function is_admin(): bool
{
    return app()->auth()->isAdmin();
}

function csrf_field(): string
{
    return \App\Services\CsrfService::field();
}

function csrf_validate(?string $token): bool
{
    return \App\Services\CsrfService::validate($token);
}

function read_packages(): array
{
    return app()->packages()->all();
}

function write_packages(array $packages): bool
{
    return app()->packages()->save($packages);
}

function read_users(): array
{
    return app()->users()->all();
}

function write_users(array $users): bool
{
    return app()->users()->save($users);
}

function read_bookings(): array
{
    return app()->bookings()->all();
}

function write_bookings(array $bookings): bool
{
    return app()->bookings()->save($bookings);
}

function handle_image_upload(string $field, string $existing = ''): string
{
    return app()->uploader()->handle($field, $existing);
}

function ensure_storage(): void
{
    foreach ([BASE_PATH . '/data', BASE_PATH . '/uploads'] as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
    }
}

function travel_url(string $file): string
{
    return app_path(ltrim($file, '/'));
}
