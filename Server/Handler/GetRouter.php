<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Server\Handler;

use function Amp\call;
use Amp\Http\Server\Middleware;
use Amp\Http\Server\Request;
use Amp\Http\Server\RequestHandler;
use Amp\Promise;

class GetRouter implements Middleware
{
    public function handleRequest(Request $request, RequestHandler $next): Promise
    {
        return call(function () use ($request, $next) {

        });
    }

}