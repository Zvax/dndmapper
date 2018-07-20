<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Client\View;

use Amp;
use Amp\Http;
use Amp\Http\Server;
use Templating;
use Zvax\DNDMapper\Wiki\Hierarchy;

class Wiki implements View, Server\RequestHandler
{
    private $renderer;

    public function __construct(Templating\Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function handleRequest(Server\Request $request): Amp\Promise
    {
        return Amp\call(function() use ($request) {
            $articles = new Hierarchy;
            $html = yield $this->renderer->render('sections/wiki.twig.html', [
                'hierarchy' => $articles->getElements(),
            ]);
            return new Server\Response(
                Http\Status::OK,
                ['content-type' => 'text/html, charset=utf-8'],
                $html
            );
        });
    }


    public function create(): Amp\Promise
    {
        return Amp\call(function () {
            return yield $this->renderer->render('sections/wiki-edit.twig.html');
        });
    }
}