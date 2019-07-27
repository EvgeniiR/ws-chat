<?php

namespace App\MigrationsComponent\Internal;

use App\MigrationsComponent\Migration;
use PDO;

class MigrationExecutor
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @throws MigratorException
     * @throws \ReflectionException
     */
    public function up(Migration $migration, DBCurrentSchemaVersionProvider $schemaVersionProvider): void
    {
        $res = $this->pdo->exec('START TRANSACTION');
        if($res === false) {
            throw new MigratorException("Can`t start transaction:\n" . print_r($this->pdo->errorInfo(), true) . "\n");
        }

        $res = $this->pdo->exec($migration->up());
        if($res === false) {
            $this->pdo->exec('END TRANSACTION');
            throw new MigratorException("Can`t aply migration:\n" . print_r($this->pdo->errorInfo(), true) . "\n");
        }
        $schemaVersionProvider->updateSchemaVersion($migration->currentVersion());

        $res = $this->pdo->exec('END TRANSACTION');
        if($res === false) {
            throw new MigratorException("Can`t commit transaction:\n" . print_r($this->pdo->errorInfo(), true) . "\n");
        }
    }

    /**
     * @throws MigratorException
     */
    public function down(Migration $migration, DBCurrentSchemaVersionProvider $schemaVersionProvider): void
    {
        $res = $this->pdo->exec('START TRANSACTION');
        if($res === false) {
            throw new MigratorException("Can`t start transaction:\n" . print_r($this->pdo->errorInfo(), true) . "\n");
        }

        $res = $this->pdo->exec($migration->down());
        if($res === false) {
            $this->pdo->exec('END TRANSACTION');
            throw new MigratorException("Can`t aply migration:\n" . print_r($this->pdo->errorInfo(), true) . "\n");
        }

        $schemaVersionProvider->updateSchemaVersion($migration->previousVersion());

        $res = $this->pdo->exec('END TRANSACTION');
        if($res === false) {
            throw new MigratorException("Can`t commit transaction:\n" . print_r($this->pdo->errorInfo(), true) . "\n");
        }
    }
}