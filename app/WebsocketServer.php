<?php

namespace App;

use App\classes\Helpers\PurifierHelper;
use App\classes\Helpers\RequestLimiter;
use App\classes\Helpers\SpamFilter;
use App\classes\Message;
use App\classes\Repositories\MessagesRepository;
use App\classes\Repositories\UsersRepository;
use App\classes\Request\LoginRequest;
use App\classes\Request\MessageRequest;
use App\classes\Response\ErrorResponse;
use App\classes\Response\LoginResponse;
use App\classes\Response\MessagesResponse;
use App\classes\User;
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
    private function initAsyncRepositories() {
        $this->messagesRepository = new MessagesRepository();
    }

    /**
     * Repositories that must be initialized in master process
     */
    private function initRepositories() {
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
        if( ! isset($data->type) ) {
            $this->ws->push($frame->fd, (new ErrorResponse('Failed to process request. Can`t parse request type')));
            return;
        }

        $requestType = $data->type;
        switch ($requestType) {
            case 'login':
                $this->processLoginRequest($frame->fd, $data);
                break;
            case 'message':
                $this->processMessageRequest($frame->fd, $data);
                break;
            default:
                $this->ws->push($frame->fd, (new ErrorResponse('Failed to process request. Unknown request type')));
                break;
        }
    }

    public function processLoginRequest(int $userId, $data) {
        if( ! isset($data->username) ) {
            $this->ws->push($userId, (new ErrorResponse('Failed to process request. Can`t parse username')));
            return;
        }
        $loginRequest = new LoginRequest($userId, $data->username);
        $this->registerNewUser($loginRequest);
    }

    public function processMessageRequest(int $userId, $data) {
        if( ! isset($data->message) ) {
            $this->ws->push($userId, (new ErrorResponse('Failed to process request. Can`t parse message')));
            return;
        }
        $messageRequest = new MessageRequest($userId, $data->message);
        $this->processMessage($messageRequest);
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
     * @param MessageRequest $messageRequest
     */
    function processMessage(MessageRequest $messageRequest) {
        $userId = $messageRequest->getUserId();
        $message = $messageRequest->getMessage();
        if (!$this->requestsLimiter->checkIsRequestAllowed($userId)) {
            $this->ws->push($userId, (new ErrorResponse('Too many messages! Try again later.'))->getJson());
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
            $response = new ErrorResponse($messageErrors[0]);
            $this->ws->push($userId, $response->getJson());
            return;
        }

        $dateTime = new \DateTime("now", new \DateTimeZone("UTC"));

        $message = new Message($user->getUsername(), $message, $dateTime);

        $this->messagesRepository->save($message);

        $response = (new MessagesResponse())->addMessage($message)->getJson();
        foreach ($this->ws->connections as $userId) {
            $this->ws->push($userId, $response);
        }
    }

    /**
     * @param int $id
     * @param LoginRequest $loginRequest
     */
    private function registerNewUser(LoginRequest $loginRequest) {
        $id = $loginRequest->getUserId();
        $username = PurifierHelper::purify((string)$loginRequest->getUsername());
        if ($user = $this->usersRepository->get($id) !== false) {
            $this->ws->push($id, (new ErrorResponse('You are already logged in'))->getJson());
        }

        if (empty(trim($username))) {
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
