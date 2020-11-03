<?php

declare(strict_types=1);

use App\Http\Action;
use HttpSoft\Basis\Application;
use HttpSoft\Router\RouteCollector;

return static function (Application $app): void {
    // For more information, see https://httpsoft.org/docs/app/v1/routing

    $app->get('home', '/', Action\HomeAction::class);

    $app->group('/posts', static function (RouteCollector $router) {
        $router->get('post.list', '', Action\Post\ListAction::class);
        $router->get('post.view', '/{id}', Action\Post\ViewAction::class)->tokens(['id' => '\d+']);
    });
};
