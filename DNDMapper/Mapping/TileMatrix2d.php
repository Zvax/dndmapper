<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Mapping;

class TileMatrix2d implements TileMatrix
{
    private $tiles;

    public function __construct(int $x, int $y)
    {
        $this->tiles = new \SplObjectStorage;
        for ($i = 0; $i !== $x; $i++) {
            for ($j = 0; $j !== $y; $j++) {
                $this->tiles[CoordinatesFactory::make($i, $j)] = new DefaultTile;
            }
        }
    }

    public function getTiles(): array
    {
        $values = [];
        /**
         * @var Coordinates $coordinates
         * @var Tile $value
         */
        foreach ($this->tiles as $coordinates) {
            [$x, $y] = $coordinates->getCoordinates();
            $values[$x][$y] = $this->tiles[$coordinates];
        }
        return $values;
    }

    private function validateOffsetType($offset): void
    {
        if (!($offset instanceof Coordinates)) {
            throw new \InvalidArgumentException('Tile matrix only accepts Coordinates as offset.');
        }
    }

    public function offsetExists($offset): bool
    {
        $this->validateOffsetType($offset);
        return isset($this->tiles[$offset]);
    }

    public function offsetGet($offset): Tile
    {
        $this->validateOffsetType($offset);
        return $this->tiles[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->validateOffsetType($offset);
        if (!isset($this->tiles[$offset])) {
            throw new \InvalidArgumentException('Trying to access out of bound tile.');
        }
        $this->tiles[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        $this->validateOffsetType($offset);
        unset($this->tiles[$offset]);
    }


}