<?php

require __DIR__ . '/vendor/autoload.php';

use function Swoole\Coroutine\run;
use function Swoole\Coroutine\go;

run(function () {

    $client = new \GuzzleHttp\Client();

    $filename = 'fotos.csv';

    $channel = new \Swoole\Coroutine\Channel(1);

    // zeramos o arquivo
    file_put_contents($filename, '');

    for ($i = 1;$i <= 100;$i++) {
        go( function() use ($client, $channel, $i) {
            $response = $client->request('GET', "https://jsonplaceholder.typicode.com/albums/$i/photos");

            /** @var object{url: string, title: string} $photo */
            $photos = json_decode($response->getBody());

            $channel->push($photos);
        });
    }

    go(function() use ($channel, $filename) {
        while ($photos = $channel->pop(2.0)) {
            foreach ($photos as $photo) {
                $row = "$photo->title,$photo->url\n";
                file_put_contents($filename, $row, FILE_APPEND);
                echo "Request $photo->url realizada e tratada\n";
            }
        }
    });
});