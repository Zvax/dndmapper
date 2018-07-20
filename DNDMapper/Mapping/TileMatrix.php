<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Mapping;

interface TileMatrix extends \ArrayAccess {
    public function getTiles(): array;
}