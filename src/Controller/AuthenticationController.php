<?php

namespace App\Controller;

use App\Model\Repository\UserRepository;
use App\Service\Database;

class AuthenticationController
{
    public function login(string $email, string $password)
    {
        $userRepository = new UserRepository();
        $userRepository->connection = new Database();

        $success = $userRepository->checkPassword($email, $password);
        if ($success) {
            $_SESSION['logged'] = true;
            header('Location: index.php');
        } else {
            $message = 'Email ou mot de passe incorrect';
            require '../src/View/login.php';
        }
    }

    public function logout()
    {
        $_SESSION['logged'] = false;
        header('Location: index.php');
    }
}
