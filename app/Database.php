<?php
namespace App;

class Database
{
    private static $connection = null;

    public static function connection()
    {
        if (self::$connection === null) {
            $connectionParams = [
                'dbname' => 'BookingApp',
                'user' => 'root',
                'password' => 'maikls123',
                'host' => 'localhost',
                'driver' => 'pdo_mysql',
            ];
            self::$connection = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
        }
        return self::$connection;
    }
}
