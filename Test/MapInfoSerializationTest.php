<?php declare(strict_types=1);

namespace Zvax\DNDMapper;

use Mapping\DefaultTile;
use Mapping\Map;
use Mapping\TileMatrix2d;
use PHPUnit\Framework\TestCase;
use Service\Mapping;

class MapInfoSerializationTest extends TestCase
{
    public function test_map_returns_correctly_formatted_json(): void
    {
        $map = new Map(new TileMatrix2d(4, 4));
        $mapService = new Mapping;
        $json = $mapService->createMapJsonRepresentation($map);
        $shouldBe = [
            'tiles' => [
                [
                    new DefaultTile,
                    new DefaultTile,
                    new DefaultTile,
                    new DefaultTile,
                ],
                [
                    new DefaultTile,
                    new DefaultTile,
                    new DefaultTile,
                    new DefaultTile,
                ],
                [
                    new DefaultTile,
                    new DefaultTile,
                    new DefaultTile,
                    new DefaultTile,
                ],
                [
                    new DefaultTile,
                    new DefaultTile,
                    new DefaultTile,
                    new DefaultTile,
                ],
            ]
        ];
        $this->assertSame(json_encode($shouldBe), $json);
    }
}