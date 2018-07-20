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

    public function create(Server\FormParser\Form $form): Amp\Promise
    {
        return Amp\call(function() use ($form) {

            if ($form->hasField('title') && $form->hasField('text')) {
                $title = $form->getField('title');
                $text = $form->getField('text');

                $article = new DNDMapper\Wiki\Article($title->getValue(), $text->getValue());
                $this->repository->add($article);
                return Data\Command::STATUS_OK;
            }
            throw new \InvalidArgumentException('Submitted form does not have required fields.');
        });
    }
}