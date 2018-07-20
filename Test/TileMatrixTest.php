<?php declare(strict_types=1);

namespace Zvax\DNDMapper;

use Mapping\CoordinatesFactory;
use Mapping\DefaultTile;
use Mapping\TileMatrix2d;
use PHPUnit\Framework\TestCase;

class TileMatrixTest extends TestCase
{
    public function test_out_of_bound_access(): void
    {
        $matrix = new TileMatrix2d(12, 12);
        $matrix[CoordinatesFactory::make(0, 0)] = new DefaultTile;
        $matrix[CoordinatesFactory::make(11, 11)] = new DefaultTile;
        $this->expectException(\InvalidArgumentException::class);
        $matrix[CoordinatesFactory::make(11, 12)] = new DefaultTile;
        $matrix[CoordinatesFactory::make(12, 11)] = new DefaultTile;
    }
}