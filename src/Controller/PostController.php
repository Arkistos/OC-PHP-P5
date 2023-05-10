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
}
