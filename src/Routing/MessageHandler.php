<?php

namespace App\Routing;

use Swoole\WebSocket\Frame;

interface MessageHandler
{
    public function handle(Frame $frame);
}