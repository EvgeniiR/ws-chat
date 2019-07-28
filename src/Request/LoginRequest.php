<?php

namespace App\Request;

class LoginRequest
{
    private $userId;

    private $username;

    public function __construct(int $userId, string $username) {
        $this->userId = $userId;
        $this->username = $username;
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
    public function getUsername(): string {
        return $this->username;
    }
}