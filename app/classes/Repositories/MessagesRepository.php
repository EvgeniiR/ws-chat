<?php

namespace App\Repositories;


use App\classes\Message;
use App\Helpers\DatabaseHelper;

class MessagesRepository
{
    private $pdo;

    /**
     * MessageRepository constructor.
     */
    public function __construct() {
        $this->pdo = DatabaseHelper::pdoInstance();
    }

    /**
     * @return Message[]
     */
    public function getAll() {
        $stmt = $this->pdo->query('SELECT * FROM messages ORDER BY date_time DESC LIMIT 100');
        $messages = [];
        foreach ($stmt->fetchAll() as $row) {
            $messages[] = new Message($row['username'], $row['message'], new \DateTime($row['date_time']));
        }
        return $messages;
    }

    /**
     * @param Message $message
     */
    public function save(Message $message) {
        $stmt = $this->pdo->prepare("INSERT INTO messages (username, message) VALUES (:username, :message)");
        $stmt->execute(array('username' => $message->getUsername(), 'message' => $message->getMessage()));
    }
}