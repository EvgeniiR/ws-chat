<?php

namespace App\Routing;

use Swoole\Http\Request;

interface NewConnectionHandler
{
    public function handle(Request $request);
}