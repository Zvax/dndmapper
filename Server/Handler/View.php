<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Server\Handler;

use Amp;
use Amp\Http\Server;
use Amp\Http;
use Templating\Renderer;
use Zvax\DNDMapper\Client\View\Factory;

class View implements Server\RequestHandler
{
    private $renderer;
    private $viewFactory;

    public function __construct(Renderer $renderer, Factory $viewFactory)
    {
        $this->renderer = $renderer;
        $this->viewFactory = $viewFactory;
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