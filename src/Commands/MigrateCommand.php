<?php

namespace App\Commands;

use App\DBConfig;
use App\Migration\Migration;
use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class MigrateCommand extends Command
{
    protected static $defaultName = 'app:migration:migrate';

    private $pdo;

    public function __construct(string $name = null)
    {
        parent::__construct($name);
        $dsn = 'pgsql:host=' . DBConfig::HOST . ';dbname=' . DBConfig::DATABASE;
        $this->pdo = new PDO($dsn, DBConfig::USER, DBConfig::PASSWORD, DBConfig::OPT);
    }

    protected function configure()
    {
        $this->setDescription('Execute a migration to a specified version or the latest available version.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $migrationsFolder = SRCDIR . 'Migration/';

        $this->createMigrationInfoTableIfNeeded();

        $migrationClasses = [];
        foreach (scandir($migrationsFolder) as $filename) {
            if(!$this->isMigrationFile($filename)) { continue; }
            $migrationClasses[$this->getVersionFromMigrationFilename($filename)] = $this->getFullClassName($filename);
        }

        $currentVersion = $this->getCurrentVersion();
        $latestVersion = array_key_last($migrationClasses);
        $versionUserWants = $this->askVersionUserWant($input, $output);
        $versionUserWants = $versionUserWants === 'latest' ? $latestVersion : $versionUserWants;

        if(is_string($versionUserWants) && !ctype_digit($versionUserWants)) {
            $output->writeln('Incorrect input. Version must be integer or empty');
            return;
        }

        $versionUserWants = (int)$versionUserWants;

        if($versionUserWants !== 0 && !array_key_exists($versionUserWants, $migrationClasses)) {
            $output->writeln('Incorrect input. Specified version not found');
            return;
        }

        if($versionUserWants === $currentVersion) {
            $output->writeln('All migrations are up');
            return;
        }

        if($versionUserWants > $currentVersion) {
            $migrationsToApply = array_filter($migrationClasses, function ($version) use ($currentVersion) {
                return $version > $currentVersion;
            }, ARRAY_FILTER_USE_KEY);

            ksort($migrationClasses);
            foreach ($migrationsToApply as $version => $migrationToUp) {
                /** @var Migration $migration */
                $migration = new $migrationToUp();
                $sql = $migration->up();
                $this->applyMigrationSql($sql, $version);
            }
        }

        if($versionUserWants < $currentVersion) {
            $migrationsToApply = array_filter($migrationClasses, function ($version) use ($currentVersion) {
                return $version <= $currentVersion;
            }, ARRAY_FILTER_USE_KEY);

            krsort($migrationClasses);
            foreach ($migrationsToApply as $migrationToDown) {
                /** @var Migration $migration */
                $migration = new $migrationToDown();
                $sql = $migration->down();
                next($migrationsToApply);
                $version = key($migrationsToApply);
                if($version === null) $version = 0;
                prev($migrationsToApply);
                $this->applyMigrationSql($sql, $version);
            }
        }

        $output->writeln('Success.');
    }

    private function isMigrationFile($filename): bool
    {
        return (bool)preg_match('/^Version\d+\.php$/', $filename);
    }

    /**
     * @param $filename
     * @return mixed
     */
    private function getVersionFromMigrationFilename(string $filename): int
    {
        preg_match('/^Version(\d+)\.php$/', $filename, $matches);
        return $matches[1];
    }

    private function getFullClassName(string $migrationFileName): string
    {
        $migrationsNamespace = 'App\Migration';
        preg_match('/^(Version\d+)\.php$/', $migrationFileName, $matches);
        $className = $matches[1];
        $fullClassName = $migrationsNamespace . '\\' . $className;
        return $fullClassName;
    }

    private function getCurrentVersion(): int
    {
        $versions = $this->pdo->query('SELECT current_version from migrations_info')->fetchAll();
        if(empty($versions)) {
            return 0;
        }
        $current_version = (int)end($versions)['current_version'];
        return $current_version;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     */
    protected function askVersionUserWant(InputInterface $input, OutputInterface $output)
    {
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');
        $question = new Question('Specify migration version(number). Skip step by pressing "Enter" to select latest available version. Enter 0 to revert all migrations: ', 'latest');

        return $helper->ask($input, $output, $question);
    }

    private function applyMigrationSql(string $sql, int $newVersion): void
    {
        $res = $this->pdo->exec('START TRANSACTION');
        if($res === false) {
            throw new \Exception("Can`t start transaction:\n" . print_r($this->pdo->errorInfo() . "\n"));
        }


        $res = $this->pdo->exec($sql);
        if($res === false) {
            $this->pdo->exec('END TRANSACTION');
            throw new \Exception("Can`t aply migration:\n" . print_r($this->pdo->errorInfo() . "\n"));
        }
        $res = $this->pdo->exec('UPDATE migrations_info SET current_version = ' . $newVersion);
        if($res === false) {
            $this->pdo->exec('END TRANSACTION');
            throw new \Exception("Can`t save schema version:\n" . print_r($this->pdo->errorInfo() . "\n"));
        }

        $res = $this->pdo->exec('END TRANSACTION');
        if($res === false) {
            throw new \Exception("Can`t commit transaction:\n" . print_r($this->pdo->errorInfo() . "\n"));
        }
    }

    private function createMigrationInfoTableIfNeeded()
    {
        $res = $this->pdo->exec('CREATE TABLE IF NOT EXISTS migrations_info ("current_version" character(17))');
        if($res === false) {
            throw new \Exception("Can`t create migrations_info table:\n" . print_r($this->pdo->errorInfo() . "\n"));
        }

        $count = $this->pdo->query('SELECT current_version FROM migrations_info')->rowCount();

        if($count === 0) {
            $res = $this->pdo->exec('INSERT INTO migrations_info VALUES(0)');
            if($res === false) {
                throw new \Exception("Can`t save schema version:\n" . print_r($this->pdo->errorInfo() . "\n"));
            }
        }
    }
}