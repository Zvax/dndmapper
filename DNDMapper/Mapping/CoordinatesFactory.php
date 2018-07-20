<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Mapping;

class CoordinatesFactory
{
    private static $coordinates = [];
    public static function make(int $x, int $y, int $z = null): Coordinates  {
        if ($z === null) {
            if (!isset(self::$coordinates[$x][$y])) {
                self::$coordinates[$x][$y] = new Coordinates2d($x, $y);
            }
            return self::$coordinates[$x][$y];
        }
        if (!isset(self::$coordinates[$x][$y][$z])) {
            self::$coordinates[$x][$y] = new Coordinates3d($x, $y, $z);
        }
        return self::$coordinates[$x][$y][$z];
    }
}