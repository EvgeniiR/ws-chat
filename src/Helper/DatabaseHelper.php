<?php

namespace App\Helper;

use App\Config;
use PDO;
use PDOException;
use Swoole\Timer;

class DatabaseHelper
{
    private const DSN = 'pgsql:host=' . Config::HOST . ';dbname=' . Config::DATABASE;

    private const DB_PING_INTERVAL = 1000 * 60 * 5;

    /**
     * @var int|null
     */
    private static $timerId;

    /**
     * @var PDO|null
     */
    protected static $pdo;


    public static function pdoInstance(): PDO {
        if (self::$pdo === null) {
            self::$pdo = self::initPdo();
        }
        return self::$pdo;
    }

    /**
     * Init new Connection, and ping DB timer function
     */
    private static function initPdo(): PDO {
        if (self::$timerId === null || (!Timer::exists(self::$timerId))) {
            self::$timerId = Timer::tick(self::DB_PING_INTERVAL, function () {
                self::ping();
            });
        }

        return new PDO(self::DSN, Config::USER, Config::PASSWORD, Config::OPT);
    }

    /**
     * Ping database to maintain the connection
     */
    private static function ping(): void {
        try {
            if (self::$pdo === null) {
                self::$pdo = self::initPdo();
            }
            self::$pdo->exec('SELECT 1');
        } catch (PDOException $e) {
            self::$pdo = self::initPdo();
        }
    }
}