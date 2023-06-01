<?php

namespace App\Model\Entity;

class Post
{
    protected int $id;
    protected string $title;
    protected string $excerpt;
    protected string $content;
    protected string $updated_at;
    protected string $author;
    protected int $user_id;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getExcerpt(): string
    {
        return $this->excerpt;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setExcerpt(string $excerpt): void
    {
        $this->excerpt = $excerpt;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updated_at = $updatedAt;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function setUserId(int $userId): void
    {
        $this->user_id = $userId;
    }
}
