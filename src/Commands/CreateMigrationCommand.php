<?php

namespace App\Commands;

use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateMigrationCommand extends Command
{
    protected static $defaultName = 'app:migration:create';

    protected function configure(): void
    {
        $this->setDescription(<<<'TEXT'
Creates new migration in migrations folder
TEXT
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $migrationsFolderPath = __DIR__ . '/../Migration/';
        $migrationsNamespace = 'App\Migration';

        $dateTimeString = (new DateTimeImmutable())->format('YmdHisv');

        $className = 'Version' . $dateTimeString;

        $migrationTemplate = <<<"TEMPLATE"
<?php
namespace {$migrationsNamespace};

use App\MigrationsComponent\Migration;

class $className extends Migration {
    /**
     * @return string SQL
     */
    public function up(): string {
        return '';
    }
    
    /**
     * @return string SQL
     */
    public function down(): string {
        return '';
    }
}

TEMPLATE;

        file_put_contents($migrationsFolderPath . $className . '.php', $migrationTemplate);

        $output->writeln('Success');
    }
}