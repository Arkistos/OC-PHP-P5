<?php

namespace App\Controller;

use App\Model\Repository\UserRepository;
use App\Service\Alerts;

class AuthenticationController extends Controller
{
    public function login(): void
    {
        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            echo $this->getTwig()->render('login.html');

            return;
        }
        if (empty($_POST['email']) || empty($_POST['password'])) {
            Alerts::addAlert('danger', 'Champs manquant');
            echo $this->getTwig()->render('login.html');

            return;
        }

        $userRepository = new UserRepository();

        $user = $userRepository->checkPassword($_POST['email'], $_POST['password']);
        if ($user->getId() < 0) {
            Alerts::addAlert('danger', 'Email ou mot de passe incorrect');
            echo $this->getTwig()->render('login.html');

            return;
        }

        $_SESSION['user'] = $user;
        header('Location: /');
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        header('Location: /');

        return;
    }

    public function signup(): void
    {
        if (!isset($_POST['firstname']) || !isset($_POST['lastname']) || !isset($_POST['email']) || !isset($_POST['password'])) {
            echo $this->getTwig()->render('signup.html');

            return;
        }

        if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['password'])) {
            Alerts::addAlert('danger', 'Champs manquant');
            echo $this->getTwig()->render('signup.html');

            return;
        }

        $userRepository = new UserRepository();
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $success = $userRepository->createUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], $password);

        if ($success) {
            Alerts::addAlert('success', 'Inscription validé, vous pouvez vous connecter');
            header('Location: /');

            return;
        }

        Alerts::addAlert('danger', 'Inscription impossible');
        echo $this->getTwig()->render('signup.html');

        return;
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

    public function setRole(int $id, string $role): void
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
