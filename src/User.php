<?php

namespace App;

class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @param int $id
     * @param string $username
     */
    public function __construct(int $id, string $username) {
        $this->id = $id;
        $this->username = $username;
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string {
        return $this->username;
    }
}