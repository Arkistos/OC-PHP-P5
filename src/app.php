<?php

use App\Controller\AuthenticationController;
use App\Controller\CommentController;
use App\Controller\HomeController;
use App\Controller\PostController;

session_start();
$_SESSION['alerts'] = $_SESSION['alerts'] ?? [];

$uri = $_SERVER['REQUEST_URI'];
try {
    if ('/' === $uri) {
        (new HomeController())->home();
    } elseif (1 === preg_match('/^\/posts\/(?<id>\d+)$/', $uri, $matches)) {
        (new PostController())->post($matches['id']);
    } elseif (1 === preg_match('/^\/addComment\/(?<id>\d+)$/', $uri, $matches)) {
        (new CommentController())->addComment($matches['id'], 1, $_POST['comment']);
    } elseif (1 === preg_match('/^\/login$/', $uri)) {
        (new AuthenticationController())->login();
    } elseif (1 === preg_match('/^\/logout$/', $uri)) {
        (new AuthenticationController())->logout();
    } elseif (1 === preg_match('/^\/signUp$/', $uri)) {
        (new AuthenticationController())->signup();
    } elseif (1 === preg_match('/^\/admin$/', $uri)) {
        (new PostController())->admin();
    } elseif (1 == preg_match('/^\/addpost$/', $uri)) {
        (new PostController())->addPost();
    } else {
        throw new Exception("La page que vous recherchez n'existe pas.");
    }
} catch (Exception $e) { // S'il y a eu une erreur, alors...
    echo 'Erreur : '.$e->getMessage();
}
