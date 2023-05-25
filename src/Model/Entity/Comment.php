<?php

namespace App\Model\Entity;

class Comment
{
    protected int $id;
    protected string $content;
    protected string $created_at;
    protected bool $approved;
    protected int $user_id;
    protected int $post_id;
    protected string $user_firstname;
    protected string $user_lastname;
    protected User $user;

    public function getId():int
    {
        return $this->id;
    }

    public function getContent():string
    {
        return $this->content;
    }

    public function getCreatedAt():string
    {
        return $this->created_at;
    }

    public function getApproved():bool
    {
        return $this->approved;
    }

    public function getUserId():int
    {
        return $this->user_id;
    }

    public function getPostId():int
    {
        return $this->post_id;
    }

    public function getUser():User
    {
        return $this->user;
    }

    public function setId(int $id):void
    {
        $this->id = $id;
    }

    public function setContent(string $content):void
    {
        $this->content = $content;
    }

    public function setCreatedAt(string $createdAt):void
    {
        $this->created_at = $createdAt;
    }

    public function setApproved(bool $approved):void
    {
        $this->approved = $approved;
    }

    public function setUserId(int $userId):void
    {
        $this->user_id = $userId;
    }

    public function setPostId(int $postId):void
    {
        $this->post_id = $postId;
    }

    public function setUser(User $user):void
    {
        $this->user = $user;
    }
}
