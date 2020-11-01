<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Http;

use App\Infrastructure\Http\WhoopsErrorResponseGenerator;
use HttpSoft\Basis\Exception\ForbiddenHttpException;
use HttpSoft\Basis\Exception\InternalServerErrorHttpException;
use HttpSoft\Message\ServerRequest;
use PHPUnit\Framework\TestCase;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Run;

use function get_class;
use function json_encode;

class WhoopsErrorResponseGeneratorTest extends TestCase
{
    public function testGenerateWithDefaultPrettyPageHandler(): void
    {
        $generator = new WhoopsErrorResponseGenerator();
        $exception = new InternalServerErrorHttpException();
        $response = $generator->generate($exception, new ServerRequest());

        $this->assertSame($exception->getStatusCode(), $response->getStatusCode());
        $this->assertSame($exception->getReasonPhrase(), $response->getReasonPhrase());
        $this->assertSame('text/html', $response->getHeaderLine('content-type'));
    }

    public function testGenerateWithPassedJsonResponseHandler(): void
    {
        $handler = new JsonResponseHandler();
        $handler->addTraceToOutput(false);

        $whops = new Run();
        $whops->pushHandler($handler);
        $whops->writeToOutput(false);
        $whops->allowQuit(false);
        $whops->register();

        $generator = new WhoopsErrorResponseGenerator($whops);
        $exception = new ForbiddenHttpException();
        $response = $generator->generate($exception, new ServerRequest());

        $this->assertSame($exception->getStatusCode(), $response->getStatusCode());
        $this->assertSame($exception->getReasonPhrase(), $response->getReasonPhrase());
        $this->assertSame('application/json', $response->getHeaderLine('content-type'));

        $exceptionData = json_encode([
            'error' => [
                'type' => get_class($exception),
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ],
        ]);

        $this->assertSame($exceptionData, (string) $response->getBody());
    }
}
