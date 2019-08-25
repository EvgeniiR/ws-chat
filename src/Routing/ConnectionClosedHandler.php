<?php

namespace App\Routing;

interface ConnectionClosedHandler
{
    public function handle(int $connectionId);
}