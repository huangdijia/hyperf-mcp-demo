<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Swoole\Coroutine\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;

// 确保安装了 swoole 扩展
if (! extension_loaded('swoole')) {
    exit('Swoole extension not installed');
}

// 创建协程运行时
\Swoole\Coroutine\run(function () {
    $server = new Server('0.0.0.0', 9501);

    echo "HTTP server listening on http://0.0.0.0:9501\n";

    $server->handle('/', function (Request $request, Response $response) {
        \Swoole\Coroutine\go(function () use ($response) {
            while ($response->isWritable()) {
                var_dump($response);
                sleep(1);
            }

            var_dump('client disconnected');
        });
        $response->header('Content-Type', 'text/html; charset=utf-8');
        $response->write("<h1>Hello, Swoole!</h1>\n<p>Request path: {$request->server['request_uri']}</p>");

        sleep(100);
    });

    $server->start();
});
