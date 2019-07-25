<?php

namespace App\Helper;

use App\DBConfig;
use PDO;
use PDOException;
use Swoole\Timer;

class DatabaseHelper
{
    private const DSN = 'pgsql:host=' . DBConfig::HOST . ';dbname=' . DBConfig::DATABASE;

    private const DB_PING_INTERVAL = 1000 * 60 * 5;

    /**
     * @var int|null
     */
    private static $timerId = null;

    /**
     * @var PDO
     */
    protected static $pdo = null;

    /**
     * @return PDO
     */
    public static function pdoInstance() {
        if (self::$pdo === null) {
            self::initPdo();
        }
        return self::$pdo;
    }

    /**
     * Init new Connection, and ping DB timer function
     */
    private static function initPdo() {
        if (self::$timerId === null || (!Timer::exists(self::$timerId))) {
            self::$timerId = Timer::tick(self::DB_PING_INTERVAL, function () {
                self::ping();
            });
        }

        self::$pdo = new PDO(self::DSN, DBConfig::USER, DBConfig::PASSWORD, DBConfig::OPT);
    }

    /**
     * Ping database to maintain the connection
     */
    private static function ping() {
        try {
            self::$pdo->exec('SELECT 1');
        } catch (PDOException $e) {
            self::initPdo();
        }
    }
}