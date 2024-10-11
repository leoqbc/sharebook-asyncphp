<?php

require __DIR__ . '/vendor/autoload.php';

use function Swoole\Coroutine\run;
use function Swoole\Coroutine\go;

//run(function () {
//    $url = 'https://slowcall.free.beeceptor.com/todos';
//    for($i = 3;$i--;) {
//        go(fn() => file_get_contents($url));
//    }
//});
run(function (){
    $url = 'https://slowcall.free.beeceptor.com/todos';
    go(function () {
        $result1 = file_get_contents('https://slowcall.free.beeceptor.com/todos');
        echo 'Rodou1';
    });

    go(function () {
        $result2 = file_get_contents('https://slowcall.free.beeceptor.com/todos');
        echo 'Rodou2';
    });

    go(function () {
        $result2 = file_get_contents('https://slowcall.free.beeceptor.com/todos');
        echo 'Rodou2';
    });

    go(function () {
        $result2 = file_get_contents('https://slowcall.free.beeceptor.com/todos');
        echo 'Rodou2';
    });
});


