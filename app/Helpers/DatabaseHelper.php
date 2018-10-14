<?php

namespace App\Helpers;

use App\DBConfig;
use PDO;

class DatabaseHelper
{
    protected static $instance = null;
    public function __construct() {}
    public function __clone() {}

    /**
     * @return PDO
     */
    public static function pdoInstance()
    {
        if (self::$instance === null) {
            $opt = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => TRUE,
            );
            $dsn = 'mysql:host=' . DBConfig::HOST . ';dbname=' . DBConfig::DATABASE . ';charset=' . DBConfig::CHARSET;
            self::$instance = new PDO($dsn, DBConfig::USER, DBConfig::PASSWORD, $opt);
        }
        return self::$instance;
    }
}