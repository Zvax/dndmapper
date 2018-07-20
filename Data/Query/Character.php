<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Data\Query;

use Amp\Postgres\Executor;
use Amp\Postgres\ResultSet;
use Amp\Postgres\Statement;
use Amp\Promise;
use function Amp\call;

class Character
{
    private $executor;

    public function __construct(Executor $executor)
    {
        $this->executor = $executor;
    }

    public function execute(string $characterName): Promise
    {
        return call(function() use ($characterName) {
            /** @var Statement $stmt */
            $stmt = yield $this->executor->prepare('select * from character where name = :name');
            /** @var ResultSet $result */
            $result = yield $stmt->execute(['name' => $characterName]);
            while (yield $result->advance()) {
                $row = $result->getCurrent();
                return (new \System\Character)->setName($row['name']);
            }
        });
    }
}