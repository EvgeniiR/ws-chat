<?php

namespace App\MigrationsComponent\Internal;

use PDO;

class DBCurrentSchemaVersionProvider
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @param PDO $pdo
     * @throws MigratorException
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->createMigrationInfoTableIfNeeded();
    }

    public function getCurrentSchemaVersion(): int
    {
        $versions = $this->pdo->query('SELECT current_version from migrations_info')->fetchAll();
        if (empty($versions)) {
            throw new MigratorException('Something wrong with versions table(more than 1 version record founded)');
        }
        return (int)end($versions)['current_version'];
    }

    public function updateSchemaVersion(int $version): void
    {
        $res = $this->pdo->exec('UPDATE migrations_info SET current_version = ' . $version);
        if ($res === false) {
            $this->pdo->exec('END TRANSACTION');
            throw new MigratorException("Can`t save schema version:\n" . print_r($this->pdo->errorInfo(), true) . "\n");
        }
    }

    private function createMigrationInfoTableIfNeeded(): void
    {
        if ($this->pdo->exec('CREATE TABLE IF NOT EXISTS migrations_info ("current_version" varchar(30))') === false) {
            throw new MigratorException("Can`t create migrations_info table:\n" . print_r($this->pdo->errorInfo(), true) . "\n");
        }

        $PDOStatement = $this->pdo->query('SELECT current_version FROM migrations_info');
        if ($PDOStatement === false) {
            throw new MigratorException("Can`t save schema version:\n" . print_r($this->pdo->errorInfo(), true) . "\n");
        }
        $count = $PDOStatement->rowCount();

        if ($count === 0) {
            if ($this->pdo->exec('INSERT INTO migrations_info VALUES(0)') === false) {
                throw new MigratorException("Can`t save schema version:\n" . print_r($this->pdo->errorInfo(), true) . "\n");
            }
        }
    }
}