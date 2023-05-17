<?php

namespace App\Controller;

use App\Model\Entity\User;
use App\Model\Repository\CommentRepository;
use App\Model\Repository\PostRepository;
use App\Service\Alerts;

class PostController extends Controller
{
    public function post($post_id)
    {
        $postRepository = new PostRepository();
        $post = $postRepository->getPost($post_id);

        $commentRepository = new CommentRepository();
        $comments = $commentRepository->getComments($post_id);

        echo $this->getTwig()->render('post.html', [
                'post' => $post,
                'comments' => $comments,
            ]
        );
    }

    public function admin()
    {
        if (isset($_SESSION['user']) && 'admin' === $_SESSION['user']->getRole()) {
            $posts = (new PostRepository())->getPosts();
            $unapprovedComments = (new CommentRepository())->getUnapprovedComments();

            echo $this->getTwig()->render('admin.html', [
                'posts' => $posts,
                'unapprovedComments' => $unapprovedComments,
            ]);
        } else {
            header('Location: /');
        }
    }

    public function addPost()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /');
            exit;
        }
        /** @var User $user */
        $user = $_SESSION['user'];
        if ('admin' !== $user->getRole()) {
            header('Location: /');
            exit;
        }

        // dd([$_POST['title'], $_POST['excerpt'], $_POST['content']]);
        if (!isset($_POST['title']) || !isset($_POST['content']) || !isset($_POST['excerpt'])) {
            echo $this->getTwig()->render('addPost.html');

            return;
        }

        if (empty($_POST['title']) || empty($_POST['content']) || empty($_POST['excerpt'])) {
            Alerts::addAlert('danger', 'Champs manquant');
            echo $this->getTwig()->render('addPost.html');

            return;
        }

        $success = (new PostRepository())->addPost($_POST['title'], $_POST['content'], $_POST['excerpt'], $_SESSION['user']->getId());
        // dd($success);
        if (!$success) {
            // array_push($_SESSION['alerts'], ['danger', 'Impossible d\'enregistrer le post']);
            Alerts::addAlert('danger', 'Impossible d\'enregistrer le post');
            echo $this->getTwig()->render('addPost.html');

            return;
        }
        // array_push($_SESSION['alerts'], ['success', 'Post enregistré']);
        Alerts::addAlert('success', 'Post enregistré');
        header('Location: /admin');
    }
}
