<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Client\View;

use Amp;
use Amp\Http;
use Amp\Http\Server;
use Templating;
use Zvax\DNDMapper\Data;
use Zvax\DNDMapper\Wiki\Hierarchy;

class Wiki implements View, Server\RequestHandler
{
    private $renderer;
    private $repository;

    public function __construct(Templating\Renderer $renderer, Data\Repository\Wiki $repository)
    {
        $this->renderer = $renderer;
        $this->repository = $repository;
    }

    public function handleRequest(Server\Request $request): Amp\Promise
    {
        $args = $request->getAttribute(Server\Router::class);

        if (array_key_exists('action', $args)) {
            return Amp\call(function() use ($args) {
                $action = $args['action'];
                $html = yield $this->renderer->render('sections/wiki-edit.twig.html');
                return new Server\Response(
                    Http\Status::OK,
                    ['content-type' => 'text/html, charset=utf-8'],
                    $html
                );
            });
        }

        return Amp\call(function() {
            $articles = new Hierarchy;
            $html = yield $this->renderer->render('sections/wiki.twig.html', [
                'hierarchy' => $this->repository->getAll(),
            ]);
            return new Server\Response(
                Http\Status::OK,
                ['content-type' => 'text/html, charset=utf-8'],
                $html
            );
        });
    }
}