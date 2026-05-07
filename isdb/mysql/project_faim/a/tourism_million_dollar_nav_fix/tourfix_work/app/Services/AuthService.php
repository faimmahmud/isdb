<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepository;

final class AuthService
{
    public function __construct(private UserRepository $users)
    {
    }

    public function currentUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public function isAdmin(): bool
    {
        return (($this->currentUser()['role'] ?? 'user') === 'admin');
    }

    public function requireAdmin(): void
    {
        if (!$this->isAdmin()) {
            $this->flash('danger', 'Admin access required.');
            header('Location: ' . $this->path('login.php'));
            exit;
        }
    }

    public function login(string $email, string $password): bool
    {
        $user = $this->users->findByEmail($email);
        if (!$user) {
            return false;
        }

        if (!password_verify($password, (string)($user['password'] ?? ''))) {
            return false;
        }

        $_SESSION['user'] = [
            'id' => $user['id'] ?? uniqid('usr_', true),
            'name' => $user['name'] ?? '',
            'email' => $user['email'] ?? '',
            'role' => $user['role'] ?? 'user',
        ];

        return true;
    }

    public function register(string $name, string $email, string $password): bool
    {
        if ($this->users->findByEmail($email)) {
            return false;
        }

        $this->users->saveUser([
            'id' => uniqid('usr_', true),
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'user',
            'created_at' => date('c'),
        ]);

        $_SESSION['user'] = [
            'name' => $name,
            'email' => $email,
            'role' => 'user',
        ];

        return true;
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
    }

    private function flash(string $type, string $message): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    private function path(string $file): string
    {
        $root = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
        if (preg_match('~/(admin|includes)$~', $root)) {
            $root = dirname($root);
        }

        return ($root === '/' ? '' : $root) . '/' . ltrim($file, '/');
    }
}
