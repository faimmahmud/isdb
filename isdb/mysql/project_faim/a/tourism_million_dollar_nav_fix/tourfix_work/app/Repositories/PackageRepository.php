<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Abstracts\JsonRepository;

class PackageRepository extends JsonRepository
{
    public function all(): array
    {
        $records = parent::all();
        return array_values(array_filter($records, static fn ($row) => is_array($row)));
    }

    public function findByCategory(string $category): array
    {
        return array_values(array_filter($this->all(), static function (array $record) use ($category): bool {
            return strtolower((string)($record['category'] ?? '')) === strtolower($category);
        }));
    }

    public function savePackage(array $package): bool
    {
        if (empty($package['id'])) {
            $package['id'] = uniqid('pkg_', true);
        }

        return $this->upsert($package);
    }
}
