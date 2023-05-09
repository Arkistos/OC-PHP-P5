<?php

namespace App\Model\Repository;

use App\Service\Database;

class UserRepository
{
    public Database $connection;

    public function checkPassword(string $email, string $passwordSubmit): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'SELECT password FROM user WHERE email = ?'
        );
        $statement->execute([$email]);
        $statement = $statement->fetch();

        if (!isset($statement['password'])) {
            return false;
        }

        return password_verify($passwordSubmit, $statement['password']);
    }
}
