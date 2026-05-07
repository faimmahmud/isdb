<?php
require_once __DIR__ . '/../includes/db.php';
require_admin();

$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = db()->prepare("DELETE FROM packages WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    flash_set('success', 'Package deleted successfully.');
}
header('Location: dashboard.php');
exit;
?>
