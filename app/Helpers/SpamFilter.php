<?php

namespace App\Helpers;


class SpamFilter
{
    /**
     * @var string[] errors
     */
    private $errors = [];

    /**
     * Check is message text correct
     */
    public function checkIsMessageTextCorrect(string $text) {
        if (empty(trim($text))) {
            $this->errors[] = 'Empty message text';
        }
    }

    /**
     * @return string[] errors
     */
    public function getErrors(): array {
        return $this->errors;
    }
}