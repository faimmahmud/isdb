<?php
declare(strict_types=1);

require_once __DIR__ . '/functions.php';
header('Content-Type: application/json');

if (!csrf_validate($_POST['csrf_token'] ?? null)) {
    echo json_encode(['success' => false, 'message' => 'Security token expired. Please refresh and try again.']);
    exit;
}

$result = app()->bookingService()->create($_POST);
echo json_encode($result, JSON_UNESCAPED_SLASHES);
