<?php

namespace App\Service;

class Database
{
    private static ?\PDO $database = null;

    public static function getConnection(): \PDO
    {
        if (null === self::$database) {
            self::$database = new \PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
        }

        return self::$database;
    }
}
