<?php

declare(strict_types=1);

namespace App\Controller\Home;

use App\Provider\GithubRepoProvider;
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
        private readonly GithubRepoProvider $githubRepoProvider,
        private readonly string $websiteHost,
    ) {
    }

    public function __invoke(): Response
    {
        return $this->render(
            view: 'home.html.twig',
            parameters: [
                'repositories' => $this->githubRepoProvider->findAll(),
                'websiteHost'  => $this->websiteHost,
            ],
        );
    }
}
