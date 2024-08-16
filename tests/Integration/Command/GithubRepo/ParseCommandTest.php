<?php

declare(strict_types=1);

namespace App\Tests\Integration\Command\GithubRepo;

use App\Command\GithubRepo\ParseCommand;
use App\Entity\GithubRepo;
use App\Enum\Language;
use App\Repository\GithubRepoRepository;
use App\Tests\Integration\Command\AbstractCommandTestCase;
use DateTimeImmutable;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\JsonMockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ParseCommandTest extends AbstractCommandTestCase
{
    private readonly MockHttpClient $client;

    public function testExecuteWithCreate(): void
    {
        $responses = [
            new JsonMockResponse(
                [
                    [
                        'id'          => 100,
                        'created_at'  => '2022-03-02T13:57:22Z',
                        'updated_at'  => '2022-04-02T13:57:22Z',
                        'clone_url'   => 'https://github.com/TemKaa1337/repo1.git',
                        'name'        => 'name1',
                        'description' => 'description1',
                        'html_url'    => 'https://github.com/TemKaa1337/repo1',
                        'language'    => 'PHP',
                    ],
                    [
                        'id'          => 200,
                        'created_at'  => '2022-03-01T13:57:22Z',
                        'updated_at'  => '2022-04-01T13:57:22Z',
                        'clone_url'   => 'https://github.com/TemKaa1337/repo2.git',
                        'name'        => 'name2',
                        'description' => 'description2',
                        'html_url'    => 'https://github.com/TemKaa1337/repo2',
                        'language'    => 'JavaScript',
                    ],
                ],
            ),
        ];

        $this->client->setResponseFactory($responses);

        $this->purgeTable();

        $repos = $this->githubRepoRepository->findAll();
        self::assertEmpty($repos);

        $commandTester = $this->getCommandTester(ParseCommand::class);
        $commandTester->execute([]);
        $commandTester->assertCommandIsSuccessful();

        /** @var GithubRepo[] $repos */
        $repos = $this->githubRepoRepository->findAll();
        self::assertCount(2, $repos);

        self::assertEquals(100, $repos[0]->getGithubId());
        self::assertEquals(new DateTimeImmutable('2022-03-02T13:57:22Z'), $repos[0]->getCreatedAt());
        self::assertEquals(new DateTimeImmutable('2022-04-02T13:57:22Z'), $repos[0]->getUpdatedAt());
        self::assertEquals('https://github.com/TemKaa1337/repo1.git', $repos[0]->getCloneUrl());
        self::assertEquals('name1', $repos[0]->getName());
        self::assertEquals('description1', $repos[0]->getDescription());
        self::assertEquals('https://github.com/TemKaa1337/repo1', $repos[0]->getViewUrl());
        self::assertEquals(Language::Php, $repos[0]->getLanguage());
        self::assertNull($repos[0]->getDemoUrl());

        self::assertEquals(200, $repos[1]->getGithubId());
        self::assertEquals(new DateTimeImmutable('2022-03-01T13:57:22Z'), $repos[1]->getCreatedAt());
        self::assertEquals(new DateTimeImmutable('2022-04-01T13:57:22Z'), $repos[1]->getUpdatedAt());
        self::assertEquals('https://github.com/TemKaa1337/repo2.git', $repos[1]->getCloneUrl());
        self::assertEquals('name2', $repos[1]->getName());
        self::assertEquals('description2', $repos[1]->getDescription());
        self::assertEquals('https://github.com/TemKaa1337/repo2', $repos[1]->getViewUrl());
        self::assertEquals(Language::JavaScript, $repos[1]->getLanguage());
        self::assertNull($repos[1]->getDemoUrl());
    }

    public function testExecuteWithUpdate(): void
    {
        $this->loadFixtures();

        $responses = [
            new JsonMockResponse(
                [
                    [
                        'id'          => 200,
                        'created_at'  => '2022-03-02T13:57:22Z',
                        'updated_at'  => '2022-09-02T13:57:22Z',
                        'clone_url'   => 'https://github.com/TemKaa1337/repo3.git',
                        'name'        => 'name3',
                        'description' => 'description3',
                        'html_url'    => 'https://github.com/TemKaa1337/repo3',
                        'language'    => 'Python',
                    ],
                    [
                        'id'          => 400,
                        'created_at'  => '2022-03-01T13:57:22Z',
                        'updated_at'  => '2022-05-01T13:57:22Z',
                        'clone_url'   => 'https://github.com/TemKaa1337/repo4.git',
                        'name'        => 'name4',
                        'description' => 'description4',
                        'html_url'    => 'https://github.com/TemKaa1337/repo4',
                        'language'    => 'HTML',
                    ],
                ],
            ),
        ];

        $this->client->setResponseFactory($responses);

        $repos = $this->githubRepoRepository->findAll();
        self::assertCount(2, $repos);

        $commandTester = $this->getCommandTester(ParseCommand::class);
        $commandTester->execute([]);
        $commandTester->assertCommandIsSuccessful();

        $repos = $this->githubRepoRepository->findBy([], ['githubId' => 'ASC']);
        self::assertCount(2, $repos);

        self::assertEquals(200, $repos[0]->getGithubId());
        self::assertEquals(new DateTimeImmutable('2022-03-01T13:57:22Z'), $repos[0]->getCreatedAt());
        self::assertEquals(new DateTimeImmutable('2022-09-02T13:57:22Z'), $repos[0]->getUpdatedAt());
        self::assertEquals('https://github.com/TemKaa1337/repo3.git', $repos[0]->getCloneUrl());
        self::assertEquals('name3', $repos[0]->getName());
        self::assertEquals('description3', $repos[0]->getDescription());
        self::assertEquals('https://github.com/TemKaa1337/repo3', $repos[0]->getViewUrl());
        self::assertEquals(Language::Python, $repos[0]->getLanguage());

        self::assertEquals(400, $repos[1]->getGithubId());
        self::assertEquals(new DateTimeImmutable('2022-03-01T13:57:22Z'), $repos[1]->getCreatedAt());
        self::assertEquals(new DateTimeImmutable('2022-05-01T13:57:22Z'), $repos[1]->getUpdatedAt());
        self::assertEquals('https://github.com/TemKaa1337/repo4.git', $repos[1]->getCloneUrl());
        self::assertEquals('name4', $repos[1]->getName());
        self::assertEquals('description4', $repos[1]->getDescription());
        self::assertEquals('https://github.com/TemKaa1337/repo4', $repos[1]->getViewUrl());
        self::assertEquals(Language::Html, $repos[1]->getLanguage());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $container = self::getContainer();

        $this->client = $container->get(HttpClientInterface::class);
        $this->githubRepoRepository = $container->get(GithubRepoRepository::class);
    }
}
