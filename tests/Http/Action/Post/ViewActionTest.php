<?php

declare(strict_types=1);

namespace Tests\Http\Action\Post;

use App\Http\Action\Post\ViewAction;
use App\Model\Post\PostRepository;
use HttpSoft\Basis\Exception\NotFoundHttpException;
use HttpSoft\Basis\Response\PrepareJsonDataTrait;
use HttpSoft\Message\ServerRequest;
use HttpSoft\Response\JsonResponse;
use PHPUnit\Framework\TestCase;

class ViewActionTest extends TestCase
{
    use PrepareJsonDataTrait;

    /**
     * @return array
     */
    public function validPostDataProvider(): array
    {
        return [
            'post-id-1' => [1],
            'post-id-2' => [2],
            'post-id-3' => [3],
        ];
    }

    /**
     * @dataProvider validPostDataProvider
     * @param int $postId
     */
    public function testHandle(int $postId): void
    {
        $posts = new PostRepository();
        $action = new ViewAction($posts);
        $response = $action->handle((new ServerRequest())->withAttribute('id', $postId));
        $expected = $this->prepareJsonData((string) (new JsonResponse($posts->findById($postId)))->getBody());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame($expected, (string) $response->getBody());
    }

    /**
     * @return array
     */
    public function invalidPostDataProvider(): array
    {
        return [
            'post-id-0' => [0],
            'post-id-4' => [4],
            'post-id-5' => [5],
        ];
    }

    /**
     * @dataProvider invalidPostDataProvider
     * @param int $postId
     */
    public function testHandleThrowsPostNotFoundException(int $postId): void
    {
        $request = (new ServerRequest())->withAttribute('id', $postId);
        $this->expectException(NotFoundHttpException::class);
        (new ViewAction(new PostRepository()))->handle($request);
    }
}
