<?php

namespace App;


class Message
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $message;

    /**
     * @var \DateTime
     */
    private $date_time;

    /**
     * @param string $username
     * @param string $message
     * @param \DateTime $date_time
     */
    public function __construct(string $username, string $message, \DateTime $date_time) {
        $this->username = $username;
        $this->message = $message;
        $this->date_time = $date_time;
    }


    /**
     * @return string
     */
    public function getUsername(): string {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getMessage(): string {
        return $this->message;
    }

    /**
     * @return \DateTime
     */
    public function getDateTime(): \DateTime {
        return $this->date_time;
    }
}