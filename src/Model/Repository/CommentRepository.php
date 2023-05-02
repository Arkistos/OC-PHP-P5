<?php

namespace App\Model\Repository;

use App\Model\Entity\Comment;
use App\Service\Database;

class CommentRepository
{
    public Database $connection;

    public function getComments(int $post): array
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, user_id, content, DATE_FORMAT(createdAt, '%d/%m/%Y à %Hh%imin%ss') AS createdAt FROM comment WHERE post_id = ? ORDER BY createdAt DESC"
        );
        $statement->execute([$post]);
        $comments = [];
        while ($row = $statement->fetch()) {
            $comment = new Comment();
            $comment->setUserId($row['user_id']);
            $comment->setCreatedAt($row['createdAt']);
            $comment->setContent($row['content']);
            $comment->setId($row['id']);

            $comments[] = $comment;
        }

        return $comments;
    }

    public function getComment(string $identifier): Comment
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, post_id, user_id, content, DATE_FORMAT(createdAt, '%d/%m/%Y à %Hh%imin%ss') AS createdAt FROM comment WHERE id = ?"
        );
        $statement->execute([$identifier]);

        $row = $statement->fetch();
        $comment = new Comment();
        $comment->setUserId($row['user_id']);
        $comment->setPostId($row['post_id']);
        $comment->setCreatedAt($row['createdAt']);
        $comment->setContent($row['content']);
        $comment->setId($row['id']);

        return $comment;
    }

    public function createComment(string $post, string $author, string $comment): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?, ?, ?, NOW())'
        );
        $affectedLines = $statement->execute([$post, $author, $comment]);

        return $affectedLines > 0;
    }

    public function updateComment(string $id, string $author, string $comment): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'UPDATE comments SET author=?, comment=?, comment_date=NOW() WHERE id=?'
        );
        $affectedLines = $statement->execute([$author, $comment, $id]);

        return $affectedLines > 0;
    }
}
