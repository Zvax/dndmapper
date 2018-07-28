<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Data\Repository;

use Zvax\DNDMapper\Data;

class Wiki implements Data\Repository
{
    private $collection = [];

    public function add($entity): void
    {
        $this->collection[] = $entity;
    }

    public function getAll()
    {
        return $this->collection;
    }

    public function fetch(Data\Condition $condition)
    {
        throw new \Exception("unimplemented method fetch on wiki repository");
    }


}