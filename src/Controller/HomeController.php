<?php

namespace App\Controller;

use App\Model\Entity\User;
use App\Model\Repository\PostRepository;
use App\Service\Database;

class HomeController extends Controller
{
    public function home()
    {
        $repository = new PostRepository();
        $posts = $repository->getPosts();

        echo $this->getTwig()->render('homepage.html', ['posts' => $posts]);
    }
}
