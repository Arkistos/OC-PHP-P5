<?php

namespace App\Controller;

use App\Model\Repository\PostRepository;
use App\Service\Database;

class HomeController{

    function home(){
        $repository = new PostRepository();
        $repository->connection = new Database();
        $posts = $repository->getPosts();
        require('../src/View/homepage.php');
    }
}