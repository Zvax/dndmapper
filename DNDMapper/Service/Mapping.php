<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Service;

use Zvax\DNDMapper\Mapping\Map;

class Mapping
{
    public function createMapJsonRepresentation(Map $map): string
    {
        $data = [
            'tiles' => $map->getTiles(),
        ];
        return json_encode($data);
    }
}