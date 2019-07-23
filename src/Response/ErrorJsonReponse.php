<?php

namespace App\Response;


class ErrorJsonReponse extends JsonReponse
{
    private $message;

    public function __construct(string $message) {
        $this->message = $message;
    }

    protected function getType(): string {
        return 'error';
    }

    protected function getBody() {
        return ['message' => $this->message];
    }
}