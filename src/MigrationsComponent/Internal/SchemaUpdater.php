<?php

namespace App\MigrationsComponent\Internal;

class SchemaUpdater
{
    /**
     * @var MigrationsLoader
     */
    private $loader;

    /**
     * @var DBCurrentSchemaVersionProvider
     */
    private $schemaVersionProvider;

    /**
     * @var MigrationExecutor
     */
    private $migrationExecutor;

    public function __construct(MigrationsLoader $loader, DBCurrentSchemaVersionProvider $schemaVersionProvider, MigrationExecutor $executor)
    {
        $this->loader = $loader;
        $this->schemaVersionProvider = $schemaVersionProvider;
        $this->migrationExecutor = $executor;
    }

    /**
     * @return string One of predefined constants text
     * @throws \ReflectionException
     * @throws MigratorException
     */
    public function migrateToVersion(?int $requiredVersion): string
    {
        $currentVersion = $this->schemaVersionProvider->getCurrentSchemaVersion();
        if ($requiredVersion === $currentVersion) {
            return MigratorResultText::REQUIRED_AND_CURRENT_VERSION_ARE_SAME;
        }

        $migrations = $this->loader->loadAllMigrations();
        if(!array_key_exists($requiredVersion, $migrations) && $requiredVersion !== 0 && $requiredVersion !== null) {
            throw new MigratorException('Incorrect input. Specified version not found');
        }

        $latestVersion = max(array_keys($migrations));
        $requiredVersion = $requiredVersion === null ? $latestVersion : $requiredVersion;

        if ($requiredVersion > $currentVersion) {
            $migrationsToUp = array_filter($migrations, function (int $version) use ($currentVersion, $requiredVersion) {
                return ($version > $currentVersion && $version <= $requiredVersion);
            }, ARRAY_FILTER_USE_KEY);

            $res = ksort($migrationsToUp);
            if ($res === false) {
                throw new MigratorException('Can`t use ksort()');
            }

            foreach ($migrationsToUp as $version => $migrationToUp) {
                $this->migrationExecutor->up($migrationToUp, $this->schemaVersionProvider);
            }
            return MigratorResultText::SUCCESS;
        }

        if ($requiredVersion < $currentVersion) {
            $migrationsToRevert = array_filter($migrations, function ($version) use ($currentVersion, $requiredVersion) {
                return ($version <= $currentVersion && $version > $requiredVersion);
            }, ARRAY_FILTER_USE_KEY);

            $res = krsort($migrationsToRevert);
            if ($res === false) {
                throw new MigratorException('Can`t use krsort()');
            }

            foreach ($migrationsToRevert as $migrationToRevert) {
                $this->migrationExecutor->down($migrationToRevert, $this->schemaVersionProvider);
            }
            return MigratorResultText::SUCCESS;
        }
    }
}