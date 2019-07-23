<?php

namespace App\Helpers;


use HTMLPurifier;
use HTMLPurifier_Config;

class PurifierHelper
{
    /**
     * @var HTMLPurifier
     */
    protected static $purifier = null;

    private static function instance() {
        if (self::$purifier === null) {
            self::$purifier = new HTMLPurifier(HTMLPurifier_Config::createDefault());
        }
        return self::$purifier;
    }

    public static function purify(string $stringToPurify, $config = null) {
        return self::instance()->purify($stringToPurify, $config);
    }
}