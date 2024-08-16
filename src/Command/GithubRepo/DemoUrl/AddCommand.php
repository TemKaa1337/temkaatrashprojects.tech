<?php

declare(strict_types=1);

namespace App\Command\GithubRepo\DemoUrl;

use App\Enum\Command\Argument;
use App\Exception\NotFoundException;
use App\Handler\GithubRepo\DemoUrl\AddHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

#[AsCommand(name: 'app:github-repo:demo-url:add')]
final class AddCommand extends Command
{
    public function __construct(
        private readonly AddHandler $addHandler,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(name: Argument::RepoName->value, mode: InputOption::VALUE_REQUIRED)
            ->addArgument(name: Argument::DemoUrl->value, mode: InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $demoUrl = (string) $input->getArgument(Argument::DemoUrl->value);
        $repoName = (string) $input->getArgument(Argument::RepoName->value);

        $io = new SymfonyStyle($input, $output);

        try {
            $this->addHandler->handle($repoName, $demoUrl);

            $io->success(sprintf('Successfully added demo url "%s" to "%s".', $demoUrl, $repoName));
        } catch (NotFoundException $exception) {
            $io->error($exception->getMessage());

            return Command::FAILURE;
        } catch (Throwable $exception) {
            $io->error($exception);

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
