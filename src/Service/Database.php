<?php

namespace App\Service;

class Database
{
    private static ?\PDO $database = null;

    public static function getConnection(): \PDO
    {
        if (null === self::$database) {
            self::$database = new \PDO('mysql:host=localhost;dbname=avbn;charset=utf8', 'root', '');
        }

        return self::$database;
    }




}
