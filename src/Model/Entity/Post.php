<?php

namespace App\Model\Entity;

class Post
{
    public int $id;
    public string $title;
    public string $excerpt;
    public string $content;
    public string $updatedAt;
    public int $user_id;
}
