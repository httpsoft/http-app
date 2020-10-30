<?php

declare(strict_types=1);

namespace Tests\Http\Action\Post;

use App\Http\Action\Post\ListAction;
use App\Model\Post\Post;
use App\Model\Post\PostRepository;
use DateTimeImmutable;
use HttpSoft\Basis\Response\PrepareJsonDataTrait;
use HttpSoft\Message\ServerRequest;
use HttpSoft\Response\JsonResponse;
use PHPUnit\Framework\TestCase;

class ListActionTest extends TestCase
{
    use PrepareJsonDataTrait;

    /**
     * @return array
     */
    public function postDataProvider(): array
    {
        return [
            'null' => [[null]],
            'posts' => [[
                4 => new Post(4, 'Post #4', new DateTimeImmutable('+4 day')),
                5 => new Post(5, 'Post #5', new DateTimeImmutable('+5 day')),
                6 => new Post(6, 'Post #6', new DateTimeImmutable('+6 day')),
            ]],
        ];
    }

    /**
     * @dataProvider postDataProvider
     * @param array|null $posts
     */
    public function testHandle(?array $posts): void
    {
        $posts = new PostRepository($posts);
        $action = new ListAction($posts);
        $response = $action->handle(new ServerRequest());
        $expected = $this->prepareJsonData((string) (new JsonResponse($posts->findAll()))->getBody());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame($expected, (string) $response->getBody());
    }
}
