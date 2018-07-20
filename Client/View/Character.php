<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Client\View;

use Amp;
use Amp\Http\Server;
use Amp\Http\Status;
use League\Uri;
use Zvax\DNDMapper\Data\Repository;
use Templating;
use Zvax\DNDMapper\Data\Query;

class Character implements Server\RequestHandler
{
    private $renderer;
    private $queryBuilder;
    private $repository;

    public function __construct(
        Templating\Renderer $r,
        Query\DBQueryBuilder $queryBuilder,
        Repository\Character $repository
    )
    {
        $this->renderer = $r;
        $this->queryBuilder = $queryBuilder;
        $this->repository = $repository;
    }

    public function handleRequest(Server\Request $request): Amp\Promise
    {
        return Amp\call(function () use ($request) {
            $characters = yield $this->repository->get();
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
                $characterName = $args['character_name'];
                /** @var Query\Character $fetchCharacterByName */
                $fetchCharacterByName = $this->queryBuilder->make(Query\Character::class);
                $characterDetail = yield $fetchCharacterByName->execute($characterName);
                return yield $this->renderer->render('sections/character-detail.twig.html', [
                    'characters' => $characters,
                    'character' => $characterDetail,
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