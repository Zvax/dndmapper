<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Data\Query;

use Amp\Postgres\Executor;

class DBQueryBuilder implements QueryBuilder
{
    private $executor;

    public function __construct(Executor $executor)
    {
        $this->executor = $executor;
    }

    public function make(string $type)
    {
        return new $type($this->executor);
    }

}