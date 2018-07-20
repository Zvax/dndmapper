<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Server\Handler;

use Amp;
use Amp\Http\Server;
use Amp\Http\Status;
use Zvax\DNDMapper\Client\View;

class Action implements Server\RequestHandler
{

    private $viewFactory;

    public function __construct(View\Factory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
    }

    public function handleRequest(Server\Request $request): Amp\Promise
    {
        return Amp\call(function () use ($request) {
            $args = $request->getAttribute(Server\Router::class);
            $section = $args['section'];
            $action = $args['action'];
            $view = yield $this->invokeFactory($section);
            $html = yield $view->$action();
            return new Server\Response(
                Status::OK,
                ['content-type' => 'text/html, charset=utf-8'],
                $html
            );
        });
    }

    private function invokeFactory(string $section): Amp\Promise {
        return Amp\call(function() use($section) {
            return $this->viewFactory->make("Zvax\DNDMapper\Client\View\\$section");
        });
    }

}