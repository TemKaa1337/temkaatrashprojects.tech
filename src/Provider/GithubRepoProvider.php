<?php

declare(strict_types=1);

namespace App\Provider;

use App\Entity\GithubRepo;
use App\Exception\NotFoundException;
use App\Repository\GithubRepoRepository;

final readonly class GithubRepoProvider
{
    public function __construct(
        private GithubRepoRepository $githubRepoRepository,
    ) {
    }

    /**
     * @return GithubRepo[]
     */
    public function findAll(): array
    {
        return $this->githubRepoRepository->findAll();
    }

    public function findByName(string $name): GithubRepo
    {
        if ($repo = $this->githubRepoRepository->findOneByName($name)) {
            return $repo;
        }

        throw new NotFoundException(sprintf('Could not find entity with name "%s".', $name));
    }
}
