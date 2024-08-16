<?php

declare(strict_types=1);

namespace App\Controller\Home;

use App\Repository\GithubRepoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route(path: '/', methods: Request::METHOD_GET)]
final class ViewAction extends AbstractController
{
    public function __construct(
        private readonly GithubRepoRepository $githubRepoRepository,
        private readonly string $websiteHost,
    ) {
    }

    public function __invoke(): Response
    {
        // TODO: naming strategy of database tables
        return $this->render(
            view: 'home.html.twig',
            parameters: [
                'repositories' => $this->githubRepoRepository->findAll(),
                'websiteHost'  => $this->websiteHost,
            ],
        );
    }
}
