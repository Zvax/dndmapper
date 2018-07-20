<?php declare(strict_types=1);

namespace Zvax\DNDMapper;

use PHPUnit\Framework\TestCase;
use Zvax\DNDMapper\Mapping;
use Zvax\DNDMapper\Service;

class MapInfoSerializationTest extends TestCase
{
    public function test_map_returns_correctly_formatted_json(): void
    {
        $map = new Mapping\Map(new Mapping\TileMatrix2d(4, 4));
        $mapService = new Service\Mapping;
        $json = $mapService->createMapJsonRepresentation($map);
        $shouldBe = [
            'tiles' => [
                [
                    new Mapping\DefaultTile,
                    new Mapping\DefaultTile,
                    new Mapping\DefaultTile,
                    new Mapping\DefaultTile,
                ],
                [
                    new Mapping\DefaultTile,
                    new Mapping\DefaultTile,
                    new Mapping\DefaultTile,
                    new Mapping\DefaultTile,
                ],
                [
                    new Mapping\DefaultTile,
                    new Mapping\DefaultTile,
                    new Mapping\DefaultTile,
                    new Mapping\DefaultTile,
                ],
                [
                    new Mapping\DefaultTile,
                    new Mapping\DefaultTile,
                    new Mapping\DefaultTile,
                    new Mapping\DefaultTile,
                ],
            ]
        ];
        $this->assertSame(json_encode($shouldBe), $json);
    }
}