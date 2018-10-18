<?php

namespace App\Response;


class LoginResponse extends Response
{
    private $result;

    private $message;

    public function __construct(bool $result, string $message = null) {
        $this->result = $result;
        $this->message = $message;
    }

    protected function getType(): string {
        return 'login';
    }

    protected function getBody() {
        if ($this->message != null) {
            $body = ['result' => $this->result, 'message' => $this->message];
        } else {
            $body = ['result' => $this->result];
        }
        return $body;
    }
}