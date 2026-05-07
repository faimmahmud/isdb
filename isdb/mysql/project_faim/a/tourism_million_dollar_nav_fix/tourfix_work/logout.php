<?php
require_once __DIR__ . '/includes/functions.php';
app()->auth()->logout();
flash_set('success', 'You have been logged out.');
redirect(app_path('index.php'));
