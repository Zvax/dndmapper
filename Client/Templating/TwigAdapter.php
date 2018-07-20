<?php declare(strict_types=1);

namespace Templating;

use function Amp\call;
use Amp\Promise;

class TwigAdapter implements Renderer {
    private $twigEnvironment;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twigEnvironment = $twig;
    }

    public function render(string $template, array $values = []): Promise
    {
        return call(function () use ($template, $values) {
            return $this->twigEnvironment->render($template, $values);
        });
    }
}