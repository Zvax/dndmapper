<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Data;

use Zvax\DNDMapper\Data;

interface Repository
{
    public function add($entity);
    public function getAll();
    public function fetch(Data\Condition $condition);
}