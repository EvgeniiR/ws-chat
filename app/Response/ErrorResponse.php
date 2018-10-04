<?php

namespace App\Response;


class ErrorResponse extends Response
{
    private $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    protected function getType(): string
    {
        return 'error';
    }

    protected function getBody()
    {
        return ['message' => $this->message];
    }
}