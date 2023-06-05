<?php

namespace App\Controller;

use App\Model\Entity\User;
use App\Model\Repository\CommentRepository;
use App\Model\Repository\PostRepository;
use App\Model\Repository\UserRepository;
use App\Service\Alerts;

class PostController extends Controller
{
    public function posts(): void
    {
        $repository = new PostRepository();
        $posts = $repository->getPosts();
        echo $this->getTwig()->render('posts.html', ['posts' => $posts]);
    }

    public function post(int $post_id): void
    {
        $post = (new PostRepository())->getPost($post_id);
        $comments = (new CommentRepository())->getComments($post_id);

        echo $this->getTwig()->render('post.html', [
                'post' => $post,
                'comments' => $comments,
            ]
        );
    }

    public function admin(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /');

            return;
        }
        /** @var User $user */
        $user = $_SESSION['user'];
        if ('admin' !== $user->getRole()) {
            header('Location: /');

            return;
        }

        $posts = (new PostRepository())->getPosts();
        $unapprovedComments = [];
        foreach ($posts as $post) {
            $unapprovedComments += [$post->getId() => (new CommentRepository())->countUnapprovedComments($post->getId())];
        }

        echo $this->getTwig()->render('admin.html', [
            'posts' => $posts,
            'unapprovedComments' => $unapprovedComments,
        ]);
    }

    public function addPost(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /');

            return;
        }
        /** @var User $user */
        $user = $_SESSION['user'];
        if ('admin' !== $user->getRole()) {
            header('Location: /');

            return;
        }

        $admins = (new UserRepository())->getAdmins();
       

        if (!isset($_POST['title']) || !isset($_POST['content']) || !isset($_POST['excerpt']) || !isset($_POST['author'])) {
            echo $this->getTwig()->render('addPost.html', ['admins'=>$admins]);
            return;
        }

        if (empty($_POST['title']) || empty($_POST['content']) || empty($_POST['excerpt']) || empty($_POST['author'])) {
            Alerts::addAlert('danger', 'Champs manquant');
            echo $this->getTwig()->render('addPost.html',['admins'=>$admins]);

            return;
        }

        $success = (new PostRepository())->addPost($_POST['title'], $_POST['content'], $_POST['excerpt'], $_POST['author']);

        if (!$success) {
            Alerts::addAlert('danger', 'Impossible d\'enregistrer le post');
            echo $this->getTwig()->render('addPost.html');

            return;
        }
        Alerts::addAlert('success', 'Post enregistré');
        header('Location: /admin');
    }

    public function updatepost(int $postId): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /');

            return;
        }
        /** @var User $user */
        $user = $_SESSION['user'];
        if ('admin' !== $user->getRole()) {
            header('Location: /');

            return;
        }
        $post = (new PostRepository())->getPost($postId);
        $admins = (new UserRepository())->getAdmins();

        if (!isset($_POST['title']) || !isset($_POST['excerpt']) || !isset($_POST['content']) || !isset($_POST['author'])) {
            echo $this->getTwig()->render('updatePost.html', [
                'post' => $post,
                'admins' => $admins
            ]);

            return;
        }

        if (empty($_POST['title']) || empty($_POST['excerpt']) || empty($_POST['content']) || empty($_POST['author'])) {
            Alerts::addAlert('danger', 'Champs manquant');
            echo $this->getTwig()->render('updatePost.html', [
                'post' => $post,
            ]);

            return;
        }

        $post->setTitle($_POST['title']);
        $post->setContent($_POST['content']);
        $post->setExcerpt($_POST['excerpt']);
        $user = new User();
        $user->setId($_POST['author']);
        $post->setUser($user);
        $success = (new PostRepository())->updatePost($post);
        if (!$success) {
            Alerts::addAlert('danger', 'Impossible d\'effectuer la modification du post');
            echo $this->getTwig()->render('updatePost.html', [
                'post' => $post,
            ]);

            return;
        }

        Alerts::addAlert('success', 'Mofication du post effectué');
        header('Location: /admin');
    }

    public function deletePost(int $id): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /');

            return;
        }
        /** @var User $user */
        $user = $_SESSION['user'];
        if ('admin' !== $user->getRole()) {
            header('Location: /');

            return;
        }

        $success = (new PostRepository())->deletePost($id);

        if ($success) {
            Alerts::addAlert('success', 'Le post est supprimé');
        } else {
            Alerts::addAlert('danger', 'Impossible de supprimer le post');
        }

        header('Location: /admin');

        return;
    }
}
