<?php
require_once __DIR__ . '/../includes/functions.php';
app()->auth()->requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_validate($_POST['csrf_token'] ?? null)) {
    $id = (string)($_POST['id'] ?? '');
    $packages = read_packages();
    $packages = array_values(array_filter($packages, static fn($pkg) => ($pkg['id'] ?? '') !== $id));
    write_packages($packages);
    flash_set('success', 'Package deleted.');
} else {
    flash_set('danger', 'Invalid request.');
}
redirect(app_path('admin/index.php'));
