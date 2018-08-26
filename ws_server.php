<?php
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
    $ws->push($fd, json_encode(['type' => 'login', 'login_result' => false, 'message' => 'unauthorized']));
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
    $messages_table->set($count + 1, $row);

    $messages[] = ['username' => $username, 'message' => $data->message];

    global $global_channel;
    $fds = $global_channel->peek() ?? [];

    global $ws;
    foreach ($fds as $fd) {
        $ws->push($fd, json_encode(['type' => 'messages', 'messages' => $messages]));
    }
}

function login(int $fd, $username)
{
    global $ws;
    if(empty($username)) {
        $ws->push($fd, json_encode(['type' => 'login', 'login_result' => false, 'message' => 'username cannot be empty']));
    }
    global $users_table;
    $row = ['fd' => $fd, 'username' => $username];
    $users_table->set($fd, $row);

    $ws->push($fd, json_encode(['type' => 'login', 'login_result' => true]));
}

$ws->on('open', function ($ws, $request) {
    global $global_channel;
    $fds = $global_channel->pop() ?? [];
    $fds[] = $request->fd;
    $global_channel->push($fds);

    global $messages_table;
    $messages = [];
    foreach ($messages_table as $row) {
        $messages[] = $row;
    }

    $ws->push($request->fd, json_encode(['type' => 'messages', 'messages' => $messages]));

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