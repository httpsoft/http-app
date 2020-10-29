<?php

declare(strict_types=1);

namespace Tests\Model\Post;

use App\Model\Post\Post;
use App\Model\Post\PostRepository;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    /**
     * @return array
     */
    public function postDataProvider(): array
    {
        $posts = [];

        foreach ((new PostRepository())->findAll() as $post) {
            $posts["post-id-{$post->getId()}"] = [
                $post->getId(),
                $post->getTitle(),
                $post->getDate(),
                $post->jsonSerialize(),
            ];
        }

        return $posts;
    }

    /**
     * @dataProvider postDataProvider
     * @param int $id
     * @param string $title
     * @param DateTimeInterface $date
     * @param array $jsonData
     */
    public function testMethods(int $id, string $title, DateTimeInterface $date, array $jsonData)
    {
        $user = new Post($id, $title, $date);

        $this->assertSame($id, $user->getId());
        $this->assertSame($title, $user->getTitle());
        $this->assertSame($date, $user->getDate());
        $this->assertSame($jsonData, $user->jsonSerialize());
    }
}
