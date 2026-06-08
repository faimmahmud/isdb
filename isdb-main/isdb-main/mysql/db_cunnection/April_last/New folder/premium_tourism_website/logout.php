<?php
require_once __DIR__ . '/includes/db.php';
unset($_SESSION['user']);
flash_set('success', 'You have been logged out.');
header('Location: index.php');
exit;
?>
