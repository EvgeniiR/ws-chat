<?php

namespace App\MigrationsComponent;

use App\MigrationsComponent\Internal\MigratorException;

abstract class Migration
{
    /**
     * @var int
     */
    private $previousVersion;

    public function __construct(int $previousVersion)
    {
        $this->previousVersion = $previousVersion;
    }

    /**
     * @throws MigratorException
     * @throws \ReflectionException
     */
    public static function currentVersion(): int {
        $reflection = new \ReflectionClass(get_called_class());
        $className = $reflection->getShortName();
        preg_match('/^Version(\d+)$/', $className, $matches);
        if(!isset($matches[1])) {
            throw new MigratorException('Incorrect migration filename. Can`t get version');
        }
        return (int)$matches[1];
    }

    public function previousVersion(): int {
        return $this->previousVersion;
    }

    /**
     * @return string SQL
     */
    abstract public function up(): string ;

    /**
     * @return string SQL
     */
    abstract public function down(): string ;
}