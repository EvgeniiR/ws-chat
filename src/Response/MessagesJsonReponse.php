<?php

namespace App\Response;


use App\Message;
use App\Helper\PurifierHelper;

class MessagesJsonReponse extends JsonReponse
{
    /**
     * @var array
     */
    private $messages = [];

    protected function getType(): string {
        return 'messages';
    }

    protected function getBody() {
        return ['messages' => $this->messages];
    }

    /**
     * @param Message $message
     * @return MessagesJsonReponse
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