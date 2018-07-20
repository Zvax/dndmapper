<?php declare(strict_types=1);

namespace Zvax\DNDMapper;

use Zvax\DNDMapper\Mapping;
use PHPUnit\Framework\TestCase;

class CoordinatesTest extends TestCase
{
    public function test_coordinates_sloppy_equivalence(): void
    {
        $coord1 = Mapping\CoordinatesFactory::make(0, 0);
        $coord2 = Mapping\CoordinatesFactory::make(0, 0);
        $this->assertSame($coord1, $coord2);
    }
}