<?php declare(strict_types=1);

namespace Zvax\DNDMapper;

use Mapping\CoordinatesFactory;
use PHPUnit\Framework\TestCase;

class CoordinatesTest extends TestCase
{
    public function test_coordinates_sloppy_equivalence(): void
    {
        $coord1 = CoordinatesFactory::make(0, 0);
        $coord2 = CoordinatesFactory::make(0, 0);
        $this->assertSame($coord1, $coord2);
    }
}