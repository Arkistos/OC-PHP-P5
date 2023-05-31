<?php

namespace App\Model\Repository;

use App\Model\Entity\Post;
use App\Service\Database;

class PostRepository
{
    public function getPost(string $identifier): Post
    {
        $statement = Database::getConnection()->prepare(
            "SELECT id, title, author, excerpt, content, DATE_FORMAT(updated_at, '%d/%m/%Y') as updated_at FROM post WHERE id = :id",
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
            "SELECT id, title, author, excerpt, content, DATE_FORMAT(updated_at, '%d/%m/%Y') as updated_at FROM post ORDER BY updated_at DESC LIMIT 0, 5"
        );

        $posts = $statement->fetchAll(\PDO::FETCH_CLASS, Post::class);

        return $posts;
    }

    public function addPost(string $title, string $content, string $excerpt, string $author): bool
    {
        $statement = Database::getConnection()->prepare(
            'INSERT INTO post(title, content, updated_at, excerpt, author) VALUES (:title, :content, NOW(), :excerpt, :author)',
            [\PDO::ATTR_CURSOR, \PDO::CURSOR_FWDONLY]
        );
        $affectedLines = $statement->execute(['title' => $title, 'content' => $content, 'excerpt' => $excerpt, 'author' => $author]);

        return 0 < $affectedLines;
    }

    public function updatePost(Post $post): bool
    {
        $statement = Database::getConnection()->prepare(
            'UPDATE post SET title=:title, content=:content, excerpt=:excerpt, updated_at=NOW(), author=:author WHERE id=:id',
            [\PDO::ATTR_CURSOR, \PDO::CURSOR_FWDONLY]
        );
        $affectedLines = $statement->execute([
            'title' => $post->getTitle(),
            'content' => $post->getContent(),
            'excerpt' => $post->getExcerpt(),
            'author' => $post->getAuthor(),
            'id' => $post->getId(),
        ]);

        return $affectedLines > 0;
    }

    public function deletePost(int $postId): bool
    {
        $statement = Database::getConnection()->prepare(
            'DELETE FROM post WHERE id=:id',
            [\PDO::ATTR_CURSOR, \PDO::CURSOR_FWDONLY]
        );

        return $statement->execute(['id' => $postId]);
    }
}
