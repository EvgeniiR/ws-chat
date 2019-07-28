<?php

namespace App;

use App\Helper\PurifierHelper;
use App\Helper\RequestLimiter;
use App\Helper\SpamFilter;
use App\Repository\MessagesRepository;
use App\Repository\UsersRepository;
use App\Request\LoginRequest;
use App\Request\MessageRequest;
use App\Response\ErrorJsonReponse;
use App\Response\LoginJsonReponse;
use App\Response\MessagesJsonReponse;
use App\Response\UsersJsonReponse;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;
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
     * @var RequestLimiter
     */
    private $requestsLimiter;

    /**
     * WebsocketServer constructor.
     */
    public function __construct() {
        $this->requestsLimiter = new RequestLimiter();

        $this->initRepositories();

        $this->ws = new Server('0.0.0.0', 9502);

        $this->ws->on('open', function ($ws, Request $request): void {
            $this->onConnection($request);
        });
        $this->ws->on('message', function ($ws, Frame $frame): void  {
            $this->onMessage($frame);
        });
        $this->ws->on('close', function ($ws, $id): void  {
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
    private function onWorkerStart(Server $ws): void {
        $this->initAsyncRepositories();

        $ws->tick(self::PING_DELAY_MS, function () use ($ws) {
            foreach ($ws->connections as $id) {
                $ws->push($id, 'ping', WEBSOCKET_OPCODE_PING);
            }
        });
    }

    /**
     * Async repositories must be initialized after master process
     */
    private function initAsyncRepositories(): void {
        $this->messagesRepository = new MessagesRepository();
    }

    /**
     * Repositories that must be initialized in master process
     */
    private function initRepositories(): void {
        $this->usersRepository = new UsersRepository();
    }

    /**
     * Client connected
     * @param Request $request
     */
    private function onConnection(Request $request): void {
        $messagesResponse = new MessagesJsonReponse();

        foreach ($this->messagesRepository->getAll() as $message) {
            $messagesResponse->addMessage($message);
        }

        $this->ws->push($request->fd, $messagesResponse->getJson());

        $usersResponse = new UsersJsonReponse(UsersJsonReponse::ACTION_NEW_USERS);
        foreach ($this->usersRepository->getByIds($this->ws->connection_list()) as $user) {
            $usersResponse->addUser($user);
        }
        $this->ws->push($request->fd, $usersResponse->getJson());

        echo "client-{$request->fd} is connected\n";
    }

    /**
     * @param $frame
     */
    private function onMessage($frame): void {
        echo 'We recieve: ';
        print_r($frame);

        $decodedData = json_decode($frame->data);
        if( ! isset($decodedData->type) ) {
            $this->ws->push($frame->fd, (new ErrorJsonReponse('Failed to process request. Can`t parse request type'))->getJson());
            return;
        }

        $requestType = $decodedData->type;
        switch ($requestType) {
            case 'login':
                $this->processLoginRequest($frame->fd, $decodedData);
                break;
            case 'message':
                $this->processMessageRequest($frame->fd, $decodedData);
                break;
            default:
                $this->ws->push($frame->fd, (new ErrorJsonReponse('Failed to process request. Unknown request type'))->getJson());
                break;
        }
    }

    public function processLoginRequest(int $userId, $data): void {
        if( ! isset($data->username) ) {
            $this->ws->push($userId, (new ErrorJsonReponse('Failed to process request. Can`t parse username'))->getJson());
            return;
        }
        $loginRequest = new LoginRequest($userId, $data->username);
        $this->registerNewUser($loginRequest);
    }

    public function processMessageRequest(int $userId, $data): void {
        if( ! isset($data->message) ) {
            $this->ws->push($userId, (new ErrorJsonReponse('Failed to process request. Can`t parse message'))->getJson());
            return;
        }
        $messageRequest = new MessageRequest($userId, $data->message);
        $this->processMessage($messageRequest);
    }

    /**
     * @param $id
     */
    private function onClose(int $id): void {
        $user = $this->usersRepository->get($id);
        foreach ($this->ws->connections as $userId) {
            $response =
                (new UsersJsonReponse(UsersJsonReponse::ACTION_DISCONNECTED_USERS))
                ->addUser($user)
                ->getJson();
            $this->ws->push($userId, $response);
        }
        $this->usersRepository->delete($id);
        echo "client-{$id} is closed\n";
    }

    /**
     * @param int $id
     */
    private function returnUnauthorized(int $id): void {
        $this->ws->push($id, (new ErrorJsonReponse('Unauthorized!'))->getJson());
    }

    /**
     * @param MessageRequest $messageRequest
     */
    function processMessage(MessageRequest $messageRequest): void {
        $userId = $messageRequest->getUserId();
        $message = $messageRequest->getMessage();
        if (!$this->requestsLimiter->checkIsRequestAllowed($userId)) {
            $this->ws->push($userId, (new ErrorJsonReponse('Too many messages! Try again later.'))->getJson());
            return;
        }

        $user = $this->usersRepository->get($userId);
        if ($user === false) {
            $this->returnUnauthorized($userId);
            return;
        }

        $spamFilter = new SpamFilter();
        $spamFilter->checkIsMessageTextCorrect($message);
        $messageErrors = $spamFilter->getErrors();
        if (!empty($messageErrors)) {
            $response = new ErrorJsonReponse($messageErrors[0]);
            $this->ws->push($userId, $response->getJson());
            return;
        }

        $dateTime = new \DateTime("now", new \DateTimeZone("UTC"));
        $message = new Message($user->getUsername(), $message, $dateTime);

        $this->messagesRepository->save($message);

        $response = (new MessagesJsonReponse())->addMessage($message)->getJson();
        foreach ($this->ws->connections as $userId) {
            $this->ws->push($userId, $response);
        }
    }

    /**
     * @param LoginRequest $loginRequest
     */
    private function registerNewUser(LoginRequest $loginRequest): void {
        $id = $loginRequest->getUserId();
        $username = PurifierHelper::purify((string)$loginRequest->getUsername());
        if ($user = $this->usersRepository->get($id) !== false) {
            $this->ws->push($id, (new ErrorJsonReponse('You are already logged in'))->getJson());
        }

        if (empty(trim($username))) {
            $this->ws->push($id, (new LoginJsonReponse(false, $username, 'username cannot be empty'))->getJson());
            return;
        }

        if ($this->isUsernameCurrentlyTaken($username)) {
            $this->ws->push($id, (new LoginJsonReponse(false, $username, 'Choose another name!'))->getJson());
            return;
        }

        $user = new User($id, $username);
        $this->usersRepository->save($user);

        foreach ($this->ws->connections as $userId) {
            $this->ws->push($userId, (
                new UsersJsonReponse(UsersJsonReponse::ACTION_NEW_USERS))
                ->addUser($user)
                ->getJson()
            );
        }

        $this->ws->push($id, (new LoginJsonReponse(true, $username))->getJson());
    }

    /**
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
}
