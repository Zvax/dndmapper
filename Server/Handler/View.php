<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Server\Handler;

use Amp;
use Amp\Http\Server\Request;
use Amp\Http\Server\RequestHandler;
use Amp\Http\Server\Response;
use Amp\Http\Server\Router;
use Amp\Http\Status;
use Templating\Renderer;
use Zvax\DNDMapper\Client\View\Factory;

class View implements RequestHandler
{
    private $renderer;
    private $viewFactory;

    public function __construct(Renderer $renderer, Factory $viewFactory)
    {
        $this->renderer = $renderer;
        $this->viewFactory = $viewFactory;
    }

    public function handleRequest(Request $request): Amp\Promise
    {
        return Amp\call(function() use ($request) {
            $args = $request->getAttribute(Router::class);
            $section = $args['section'];
            $html = yield $this->renderer->render("sections/$section.twig.html");
            return new Response(
                Status::OK,
                ['content-type' => 'text/html, charset=utf-8'],
                $html
            );
        });
    }

}