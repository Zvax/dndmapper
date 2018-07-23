<?php declare(strict_types=1);

namespace Zvax\DNDMapper\System;

use Zvax\DNDMapper\System\Action\RequirementCollection;

abstract class Action
{
    protected $name;
    protected $actionType;
    protected $requirements;
    protected $origin;
    protected $target;

    public function __construct(
        string $name,
        ActionType $actionType,
        RequirementCollection $requirements
    )
    {
        $this->name = $name;
        $this->actionType = $actionType;
        $this->requirements = $requirements;
    }

    public function validate($origin, $target)
    {

    }
}
