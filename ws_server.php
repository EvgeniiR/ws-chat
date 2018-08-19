<?php
$ws = new swoole_websocket_server('0.0.0.0', 9502);
$messages_table = new swoole_table(5000);
$messages_table->column('fd', swoole_table::TYPE_INT, 5);
$messages_table->column('message', swoole_table::TYPE_STRING, 250);
$messages_table->create();

$global_channel = new swoole_channel(1000);

$ws->on('open', function ($ws, $request) {
    global $global_channel;
    $fds = $global_channel->pop() ?? [];
    $fds[] = $request->fd;
    $global_channel->push($fds);

    global $messages_table;
    $messages = [];
    foreach($messages_table as $row)
    {
        $messages[] = $row;
    }

    $ws->push($request->fd, json_encode(['messages' => $messages]));

    echo "client-{$request->fd} is connected\n";
});

$ws->on('message', function ($ws, $frame) {
    print('message: ' . $frame->data);

    global $messages_table;
    $count = count($messages_table);
    $row = ['fd' => $frame->fd, 'message' => $frame->data];
    $messages_table->set($count + 1, $row);

    $messages[] = ['fd' => $frame->fd, 'message' => $frame->data];

    global $global_channel;
    $fds = $global_channel->peek() ?? [];
    foreach ($fds as $fd) {
        $ws->push($fd, json_encode(['messages' => $messages]));
    }
});

$ws->on('close', function ($ws, $fd) {
    global $global_channel;
    $fds = $global_channel->pop() ?? [];
    if(($key = array_search($fd, $fds)) !== FALSE){
	     unset($fds[$key]);
	}
    $global_channel->push($fds);

    echo "client-{$fd} is closed\n";
});

$ws->start();