<?php

namespace App\classes\Response;


use App\classes\Message;
use App\classes\Helpers\PurifierHelper;

class MessagesResponse extends Response
{
    private $messages = [];

    protected function getType(): string {
        return 'messages';
    }

    protected function getBody() {
        return ['messages' => $this->messages];
    }

    /**
     * @param Message $message
     * @return MessagesResponse
     */
    public function addMessage(Message $message) {
        $purifiedMessage = PurifierHelper::purify($message->getMessage());
        $timestamp = $message->getDateTime()->getTimestamp();
        $this->messages[] = [
            'username' => $message->getUsername(),
            'message' => $purifiedMessage,
            'dateTime' => $timestamp
        ];
        return $this;
    }
}