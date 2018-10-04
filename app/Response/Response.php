<?php

namespace App\Response;


abstract class Response
{
	abstract protected function getType(): string;
	abstract protected function getBody();

	public function getJson()
	{
		return json_encode(['type' => $this->getType(), 'body' => $this->getBody()]);
	}
}