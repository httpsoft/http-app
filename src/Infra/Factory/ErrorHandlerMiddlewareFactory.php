<?php

declare(strict_types=1);

namespace Factory;

use Devanych\Di\FactoryInterface;
use HttpSoft\Basis\ErrorHandler\ErrorJsonResponseGenerator;
use HttpSoft\Basis\ErrorHandler\LogErrorListener;
use HttpSoft\ErrorHandler\ErrorHandlerMiddleware;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

final class ErrorHandlerMiddlewareFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @return ErrorHandlerMiddleware
     * @psalm-suppress MixedArgument
     * @psalm-suppress MixedArrayAccess
     */
    public function create(ContainerInterface $container): ErrorHandlerMiddleware
    {
        $errorHandler = new ErrorHandlerMiddleware(new ErrorJsonResponseGenerator($container->get('config')['debug']));
        $errorHandler->addListener(new LogErrorListener($container->get(LoggerInterface::class)));
        return $errorHandler;
    }
}
