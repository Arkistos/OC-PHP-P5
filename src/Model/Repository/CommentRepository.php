<?php

namespace App\Model\Repository;

use App\Service\Database;
use App\Model\Entity\Comment;

class CommentRepository
{
    public Database $connection;

    public function getComments(string $post): array
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, author, comment, DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM comments WHERE post_id = ? ORDER BY comment_date DESC"
        );
        $statement->execute([$post]);

        $comments = [];
        while (($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->author = $row['author'];
            $comment->frenchCreationDate = $row['french_creation_date'];
            $comment->comment = $row['comment'];
			$comment->identifier = $row['id'];

            $comments[] = $comment;
        }

        return $comments;
    }

	public function getComment(string $identifier): Comment
	{
    	$statement = $this->connection->getConnection()->prepare(
        	"SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM comments WHERE id = ?"
    	);
    	$statement->execute([$identifier]);

    	$row = $statement->fetch();
    	$comment = new Comment();
    	$comment->author = $row['author'];
		$comment->post_id = $row['post_id'];
    	$comment->frenchCreationDate = $row['french_creation_date'];
    	$comment->comment = $row['comment'];
    	$comment->identifier = $row['id'];

    	return $comment;
	}

    public function createComment(string $post, string $author, string $comment): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?, ?, ?, NOW())'
        );
        $affectedLines = $statement->execute([$post, $author, $comment]);

        return ($affectedLines > 0);
    }

	public function updateComment(string $id, string $author, string $comment): bool
	{
		$statement = $this->connection->getConnection()->prepare(
			'UPDATE comments SET author=?, comment=?, comment_date=NOW() WHERE id=?'
		);
		$affectedLines = $statement->execute(([$author, $comment, $id]));

		return ($affectedLines>0);
	}
}