<?php

namespace App\Controller;

use App\Model\Repository\UserRepository;
use App\Service\Database;

class AuthenticationController extends Controller
{
    public function login()
    {
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
        echo $this->getTwig()->render('login.html', ['message' => $message]);
    }

    public function logout()
    {
        $_SESSION['logged'] = false;
        header('Location: /');
    }

    public function signup()
    {
        if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password'])) {
            $userRepository = new UserRepository();
            $userRepository->connection = new Database();
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $success = $userRepository->createUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], $password);

            if ($success) {
                header('Location: /');
            }
            echo $this->getTwig()->render('signup.html', ['message' => 'Inscription impossible']);
        } else {
            echo $this->getTwig()->render('signup.html', ['message' => '']);
        }
    }
}
