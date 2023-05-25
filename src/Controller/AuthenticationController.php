<?php

namespace App\Controller;

use App\Model\Repository\UserRepository;

class AuthenticationController extends Controller
{
    public function login(): void
    {
        $message = '';
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $userRepository = new UserRepository();

            $user = $userRepository->checkPassword($_POST['email'], $_POST['password']);
            if ($user) {
                $_SESSION['user'] = $user;
                header('Location: /');
                return;
            } else {
                $message = 'Email ou mot de passe incorrect';
            }
        }
        echo $this->getTwig()->render('login.html', ['message' => $message]);
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        header('Location: /');
        return;
    }

    public function signup(): void
    {
        if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password'])) {
            $userRepository = new UserRepository();
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $success = $userRepository->createUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], $password);

            if ($success > 0) {
                header('Location: /');
                return;
            }
            echo $this->getTwig()->render('signup.html', ['message' => 'Inscription impossible']);
        } else {
            echo $this->getTwig()->render('signup.html', ['message' => '']);
        }
    }

    public function users(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /');
            return;
        }
        /** @var User $user */
        $user = $_SESSION['user'];
        if ('admin' !== $user->getRole()) {
            header('Location: /');
            return;
        }
        $users = (new UserRepository())->getUsers();
        echo $this->getTwig()->render('users.html', ['users' => $users]);
    }

    public function setRole(int $id, string $role):void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /');
            return;
        }
        /** @var User $user */
        $user = $_SESSION['user'];
        if ('admin' !== $user->getRole()) {
            header('Location: /');
            return;
        }
        $role = 'user' === $role ? 'admin' : 'user';
        $success = (new UserRepository())->updateRole($id, $role);

        header('Location: /admin/users');
        return;
    }
}
