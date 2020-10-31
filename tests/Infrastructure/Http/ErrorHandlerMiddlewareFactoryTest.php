<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Http;

use App\Infrastructure\Http\ErrorHandlerMiddlewareFactory;
use App\Infrastructure\LoggerFactory;
use Devanych\Di\Container;
use Devanych\Di\Exception\NotFoundException;
use HttpSoft\ErrorHandler\ErrorHandlerMiddleware;
use PHPUnit\Framework\TestCase;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Log\LoggerInterface;

class ErrorHandlerMiddlewareFactoryTest extends TestCase
{
    /**
     * @var ErrorHandlerMiddlewareFactory
     */
    private ErrorHandlerMiddlewareFactory $factory;

    public function setUp(): void
    {
        $this->factory = new ErrorHandlerMiddlewareFactory();
    }

    /**
     * @return array
     */
    public function debugDataProvider(): array
    {
        return [
            'debug-true' => [true],
            'debug-false' => [false],
        ];
    }

    /**
     * @dataProvider debugDataProvider
     * @param bool $debug
     */
    public function testCreate(bool $debug): void
    {
        $container = new Container([
            'config' => ['debug' => $debug, 'log_file' => 'test.log'],
            LoggerInterface::class => LoggerFactory::class,
        ]);

        $errorHandler = $this->factory->create($container);
        $this->assertInstanceOf(MiddlewareInterface::class, $errorHandler);
        $this->assertInstanceOf(ErrorHandlerMiddleware::class, $errorHandler);
    }

    public function testCreateThrowNotFoundExceptionIfConfigIsNotSet(): void
    {
        $this->expectException(NotFoundException::class);
        $this->factory->create(new Container());
    }

    public function testCreateThrowNotFoundExceptionIfLoggerInterfaceIsNotSet(): void
    {
        $this->expectException(NotFoundException::class);
        $this->factory->create(new Container(['debug' => true, 'log_file' => 'test.log']));
    }
}
