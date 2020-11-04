<?php

declare(strict_types=1);

use App\Infrastructure\Http\ApplicationFactory;
use App\Infrastructure\Http\ErrorHandlerMiddlewareFactory;
use App\Infrastructure\LoggerFactory;
use HttpSoft\Basis\Application;
use HttpSoft\Basis\Response\CustomResponseFactory;
use HttpSoft\Cookie\CookieManager;
use HttpSoft\Cookie\CookieManagerInterface;
use HttpSoft\Emitter\SapiEmitter;
use HttpSoft\Emitter\EmitterInterface;
use HttpSoft\ErrorHandler\ErrorHandlerMiddleware;
use HttpSoft\Router\RouteCollector;
use HttpSoft\Runner\MiddlewarePipeline;
use HttpSoft\Runner\MiddlewarePipelineInterface;
use HttpSoft\Runner\MiddlewareResolver;
use HttpSoft\Runner\MiddlewareResolverInterface;
use Devanych\Di\Container;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;

return new Container([
    // For more information, see https://httpsoft.org/docs/app/v1/dependency-injection
    'config' => require_once 'config.php',
    Application::class => fn() => new ApplicationFactory(),
    EmitterInterface::class => fn() => new SapiEmitter(),
    RouteCollector::class => fn() => new RouteCollector(),
    MiddlewarePipelineInterface::class => fn() => new MiddlewarePipeline(),
    MiddlewareResolverInterface::class => fn(ContainerInterface $c) => new MiddlewareResolver($c),
    CookieManagerInterface::class => fn() => new CookieManager(),
    ErrorHandlerMiddleware::class => fn() => new ErrorHandlerMiddlewareFactory(),
    ResponseFactoryInterface::class => fn() => new CustomResponseFactory(),
    LoggerInterface::class => fn() => new LoggerFactory(),
]);
