<?php

namespace App\Model\Repository;

use App\Model\Entity\Post;
use App\Service\Database;

class PostRepository
{
    public Database $connection;

    public function getPost(string $identifier): Post
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, title, content, DATE_FORMAT(updatedAt, '%d/%m/%Y à %Hh%imin%ss') as updatedAt FROM post WHERE id = ?"
        );
        $statement->execute([$identifier]);

        $row = $statement->fetch();
        $post = new Post();
        $post->setTitle($row['title']);
        $post->setUpdatedAt($row['updatedAt']);
        $post->setContent($row['content']);
        $post->setId($row['id']);

        return $post;
    }

    public function getPosts(): array
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT id, title, content, DATE_FORMAT(updatedAt, '%d/%m/%Y à %Hh%imin%ss') as updatedAt FROM post ORDER BY updatedAt DESC LIMIT 0, 5"
        );
        $posts = [];
        while ($row = $statement->fetch()) {
            $post = new Post();
            $post->setTitle($row['title']);
            $post->setUpdatedAt($row['updatedAt']);
            $post->setContent($row['content']);
            $post->setId($row['id']);

            $posts[] = $post;
        }

        return $posts;
    }
}
