<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Server\Handler;

use Amp;
use Amp\Http;
use Amp\Http\Server;
use Amp\Http\Server\Request;
use Amp\Http\Server\RequestHandler;



class ExceptionMiddleware implements Server\Middleware
{
    public function handleRequest(Request $request, RequestHandler $next): Amp\Promise
    {
        return Amp\call(function() use ($request, $next) {
            try {
                $response = yield $next->handleRequest($request);
            } catch (\Exception $exception) {
                $response = new Server\Response(
                    Http\Status::INTERNAL_SERVER_ERROR,
                    ['content-type', 'text/html'],
                    $exception->getMessage()
                );
            }
            return $response;
        });
    }

}