<?php declare(strict_types=1);

namespace Controller;

use Templating\Renderer;

abstract class RenderingController
{
    protected $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }
}
