<?php

namespace App\Commands;

use App\WebsocketServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartAppCommand extends Command
{
    protected static $defaultName = 'app:start';

    protected function configure(): void
    {
        $this->setDescription('Start the application(Chat)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        new WebsocketServer();
    }
}