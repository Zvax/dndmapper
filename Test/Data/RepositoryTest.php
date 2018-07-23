<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Test\Data;

use Amp;
use Amp\Http\Server;
use PHPUnit\Framework\TestCase;
use Zvax\DNDMapper;
use Zvax\DNDMapper\Data;

class RepositoryTest extends TestCase
{

    public function test_create_command(): void
    {
        $injector = DNDMapper\createInjector();
        $repository = $injector->make(Data\Repository\Wiki::class);
        $command = $injector->make(Data\Command\Wiki::class);

        $form = new Server\FormParser\Form([
            'title' => [new Server\FormParser\Field('title', 'title-value')],
            'text' => [new Server\FormParser\Field('text', 'text-value')],
        ]);
        Amp\Promise\wait($command->create($form));

        $articles = $repository->getAll();

        $this->assertCount(1, $articles);
        $this->assertSame('title-value', $articles[0]->getTitle());
    }
}
