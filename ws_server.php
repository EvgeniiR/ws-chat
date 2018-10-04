<?php

use App\Response\ErrorResponse;
use App\Response\LoginResponse;
use App\Response\MessagesReponse;

require_once('./vendor/autoload.php');

$ws = new swoole_websocket_server('0.0.0.0', 9502);
$messages_table = new swoole_table(5000);
$messages_table->column('username', swoole_table::TYPE_STRING, 100);
$messages_table->column('message', swoole_table::TYPE_STRING, 250);
$messages_table->create();

$users_table = new swoole_table(5000);
$users_table->column('fd', swoole_table::TYPE_INT, 5);
$users_table->column('username', swoole_table::TYPE_STRING, 100);
$users_table->create();

$global_channel = new swoole_channel(1000);

function getUsername($fd)
{
    global $users_table;
    $username = $users_table->get($fd, 'username');
    if ($username != false) {
        return $username;
    }
    return false;
}

function return_unauthorized($fd)
{
    global $ws;
    $ws->push($fd, (new ErrorResponse('Unauthorized!'))->getJson());
}

function addMessage($fd, $data)
{
    $username = getUsername($fd);
    if ($username == false) {
        return_unauthorized($fd);
        return;
    }

    global $messages_table;
    $count = count($messages_table);
    $row = ['username' => $username, 'message' => $data->message];
    $messages_table->set($count, $row);

    global $global_channel;
    $fds = $global_channel->peek() ?? [];
    $response = (new MessagesReponse())->addMessage($username, $data->message)->getJson();
    global $ws;
    foreach ($fds as $fd) {
        $ws->push($fd, $response);
    }
}

function login(int $fd, $username)
{
    global $ws;
    if (empty($username)) {
        $ws->push($fd, (new LoginResponse(false, 'username cannot be empty'))->getJson());
    }
    global $users_table;
    $row = ['fd' => $fd, 'username' => $username];

    foreach ($users_table as $user) {
        if ($user['username'] == $username) {
            $user_with_some_nick_fd = $user['fd'];
            global $global_channel;
            $fds = $global_channel->peek();
            if (($key = array_search($user_with_some_nick_fd, $fds)) !== FALSE) {
                if($fds[$key] !== $fd) {
                    $ws->push($fd, (new LoginResponse(false, 'Choose another name!'))->getJson());
                    return;
                }
            }
        }
    }

    $users_table->set($fd, $row);

    $ws->push($fd, (new LoginResponse(true))->getJson());
}

$ws->on('open', function ($ws, $request) {
    global $global_channel;
    $fds = $global_channel->pop() ?? [];
    $fds[] = $request->fd;
    $global_channel->push($fds);

    global $messages_table;
    $messagesResponse = new MessagesReponse();
    $count = count($messages_table);
    for ($i = 0; $i < $count; $i++) {
        $username = $messages_table[$i]->value['username'];
        $message = $messages_table[$i]->value['message'];
        $messagesResponse->addMessage($username, $message);
    }
    $ws->push($request->fd, $messagesResponse->getJson());

    echo "client-{$request->fd} is connected\n";
});

$ws->on('message', function ($ws, $frame) {
    $data = json_decode($frame->data);
    switch ($data->type) {
        case 'login':
            login($frame->fd, $data->username);
            break;
        case 'message':
            addMessage($frame->fd, $data);
    }
});

$ws->on('close', function ($ws, $fd) {
    global $global_channel;
    $fds = $global_channel->pop() ?? [];
    if (($key = array_search($fd, $fds)) !== FALSE) {
        unset($fds[$key]);
    }
    $global_channel->push($fds);

    echo "client-{$fd} is closed\n";
});

$ws->start();