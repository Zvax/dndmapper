<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Client\View;

use Amp\Promise;
use Templating\Renderer;

class GameSession implements View
{
    private $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function show(): Promise
    {
        return $this->renderer->render('sections/game-session.twig.html');
    }

}
