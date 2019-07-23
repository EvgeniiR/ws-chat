<?php

namespace App\Request;

class MessageRequest
{
    private $userId;

    private $message;

    public function __construct(int $userId, string $message) {
        $this->userId = $userId;
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getUserId(): int {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getMessage(): string {
        return $this->message;
    }
}