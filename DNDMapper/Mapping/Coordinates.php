<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Mapping;

interface Coordinates {
    public function distanceTo(Coordinates $coordinates);
    public function getCoordinates(): array;
}