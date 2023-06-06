<?php

namespace App\Model\Repository;

use App\Model\Entity\Post;
use App\Model\Entity\User;
use App\Service\Database;
use DateTime;

class PostRepository
{
    public function getPost(string $identifier): Post
    {
        $statement = Database::getConnection()->prepare(
            "SELECT post.id as post_id, post.title, post.excerpt, post.content, post.updated_at, user.firstname, user.lastname, user.id as user_id FROM post INNER JOIN user ON post.user_id=user.id WHERE post.id=:id",
            [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]
        );

        $statement->execute(['id' => $identifier]);
        $statement = $statement->fetch();
        $user = new User();
        $post = new Post();
        $user->setId($statement['user_id']);
        $user->setFirstname($statement['firstname']);
        $user->setLastname($statement['lastname']);
        $post->setId($statement['post_id']);
        $post->setTitle($statement['title']);
        $post->setExcerpt($statement['excerpt']);
        $post->setContent($statement['content']);
        $post->setUpdatedAt((new DateTime($statement['updated_at']))->format('d-m-Y'));
        $post->setUser($user);

        return $post;
    }

    public function getPosts(): array
    {
        $statement = Database::getConnection()->prepare(
            "SELECT post.id as post_id, post.title, post.excerpt, post.content, post.updated_at, user.firstname, user.lastname, user.id as user_id FROM post INNER JOIN user ON post.user_id=user.id"
        );
        $statement->execute();
        $posts = [];
        foreach ($statement->fetchAll() as $line) {
            $post = new Post();
            $user = new User();
            $user->setId($line['user_id']);
            $user->setFirstname($line['firstname']);
            $user->setLastname($line['lastname']);
            $post->setId($line['post_id']);
            $post->setTitle($line['title']);
            $post->setExcerpt($line['excerpt']);
            $post->setContent($line['content']);
            $post->setUpdatedAt((new DateTime($line['updated_at']))->format('d-m-Y'));
            $post->setUser($user);
            array_push($posts, $post);
        }

        return $posts;
    }

    public function addPost(string $title, string $content, string $excerpt, string $author): bool
    {
        $statement = Database::getConnection()->prepare(
            'INSERT INTO post(title, content, updated_at, excerpt, user_id) VALUES (:title, :content, NOW(), :excerpt, :user_id)',
            [\PDO::ATTR_CURSOR, \PDO::CURSOR_FWDONLY]
        );
        $affectedLines = $statement->execute(['title' => $title, 'content' => $content, 'excerpt' => $excerpt, 'user_id' => $author]);

        return 0 < $affectedLines;
    }

    public function updatePost(Post $post): bool
    {
        $statement = Database::getConnection()->prepare(
            'UPDATE post SET title=:title, content=:content, excerpt=:excerpt, updated_at=NOW(), user_id=:user_id WHERE id=:id',
            [\PDO::ATTR_CURSOR, \PDO::CURSOR_FWDONLY]
        );
        $affectedLines = $statement->execute([
            'title' => $post->getTitle(),
            'content' => $post->getContent(),
            'excerpt' => $post->getExcerpt(),
            'user_id' => $post->getUser()->getId(),
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
