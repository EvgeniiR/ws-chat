<?php

namespace App;

use Swoole\Http\Request;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

class WS
{
    /**
     * @var Server
     */
    private $ws;

    public function __construct(string $host, int $port) {
        $this->ws = new Server($host, $port);
    }

    public function onConnection(callable $onConnection): void
    {
        $this->ws->on('open', function (Server $ws, Request $request) use ($onConnection): void {
            $onConnection($request);
        });
    }

    public function onMessage(callable $onMessage): void
    {
        $this->ws->on('message', function (Server $ws, Frame $frame) use ($onMessage): void {
            $onMessage($frame);
        });
    }

    public function onClose(callable $onClose): void
    {
        $this->ws->on('close', function (Server $ws, int $id) use ($onClose): void {
            $onClose($id);
        });
    }

    public function start(): void
    {
        $this->ws->start();
    }
}