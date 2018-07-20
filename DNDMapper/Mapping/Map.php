<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Mapping;

/*
 * The map is the single entity created by a human when using the create map interface
 * It will also be used in visualization mode during a game session
 *
 * It features
 * - a size
 * - a matrix of all the possible tiles (limited by the size)
 *   a 12x12 map will have a matrix of 144 units, each of which can be linked with different things
 *   generally only one tile per unit (can't think of reason why not)
 * - api to replace tiles, add static things (walls, holes)
 * - api to link conditions to scripts
 *   - first character that enters a tile
 *   - ignite tile after 4 rounds
 *   - burn all undead entering the tile
 */
class Map
{
    private $tileMatrix;

    public function __construct(TileMatrix $tileMatrix)
    {
        $this->tileMatrix = $tileMatrix;
    }

    public function getTiles(): array
    {
        return $this->tileMatrix->getTiles();
    }
}
