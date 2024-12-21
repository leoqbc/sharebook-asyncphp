<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Book;
use GuzzleHttp\Client;
use Hyperf\Coroutine\WaitGroup;
use Hyperf\DbConnection\Db;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

use function Hyperf\Coroutine\go;

#[Controller(prefix: "sharebook")]
class ApiController
{
    public function __construct(
        protected Client $client,
    ) {

    }
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        return $response->raw('Hello Hyperf!');
    }

    #[GetMapping(path: 'storebooks')]
    public function createUser(RequestInterface $request, ResponseInterface $response)
    {
        $wg = new WaitGroup();
        $client = $this->client;
        go(function () use ($client) {
            Db::table('books')->truncate();
            $booksResponse = $client->get('https://www.sharebook.com.br/api/Book/AvailableBooks');
            $books = json_decode($booksResponse->getBody()->getContents());

            foreach ($books as $book) {
                $bookModel = new Book([
                    'title' => $book->title,
                    'image' => $book->imageUrl,
                ]);
                $bookModel->save();
            }
        });

        go(function () use ($wg) {
            $wg->add();
            sleep(2);
            $book = Book::find(3);
            $book->delete();
            $wg->done();
        });

        $wg->wait();

        return $response->json([
            'message' => 'Books are being loaded'
        ]);
    }
}
