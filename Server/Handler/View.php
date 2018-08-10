<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Server\Handler;

use Amp;
use Amp\Http;
use Amp\Http\Server;
use Auryn;
use Templating\Renderer;

class View implements Server\RequestHandler
{
    private $renderer;
    private $injector;

    public function __construct(Renderer $renderer, Auryn\Injector $injector)
    {
        $this->renderer = $renderer;
        $this->injector = $injector;
    }

    public function handleRequest(Server\Request $request): Amp\Promise
    {
        return Amp\call(function() use ($request) {
            $args = $request->getAttribute(Server\Router::class);
            $section = $args['section'];
            $html = yield $this->renderer->render("sections/$section.twig.html");
            return new Server\Response(
                Http\Status::OK,
                ['content-type' => 'text/html, charset=utf-8'],
                $html
            );
        });
    }

}