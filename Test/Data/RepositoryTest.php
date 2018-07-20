<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Test\Data;

use Amp;
use Amp\Http\Server;
use PHPUnit\Framework\TestCase;
use Zvax\DNDMapper\Data\Command;
use Zvax\DNDMapper\Data\Repository;

class RepositoryTest extends TestCase
{

    public function test_create_command(): void
    {
        $repository = new Repository\Wiki();
        $command = new Command\Wiki($repository);

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
