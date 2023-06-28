<?php

namespace Simplemvc\Core;

use Exception;
use PDO;
use PDOException;

class DBConnection
{
    protected static ?PDO $conn = null;

    /**
     * @throws Exception
     */
    public static function getConnection(): PDO
    {
        if (is_null(self::$conn)) {
            try {
                $options = [
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ];
                $driver = 'mysql';
                $dsn = sprintf('%s:dbname=%s;host=%s;port=%d;charset=utf8', $driver, $_ENV['MYSQL_DATABASE'], $_ENV['MYSQL_HOST'], $_ENV['MYSQL_PORT']);
                self::$conn = new PDO($dsn, $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD'], $options);
            } catch (PDOException|Exception $e) {
                // TODO: log - show 500 page
                throw new Exception('DB ERROR: ' . $e->getMessage() . PHP_EOL, 500);
            }
        }
        return self::$conn;
    }
}