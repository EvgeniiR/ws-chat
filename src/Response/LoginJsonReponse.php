<?php

namespace App\Response;


class LoginJsonReponse extends JsonReponse
{
    private $result;

    private $username;

    private $message;

    public function __construct(bool $result, string $username, string $message = null) {
        $this->result = $result;
        $this->username = $username;
        $this->message = $message;
    }

    protected function getType(): string {
        return 'login';
    }

    protected function getBody() {
        if ($this->message != null) {
            $body = ['result' => $this->result, 'username' => $this->username, 'message' => $this->message];
        } else {
            $body = ['result' => $this->result, 'username' => $this->username];
        }
        return $body;
    }
}