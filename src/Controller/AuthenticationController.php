<?php

namespace App\Controller;

use App\Model\Repository\UserRepository;

class AuthenticationController extends Controller
{
    public function login()
    {
        $message = '';
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $userRepository = new UserRepository();

            $user = $userRepository->checkPassword($_POST['email'], $_POST['password']);
            if ($user) {
                $_SESSION['logged'] = true;
                $_SESSION['user_role'] = $user->getRole();
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
        $_SESSION['user_role'] = '';
        header('Location: /');
    }

    public function signup()
    {
        if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password'])) {
            $userRepository = new UserRepository();
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $success = $userRepository->createUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], $password);

            if ($success > 0) {
                header('Location: /');
            }
            echo $this->getTwig()->render('signup.html', ['message' => 'Inscription impossible']);
        } else {
            echo $this->getTwig()->render('signup.html', ['message' => '']);
        }
    }
}
