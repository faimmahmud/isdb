<?php
declare(strict_types=1);

session_start();
date_default_timezone_set('Asia/Dhaka');

define('BASE_PATH', __DIR__);
define('DATA_DIR', BASE_PATH . '/data');
define('UPLOAD_DIR', BASE_PATH . '/uploads');
define('USERS_FILE', DATA_DIR . '/users.txt');
define('POSTS_FILE', DATA_DIR . '/posts.txt');
define('APP_NAME', 'Open AI x World AI');
define('APP_PLATFORM', 'Social Atlas');
define('APP_TAGLINE', 'A premium social media concept with editorial-grade interfaces.');

function ensure_storage(): void
{
    if (!is_dir(DATA_DIR)) {
        mkdir(DATA_DIR, 0777, true);
    }
    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0777, true);
    }
    if (!file_exists(USERS_FILE)) {
        file_put_contents(USERS_FILE, '');
    }
    if (!file_exists(POSTS_FILE)) {
        file_put_contents(POSTS_FILE, '');
    }
}

ensure_storage();

function e($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function load_json_lines(string $file): array
{
    if (!file_exists($file)) {
        return [];
    }

    $rows = [];
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        $row = json_decode($line, true);
        if (is_array($row)) {
            $rows[] = $row;
        }
    }

    return $rows;
}

function append_json_line(string $file, array $row): bool
{
    return file_put_contents($file, json_encode($row, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND | LOCK_EX) !== false;
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function require_login(): void
{
    if (!current_user()) {
        header('Location: login.php');
        exit();
    }
}

function flash_set(string $message, string $type = 'success'): void
{
    $_SESSION['flash'] = [
        'message' => $message,
        'type'    => $type,
    ];
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

function human_filesize(int $bytes): string
{
    if ($bytes <= 0) return '0 B';

    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $pow = (int)floor(log($bytes, 1024));
    $pow = min($pow, count($units) - 1);

    return round($bytes / (1024 ** $pow), 1) . ' ' . $units[$pow];
}

function load_users(): array
{
    return load_json_lines(USERS_FILE);
}

function load_posts(): array
{
    return load_json_lines(POSTS_FILE);
}

function newest_posts(array $posts): array
{
    usort($posts, static function (array $a, array $b): int {
        return ((int)($b['created_at'] ?? 0)) <=> ((int)($a['created_at'] ?? 0));
    });

    return $posts;
}

function user_initials(array $user): string
{
    $name = trim((string)($user['name'] ?? ''));
    $username = trim((string)($user['username'] ?? ''));
    $source = $name !== '' ? $name : $username;

    if ($source === '') {
        return 'U';
    }

    $parts = preg_split('/\s+/', $source) ?: [];
    $letters = '';

    foreach (array_slice($parts, 0, 2) as $part) {
        $letters .= mb_strtoupper(mb_substr($part, 0, 1));
    }

    return $letters !== '' ? $letters : 'U';
}

function current_user_record(): ?array
{
    $sessionUser = current_user();
    if (!$sessionUser) {
        return null;
    }

    foreach (load_users() as $user) {
        if (
            (string)($user['id'] ?? '') === (string)($sessionUser['id'] ?? '') ||
            strcasecmp((string)($user['username'] ?? ''), (string)($sessionUser['username'] ?? '')) === 0
        ) {
            return $user;
        }
    }

    return $sessionUser;
}

function filter_posts(array $posts, string $query = '', string $kind = 'all'): array
{
    $query = trim(mb_strtolower($query));
    $filtered = [];

    foreach ($posts as $post) {
        $postKind = (string)($post['kind'] ?? 'text');

        if ($kind !== 'all' && $postKind !== $kind) {
            continue;
        }

        if ($query !== '') {
            $haystack = mb_strtolower(implode(' ', [
                (string)($post['caption'] ?? ''),
                (string)($post['name'] ?? ''),
                (string)($post['username'] ?? ''),
                (string)($post['original_name'] ?? ''),
            ]));

            if (mb_strpos($haystack, $query) === false) {
                continue;
            }
        }

        $filtered[] = $post;
    }

    return $filtered;
}

function summarize_posts(array $posts): array
{
    $summary = [
        'total' => 0,
        'text' => 0,
        'image' => 0,
        'file' => 0,
        'bytes' => 0,
    ];

    foreach ($posts as $post) {
        $kind = (string)($post['kind'] ?? 'text');
        $summary['total']++;
        $summary['bytes'] += (int)($post['size'] ?? 0);

        if (!isset($summary[$kind])) {
            $summary[$kind] = 0;
        }

        $summary[$kind]++;
    }

    return $summary;
}

function posts_for_user(array $posts, array $user): array
{
    $userId = (string)($user['id'] ?? '');
    $username = (string)($user['username'] ?? '');

    return array_values(array_filter($posts, static function (array $post) use ($userId, $username): bool {
        return
            (string)($post['user_id'] ?? '') === $userId ||
            strcasecmp((string)($post['username'] ?? ''), $username) === 0;
    }));
}

function unique_creator_count(array $posts): int
{
    $creators = [];

    foreach ($posts as $post) {
        $username = trim((string)($post['username'] ?? ''));
        $name = trim((string)($post['name'] ?? ''));
        $key = $username !== '' ? mb_strtolower($username) : mb_strtolower($name);

        if ($key !== '') {
            $creators[$key] = true;
        }
    }

    return count($creators);
}

function format_post_time(int $timestamp): string
{
    return date('M d, Y h:i A', $timestamp);
}

function time_ago(int $timestamp): string
{
    $seconds = max(1, time() - $timestamp);

    if ($seconds < 60) {
        return $seconds . 's ago';
    }

    $minutes = (int)floor($seconds / 60);
    if ($minutes < 60) {
        return $minutes . 'm ago';
    }

    $hours = (int)floor($minutes / 60);
    if ($hours < 24) {
        return $hours . 'h ago';
    }

    $days = (int)floor($hours / 24);
    if ($days < 7) {
        return $days . 'd ago';
    }

    return date('M d', $timestamp);
}

function profile_completion(array $user): int
{
    $fields = ['id', 'name', 'email', 'username', 'address', 'phone'];
    $complete = 0;

    foreach ($fields as $field) {
        if (trim((string)($user[$field] ?? '')) !== '') {
            $complete++;
        }
    }

    return (int)round(($complete / count($fields)) * 100);
}
