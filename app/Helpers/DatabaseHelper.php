<?php

namespace App\Helpers;

use App\DBConfig;
use PDO;
use PDOException;

class DatabaseHelper
{
    const OPT = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => TRUE,
    );

    const DSN = 'mysql:host=' . DBConfig::HOST . ';dbname=' . DBConfig::DATABASE . ';charset=' . DBConfig::CHARSET;

    /**
     * @var PDO
     */
    protected static $pdo = null;

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
        swoole_timer_tick(1000*60*5, function () { self::ping(); });
        return self::$pdo;
    }

    private static function ping()
    {
        try {
            self::$pdo->query('SELECT 1');
        } catch (PDOException $e) {
            self::initPdo();
        }

        return true;
    }

    private static function initPdo()
    {
        self::$pdo = new PDO(self::DSN, DBConfig::USER, DBConfig::PASSWORD, self::OPT);
    }
}