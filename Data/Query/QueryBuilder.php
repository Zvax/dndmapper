<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Data\Query;

interface QueryBuilder
{
    public function make(string $type);
}