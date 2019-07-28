<?php

namespace App\MigrationsComponent;

use App\MigrationsComponent\Internal\DBCurrentSchemaVersionProvider;
use App\MigrationsComponent\Internal\MigrationExecutor;
use App\MigrationsComponent\Internal\MigrationsLoader;
use App\MigrationsComponent\Internal\MigratorException;
use App\MigrationsComponent\Internal\SchemaUpdater;
use PDO;

/**
 * Facade for using  migrations component
 */
class Migrator
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var DBCurrentSchemaVersionProvider
     */
    private $schemaVersionProvider;

    /**
     * @var MigrationsLoader
     */
    private $migrationsLoader;

    /**
     * @throws MigratorException
     */
    public function __construct(PDO $pdo, string $migrationsFolderPath)
    {
        $this->pdo = $pdo;
        $this->schemaVersionProvider = new DBCurrentSchemaVersionProvider($this->pdo);
        $this->migrationsLoader = new MigrationsLoader($migrationsFolderPath);
    }

    /**
     * @param int $requiredVersion
     * Pass 0 version to drop all migrations, pass null to apply all new migrations
     * @throws \ReflectionException
     * @throws MigratorException
     */
    public function updateSchema(?int $requiredVersion): string {
        $this->migrationsLoader->loadAllMigrations();
        $schemaUpdater = new SchemaUpdater($this->migrationsLoader, $this->schemaVersionProvider, new MigrationExecutor($this->pdo));
        return $schemaUpdater->migrateToVersion($requiredVersion);
    }
}