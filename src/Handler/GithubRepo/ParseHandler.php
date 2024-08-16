<?php

declare(strict_types=1);

namespace App\Handler\GithubRepo;

use App\Entity\GithubRepo;
use App\Factory\GithubRepoFactory;
use App\Model\GithubRepo as GitHubRepoModel;
use App\Provider\GithubRepoProvider;
use App\Repository\GithubRepoRepository;
use App\Trait\DependencyInjection\ValidatorTrait;
use App\Trait\MapTrait;
use Doctrine\DBAL\Types\Types;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class ParseHandler
{
    use MapTrait;
    use ValidatorTrait;

    private const string GITHUB_BASE_URL = 'https://api.github.com';

    public function __construct(
        private HttpClientInterface $client,
        private LoggerInterface $githubParserLogger,
        private GithubRepoFactory $githubRepoFactory,
        private GithubRepoProvider $githubRepoProvider,
        private GithubRepoRepository $githubRepoRepository,
        private string $githubUsername,
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function handle(): void
    {
        $url = sprintf('%s/users/%s/repos', self::GITHUB_BASE_URL, $this->githubUsername);

        $response = $this->client->request(Request::METHOD_GET, $url);

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new RuntimeException(
                sprintf(
                    'Unexpected http status code received while parsing github repositories urls: "%s".',
                    $response->getStatusCode(),
                ),
            );
        }

        /** @var GitHubRepoModel[] $repositoriesList */
        $newRepositories = $this->serializer->deserialize(
            $response->getContent(),
            type: GitHubRepoModel::class.'[]',
            format: Types::JSON,
        );

        /** @var array<int, GithubRepo> $oldRepositories */
        $oldRepositoriesMap = $this->createMap(
            collection: $this->githubRepoProvider->findAll(),
            keyProvider: static fn (GithubRepo $githubRepo): int => $githubRepo->getGithubId(),
        );

        $this->deleteUnlistedRepos($oldRepositoriesMap, $newRepositories);

        /** @var GitHubRepoModel $newRepository */
        foreach ($newRepositories as $newRepository) {
            $this->validate($newRepository);

            /** @var GithubRepo $repository */
            if ($repository = $oldRepositoriesMap[$newRepository->githubId] ?? null) {
                $this->githubParserLogger->info(sprintf('Updating repository "%s".', $repository->getName()));

                $repository
                    ->setUpdatedAt($newRepository->updatedAt)
                    ->setCloneUrl($newRepository->cloneUrl)
                    ->setDescription($newRepository->description)
                    ->setLanguage($newRepository->language)
                    ->setName($newRepository->name)
                    ->setViewUrl($newRepository->viewUrl);
            } else {
                $this->githubParserLogger->info(sprintf('Creating repository "%s".', $newRepository->name));

                $repository = $this->githubRepoFactory->create($newRepository);
            }

            $this->validate($repository);

            $this->githubRepoRepository->save($repository, flush: false);

            $this->githubParserLogger->info(sprintf('Repository "%s" saved.', $newRepository->name));
        }

        $this->githubRepoRepository->flush();
    }

    private function deleteUnlistedRepos(array $oldRepositoriesMap, array $newRepositories): void
    {
        $newRepositoriesMap = $this->createMap(
            $newRepositories,
            keyProvider: static fn (GitHubRepoModel $githubRepo): int => $githubRepo->githubId,
        );

        foreach ($oldRepositoriesMap as $oldRepository) {
            if (!isset($newRepositoriesMap[$oldRepository->getGithubId()])) {
                $this->githubParserLogger->info(sprintf('Deleting repository "%s".', $oldRepository->getName()));

                $this->githubRepoRepository->remove($oldRepository, flush: false);
            }
        }
    }
}
