<?php declare(strict_types=1);

namespace Zvax\DNDMapper;

use Amp\ByteStream\ResourceOutputStream;
use Amp\Http\Server;
use Amp\Log;
use Amp\Loop;
use Monolog\Logger;
use function Amp\Socket\listen;

require __DIR__ . '/../vendor/autoload.php';

Loop::run(function () {
    $sockets = [
        listen('0.0.0.0:1337'),
        listen('[::]:1337'),
    ];

    $logHandler = new Log\StreamHandler(new ResourceOutputStream(\STDOUT));
    $logHandler->setFormatter(new Log\ConsoleFormatter);
    $logger = new Logger('server');
    $logger->pushHandler($logHandler);

    $injector = createInjector();
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
