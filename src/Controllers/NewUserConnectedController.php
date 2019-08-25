<?php

namespace App\Controllers;

use App\Routing\NewConnectionHandler;
use Swoole\Http\Request;

class NewUserConnectedController implements NewConnectionHandler
{
    public function handle(Request $request): void
    {

    }
}