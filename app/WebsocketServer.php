<?php

namespace App;

use App\Response\ErrorResponse;
use App\Response\LoginResponse;
use App\Response\MessagesResponse;
use HTMLPurifier;
use HTMLPurifier_Config;
use Swoole\Http\Request;
use swoole_table;
use swoole_websocket_server;

/**
 * Class WebsocketServer
 * @package App
 */
class WebsocketServer
{
    const PING_DELAY_MS = 25000;

    /**
     * @var swoole_websocket_server
     */
    private $ws;

    /**
     * Messages table. Columns:
     *  - username
     *  - message
     * @var swoole_table
     */
    private $messages_table;

    /**
     * Users table. Columns:
     *  - id
     *  - username
     * @var swoole_table
     */
    private $users_table;

    /**
     * WebsocketServer constructor.
     */
    public function __construct()
    {
        $this->purifier = new HTMLPurifier(HTMLPurifier_Config::createDefault());

        $this->ws = new swoole_websocket_server('0.0.0.0', 9502);

        $this->initTables();

        $this->ws->on('open', function ($ws, $request) {
            $this->onConnection($request);
        });
        $this->ws->on('message', function ($ws, $frame) {
            $this->onMessage($frame);
        });
        $this->ws->on('close', function ($ws, $id) {
            $this->onClose($id);
        });

        $this->ws->on('workerStart', function (swoole_websocket_server $ws) {
            $ws->tick(self::PING_DELAY_MS, function () use ($ws) {
                foreach ($ws->connections as $fd) {
                    $ws->push($fd, 'ping', WEBSOCKET_OPCODE_PING);
                }
            });
        });

        $this->ws->start();
    }

    /**
     * Client connected
     * @param Request $request
     */
    private function onConnection(Request $request)
    {
        $messagesResponse = new MessagesResponse();
        $count = count($this->messages_table);
        for ($i = 0; $i < $count; $i++) {
            $username = $this->messages_table[$i]->value['username'];
            $message = $this->messages_table[$i]->value['message'];
            $dateTIme = $this->messages_table[$i]->value['date_time'];
            $messagesResponse->addMessage($username, $message, $dateTIme);
        }
        $this->ws->push($request->fd, $messagesResponse->getJson());
        echo "client-{$request->fd} is connected\n";
    }

    /**
     * @param $frame
     */
    private function onMessage($frame)
    {
        echo 'We recieve: ';
        print_r($frame);
        $data = json_decode($frame->data);
        switch ($data->type) {
            case 'login':
                $this->registerNewUser($frame->fd, $data->username);
                break;
            case 'message':
                $this->addMessage($frame->fd, $data);
        }
    }

    /**
     * @param $id
     */
    private function onClose(int $id)
    {
        echo "client-{$id} is closed\n";
    }

    /**
     * @param int $id
     * @return bool|string
     */
    private function getUsername(int $id)
    {
        $username = $this->users_table->get($id, 'username');
        if ($username != false) {
            return $username;
        }
        return false;
    }

    /**
     * @param int $id
     */
    private function return_unauthorized(int $id)
    {
        $this->ws->push($id, (new ErrorResponse('Unauthorized!'))->getJson());
    }

    /**
     * @param int $id
     * @param $data
     */
    function addMessage(int $id, $data)
    {
        $username = $this->getUsername($id);
        if ($username == false) {
            $this->return_unauthorized($id);
            return;
        }

        $count = count($this->messages_table);

        $dateTime = time();
        $row = ['username' => $username, 'message' => $data->message, 'date_time' => $dateTime];
        $this->messages_table->set($count, $row);

        $purifiedMessage = $this->purifier->purify($data->message);

        $response = (new MessagesResponse())->addMessage($username, $purifiedMessage, $dateTime)->getJson();
        foreach ($this->ws->connections as $id) {
            $this->ws->push($id, $response);
        }
    }

    /**
     * @param int $id
     * @param string $username
     */
    private function registerNewUser(int $id, $username)
    {
        if (empty($username)) {
            $this->ws->push($id, (new LoginResponse(false, 'username cannot be empty'))->getJson());
            return;
        }
        $row = ['id' => $id, 'username' => $username];

        if ($this->isUsernameCurrentlyTaken($username)) {
            $this->ws->push($id, (new LoginResponse(false, 'Choose another name!'))->getJson());
        }

        $this->users_table->set($id, $row);

        $this->ws->push($id, (new LoginResponse(true))->getJson());
    }

    /**
     * Check if there are online users with some username
     * @param string $username
     * @return bool
     */
    private function isUsernameCurrentlyTaken(string $username)
    {
        foreach ($this->users_table as $user) {
            if ($user['username'] == $username) {
                $currentUserWithSomeNickId = $user['id'];
                if ($this->isUserOnline($currentUserWithSomeNickId)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Check if user with specified ID is currently online
     * @param int $id
     * @return bool
     */
    private function isUserOnline(int $id)
    {
        return (($key = array_search($id, $this->ws->connection_list())) !== false);
    }

    public function initTables()
    {
        $this->messages_table = new swoole_table(5000);
        $this->messages_table->column('username', swoole_table::TYPE_STRING, 100);
        $this->messages_table->column('message', swoole_table::TYPE_STRING, 250);
        $this->messages_table->column('date_time', swoole_table::TYPE_INT, 10);
        $this->messages_table->create();

        $this->users_table = new swoole_table(5000);
        $this->users_table->column('id', swoole_table::TYPE_INT, 5);
        $this->users_table->column('username', swoole_table::TYPE_STRING, 100);
        $this->users_table->create();
    }
}