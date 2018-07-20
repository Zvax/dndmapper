<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Server\Handler;

use function Amp\call;
use Amp\Http\Server\Request;
use Amp\Http\Server\RequestHandler;
use Amp\Http\Server\Response;
use Amp\Http\Status;
use Amp\Promise;
use Templating\Renderer;

class NotFound implements RequestHandler
{
    private $renderer;

    public function __construct(Renderer $r)
    {
        $this->renderer = $r;
    }
    public function handleRequest(Request $request): Promise
    {
        return call(function() {
            $html = yield $this->renderer->render('not-found.twig.html');
            return new Response(
                Status::NOT_FOUND,
                ['content-type' => 'text/html; charset=utf-8'],
                $html
            );
        });
    }

}