<?php

namespace App\Model\Repository;

use App\Service\Database;

class UserRepository
{
    public Database $connection;

    public function checkPassword(string $email, string $passwordSubmit): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'SELECT password FROM user WHERE email = :email',
            [\PDO::ATTR_CURSOR, \PDO::CURSOR_FWDONLY]
        );
        $statement->execute(['email' => $email]);
        $statement = $statement->fetch();

        if (!isset($statement['password'])) {
            return false;
        }

        return password_verify($passwordSubmit, $statement['password']);
    }

    public function createUser(string $firstname, string $lastname, string $email, string $password)
    {
        $statement = $this->connection->getConnection()->prepare(
            'INSERT INTO user(firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)',
            [\PDO::ATTR_CURSOR, \PDO::CURSOR_FWDONLY]
        );
        $affectedLines = $statement->execute(['firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'password' => $password]);

        return $affectedLines > 0;
    }
}
