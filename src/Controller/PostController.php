<?php

namespace App\Controller;

use App\Model\Repository\CommentRepository;
use App\Model\Repository\PostRepository;
use App\Service\Database;

class PostController extends Controller
{
    public function post($post_id)
    {
        $database = new Database();

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
        if ('admin' === $_SESSION['user_role']) {
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
}
