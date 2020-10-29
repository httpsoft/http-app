<?php

declare(strict_types=1);

namespace Tests\Model\Post;

use App\Model\Post\Post;
use App\Model\Post\PostRepository;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class PostRepositoryTest extends TestCase
{
    public function testFindAll(): void
    {
        $post = new Post($id = 1, 'Post #1', new DateTimeImmutable('+1 day'));
        $posts = new PostRepository([$id => $post]);
        $this->assertSame([$post], $posts->findAll());
    }

    public function testFindById(): void
    {
        $post = new Post($id = 1, 'Post #1', new DateTimeImmutable('+1 day'));
        $posts = new PostRepository([$id => $post]);
        $this->assertSame($post, $posts->findById($id));
        $this->assertNull($posts->findById(2));
    }
}
