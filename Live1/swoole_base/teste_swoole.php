<?php

use function Swoole\Coroutine\run;
use function Swoole\Coroutine\go;

run(function () {
    go(function () {
        sleep(2);
        echo 'hello ';
    });

    go(function () {
        sleep(1);
        echo 'world!';
    });
});