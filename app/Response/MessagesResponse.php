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

	public function addMessage(string $username, string $message)
	{
		$this->messages[] = ['username' => $username, 'message' => $message, 'dateTime' => ChatHelper::currentTime()];
		return $this;
	}
}