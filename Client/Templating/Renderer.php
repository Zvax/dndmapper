<?php declare(strict_types=1);

namespace Templating;

use Amp\Promise;

interface Renderer
{
    public function render(string $template, array $values = []): Promise;
}