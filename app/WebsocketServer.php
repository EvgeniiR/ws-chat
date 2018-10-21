<?php

namespace App;

use App\classes\Message;
use App\classes\User;
use App\Helpers\PurifierHelper;
use App\Helpers\SpamFilter;
use App\Repositories\MessagesRepository;
use App\Repositories\UsersRepository;
use App\Response\ErrorResponse;
use App\Response\LoginResponse;
use App\Response\MessagesResponse;
use Swoole\Http\Request;
use Swoole\WebSocket\Server;

/**
 * Class WebsocketServer
 * @package App
 */
class WebsocketServer
{
    const PING_DELAY_MS = 25000;

    /**
     * @var Server
     */
    private $ws;

    /**
     * @var MessagesRepository
     */
    private $messagesRepository;

    /**
     * @var UsersRepository
     */
    private $usersRepository;

    /**
     * WebsocketServer constructor.
     */
    public function __construct() {
        $this->ws = new Server('0.0.0.0', 9502);

        $this->initSwooleAsyncRepositories();

        $this->ws->on('open', function ($ws, $request) {
            $this->onConnection($request);
        });
        $this->ws->on('message', function ($ws, $frame) {
            $this->onMessage($frame);
        });
        $this->ws->on('close', function ($ws, $id) {
            $this->onClose($id);
        });

        $this->ws->on('workerStart', function (Server $ws) {
            $this->onWorkerStart($ws);
        });

        $this->ws->start();
    }

    /**
     * @param Server $ws
     */
    private function onWorkerStart(Server $ws) {
        $this->initRepositories();
        $ws->tick(self::PING_DELAY_MS, function () use ($ws) {
            foreach ($ws->connections as $id) {
                $ws->push($id, 'ping', WEBSOCKET_OPCODE_PING);
            }
        });
    }

    private function initRepositories() {
        $this->messagesRepository = new MessagesRepository();
    }

    private function initSwooleAsyncRepositories() {
        $this->usersRepository = new UsersRepository();
    }

    /**
     * Client connected
     * @param Request $request
     */
    private function onConnection(Request $request) {
        $messagesResponse = new MessagesResponse();

        foreach ($this->messagesRepository->getAll() as $message) {
            $messagesResponse->addMessage($message);
        }

        $this->ws->push($request->fd, $messagesResponse->getJson());
        echo "client-{$request->fd} is connected\n";
    }

    /**
     * @param $frame
     */
    private function onMessage($frame) {
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
    private function onClose(int $id) {
        $this->usersRepository->delete($id);
        echo "client-{$id} is closed\n";
    }

    /**
     * @param int $id
     */
    private function returnUnauthorized(int $id) {
        $this->ws->push($id, (new ErrorResponse('Unauthorized!'))->getJson());
    }

    /**
     * @param int $userId
     * @param $data
     */
    function addMessage(int $userId, $data) {
        $user = $this->usersRepository->get($userId);
        if ($user === false) {
            $this->returnUnauthorized($userId);
        }

        $spamFilter = new SpamFilter();
        $spamFilter->checkIsMessageTextCorrect($data->message);
        $messageErrors = $spamFilter->getErrors();
        if (!empty($messageErrors)) {
            $response = new ErrorResponse($messageErrors[0]);
            $this->ws->push($userId, $response->getJson());
            return;
        }

        $dateTime = new \DateTime("now", new \DateTimeZone("UTC"));

        $message = new Message($user->getUsername(), $data->message, $dateTime);

        $this->messagesRepository->save($message);

        $response = (new MessagesResponse())->addMessage($message)->getJson();
        foreach ($this->ws->connections as $userId) {
            $this->ws->push($userId, $response);
        }
    }

    /**
     * @param int $id
     * @param string $username
     */
    private function registerNewUser(int $id, $username) {
        $username = PurifierHelper::purify($username);
        if ($user = $this->usersRepository->get($id) !== false) {
            $this->ws->push($id, (new ErrorResponse('You are already logged in'))->getJson());
        }

        if (empty($username)) {
            $this->ws->push($id, (new LoginResponse(false, $username, 'username cannot be empty'))->getJson());
            return;
        }

        if ($this->isUsernameCurrentlyTaken($username)) {
            $this->ws->push($id, (new LoginResponse(false, $username, 'Choose another name!'))->getJson());
            return;
        }

        $user = new User($id, $username);
        $this->usersRepository->save($user);

        $this->ws->push($id, (new LoginResponse(true, $username))->getJson());
    }

    /**
     * Check if there are online users with some username
     * @param string $username
     * @return bool
     */
    private function isUsernameCurrentlyTaken(string $username) {
        foreach ($this->usersRepository->getByIds($this->ws->connection_list()) as $user) {
            if ($user->getUsername() == $username) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if user with specified ID is currently online
     * @param int $id
     * @return bool
     */
    private function isUserOnline(int $id) {
        return (($key = array_search($id, $this->ws->connection_list())) !== false);
    }
}