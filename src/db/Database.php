<?php

namespace db;

use PDO;

class Database
{
    private static $conn = null;

    public static function getConnection()
    {
        if (null == self::$conn) {
            $conf = include('config.php');
            $db = $conf['db'];
            self::$conn = new PDO("mysql:host=$db[host];dbname=$db[name];charset=$db[encoding]", $db['user'], $db['password']);
        }

        return self::$conn;

    }
}