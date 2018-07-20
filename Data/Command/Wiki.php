<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Data\Command;

use Amp;
use Amp\Http\Server;
use Zvax\DNDMapper;
use Zvax\DNDMapper\Data;

class Wiki
{
    private $repository;

    public function __construct(Data\Repository $repository)
    {
        $this->repository = $repository;
    }

    public function create(Server\Request $request, Server\FormParser\Form $form): Amp\Promise
    {
        return Amp\call(function() use ($request, $form) {
            // /** @var Server\FormParser\Form $form */
            // $form = yield Server\FormParser\parseForm($request);

            /** @var Server\FormParser\Field $title */
            $title = $form->getField('title');

            /** @var Server\FormParser\Field $text */
            $text = $form->getField('text');

            $article = new DNDMapper\Wiki\Article($title->getValue(), $text->getValue());
            $this->repository->add($article);
            return Data\Command::STATUS_OK;
        });
    }
}