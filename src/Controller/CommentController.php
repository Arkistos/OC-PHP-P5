<?php

namespace App\Controller;

use App\Model\Repository\CommentRepository;
use App\Service\Alerts;
use App\Service\Database;
use Application\Model\Comment\CommentRepository as CommentCommentRepository;

class CommentController extends Controller
{
    public function addComment(int $post_id)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /posts/'.$post_id);
            exit;
        }

        if(empty($_POST['comment'])){
            Alerts::addAlert('danger', 'Champs manquant');
            header('Location: /posts/'.$post_id);
            return;
        }

        $success = (new CommentRepository())->createComment($post_id, $_SESSION['user']->getId(), $_POST['comment']);
        if (!$success) {
            Alerts::addAlert('danger', 'Impossbile d\'enregistrer le commentaire');
        } else {
            Alerts::addAlert('success', 'Le commentaire à bien été enregistré, une fois validé il sera visible');
        }
        header('Location: /posts/'.$post_id);
    }

    public function approveComment($comment_id){
        $success = (new CommentRepository())->approveComment($comment_id);

        if($success){
            Alerts::addAlert('success', 'Le commentaire à été validé');
        } else {
            Alerts::addAlert('danger', 'Le commentaire n\'a pas pu être validé');
        }
        header('Location: /admin');
        return;
    }

    public function deleteComment($comment_id){
        $success = (new CommentRepository())->deleteComment($comment_id);

        if($success){
            Alerts::addAlert('success', 'Le commentaire à été supprimé');
        } else {
            Alerts::addAlert('danger', 'Le commentaire n\'a pas pu être supprimé');
        }
        header('Location: /admin');
        return;
    }
    
}
