<?php

namespace App\Model\Repository;

use App\Model\Entity\Comment;
use App\Service\Database;

class CommentRepository
{
    public function getComments(int $post): array
    {
        $statement = Database::getConnection()->prepare(
            "SELECT id, user_id, content, DATE_FORMAT(created_at, '%d/%m/%Y à %Hh%imin%ss') AS created_at FROM comment WHERE post_id = :post_id ORDER BY created_at DESC",
            [\PDO::ATTR_CURSOR, \PDO::CURSOR_FWDONLY]
        );
        $statement->execute(['post_id' => $post]);

        $comments = $statement->fetchAll(\PDO::FETCH_CLASS, Comment::class);

        return $comments;
    }

    public function getComment(string $identifier): Comment
    {
        $statement = Database::getConnection()->prepare(
            "SELECT id, post_id, user_id, content, DATE_FORMAT(created_at, '%d/%m/%Y à %Hh%imin%ss') AS created_at FROM comment WHERE id = :id",
            [\PDO::ATTR_CURSOR, \PDO::CURSOR_FWDONLY]
        );
        $statement->execute([':id' => $identifier]);

        $statement->setFetchMode(\PDO::FETCH_CLASS, Comment::class);
        $comment = $statement->fetch();

        $row = $statement->fetch();

        return $comment;
    }

    public function createComment(int $post, int $author, string $comment): bool
    {
        $statement = Database::getConnection()->prepare(
            'INSERT INTO comment(post_id, user_id, content, created_at, approved) VALUES(:post_id, :user_id, :content, NOW(), false)',
            [\PDO::ATTR_CURSOR, \PDO::CURSOR_FWDONLY]
        );
        $affectedLines = $statement->execute(['post_id' => $post, 'user_id' => 1, 'content' => $comment]);

        return $affectedLines > 0;
    }

    public function updateComment(string $id, string $author, string $comment): bool
    {
        $statement = Database::getConnection()->prepare(
            'UPDATE comments SET author=?, comment=?, comment_date=NOW() WHERE id=?'
        );
        $affectedLines = $statement->execute([$author, $comment, $id]);

        return $affectedLines > 0;
    }
}
