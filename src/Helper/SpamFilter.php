<?php

namespace App\Helper;


class SpamFilter
{
    /**
     * @var string[] errors
     */
    private $errors = [];

    /**
     * @param string $text
     * @return bool
     */
    public function checkIsMessageTextCorrect(string $text) {
        $isCorrect = true;
        if (empty(trim($text))) {
            $this->errors[] = 'Empty message text';
            $isCorrect = false;
        }
        return $isCorrect;
    }

    /**
     * @return string[] errors
     */
    public function getErrors(): array {
        return $this->errors;
    }
}