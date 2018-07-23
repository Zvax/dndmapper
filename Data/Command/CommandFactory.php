<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Data\Command;

use Amp;
use Auryn;

class CommandFactory
{
    private $injector;

    public function __construct(Auryn\Injector $injector)
    {
        $this->injector = $injector;
    }

    public function make(string $type): Amp\Promise
    {
        return Amp\call(function () use ($type) {
            $className = ucfirst($type);
            $fullClassName = "\Zvax\DNDMapper\Data\Command\\$className";
            return $this->injector->make($fullClassName);
        });
    }
}