<?php

namespace App\Commands;

use App\Config;
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

    protected function configure(): void
    {
        $this->setDescription('Execute a migration to a specified version or the latest available version.');
    }

    /**
     * @throws \App\MigrationsComponent\Internal\MigratorException
     * @throws \ReflectionException
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dsn = 'pgsql:host=' . Config::HOST . ';dbname=' . Config::DATABASE;
        $pdo = new PDO($dsn, Config::USER, Config::PASSWORD, Config::OPT);
        $migrationsFolderPath = Config::SRCDIR . '/Migration/';
        $migrator = new Migrator($pdo, $migrationsFolderPath);
        $result = $migrator->updateSchema($this->askVersionUserWant($input, $output));
        $output->writeln($result);
    }

    private function askVersionUserWant(InputInterface $input, OutputInterface $output): ?int
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