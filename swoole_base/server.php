<?php

use Swoole\Http\Request;
use Swoole\Http\Response;

$server = new Swoole\Http\Server('0.0.0.0', 9501, SWOOLE_PROCESS, SWOOLE_SOCK_TCP);

$server->set([
    'worker_num' => 4
]);

$server->on(Swoole\Constant::EVENT_REQUEST, function(Request $request, Response $response) {
    $response->header('Content-Type', 'application/json');
    $response->end('{ "message": "Hello World" }');
});

$server->start();