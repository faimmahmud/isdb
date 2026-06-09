<?php
declare(strict_types=1);

namespace App\Services;

final class ImageUploadService
{
    private string $uploadDir;

    public function __construct(string $uploadDir)
    {
        $this->uploadDir = rtrim($uploadDir, '/\\');
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0775, true);
        }
    }

    public function handle(string $field, string $existing = ''): string
    {
        if (!isset($_FILES[$field]) || ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return $existing;
        }

        $tmp = (string)($_FILES[$field]['tmp_name'] ?? '');
        $original = (string)($_FILES[$field]['name'] ?? '');
        $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

        if (!in_array($ext, $allowed, true)) {
            return $existing;
        }

        $mime = @mime_content_type($tmp);
        if ($mime && !str_starts_with($mime, 'image/')) {
            return $existing;
        }

        $newName = uniqid('img_', true) . '.' . $ext;
        $target = $this->uploadDir . DIRECTORY_SEPARATOR . $newName;

        if (move_uploaded_file($tmp, $target)) {
            return 'uploads/' . $newName;
        }

        return $existing;
    }
}
