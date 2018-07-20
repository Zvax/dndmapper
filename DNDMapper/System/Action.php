<?php declare(strict_types=1);

namespace Zvax\DNDMapper\System;

interface Action
{
    public function __construct(
        $name,
        ActionType $actionType
    );
}
