<?php

require_once('src/lib/database.php');
require_once('src/model/comment.php');

use Application\Model\Comment\CommentRepository;
use Application\Lib\Database\DatabaseConnection;

function updateComment(string $comment_id, array $input)
{
    $author = null;
    $comment = null;

    $commentRepository = new CommentRepository();
    $commentRepository->connection = new DatabaseConnection();
    $comment = $commentRepository->getComment($comment_id);


    if (!empty($input['author']) && !empty($input['comment'])) {
        $success = $commentRepository->updateComment($comment_id, $input['author'], $input['comment']);
        if (!$success) {
            throw new Exception('Impossible d\'ajouter le commentaire !');
        } else {
            header('Location: index.php?action=post&id=' . $comment->post_id);
        }
    } else {
        require('templates/update_comment.php');
    }

}