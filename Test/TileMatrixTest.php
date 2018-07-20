<?php declare(strict_types=1);

namespace Zvax\DNDMapper;

use Zvax\DNDMapper\Mapping;
use PHPUnit\Framework\TestCase;

class TileMatrixTest extends TestCase
{
    public function test_out_of_bound_access(): void
    {
        $matrix = new Mapping\TileMatrix2d(12, 12);
        $matrix[Mapping\CoordinatesFactory::make(0, 0)] = new Mapping\DefaultTile;
        $matrix[Mapping\CoordinatesFactory::make(11, 11)] = new Mapping\DefaultTile;
        $this->expectException(\InvalidArgumentException::class);
        $matrix[Mapping\CoordinatesFactory::make(11, 12)] = new Mapping\DefaultTile;
        $matrix[Mapping\CoordinatesFactory::make(12, 11)] = new Mapping\DefaultTile;
    }
}