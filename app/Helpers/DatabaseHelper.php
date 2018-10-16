<?php

namespace App\Helpers;

use App\DBConfig;
use PDO;
use PDOException;
use Swoole\Timer;

class DatabaseHelper
{
    const OPT = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => TRUE,
    );

    const DSN = 'mysql:host=' . DBConfig::HOST . ';dbname=' . DBConfig::DATABASE . ';charset=' . DBConfig::CHARSET;

    private static $timerId = null;

    /**
     * @var PDO
     */
    protected static $pdo = null;

    const MySQL_PING_INTERVAL = 1000 * 60 * 5;

    public function __construct(){}

    public function __clone(){}

    /**
     * @return PDO
     */
    public static function pdoInstance()
    {
        if (self::$pdo === null) {
            self::initPdo();
        }
        return self::$pdo;
    }

    /**
     * Init new Connection, and ping DB timer function
     */
    private static function initPdo()
    {
        if (self::$timerId === null || (!Timer::exists(self::$timerId))) {
            self::$timerId = Timer::tick(self::MySQL_PING_INTERVAL, function () {
                self::ping();
            });
        }

        self::$pdo = new PDO(self::DSN, DBConfig::USER, DBConfig::PASSWORD, self::OPT);
    }

    /**
     * Ping database to maintain the connection
     */
    private static function ping()
    {
        try {
            self::$pdo->query('SELECT 1');
        } catch (PDOException $e) {
            self::initPdo();
        }
    }
}