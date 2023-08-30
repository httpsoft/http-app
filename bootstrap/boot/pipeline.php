<?php declare(strict_types=1);

/**
 * @requires config/middleware.php
 */

use HttpSoft\Basis\Middleware\BodyParamsMiddleware;
use HttpSoft\Basis\Middleware\ContentLengthMiddleware;
use HttpSoft\Cookie\CookieSendMiddleware;
use HttpSoft\ErrorHandler\ErrorHandlerMiddleware;
use HttpSoft\Router\Middleware\RouteDispatchMiddleware;
use HttpSoft\Router\Middleware\RouteMatchMiddleware;

// You can remove unnecessary middleware, but it is not recommended to remove or reorder
// "ErrorHandlerMiddleware", "RouteMatchMiddleware", and "RouteDispatchMiddleware".

// The error handler should be the very first middleware to catch all exceptions.
$app->pipe(ErrorHandlerMiddleware::class);

// Sets the request header Content-Length if it was not set earlier and the request body was defined.
$app->pipe(ContentLengthMiddleware::class);

// Parses request body with "Content-type" header equal to:
// - application/json,
// - application/*+json,
// - application/x-www-form-urlencoded.
$app->pipe(BodyParamsMiddleware::class);

// Matches the incoming request with the added routes. If a match occurs, registers an instance
// of HttpSoft\Router\Route as a request attribute, using the class name as the attribute name.
$app->pipe(RouteMatchMiddleware::class);

// Pipe here any custom middleware that you want to execute on every request or for specific paths.
// For more information, see:
// - https://github.com/httpsoft/http-runner/blob/master/src/MiddlewarePipelineInterface.php
// - https://httpsoft.org/docs/runner/v1/middleware-pipeline
// - https://httpsoft.org/docs/app/v1/psr-7-and-psr-15
require __DIR__.'/../../config/middleware.php';

// If cookies were set in the cookie manager, this middleware will add them to the response.
$app->pipe(CookieSendMiddleware::class);

// Checks for the existence of a matching route (instance of Http Soft\Router\Route) as an attribute
// in the request. If it exists, the handler for this route is used, otherwise the request processing
// is delegated to the handler, which is passed as an argument to the "process()" method.
$app->pipe(RouteDispatchMiddleware::class);