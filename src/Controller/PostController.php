<?php

namespace App\Controller;

use App\Model\Repository\CommentRepository;
use App\Model\Repository\PostRepository;
use App\Service\Database;

class PostController extends Controller
{
    public function post($post_id)
    {
        $postRepository = new PostRepository();
        $postRepository->connection = new Database();
        $post = $postRepository->getPost($post_id);

        $commentRepository = new CommentRepository();
        $commentRepository->connection = new Database();
        $comments = $commentRepository->getComments($post_id);

        echo $this->getTwig()->render('post.html', [
                'post' => $post,
                'comments' => $comments,
            ]
        );
    }
}
