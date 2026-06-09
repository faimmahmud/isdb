<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Abstracts\JsonRepository;

class UserRepository extends JsonRepository
{
    public function findByEmail(string $email): ?array
    {
        foreach ($this->all() as $user) {
            if (strcasecmp((string)($user['email'] ?? ''), $email) === 0) {
                return $user;
            }
        }

        return null;
    }

    public function saveUser(array $user): bool
    {
        if (empty($user['id'])) {
            $user['id'] = uniqid('usr_', true);
        }

        return $this->upsert($user);
    }
}
