<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Data\Query;

use Amp\Promise;
use System\Attributes;
use System\Character;
use System\CharacterClass;
use System\Race;
use function Amp\call;

class CharacterList
{

    public function execute(): Promise
    {
        return call(function () {
            return [
                (new Character)
                    ->setName('Elaktor')
                    ->setRace(new Race('Elf'))
                    ->setClass(new CharacterClass('Druid'))
                    ->setLevel(3)
                    ->setAttributes(new Attributes(14, 12, 15, 10, 13, 16)),
                (new Character)
                    ->setName('Khalessi')
                    ->setRace(new Race('Human'))
                    ->setClass(new CharacterClass('monk'))
                    ->setLevel(3)
                    ->setAttributes(new Attributes(14, 12, 15, 10, 13, 16)),
            ];
        });
    }

}