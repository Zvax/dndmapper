<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Server\Handler;

use Amp;
use Amp\Http;
use Amp\Http\Server;
use League\Uri;

class Get implements Server\Middleware
{
    /*
     * unpack request query string
     * put it into request?
     * (try to) get next's response
     * return it
     */
    public function handleRequest(Server\Request $request, Server\RequestHandler $next): Amp\Promise
    {
        return Amp\call(function () use ($request, $next) {
            yield $this->populate_request($request);
            return yield $next->handleRequest($request);
        });
    }

    private function populate_request(Server\Request $request): Amp\Promise
    {
        return Amp\call(function () use ($request) {
            $query = new Uri\Components\Query($request->getUri()->getQuery());
            $query_params = $query->getParams();
            $args = $request->getAttribute(Server\Router::class);
            foreach (array_merge($query_params, $args) as $arg => $value) {
                $request->setAttribute($arg, $value);
            }
        });
    }

}