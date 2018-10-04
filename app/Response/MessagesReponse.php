<?php

namespace App\Response;


class MessagesReponse extends Response
{
	private $messages = [];

	protected function getType(): string
	{
		return 'messages';
	}

	protected function getBody()
	{
		return $this->messages;
	}

	public function addMessage(string $username, string $message)
	{
		$this->messages[] = ['username' => $username, 'message' => $message, 'dateTime' => ChatHelper::currentTime()];
	}
}