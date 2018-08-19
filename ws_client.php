// Test client
<?php
require './vendor/autoload.php';

$cli = new swoole_http_client('0.0.0.0', 9502);

$cli->on('message', function ($_cli, $frame) {
    print('Server send us: ' . $frame->data);
});

$cli->upgrade('/asd', function ($cli) {
    print_r($cli->body);
    $cli->push("hello world");
    $cli->push("how are you, websockets world?");
});