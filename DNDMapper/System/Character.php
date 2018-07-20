<?php declare(strict_types=1);

namespace Zvax\DNDMapper\System;

class Character
{
    private $attributes;
    private $name = '';
    private $level = 1;
    private $race;
    private $class;

    public function __construct()
    {
        $this->attributes = new Attributes;
    }

    public function setAttributes(Attributes $attributes): Character
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function getAttributes(): Attributes
    {
        return $this->attributes;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Character
    {
        $this->name = $name;
        return $this;
    }

    public function getRace(): Race
    {
        return $this->race;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): Character
    {
        $this->level = $level;
        return $this;
    }

    public function setRace(Race $race): Character
    {
        $this->race = $race;
        return $this;
    }

    public function getClass(): CharacterClass
    {
        return $this->class;
    }

    public function setClass(CharacterClass $class): Character
    {
        $this->class = $class;
        return $this;
    }


}