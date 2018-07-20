<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Data\Command;

use Amp;

class CommandFactory
{
    public function make(string $type): Amp\Promise
    {
        return Amp\call(function () use ($type) {
            $className = ucfirst($type);
            $fullClassName = "\Zvax\DNDMapper\Data\Command\\$className";
            $repositoryClassName = "\Zvax\DNDMapper\Data\Repository\\$className";
            return new $fullClassName(new $repositoryClassName());
        });
    }
}