<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Http;

use App\Infrastructure\Http\ApplicationFactory;
use Devanych\Di\Container;
use Devanych\Di\Exception\NotFoundException;
use HttpSoft\Basis\Application;
use HttpSoft\Emitter\EmitterInterface;
use HttpSoft\Emitter\SapiEmitter;
use HttpSoft\Router\RouteCollector;
use HttpSoft\Runner\MiddlewarePipeline;
use HttpSoft\Runner\MiddlewarePipelineInterface;
use HttpSoft\Runner\MiddlewareResolver;
use HttpSoft\Runner\MiddlewareResolverInterface;
use PHPUnit\Framework\TestCase;

class ApplicationFactoryTest extends TestCase
{
    /**
     * @var ApplicationFactory
     */
    private ApplicationFactory $factory;

    public function setUp(): void
    {
        $this->factory = new ApplicationFactory();
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
            'config' => ['debug' => $debug],
            EmitterInterface::class => SapiEmitter::class,
            MiddlewarePipelineInterface::class => MiddlewarePipeline::class,
            MiddlewareResolverInterface::class => MiddlewareResolver::class,
        ]);

        $app = $this->factory->create($container);
        $this->assertInstanceOf(Application::class, $app);
    }

    public function testCreateThrowNotFoundExceptionIfConfigIsNotSet(): void
    {
        $this->expectException(NotFoundException::class);
        $this->factory->create(new Container([
            RouteCollector::class => RouteCollector::class,
            EmitterInterface::class => SapiEmitter::class,
            MiddlewarePipelineInterface::class => MiddlewarePipeline::class,
            MiddlewareResolverInterface::class => MiddlewareResolver::class,
        ]));
    }

    /**
     * @return array
     */
    public function invalidDependenciesDataProvider(): array
    {
        return [
            'EmitterInterface-is-not-set' => [[
                MiddlewarePipelineInterface::class => MiddlewarePipeline::class,
                MiddlewareResolverInterface::class => MiddlewareResolver::class,
            ]],
            'MiddlewarePipelineInterface-is-not-set' => [[
                EmitterInterface::class => SapiEmitter::class,
                MiddlewareResolverInterface::class => MiddlewareResolver::class,
            ]],
            'MiddlewareResolverInterface-is-not-set' => [[
                EmitterInterface::class => SapiEmitter::class,
                MiddlewarePipelineInterface::class => MiddlewarePipeline::class,
            ]],
        ];
    }

    /**
     * @dataProvider invalidDependenciesDataProvider
     * @param array $dependencies
     */
    public function testCreateThrowNotFoundExceptionIfOneOfDependenciesIsNotSet(array $dependencies): void
    {
        $this->expectException(NotFoundException::class);
        $this->factory->create(new Container(['debug' => true, 'log_file' => 'test.log'] + $dependencies));
    }
}
