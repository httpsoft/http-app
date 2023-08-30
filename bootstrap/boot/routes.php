<?php declare(strict_types=1);

use HttpSoft\Router\RouteCollector;

if(file_exists(__DIR__ . '/../../routes/api.php')) {
    $app->group('/api', fn (RouteCollector $route) => require __DIR__ . '/../../routes/api.php');
}

if(file_exists(__DIR__ . '/../../routes/web.php')) {
    $app->group('', fn (RouteCollector $route) => require __DIR__ . '/../../routes/web.php');
}
