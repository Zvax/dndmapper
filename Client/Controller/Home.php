<?php declare(strict_types=1);

namespace Controller;

/*
 * This would generally be called as the landing controller of the application
 * from here, we should see the menus, a login form and default to a random article from the universe wiki
 */

use Amp\Http\Server\Request;
use Amp\Http\Server\RequestHandler;
use Amp\Http\Server\Response;
use Amp\Http\Status;
use Amp\Promise;
use function Amp\call;

class Home extends RenderingController implements RequestHandler
{
    public function handleRequest(Request $request): Promise
    {
        return call(function() {
            $html = yield $this->show();
            return new Response(
                Status::OK,
                ['content-type' => 'text/html; charset=utf-8'],
                $html
            );
        });
    }

    private function show(): Promise
    {
        return $this->renderer->render('content.twig.html', [
            'col_1' => 'home controller'
        ]);
    }
}
