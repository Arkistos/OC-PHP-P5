<?php

namespace App\Model\Entity;

class Comment
{
    public int $id;
    public string $content;
    public string $createdAt;
    public bool $approved;
    public int $user_id;
    public int $post_id;
}
