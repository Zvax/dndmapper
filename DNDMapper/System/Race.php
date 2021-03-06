<?php declare(strict_types=1);

namespace Zvax\DNDMapper\System;

class Race
{
    private $descriptor;

    public function __construct(string $descriptor)
    {
        $this->descriptor = $descriptor;
    }

    public function getDescriptor(): string
    {
        return $this->descriptor;
    }

}