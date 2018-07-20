<?php declare(strict_types=1);

namespace Zvax\DNDMapper\System;

class Attributes
{
    private $strength;
    private $dexterity;
    private $constitution;
    private $intelligence;
    private $wisdom;
    private $charisma;

    public function __construct(
        int $str = 10,
        int $dex = 10,
        int $con = 10,
        int $int = 10,
        int $wis = 10,
        int $cha = 10
    )
    {
        $this->strength = $str;
        $this->dexterity = $dex;
        $this->constitution = $con;
        $this->intelligence = $int;
        $this->wisdom = $wis;
        $this->charisma = $cha;
    }

    public function getStrength(): int
    {
        return $this->strength;
    }

    public function getDexterity(): int
    {
        return $this->dexterity;
    }

    public function getConstitution(): int
    {
        return $this->constitution;
    }

    public function getIntelligence(): int
    {
        return $this->intelligence;
    }

    public function getWisdom(): int
    {
        return $this->wisdom;
    }

    public function getCharisma(): int
    {
        return $this->charisma;
    }

}