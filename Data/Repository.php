<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Data;

interface Repository
{
    public function add($entity);
    public function getAll();
}