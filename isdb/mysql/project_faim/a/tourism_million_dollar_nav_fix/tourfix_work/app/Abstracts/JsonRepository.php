<?php
declare(strict_types=1);

namespace App\Abstracts;

use App\Contracts\JsonRepositoryInterface;
use RuntimeException;

abstract class JsonRepository implements JsonRepositoryInterface
{
    protected string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->ensureDirectory();
    }

    public function all(): array
    {
        if (!is_file($this->path)) {
            return [];
        }

        $raw = file_get_contents($this->path);
        if ($raw === false || trim($raw) === '') {
            return [];
        }

        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    public function find(string $id): ?array
    {
        foreach ($this->all() as $record) {
            if (($record['id'] ?? '') === $id) {
                return $record;
            }
        }

        return null;
    }

    public function save(array $records): bool
    {
        return $this->persist(array_values($records));
    }

    public function delete(string $id): bool
    {
        $records = array_values(array_filter(
            $this->all(),
            static fn (array $record): bool => ($record['id'] ?? '') !== $id
        ));

        return $this->persist($records);
    }

    protected function upsert(array $record): bool
    {
        $records = $this->all();
        $found = false;

        foreach ($records as $index => $existing) {
            if (($existing['id'] ?? '') === ($record['id'] ?? '')) {
                $records[$index] = $record;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $records[] = $record;
        }

        return $this->persist($records);
    }

    protected function persist(array $records): bool
    {
        $json = json_encode($records, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        if ($json === false) {
            throw new RuntimeException('Failed to encode JSON data.');
        }

        $handle = fopen($this->path, 'c+');
        if (!$handle) {
            throw new RuntimeException('Unable to open data file for writing.');
        }

        try {
            if (!flock($handle, LOCK_EX)) {
                throw new RuntimeException('Unable to lock data file.');
            }

            ftruncate($handle, 0);
            rewind($handle);
            fwrite($handle, $json);
            fflush($handle);
            flock($handle, LOCK_UN);
        } finally {
            fclose($handle);
        }

        return true;
    }

    protected function ensureDirectory(): void
    {
        $dir = dirname($this->path);
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
    }
}
