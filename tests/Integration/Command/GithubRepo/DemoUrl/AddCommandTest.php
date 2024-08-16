<?php

declare(strict_types=1);

namespace App\Tests\Integration\Command\GithubRepo\DemoUrl;

use App\Command\GithubRepo\DemoUrl\AddCommand;
use App\Enum\Command\Argument;
use App\Tests\Integration\Command\AbstractCommandTestCase;

final class AddCommandTest extends AbstractCommandTestCase
{
    public function testExecute(): void
    {
        self::assertCount(2, $this->githubRepoRepository->findAll());

        $commandTester = $this->getCommandTester(AddCommand::class);
        $commandTester->execute([
            Argument::RepoName->value => 'name1',
            Argument::DemoUrl->value => 'https://new_demo.name',
        ]);
        $commandTester->assertCommandIsSuccessful();

        $repo = $this->githubRepoRepository->findOneByName('name1');
        self::assertNotNull($repo);
        self::assertEquals('https://new_demo.name', $repo->getDemoUrl());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures();
    }
}
