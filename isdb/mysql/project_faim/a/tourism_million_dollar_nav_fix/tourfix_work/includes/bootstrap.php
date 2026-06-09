<?php
declare(strict_types=1);

session_start();

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/includes/travel-data.php';

spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    $baseDir = BASE_PATH . '/app/';

    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }

    $relative = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relative) . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});

require_once BASE_PATH . '/app/Services/CsrfService.php';
require_once BASE_PATH . '/app/Core/Application.php';

$GLOBALS['app'] = new App\Core\Application(BASE_PATH);
