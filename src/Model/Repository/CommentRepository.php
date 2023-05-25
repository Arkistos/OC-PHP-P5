<?php

namespace App\Model\Repository;

use App\Model\Entity\Comment;
use App\Model\Entity\User;
use App\Service\Database;

class CommentRepository
{
    public function getComments(int $post): array
    {
        $statement = Database::getConnection()->prepare(
            "SELECT comment.id, comment.user_id, comment.content, DATE_FORMAT(created_at, '%d/%m/%Y à %Hh%imin%ss') AS created_at, user.firstname, user.lastname FROM comment INNER JOIN user  ON comment.user_id=user.id WHERE post_id = :post_id AND approved = 1 ORDER BY created_at DESC",
            [\PDO::ATTR_CURSOR, \PDO::CURSOR_FWDONLY]
        );
        $statement->execute(['post_id' => $post]);

        $comments = [];
        foreach ($statement->fetchAll() as $line) {
            $comment = new Comment();
            $user = new User();
            $user->setFirstname($line['firstname']);
            $user->setLastname($line['lastname']);
            $comment->setId($line['id']);
            $comment->setContent($line['content']);
            $comment->setCreatedAt($line['created_at']);
            $comment->setUser($user);
            array_push($comments, $comment);
        }

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

    public function getUnapprovedComments(): array
    {
        $statement = Database::getConnection()->prepare(
            "SELECT comment.id, comment.user_id, comment.content, DATE_FORMAT(created_at, '%d/%m/%Y à %Hh%imin%ss') AS created_at, user.firstname, user.lastname FROM comment INNER JOIN user  ON comment.user_id=user.id WHERE approved = 0 ORDER BY created_at DESC",
            [\PDO::ATTR_CURSOR, \PDO::CURSOR_FWDONLY]
        );
        $statement->execute();
        $comments = [];
        foreach ($statement->fetchAll() as $line) {
            $comment = new Comment();
            $user = new User();
            $user->setFirstname($line['firstname']);
            $user->setLastname($line['lastname']);
            $comment->setId($line['id']);
            $comment->setContent($line['content']);
            $comment->setCreatedAt($line['created_at']);
            $comment->setUser($user);
            array_push($comments, $comment);
        }

        return $comments;
    }

    public function createComment(int $post_id, int $user_id, string $comment): bool
    {
        $statement = Database::getConnection()->prepare(
            'INSERT INTO comment(post_id, user_id, content, created_at, approved) VALUES(:post_id, :user_id, :content, NOW(), false)',
            [\PDO::ATTR_CURSOR, \PDO::CURSOR_FWDONLY]
        );
        $affectedLines = $statement->execute(['post_id' => $post_id, 'user_id' => $user_id, 'content' => $comment]);

        return $affectedLines > 0;
    }

    public function approveComment(int $commentId): bool
    {
        $statement = Database::getConnection()->prepare(
            'UPDATE comment SET approved = 1 WHERE id=:comment_id',
            [\PDO::ATTR_CURSOR, \PDO::CURSOR_FWDONLY]
        );
        $affectedLines = $statement->execute([':comment_id' => $commentId]);

        return $affectedLines > 0;
    }

    public function deleteComment(int $commentId):bool
    {
        $statement = Database::getConnection()->prepare(
            'DELETE FROM comment WHERE id = :comment_id ',
            [\PDO::ATTR_CURSOR, \PDO::CURSOR_FWDONLY]
        );
        $affectedLines = $statement->execute(['comment_id' => $commentId]);

        return $affectedLines > 0;
    }
}
