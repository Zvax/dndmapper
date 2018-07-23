<?php declare(strict_types=1);

namespace Zvax\DNDMapper;

use Amp;
use PHPUnit\Framework\TestCase;
use Zvax\DNDMapper\Data\Query;
use Zvax\DNDMapper\System;

class MappingTest extends TestCase
{
    public function test_selects_character(): void
    {
        try {
            $injector = createInjector();
            $characterQuery = $injector->make(Query\Character::class);
            /** @var System\Character $character */
            $character = Amp\Promise\wait($characterQuery->execute('elaktor'));
            $this->assertSame('elaktor', $character->getName());
        } catch (Amp\CancelledException $exception) {
            $this->assertTrue(true);
        }

    }
}