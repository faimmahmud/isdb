<?php
require_once __DIR__ . '/includes/functions.php';
session_unset();
session_destroy();
session_start();
flash_set('success', 'You have been logged out.');
redirect('index.php');
