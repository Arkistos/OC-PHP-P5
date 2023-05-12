<?php

namespace App\Model\Repository;

use App\Model\Entity\User;
use App\Service\Database;

class UserRepository
{
    public function checkPassword(string $email, string $passwordSubmit)
    {
        $statement = Database::getConnection()->prepare(
            'SELECT * FROM user WHERE email = :email',
            [\PDO::ATTR_CURSOR, \PDO::CURSOR_FWDONLY]
        );
        $statement->execute(['email' => $email]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, User::class);
        $user = $statement->fetch();

        if ($user && password_verify($passwordSubmit, $user->getPassword())) {
            return $user;
        }

        return false;
    }

    public function createUser(string $firstname, string $lastname, string $email, string $password)
    {
        $statement = Database::getConnection()->prepare(
            'SELECT email FROM user WHERE email = :email',
            [\PDO::ATTR_CURSOR, \PDO::CURSOR_FWDONLY]
        );
        $statement->execute(['email' => $email]);
        if (count($statement->fetchAll()) > 0) {
            return -1;
        } else {
            $statement = Database::getConnection()->prepare(
                'INSERT INTO user(firstname, lastname, role, email, password) 
             VALUES (:firstname, :lastname, "user", :email, :password)',

                [\PDO::ATTR_CURSOR, \PDO::CURSOR_FWDONLY]
            );
            $affectedLines = $statement->execute(['firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'password' => $password]);

            return $affectedLines;
        }
    }
}
