<?php

declare(strict_types=1);

use HttpSoft\Basis\Application;
use HttpSoft\ServerRequest\ServerRequestCreator;

require_once __DIR__ . '/../../../../vendor/autoload.php';

$container = require_once __DIR__ . '/../config/container.php';
$app = $container->get(Application::class);

(require_once __DIR__ . '/../config/pipeline.php')($app);
(require_once __DIR__ . '/../config/routes.php')($app);

$app->run(ServerRequestCreator::create());
