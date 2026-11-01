<?php

declare(strict_types=1);

class Database
{
    private static ?PDO $connection = null;

    public static function connect(): PDO
    {
        if (self::$connection === null) {
            $config = require __DIR__ . '/config.php';
            $database = $config['database'];

            $dsn = 'mysql:host=' . $database['host']
                . ';dbname=' . $database['name']
                . ';charset=' . $database['charset'];

            self::$connection = new PDO(
                $dsn,
                $database['username'],
                $database['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        }

        return self::$connection;
    }
}