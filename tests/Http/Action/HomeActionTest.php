<?php

declare(strict_types=1);

namespace Tests\Http\Action;

use App\Http\Action\HomeAction;
use HttpSoft\Message\ServerRequest;
use HttpSoft\Response\JsonResponse;
use Monolog\Test\TestCase;

class HomeActionTest extends TestCase
{
    public function testHandle(): void
    {
        $action = new HomeAction();
        $response = $action->handle(new ServerRequest());

        $expected = (string) (new JsonResponse([
            'name' => 'HTTP Software Application Template',
            'docs' => 'https://httpsoft.org/docs/app',
        ]))->getBody();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame($expected, (string) $response->getBody());
    }
}
