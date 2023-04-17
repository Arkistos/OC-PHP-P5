<?php

require_once('src/model/post.php');
require_once('src/lib/database.php');

use Application\Model\Post\PostRepository;
use Application\Lib\Database\DatabaseConnection;

function homepage(){
    $postRepository = new PostRepository();
    $postRepository->connection = new DatabaseConnection();
    $posts = $postRepository->getPosts();

    require('templates/homepage.php');
}