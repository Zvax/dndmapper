<?php declare(strict_types=1);

namespace Zvax\DNDMapper;

use Amp;
use Amp\Http\Server;
use Amp\Http\Server\RequestHandler\CallableRequestHandler;
use Amp\Http\Server\StaticContent;
use Amp\Http\Server\Websocket;
use Amp\Http\Status;
use Amp\Postgres;
use Auryn;
use Controller\Home;
use Templating;
use Zvax\DNDMapper\Client\View;
use Zvax\DNDMapper\Data;
use Zvax\DNDMapper\Mapping;
use Zvax\DNDMapper\Server\Handler;
use Zvax\DNDMapper\Service;

function populateRouter(Server\Router $router, Auryn\Injector $injector): void
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
        ['GET', '/wiki[/{action}]', View\Wiki::class],
        ['GET', '/{fileName:.+\.(?:js|css|ico|xml|png|svg)}', StaticContent\DocumentRoot::class],
        ['GET', '/{section}', Handler\View::class],
        ['GET', '/{section}/{action}', Handler\Action::class],
        ['POST', '/{entity}[/{action}]', Handler\Command::class],
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
function createInjector(): Auryn\Injector
{
    $injector = (new Auryn\Injector())
        ->share(Data\Repository\Wiki::class)
        ->share(Data\Repository::class)
        ->share(Data\Command\CommandFactory::class)
        ->share(Data\Command\Wiki::class)
        ->delegate(Data\Command\Wiki::class, function(Auryn\Injector $injector) {
            return new Data\Command\Wiki($injector->make(Data\Repository\Wiki::class));
        })
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
        ->share(Postgres\Pool::class)
        ->delegate(View\Character::class, function (Auryn\Injector $injector) {
            $repository = $injector->make(Data\Repository\Character::class);
            $goblin = new class implements Data\Entity {
                public $name = 'Elaktor';
                public $level = 7;
                public $category = 'Goblinoid';
                public $race;
                public $statistics;

                public function __construct()
                {
                    $this->race = new class {
                        public $name = 'Elf';
                        public $description = 'Humanoid';
                        public $category = 'Humanoid';
                    };
                    $this->statistics = new class {
                        public $str = 12;
                        public $con = 27;
                        public $dex = 21;
                        public $int = 18;
                        public $wis = 9;
                        public $cha = 18;
                    };
                }
            };

            $repository->add($goblin);
            return new View\Character(
                $injector->make(Templating\Renderer::class),
                $injector->make(Data\Query\DBQueryBuilder::class),
                $repository
            );
        })
        ->delegate(StaticContent\DocumentRoot::class, function() {
            return new StaticContent\DocumentRoot(__DIR__ . '/../static');
        });
    $injector->share($injector);
    return $injector;
}
