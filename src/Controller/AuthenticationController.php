<?php

namespace App\Controller;

use App\Model\Repository\UserRepository;
use App\Service\Database;

class AuthenticationController extends Controller
{
    public function login()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../src/View');
        $twig = new \Twig\Environment($loader);
        $message = '';
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $userRepository = new UserRepository();
            $userRepository->connection = new Database();

            $success = $userRepository->checkPassword($_POST['email'], $_POST['password']);
            if ($success) {
                $_SESSION['logged'] = true;
                header('Location: /');
            } else {
                $message = 'Email ou mot de passe incorrect';
            }
        }
        echo $this->getTwig()->render('login.html', ['message'=>$message]);

    }

    public function logout()
    {
        $_SESSION['logged'] = false;
        header('Location: /');
    }
}
