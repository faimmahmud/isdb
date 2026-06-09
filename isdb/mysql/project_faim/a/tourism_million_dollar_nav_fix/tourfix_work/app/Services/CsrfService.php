<?php
declare(strict_types=1);

namespace App\Services;

final class CsrfService
{
    public static function token(): string
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return (string) $_SESSION['csrf_token'];
    }

    public static function field(): string
    {
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(self::token(), ENT_QUOTES, 'UTF-8') . '">';
    }

    public static function validate(?string $token): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        return is_string($token)
            && isset($_SESSION['csrf_token'])
            && hash_equals((string)$_SESSION['csrf_token'], $token);
    }
}
