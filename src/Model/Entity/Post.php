<?php

namespace App\Model\Entity;

class Post
{
    protected int $id;
    protected string $title;
    protected string $excerpt;
    protected string $content;
    protected string $updated_at;
    protected User $user;

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

    public function getUser(): User
    {
        return $this->user;
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

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
