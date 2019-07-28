<?php

namespace App\Repository;


use App\Message;
use App\Helper\DatabaseHelper;

class MessagesRepository
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * MessageRepository constructor.
     */
    public function __construct() {
        $this->pdo = DatabaseHelper::pdoInstance();
    }

    /**
     * @return Message[]
     * @throws \Exception
     */
    public function getAll():array {
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
    public function save(Message $message): void {
        $stmt = $this->pdo->prepare("INSERT INTO messages (username, message) VALUES (:username, :message)");
        $stmt->execute(array('username' => $message->getUsername(), 'message' => $message->getMessage()));
    }
}