<?php

declare(strict_types=1);

namespace App\Model\Post;

use DateTimeImmutable;

use function array_values;

final class PostRepository
{
    /**
     * @var array<int, Post>
     */
    private array $posts;

    /**
     * @param array<int, Post>|null $posts
     */
    public function __construct(array $posts = null)
    {
        $this->posts = $posts ?? [
            1 => new Post(1, 'Post #1', new DateTimeImmutable('+1 day')),
            2 => new Post(2, 'Post #2', new DateTimeImmutable('+2 day')),
            3 => new Post(3, 'Post #3', new DateTimeImmutable('+3 day')),
        ];
    }

    /**
     * @return Post[]
     */
    public function findAll(): array
    {
        return array_values($this->posts);
    }

    /**
     * @param int $id
     * @return Post|null
     */
    public function findById(int $id): ?Post
    {
        return $this->posts[$id] ?? null;
    }
}
