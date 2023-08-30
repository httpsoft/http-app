<?php

declare(strict_types=1);

namespace Factory;

use Devanych\Di\FactoryInterface;
use Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

final class LoggerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @return LoggerInterface
     * @throws Exception
     * @psalm-suppress MixedArgument
     * @psalm-suppress MixedArrayAccess
     * @psalm-suppress MixedAssignment
     * @psalm-suppress DeprecatedConstant
     */
    public function create(ContainerInterface $container): LoggerInterface
    {
        $logger = new Logger('App');
        $config = $container->get('config');

        $logger->pushHandler(new StreamHandler(
            $config['logFile'],
            $config['debug'] ? Logger::DEBUG : Logger::WARNING
        ));

        return $logger;
    }
}
