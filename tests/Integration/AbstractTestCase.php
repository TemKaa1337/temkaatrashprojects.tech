<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use App\Entity\GithubRepo;
use App\Enum\Language;
use App\Repository\GithubRepoRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractTestCase extends WebTestCase
{
    protected GithubRepoRepository $githubRepoRepository;

    protected function loadFixtures(): void
    {
        $fixtures = [
            (new GithubRepo())
                ->setCloneUrl('https://github.com/TemKaa1337/repo1.git')
                ->setCreatedAt(new DateTimeImmutable('2022-03-20T13:57:22Z'))
                ->setUpdatedAt(new DateTimeImmutable('2022-03-20T13:57:22Z'))
                ->setDescription('description1')
                ->setGithubId(100)
                ->setLanguage(Language::Php)
                ->setName('name1')
                ->setViewUrl('https://github.com/TemKaa1337/repo1')
                ->setDemoUrl('https://demo1.url'),
            (new GithubRepo())
                ->setCloneUrl('https://github.com/TemKaa1337/repo2.git')
                ->setCreatedAt(new DateTimeImmutable('2022-03-01T13:57:22Z'))
                ->setUpdatedAt(new DateTimeImmutable('2022-03-20T13:57:22Z'))
                ->setDescription('description2')
                ->setGithubId(200)
                ->setLanguage(Language::JavaScript)
                ->setName('name2')
                ->setViewUrl('https://github.com/TemKaa1337/repo2'),
        ];

        foreach ($fixtures as $fixture) {
            $this->githubRepoRepository->save($fixture);
        }
    }

    protected function purgeTable(): void
    {
        foreach ($this->githubRepoRepository->findAll() as $repo) {
            $this->githubRepoRepository->remove($repo);
        }
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->githubRepoRepository = self::getContainer()->get(GithubRepoRepository::class);

        $this->purgeTable();
    }
}
