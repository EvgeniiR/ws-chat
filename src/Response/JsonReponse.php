<?php

namespace App\Response;


abstract class JsonReponse
{
    abstract protected function getType(): string;

    /**
     * Body section of Response
     * @return mixed
     */
    abstract protected function getBody();

    /**
     * Return JSON response
     * @return false|string
     */
    public function getJson() {
        return json_encode(['type' => $this->getType(), 'body' => $this->getBody()]);
    }
}