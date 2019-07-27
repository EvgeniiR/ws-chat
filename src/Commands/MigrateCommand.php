<?php

namespace App\Commands;

use App\DBConfig;
use App\MigrationsComponent\Migrator;
use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
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

    /**
     * @throws \App\MigrationsComponent\Internal\MigratorException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $migrationsFolderPath = SRCDIR . 'Migration/';
        $migrator = new Migrator($this->pdo, $migrationsFolderPath);
        $result = $migrator->updateSchema($this->askVersionUserWant($input, $output));
        $output->writeln($result);
    }

    protected function askVersionUserWant(InputInterface $input, OutputInterface $output): ?int
    {
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');
        $question = new Question('Specify migration version(number). Skip step by pressing "Enter" to select latest available version. Enter 0 to revert all migrations: ', null);

        $answer = $helper->ask($input, $output, $question);

        if($answer === null) {
            return $answer;
        }

        if(!ctype_digit($answer)) {
            throw new \Exception('Incorrect input.');
        }

        return (int)$answer;
    }
}