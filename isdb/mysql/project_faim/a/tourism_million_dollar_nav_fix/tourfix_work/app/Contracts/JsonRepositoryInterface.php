<?php
declare(strict_types=1);

namespace App\Contracts;

interface JsonRepositoryInterface
{
    public function all(): array;
    public function find(string $id): ?array;
    public function save(array $records): bool;
    public function delete(string $id): bool;
}
