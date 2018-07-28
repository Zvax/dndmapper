<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Client\View;

use Amp;
use Amp\Http\Server;
use Amp\Http\Status;
use League\Uri;
use Zvax\DNDMapper\Data;
use Templating;
use Zvax\DNDMapper\Data\Query;

class Character implements Server\RequestHandler
{
    private $renderer;
    private $queryBuilder;
    private $repository;

    public function __construct(
        Templating\Renderer $renderer,
        Query\DBQueryBuilder $queryBuilder,
        Data\Repository $repository
    )
    {
        $this->renderer = $renderer;
        $this->queryBuilder = $queryBuilder;
        $this->repository = $repository;
    }

    public function handleRequest(Server\Request $request): Amp\Promise
    {
        return Amp\call(function () use ($request) {
            $characters = yield $this->repository->getAll();
            $query = new Uri\Components\Query($request->getUri()->getQuery());
            $args = $request->getAttribute(Server\Router::class);
            $action = $query->getParam('action');
            $html = yield $this->dispatchRequestOptions($args, $characters, $action);
            return new Server\Response(
                Status::OK,
                ['content-type' => 'text/html; charset=utf8'],
                $html
            );
        });
    }

    private function dispatchRequestOptions($args, $characters, $action): Amp\Promise {
        return Amp\call(function() use($args, $characters, $action) {
            if (isset($args['character_name'])) {
                $character_name = $args['character_name'];
                $condition = new class implements Data\Condition {
                    public $name;
                };
                $condition->name = $character_name;
                $characterDetail = yield $this->repository->fetch($condition);
                return yield $this->renderer->render('components/entity.twig.html', [
                    'characters' => $characters,
                    'e' => $characterDetail,
                ]);
            }
            if ($action) {
                return yield $this->renderer->render('sections/character-creation-form.twig.html', [
                    'characters' => $characters,
                ]);
            }
            return yield $this->showCharacterList($characters);
        });
    }

    private function showCharacterList($characters): Amp\Promise
    {
        return Amp\call(function() use ($characters) {
            return yield $this->renderer->render('sections/character.twig.html', [
                'characters' => $characters,
            ]);
        });
    }


}