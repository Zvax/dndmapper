<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Data\Repository;

use Amp;
use Zvax\DNDMapper\Data;

class Character implements Data\Repository
{
    private $entries;

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public function __construct()
    {
        $this->entries = new \SplObjectStorage;
    }

    public function add($entity): void
    {
        if ($this->entries->contains($entity)) {
            throw new \LogicException("Trying to add an entity that's already present.");
        }
        $this->entries->attach($entity);
    }

    public function get(): Amp\Promise
    {
        return Amp\call(function() {
            yield from $this->entries;
        });
    }
}