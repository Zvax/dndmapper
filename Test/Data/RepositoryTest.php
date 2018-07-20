<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Test\Data;

use PHPUnit\Framework\TestCase;
use Zvax\DNDMapper\Data\Command;
use Zvax\DNDMapper\Data\Repository;

class RepositoryTest extends TestCase
{
    public function test_post_request_adds_wiki_to_repo(): void
    {
        // TODO mock request to test the whole thing
    }

    public function test_create_command(): void
    {
        $repository = new Repository\Wiki();
        $command = new Command\Wiki($repository);
        $command->create();
    }
}
