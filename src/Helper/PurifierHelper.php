<?php

namespace App\Helper;


use HTMLPurifier;
use HTMLPurifier_Config;

class PurifierHelper
{
    /**
     * @var HTMLPurifier|null
     */
    protected static $purifier = null;

    private static function instance(): HTMLPurifier {
        if (self::$purifier === null) {
            self::$purifier = new HTMLPurifier(HTMLPurifier_Config::createDefault());
        }
        return self::$purifier;
    }

    public static function purify(string $stringToPurify, ?HTMLPurifier_Config $config = null):string {
        return self::instance()->purify($stringToPurify, $config);
    }
}