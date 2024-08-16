<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\GithubRepo;
use App\Model\GithubRepo as GithubRepoModel;

final readonly class GithubRepoFactory
{
    public function create(GithubRepoModel $githubRepo): GithubRepo
    {
        return (new GithubRepo())
            ->setCloneUrl($githubRepo->cloneUrl)
            ->setCreatedAt($githubRepo->createdAt)
            ->setUpdatedAt($githubRepo->updatedAt)
            ->setDescription($githubRepo->description)
            ->setGithubId($githubRepo->githubId)
            ->setLanguage($githubRepo->language)
            ->setName($githubRepo->name)
            ->setViewUrl($githubRepo->viewUrl);
    }
}
