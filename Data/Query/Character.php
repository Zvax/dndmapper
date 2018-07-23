<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Data\Query;

use Amp;
use Amp\Postgres;
use Zvax\DNDMapper\System;

class Character
{
    private $executor;

    public function __construct(Postgres\Executor $executor)
    {
        $this->executor = $executor;
    }

    public function execute(string $characterName): Amp\Promise
    {
        return Amp\call(function() use ($characterName) {
            /** @var Postgres\Statement $stmt */
            $stmt = yield $this->executor->prepare('select * from character where name = :name');
            /** @var Postgres\ResultSet $result */
            $result = yield $stmt->execute(['name' => $characterName]);
            while (yield $result->advance()) {
                $row = $result->getCurrent();
                return (new System\Character)->setName($row['name']);
            }
            return false;
        });
    }
}