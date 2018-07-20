<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Mapping;

class Coordinates3d implements Coordinates
{
    private $x;
    private $y;
    private $z;

    public function __construct(int $x, int $y, int $z)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    public function distanceTo(Coordinates $coordinates)
    {
        // TODO: Implement distanceTo() method.
    }

    public function getCoordinates(): array
    {
        return [$this->x, $this->y, $this->z];
    }

}