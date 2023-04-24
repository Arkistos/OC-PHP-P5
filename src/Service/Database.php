<?php

namespace App\Service;

class Database
{
    public ?\PDO $database = null;

    public function getConnection(): \PDO
    {
        if (null === $this->database) {
            $this->database = new \PDO('mysql:host=localhost;dbname=avbn;charset=utf8', 'root', '');
        }

        return $this->database;
    }
}
