<?php

declare(strict_types=1);

namespace Tests\Infrastructure;

use App\Infrastructure\LoggerFactory;
use Devanych\Di\Container;
use Devanych\Di\Exception\NotFoundException;
use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class LoggerFactoryTest extends TestCase
{
    /**
     * @var LoggerFactory
     */
    private LoggerFactory $factory;

    public function setUp(): void
    {
        $this->factory = new LoggerFactory();
    }

    /**
     * @return array
     */
    public function debugDataProvider(): array
    {
        return [
            'debug-true' => [true],
            'debug-false' => [false],
            'debug-null' => [null],
        ];
    }

    /**
     * @dataProvider debugDataProvider
     * @param bool|null $debug
     * @throws Exception
     */
    public function testCreate(?bool $debug): void
    {
        $container = new Container(['config' => ['debug' => $debug, 'log_file' => 'test.log']]);

        /** @var Logger $logger */
        $logger = $this->factory->create($container);
        $this->assertInstanceOf(LoggerInterface::class, $logger);
        $this->assertInstanceOf(Logger::class, $logger);
        $this->assertTrue($logger->isHandling($debug ? Logger::DEBUG : Logger::WARNING));

        foreach ($logger->getHandlers() as $handler) {
            $this->assertInstanceOf(StreamHandler::class, $handler);
        }
    }

    /**
     * @throws Exception
     */
    public function testCreateThrowNotFoundExceptionIfConfigIsNotSet(): void
    {
        $this->expectException(NotFoundException::class);
        $this->factory->create(new Container());
    }
}
