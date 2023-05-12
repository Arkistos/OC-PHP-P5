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

    public function getId()
    {
        return $this->id;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getApproved()
    {
        return $this->approved;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getPostId()
    {
        return $this->post_id;
    }

    public function getUserFirstname()
    {
        return $this->user_firstname;
    }

    public function getUserLastname()
    {
        return $this->user_lastname;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    public function setApproved($approved)
    {
        $this->approved = $approved;
    }

    public function setUserId($userId)
    {
        $this->user_id = $userId;
    }

    public function setPostId($postId)
    {
        $this->post_id = $postId;
    }

    public function setUserFirstnam($userFirstname)
    {
        $this->user_firstname = $userFirstname;
    }

    public function setUserLastname($userLastname)
    {
        $this->user_lastname = $userLastname;
    }
}
