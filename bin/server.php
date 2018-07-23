#!/usr/bin/php
<?php declare(strict_types=1);

namespace Zvax\DNDMapper;

use Amp;
use Amp\ByteStream\ResourceOutputStream;
use Amp\Http\Server;
use Monolog\Logger;
use function Amp\Socket\listen;

require __DIR__ . '/../vendor/autoload.php';

$injector = createInjector();

Amp\Loop::run(function () use ($injector) {
    $sockets = [
        listen('0.0.0.0:1337'),
        listen('[::]:1337'),
    ];

    $logHandler = new Amp\Log\StreamHandler(new ResourceOutputStream(\STDOUT));
    $logHandler->setFormatter(new Amp\Log\ConsoleFormatter);
    $logger = new Logger('server');
    $logger->pushHandler($logHandler);

    $router = new Server\Router();
    populateRouter($router, $injector);

    $server = new Server\Server(
        $sockets,
        $router,
        $logger
    );

    yield $server->start();

    /* SIGINT on 'nixes only?
    Loop::onSignal(SIGINT, function (string $watcherId) use ($server) {
        Loop::cancel($watcherId);
        yield $server->stop();
    });
    */
});
