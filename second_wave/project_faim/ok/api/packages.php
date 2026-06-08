<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';
header('Content-Type: application/json');

$packages = get_packages([
    'search' => trim((string) ($_GET['search'] ?? '')),
    'category' => trim((string) ($_GET['category'] ?? '')),
]);

echo json_encode([
    'ok' => true,
    'packages' => array_values($packages),
], JSON_UNESCAPED_SLASHES);
