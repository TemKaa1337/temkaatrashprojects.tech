<?php

declare(strict_types=1);

namespace App\Handler\GithubRepo\DemoUrl;

use App\Provider\GithubRepoProvider;
use App\Repository\GithubRepoRepository;

final readonly class AddHandler
{
    public function __construct(
        private GithubRepoProvider $githubRepoProvider,
        private GithubRepoRepository $githubRepoRepository,
    ) {
    }

    public function handle(string $repoName, string $demoUrl): void
    {
        $repo = $this->githubRepoProvider->findByName($repoName);

        $repo->setDemoUrl($demoUrl);

        $this->githubRepoRepository->save($repo);
    }
}
