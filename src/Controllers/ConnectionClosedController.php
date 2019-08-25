<?php

namespace App\Controllers;

use \App\Routing\ConnectionClosedHandler;

class ConnectionClosedController implements ConnectionClosedHandler
{
    public function handle(int $connectionId): void
    {
    }
}