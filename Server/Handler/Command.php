<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Server\Handler;

use Amp;
use Amp\Http;
use Amp\Http\Server;
use Zvax\DNDMapper\Data;

class Command implements Server\RequestHandler
{
    private $commandFactory;

    public function __construct(Data\Command\CommandFactory $commandFactory)
    {
        $this->commandFactory = $commandFactory;
    }

    public function handleRequest(Server\Request $request): Amp\Promise
    {
        /*
         * this handles the request for a "command", that is, act on the data
         * we assume that there is always an entity being constructed
         * so first verify that the entity named in the route is buildable from the form
         */
        return Amp\call(function() use ($request) {

            $args = $request->getAttribute(Server\Router::class);

            $entity = $args['entity'];
            $action = $args['action'];

            $command = yield $this->commandFactory->make($entity);
            $form = yield Server\FormParser\parseForm($request);

            $commandResult = yield $command->$action($request, $form);

            if ($commandResult === Data\Command::STATUS_OK) {
                return new Server\Response(
                    Http\Status::OK,
                    ['content-type' => 'text/html, charset=utf-8'],
                    'the command was successful'
                );
            }

            return new Server\Response(
                Http\Status::OK,
                ['content-type' => 'text/html, charset=utf-8'],
                'we could not execute the command'
            );

        });
    }
}