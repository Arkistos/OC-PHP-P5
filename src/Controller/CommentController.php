<?php

namespace App\Controller;

use App\Model\Repository\CommentRepository;
use App\Service\Alerts;

class CommentController extends Controller
{
    public function addComment(int $post_id): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /posts/'.$post_id);

            return;
        }

        if (empty($_POST['comment'])) {
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

    public function approveComment(int $comment_id): void
    {
        $success = (new CommentRepository())->approveComment($comment_id);

        if ($success) {
            Alerts::addAlert('success', 'Le commentaire à été validé');
        } else {
            Alerts::addAlert('danger', 'Le commentaire n\'a pas pu être validé');
        }
        header('Location: /admin');

        return;
    }

    public function deleteComment(int $comment_id): void
    {
        $success = (new CommentRepository())->deleteComment($comment_id);

        if ($success) {
            Alerts::addAlert('success', 'Le commentaire à été supprimé');
        } else {
            Alerts::addAlert('danger', 'Le commentaire n\'a pas pu être supprimé');
        }
        header('Location: /admin');

        return;
    }
}
