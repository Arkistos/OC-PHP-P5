<?php

namespace App\Controller;

use App\Model\Repository\CommentRepository;
use App\Service\Database;

class CommentController
{
    public function addComment(string $post_id, string $author, $comment)
    {
        $commentRepository = new CommentRepository();
        $commentRepository->connection = new Database();

        $success = $commentRepository->createComment($post_id, $author, $comment);
        if ($success) {
            header('Location: index.php?action=post&id='.$post_id);
        } else {
            throw new \Exception('Pas de passage de commentaire');
        }
    }
}
