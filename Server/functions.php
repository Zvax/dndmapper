<?php declare(strict_types=1);

namespace Zvax\DNDMapper;

use Amp;
use Amp\Http\Server;
use Amp\Http\Server\RequestHandler\CallableRequestHandler;
use Amp\Http\Server\StaticContent;
use Amp\Http\Server\Websocket;
use Amp\Http\Status;
use Amp\Postgres;
use Auryn\Injector;
use Controller\Home;
use Templating;
use Zvax\DNDMapper\Client\View;
use Zvax\DNDMapper\Mapping;
use Zvax\DNDMapper\Server\Handler;
use Zvax\DNDMapper\Service;

function populateRouter(Server\Router $router, Injector $injector): void
{

    $websocket = new Websocket\Websocket(new class implements Websocket\Application
    {
        /** @var Websocket\Endpoint */
        private $endpoint;
        private $watcher;

        public function onStart(Websocket\Endpoint $endpoint): void
        {
            $this->endpoint = $endpoint;
            $this->watcher = Amp\Loop::repeat(10000, function () {

            });
        }

        public function onHandshake(Server\Request $request, Server\Response $response)
        {
            if ($request->getHeader('origin') !== 'http://localhost:1337') {
                $response->setStatus(403);
            }
            return $response;
        }

        public function onOpen(int $clientId, Server\Request $request): void
        {

        }

        public function onData(int $clientId, Websocket\Message $message)
        {
            $text = yield $message->read();
            $this->endpoint->broadcast($text);
        }

        public function onClose(int $clientId, int $code, string $reason): void
        {
        }

        public function onStop(): void
        {
            Amp\Loop::cancel($this->watcher);
        }

    });

    $router->addRoute('GET', '/live', $websocket);

    $router->addRoute('GET', '/tiles', new CallableRequestHandler(function () {
        $tileMatrix = new Mapping\TileMatrix2d(4, 4);
        $tileMatrix[Mapping\CoordinatesFactory::make(0, 0)] = new Mapping\ForestTile;
        $map = new Mapping\Map($tileMatrix);
        $mappingService = new Service\Mapping();
        return new Server\Response(
            Status::OK,
            ['content-type' => 'application/json'],
            $mappingService->createMapJsonRepresentation($map)
        );
    }));

    foreach (getRoutes() as $route) {
        [$method, $path, $handler] = $route;
        $router->addRoute($method, $path, $injector->make($handler));
    }

    $notFoundHandler = $injector->make(Handler\NotFound::class);
    $router->setFallback($notFoundHandler);
}

function getRoutes(): array
{
    return [
        ['GET', '/', Home::class],
        ['GET', '/character[/{character_name}]', View\Character::class],
        ['GET', '/wiki', View\Wiki::class],
        ['GET', '/{fileName:.+\.(?:js|css|ico|xml|png|svg)}', new StaticContent\DocumentRoot(__DIR__ . '/../static/')],
        ['GET', '/{section:[^/]+(?<!\.ico)$}', Handler\View::class],
        ['GET', '/{section:[^/]+(?<!\.ico)$}/{action}', Handler\Action::class],
        ['POST', '/{entity:[^/]+(?<!\.ico)$}[/{action}]', Handler\Command::class],
    ];
}

function createTwigTemplatingEngine(): \Twig_Environment
{
    $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../templates');
    $twig = new \Twig_Environment($loader, [
        //'cache' => __DIR__ . '/../Data/cache',
        'autoescape' => 'html',
    ]);
    $twig->addGlobal('menus', generateMenus());
    $twig->addGlobal('title', 'dndmapper');
    return $twig;
}

/** @throws */
function createInjector(): Injector
{
    $injector = (new Injector)
        ->alias(View\Factory::class, View\ViewFactory::class)
        ->delegate(\Twig_Environment::class, 'Zvax\DNDMapper\createTwigTemplatingEngine')
        ->alias(Templating\Renderer::class, Templating\TwigAdapter::class)
        ->share(Templating\Renderer::class)
        ->delegate(Postgres\Pool::class, function (): Postgres\Pool {
            $config = require __DIR__ . '/../config.php';
            return Postgres\pool($config['DSN'], 100);
        })
        ->alias(Postgres\Executor::class, Postgres\Pool::class)
        ->alias(Postgres\Link::class, Postgres\Pool::class)
        ->share(Postgres\Pool::class);
    return $injector;
}
