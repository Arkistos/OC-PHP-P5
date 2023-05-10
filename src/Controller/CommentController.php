<?php

namespace App\Controller;

use App\Model\Repository\CommentRepository;
use App\Service\Database;

class CommentController extends Controller
{
    public function addComment(int $post_id, int $user_id, $comment)
    {
        $commentRepository = new CommentRepository();

        $success = $commentRepository->createComment($post_id, $user_id, $comment);
        if ($success) {
            header('Location: /posts/'.$post_id);
            
        } else {
            throw new \Exception('Pas de passage de commentaire');
        }
    }
}
