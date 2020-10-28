<?php

declare(strict_types=1);

namespace App\Model\Post;

use DateTimeInterface;
use JsonSerializable;

final class Post implements JsonSerializable
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $title;

    /**
     * @var DateTimeInterface
     */
    private DateTimeInterface $date;

    /**
     * @param int $id
     * @param string $title
     * @param DateTimeInterface $date
     */
    public function __construct(int $id, string $title, DateTimeInterface $date)
    {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'date' => $this->date,
        ];
    }
}
