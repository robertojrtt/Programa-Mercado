<?php

namespace App\Config;

class Connection
{
    private static $host = "localhost";
    private static $port  = "3306";
    private static $user = "user";
    private static $password = "password";
    private static $database = "database";
    private static $charset = "utf8";
    private static $connection;

    public static function getConnection()
    {
        try {
            if (Connection::$connection == null) {

                Connection::$connection = new \PDO(
                    "mysql:host=" . Connection::$host .
                    ";port=" . Connection::$port .
                    ";dbname=" . Connection::$database .
                    ";charset=" . Connection::$charset,
                    Connection::$user,
                    Connection::$password
                );
                return Connection::$connection;
            }
            return Connection::$connection;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
