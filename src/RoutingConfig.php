<?php

namespace App;

use App\Controllers\ConnectionClosedController;
use App\Controllers\NewUserConnectedController;
use App\Routing\Router;
use Swoole\WebSocket\Frame;

class RoutingConfig
{
    public static function configure(Router $router): void {
        $router->addNewConnectionHandler(NewUserConnectedController::class);
        $router->addClosedConnectionHandler(ConnectionClosedController::class);


    }

    public static function getMessageTypeFromRequest(Frame $frame): string {
        return json_decode($frame->data)->type;
    }
}