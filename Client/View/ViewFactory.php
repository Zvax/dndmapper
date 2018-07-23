<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Client\View;

use Auryn;

class ViewFactory implements Factory
{
    private $injector;

    public function __construct(Auryn\Injector $injector)
    {
        $this->injector = $injector;
    }

    public function make(string $type): View
    {
        return $this->injector->make($type);
    }

}