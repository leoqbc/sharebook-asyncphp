<?php
require __DIR__ . '/vendor/autoload.php';

use function Swoole\Coroutine\go;
use function Swoole\Coroutine\run;

run(function () {
    go(function () {
        sleep(2);
        file_put_contents('output', ' Mundo ', FILE_APPEND);
    });

    go(function () {
        sleep(1);
        file_put_contents('output', 'Olá ', FILE_APPEND);
    });
    echo 'Terminou' . PHP_EOL;
});
