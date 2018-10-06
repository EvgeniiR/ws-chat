<?php

namespace App\Response;


class MessagesResponse extends Response
{
	private $messages = [];

	protected function getType(): string
	{
		return 'messages';
	}

	protected function getBody()
	{
		return ['messages' => $this->messages];
	}

	public function addMessage(string $username, string $message, int $dateTime)
	{
		$this->messages[] = ['username' => $username, 'message' => $message, 'dateTime' => $dateTime];
		return $this;
	}
}