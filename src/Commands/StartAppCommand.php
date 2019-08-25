<?php

namespace App\Commands;

use Swoole\Http\Request;
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
//        new WebsocketServer();
        $router = new \App\Routing\Router();

        \App\RoutingConfig::configure($router);

        $ws = new \App\WS('0.0.0.0', 9502);

        $ws->onConnection(function (Request $request) use ($router): void {
            $router->handleNewConnection($request);
        });

        $ws->onClose(function (int $connectionId) use ($router): void {
            $router->handleClosedConnection($connectionId);
        });

        $ws->onMessage(function (\Swoole\WebSocket\Frame $frame) use ($router): void {
            $router->handleMessage($frame);
        });

        $ws->start();
    }
}