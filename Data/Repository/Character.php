<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Data\Repository;

use Amp;
use Zvax\DNDMapper\Data;

class Character implements Data\Repository
{
    private $entries;

    public function getAll(): Amp\Promise
    {
        return Amp\call(function () {
            return iterator_to_array($this->entries);
        });
    }

    public function __construct(array $entries = [])
    {
        $this->entries = new \SplObjectStorage;
        foreach ($entries as $character) {
            $this->add($character);
        }
    }

    public function add($entity): void
    {
        if ($this->entries->contains($entity)) {
            throw new \LogicException("Trying to add an entity that's already present.");
        }
        $this->entries->attach($entity);
    }

    public function fetch(Data\Condition $condition): Amp\Promise
    {
        return Amp\call(function () use ($condition) {
            if (isset($condition->name)) {
                return yield $this->find_entity_by_name($condition->name);
            }
            throw new \InvalidArgumentException("No valid search schemas found for " . self::class . ".");
        });
    }

    private function find_entity_by_name($entity_name): Amp\Promise
    {
        return Amp\call(function () use ($entity_name) {
            foreach ($this->entries as $entity) {
                if ($entity_name === $entity->name) {
                    return $entity;
                }
            }
            throw new \InvalidArgumentException();
        });
    }


}