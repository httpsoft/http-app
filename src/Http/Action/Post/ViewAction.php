<?php

declare(strict_types=1);

namespace App\Http\Action\Post;

use App\Model\Post\PostRepository;
use HttpSoft\Basis\Exception\NotFoundHttpException;
use HttpSoft\Basis\Response\PrepareJsonDataTrait;
use HttpSoft\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ViewAction implements RequestHandlerInterface
{
    use PrepareJsonDataTrait;

    /**
     * @var PostRepository
     */
    private PostRepository $posts;

    /**
     * @param PostRepository $posts
     */
    public function __construct(PostRepository $posts)
    {
        $this->posts = $posts;
    }

    /**
     * {@inheritDoc}
     * @throws NotFoundHttpException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (!$user = $this->posts->findById((int) $request->getAttribute('id'))) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse($this->prepareJsonData($user));
    }
}
