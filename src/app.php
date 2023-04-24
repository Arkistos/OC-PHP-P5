<?php

use App\Controller\CommentController;
use App\Controller\HomeController;
use App\Controller\PostController;

try {
    if (isset($_GET['action']) && '' !== $_GET['action']) {
        if ('post' === $_GET['action']) {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];
                $postController = new PostController();
                $postController->post($identifier);
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ('addComment' === $_GET['action']) {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];

                $commentController = new CommentController();
                $commentController->addComment($identifier, $_POST['author'], $_POST['comment']);
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        } else {
            throw new Exception("La page que vous recherchez n'existe pas.");
        }
    } else {
        $controller = new HomeController();
        $controller->home();
    }
} catch (Exception $e) { // S'il y a eu une erreur, alors...
    echo 'Erreur : '.$e->getMessage();
}
