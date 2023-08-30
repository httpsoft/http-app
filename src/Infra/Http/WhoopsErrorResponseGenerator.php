<?php

declare(strict_types=1);

namespace Http;

use HttpSoft\Basis\Response\ExtractErrorDataTrait;
use HttpSoft\ErrorHandler\ErrorResponseGeneratorInterface;
use HttpSoft\Message\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;
use Throwable;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\RunInterface;
use Whoops\Run;

use function class_exists;

final class WhoopsErrorResponseGenerator implements ErrorResponseGeneratorInterface
{
    use ExtractErrorDataTrait;

    /**
     * @var RunInterface
     */
    private RunInterface $whoops;

    /**
     * @param RunInterface|null $whoops
     */
    public function __construct(RunInterface $whoops = null)
    {
        if ($whoops instanceof RunInterface) {
            $this->whoops = $whoops;
            return;
        }

        if (!class_exists(Run::class)) {
            throw new RuntimeException('Class "Whoops\Run" not found.');
        }

        $this->whoops = new Run();
        $this->whoops->writeToOutput(false);
        $this->whoops->allowQuit(false);
        $this->whoops->pushHandler(new PrettyPageHandler());
        $this->whoops->register();
    }

    /**
     * {@inheritDoc}
     *
     * @psalm-suppress MixedAssignment
     */
    public function generate(Throwable $error, ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response($this->extractErrorStatusCode($error));

        foreach ($this->whoops->getHandlers() as $handler) {
            if ($handler instanceof PrettyPageHandler) {
                $handler->addDataTable('HTTP Application Request', $this->extractRequestData($request));
            }

            if ($handler instanceof PrettyPageHandler || $handler instanceof JsonResponseHandler) {
                $response = $response->withHeader('content-type', $handler->contentType());
            }
        }

        $sendOutputFlag = $this->whoops->writeToOutput();
        $this->whoops->writeToOutput(false);
        $response->getBody()->write($this->whoops->handleException($error));
        $this->whoops->writeToOutput($sendOutputFlag);
        return $response;
    }
}
