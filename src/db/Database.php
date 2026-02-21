<?php

namespace db;

use PDO;

class Database
{
    private static $conn = null;

    public static function getConnection()
    {
        if (null == self::$conn) {
            $host = getenv('DB_HOST') ?: 'localhost';
            $name = getenv('DB_NAME') ?: 'attiladesk';
            $user = getenv('DB_USER') ?: 'root';
            $pass = getenv('DB_PASSWORD') ?: '';
            $enc  = getenv('DB_ENCODING') ?: 'utf8';

            self::$conn = new PDO("mysql:host=$host;dbname=$name;charset=$enc", $user, $pass);
        }

        return self::$conn;
    }
}