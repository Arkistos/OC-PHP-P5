<?php

namespace App\Model\Entity;

class Post
{
    protected int $id;
    protected string $title;
    protected string $excerpt;
    protected string $content;
    protected string $updatedAt;
    protected int $userId;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getExcerpt()
    {
        return $this->excerpt;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
}
