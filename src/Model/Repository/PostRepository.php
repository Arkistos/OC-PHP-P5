<?php

namespace App\Model\Repository;

use App\Model\Entity\Post;
use App\Service\Database;
use Symfony\Component\VarDumper\Cloner\Data;

class PostRepository
{
    public function getPost(string $identifier): Post
    {
        $statement = Database::getConnection()->prepare(
            "SELECT id, title, content, DATE_FORMAT(updated_at, '%d/%m/%Y à %Hh%imin%ss') as updated_at FROM post WHERE id = :id",
            [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]
        );

        $statement->execute(['id' => $identifier]);

        $statement->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        $post = $statement->fetch();

        return $post;
    }

    public function getPosts(): array
    {
        $statement = Database::getConnection()->query(
            "SELECT id, title, content, DATE_FORMAT(updated_at, '%d/%m/%Y à %Hh%imin%ss') as updated_at FROM post ORDER BY updated_at DESC LIMIT 0, 5"
        );

        $posts = $statement->fetchAll(\PDO::FETCH_CLASS, Post::class);

        return $posts;
    }
}
