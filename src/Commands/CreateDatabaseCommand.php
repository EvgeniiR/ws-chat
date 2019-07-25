<?php

namespace App\Commands;

use App\DBConfig;
use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDatabaseCommand extends Command
{
    protected static $defaultName = 'app:database:create';

    protected function configure()
    {
        $this->setDescription(<<<'TEXT'
Run to create database when installing the project. Command is idempotent and shouldn`t harm or clean up an existing database by accidental start-up.
TEXT
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dsn = 'pgsql:host=' . DBConfig::HOST;
        $pdo = new PDO($dsn, DBConfig::USER, DBConfig::PASSWORD, DBConfig::OPT);
        $db = DBConfig::DATABASE;

        $dbCount = $pdo->query("SELECT datname FROM pg_catalog.pg_database WHERE lower(datname) = lower('$db')")->rowCount();
        if ($dbCount === 0) {
            $res = $pdo->exec("CREATE DATABASE \"$db\";");
            if ($res === false) {
                $output->writeln(print_r($pdo->errorInfo(), 1));
            } else {
                $output->writeln('Success.');
            }
        }
    }
}