<?php

declare(strict_types=1);

namespace Controller\Api;

use HttpSoft\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class DocApiRedirectController implements RequestHandlerInterface
{
    public function __construct(){
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new RedirectResponse(uri: '/doc/api', code: 301, reasonPhrase: 'Redirect');
    }
}
