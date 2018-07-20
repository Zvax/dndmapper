<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Mapping;

class Coordinates2d implements Coordinates
{
    private $x;
    private $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function distanceTo(Coordinates $coordinates)
    {

    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getCoordinates(): array
    {
        return [$this->x, $this->y];
    }


}