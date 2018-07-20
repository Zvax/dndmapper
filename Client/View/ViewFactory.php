<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Client\View;

use Templating\Renderer;

class ViewFactory implements Factory
{
    private $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function make(string $type): View
    {
        return new $type($this->renderer);
    }

}