<?php declare(strict_types=1);

namespace Zvax\DNDMapper;

use Amp\Postgres\Executor;
use Amp\Postgres\Pool;
use PHPUnit\Framework\TestCase;
use Query\Character;

class MappingTest extends TestCase
{
    public function test_selects_character(): void
    {
        $injector = createInjector();
        $characterQuery = $injector->make(Character::class);
        $character = $characterQuery->execute('elaktor');

    }
}